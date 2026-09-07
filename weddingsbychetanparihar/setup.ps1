$ErrorActionPreference = "Continue"
Set-Location $PSScriptRoot

if (-not (Test-Path ".env")) {
    Copy-Item ".env.example" ".env"
}

Get-Content ".env" | ForEach-Object {
    if ($_ -match "^\s*#" -or $_ -notmatch "=") { return }
    $name, $value = $_.Split("=", 2)
    Set-Item -Path "Env:$($name.Trim())" -Value $value.Trim()
}

$wpUrl = if ($env:WP_URL) { $env:WP_URL } else { "http://localhost:8090" }
$wpTitle = if ($env:WP_TITLE) { $env:WP_TITLE } else { "Weddings by Chetan Parihar" }
$adminUser = if ($env:WP_ADMIN_USER) { $env:WP_ADMIN_USER } else { "admin" }
$adminPass = if ($env:WP_ADMIN_PASSWORD) { $env:WP_ADMIN_PASSWORD } else { "wcp-admin-local" }
$adminEmail = if ($env:WP_ADMIN_EMAIL) { $env:WP_ADMIN_EMAIL } else { "admin@weddingsbychetanparihar.local" }

Write-Host "Starting WordPress stack..."
docker compose up -d db wordpress
if ($LASTEXITCODE -ne 0) { throw "Docker Compose failed to start." }

function Invoke-Wp {
    param([Parameter(Mandatory = $true)][string[]]$WpArgs)
    docker compose --profile cli run --rm wpcli wp @WpArgs
}

Write-Host "Waiting for WordPress to accept WP-CLI..."
$ready = $false
for ($i = 1; $i -le 45; $i++) {
    docker compose --profile cli run --rm wpcli wp core version 2>$null | Out-Null
    if ($LASTEXITCODE -eq 0) {
        $ready = $true
        break
    }
    Start-Sleep -Seconds 4
}

if (-not $ready) {
    throw "WordPress did not become ready in time. Check 'docker compose logs wordpress'."
}

docker compose --profile cli run --rm wpcli wp core is-installed 2>$null | Out-Null
if ($LASTEXITCODE -ne 0) {
    Write-Host "Installing WordPress at $wpUrl ..."
    Invoke-Wp @(
        "core", "install",
        "--url=$wpUrl",
        "--title=$wpTitle",
        "--admin_user=$adminUser",
        "--admin_password=$adminPass",
        "--admin_email=$adminEmail",
        "--skip-email"
    )
}

Invoke-Wp @("theme", "activate", "weddings-by-chetan-parihar")
Invoke-Wp @("option", "update", "blogdescription", "Extraordinary weddings. Timeless stories.")
Invoke-Wp @("rewrite", "structure", "/%postname%/")
Invoke-Wp @("rewrite", "flush", "--hard")

$pages = @(
    @{ title = "About"; slug = "about" },
    @{ title = "Services"; slug = "services" },
    @{ title = "Destinations"; slug = "destinations" },
    @{ title = "Real Weddings"; slug = "real-weddings" },
    @{ title = "Blog"; slug = "blog" },
    @{ title = "Contact"; slug = "contact" }
)

foreach ($page in $pages) {
    $existing = docker compose --profile cli run --rm wpcli wp post list --post_type=page --name=$($page.slug) --field=ID --format=csv
    if (-not $existing) {
        Invoke-Wp @(
            "post", "create",
            "--post_type=page",
            "--post_status=publish",
            "--post_title=$($page.title)",
            "--post_name=$($page.slug)"
        )
    }
}

$blogId = ("$(docker compose --profile cli run --rm wpcli wp post list --post_type=page --name=blog --field=ID)").Trim()
if ($blogId) {
    Invoke-Wp @("option", "update", "page_for_posts", $blogId)
}

$frontPageId = ("$(docker compose --profile cli run --rm wpcli wp post list --post_type=page --name=home --field=ID)").Trim()
if (-not $frontPageId) {
    $created = docker compose --profile cli run --rm wpcli wp post create --post_type=page --post_status=publish --post_title="Home" --post_name=home --porcelain
    $frontPageId = "$created".Trim()
}
if ($frontPageId) {
    Invoke-Wp @("option", "update", "show_on_front", "page")
    Invoke-Wp @("option", "update", "page_on_front", $frontPageId)
}

docker compose --profile cli run --rm wpcli wp menu list --format=csv | Out-Null
$menuExists = docker compose --profile cli run --rm wpcli wp menu list --fields=slug --format=csv
if ($menuExists -notmatch "primary") {
    Invoke-Wp @("menu", "create", "Primary")
}

foreach ($page in $pages) {
    $pageId = (docker compose --profile cli run --rm wpcli wp post list --post_type=page --name=$($page.slug) --field=ID).Trim()
    if ($pageId) {
        docker compose --profile cli run --rm wpcli wp menu item add-post primary $pageId 2>$null | Out-Null
    }
}

Invoke-Wp @("menu", "location", "assign", "primary", "primary")

Write-Host ""
Write-Host "Weddings by Chetan Parihar is ready."
Write-Host "Site:  $wpUrl"
Write-Host "Admin: $wpUrl/wp-admin"
Write-Host "User:  $adminUser"

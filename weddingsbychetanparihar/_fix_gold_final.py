from pathlib import Path
import re

css = Path(r"d:\nikhil\weddingsbychetanparihar\wp-content\themes\weddingsbychetanparihar\assets\css\site.css")
php = Path(r"d:\nikhil\weddingsbychetanparihar\wp-content\themes\weddingsbychetanparihar\functions.php")
text = css.read_text(encoding="utf-8")

# Reference-sampled antique bronze
TITLE = "#735539"   # title / CTA text
STROKE = "#a67d47"  # double cutout border
KICKER = "#7a5a3d"

# Fix h1 color inside .wbc-art-copy h1 block
text2, n1 = re.subn(
    r"(\.wbc-art-copy h1\s*\{[^}]*?)color:\s*#[0-9a-fA-F]{3,8};",
    rf"\1color: {TITLE};",
    text,
    count=1,
    flags=re.S,
)
# Fix CTA text color (keep border, change color:)
text2, n2 = re.subn(
    r"(\.wbc-art-cta\s*\{[^}]*?border:\s*1px solid\s*)#[0-9a-fA-F]{3,8}(;\s*color:\s*)#[0-9a-fA-F]{3,8};",
    rf"\1{TITLE}\2{TITLE};",
    text2,
    count=1,
    flags=re.S,
)
# Kicker
text2, n3 = re.subn(
    r"(\.wbc-art-copy \.wbc-kicker\s*\{[^}]*?)color:\s*#[0-9a-fA-F]{3,8};",
    rf"\1color: {KICKER};",
    text2,
    count=1,
    flags=re.S,
)
# Stroke
text2, n4 = re.subn(
    r"(\.wbc-art-stroke\s*\{[^}]*?)stroke:\s*#[0-9a-fA-F]{3,8};",
    rf"\1stroke: {STROKE};",
    text2,
    count=1,
    flags=re.S,
)

css.write_text(text2, encoding="utf-8")
print("h1", n1, "cta", n2, "kicker", n3, "stroke", n4)

php_t = php.read_text(encoding="utf-8")
php_t2, nv = re.subn(
    r"define\(\s*'WBC_THEME_VERSION',\s*'[^']+'\s*\);",
    "define( 'WBC_THEME_VERSION', '3.0.5' );",
    php_t,
    count=1,
)
php.write_text(php_t2, encoding="utf-8")
print("version bump", nv)

# verify colors
t = css.read_text(encoding="utf-8")
for label, pat in [
    ("h1", r"\.wbc-art-copy h1\s*\{[^}]*?color:\s*(#[0-9a-fA-F]+);"),
    ("cta", r"\.wbc-art-cta\s*\{[^}]*?color:\s*(#[0-9a-fA-F]+);"),
    ("stroke", r"\.wbc-art-stroke\s*\{[^}]*?stroke:\s*(#[0-9a-fA-F]+);"),
]:
    m = re.search(pat, t, re.S)
    print(label, m.group(1) if m else "MISSING")

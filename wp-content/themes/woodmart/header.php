<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="light">
<head>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-M74VGCHK');</script>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('wvn-body'); ?>>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M74VGCHK" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php
$nav = function_exists('wvn_nav_items') ? wvn_nav_items() : array();
$icons = array(
    'home'   => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 11.5 12 4l8 7.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1v-8.5z"/></svg>',
    'grid'   => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="4" y="4" width="7" height="7" rx="1.5"/><rect x="13" y="4" width="7" height="7" rx="1.5"/><rect x="4" y="13" width="7" height="7" rx="1.5"/><rect x="13" y="13" width="7" height="7" rx="1.5"/></svg>',
    'blog'   => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M5 5h14M5 10h14M5 15h8"/><path d="M5 20h6"/></svg>',
    'image'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10" r="1.5"/><path d="m21 16-5-5-9 8"/></svg>',
    'doc'    => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M7 3h8l5 5v13H7z"/><path d="M15 3v5h5"/></svg>',
);
?>
<?php
$wvn_dark_start = is_page('what-we-do')
    || is_page_template('page-what-we-do.php')
    || is_page_template('page-money-landing.php')
    || is_page_template('page-wvn-commercial.php')
    || is_page_template('page-seo-landing.php')
    || is_page_template('page-event-planner-udaipur.php')
    || is_page_template('page-weddings-udaipur.php')
    || is_page('contact-us')
    || is_post_type_archive('portfolio')
    || is_page('portfolio')
    || is_singular('portfolio')
    || is_home()
    || is_category()
    || is_singular('post');
?>
<header class="wvn-header<?php echo $wvn_dark_start ? '' : ' is-light'; ?>">
    <a class="wvn-logo" href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo esc_url(wvn_logo_src()); ?>" alt="Wedding Vows by Nikhil — destination wedding planner in Udaipur">
    </a>
    <nav class="wvn-pillnav" aria-label="Primary">
        <?php foreach ($nav as $item) :
            $request = (isset($GLOBALS['wp']) && is_object($GLOBALS['wp']) && isset($GLOBALS['wp']->request))
                ? $GLOBALS['wp']->request
                : '';
            $current = untrailingslashit(home_url('/' . ltrim($request, '/')));
            $active = untrailingslashit($item['url']) === $current
                || (is_front_page() && $item['icon'] === 'home')
                || ((is_home() || is_singular('post') || is_category()) && $item['icon'] === 'blog')
                || ((is_post_type_archive('portfolio') || is_singular('portfolio')) && $item['icon'] === 'image');
            ?>
            <a href="<?php echo esc_url($item['url']); ?>" class="<?php echo $active ? 'is-active' : ''; ?>" title="<?php echo esc_attr($item['label']); ?>">
                <?php echo $icons[$item['icon']] ?? $icons['doc']; ?>
                <span><?php echo esc_html($item['label']); ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
    <a class="wvn-book" href="<?php echo esc_url(home_url('/contact-us/')); ?>" aria-label="Book consultation">
        <svg viewBox="0 0 100 100" aria-hidden="true">
            <defs>
                <path id="wvnCircle" d="M50,50 m-36,0 a36,36 0 1,1 72,0 a36,36 0 1,1 -72,0"/>
            </defs>
            <text><textPath href="#wvnCircle">BOOK CONSULTATION · BOOK CONSULTATION · </textPath></text>
        </svg>
        <span class="wvn-book-arrow">↗</span>
    </a>
    <button class="wvn-mobile-toggle" type="button" aria-label="Open navigation" aria-controls="wvn-mobile-panel" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
</header>

<div class="wvn-mobile-backdrop" data-wvn-mobile-close></div>
<aside class="wvn-mobile-panel" id="wvn-mobile-panel" aria-label="Mobile navigation" aria-hidden="true">
    <div class="wvn-mobile-panel-header">
        <p class="wvn-mobile-panel-title">Wedding Vows</p>
        <button class="wvn-mobile-close" type="button" aria-label="Close navigation" data-wvn-mobile-close>×</button>
    </div>
    <nav class="wvn-mobile-links">
        <?php foreach ($nav as $item) : ?>
            <a href="<?php echo esc_url($item['url']); ?>">
                <span><?php echo esc_html($item['label']); ?></span>
                <span aria-hidden="true">↗</span>
            </a>
        <?php endforeach; ?>
    </nav>
    <a class="wvn-mobile-cta" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Book a Consultation ↗</a>
</aside>

<script>
(function () {
    var toggle = document.querySelector('.wvn-mobile-toggle');
    var panel = document.getElementById('wvn-mobile-panel');
    var closers = document.querySelectorAll('[data-wvn-mobile-close]');
    if (!toggle || !panel) return;

    function setOpen(open) {
        document.body.classList.toggle('wvn-mobile-open', open);
        panel.classList.toggle('is-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        panel.setAttribute('aria-hidden', open ? 'false' : 'true');
    }

    toggle.addEventListener('click', function () { setOpen(true); });
    closers.forEach(function (el) { el.addEventListener('click', function () { setOpen(false); }); });
    panel.querySelectorAll('a').forEach(function (link) { link.addEventListener('click', function () { setOpen(false); }); });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') setOpen(false);
    });
})();
</script>

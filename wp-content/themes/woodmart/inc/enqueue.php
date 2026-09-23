<?php
/* Load Theme Files */
function theme_files() {
    wp_enqueue_style('wvn-fonts', 'https://fonts.googleapis.com/css2?family=Aboreto&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap', array(), null);
    wp_enqueue_style('font', 'https://use.typekit.net/mgk5doc.css', array(), null);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2');
    wp_enqueue_style('icons', get_theme_file_uri('/css/icons.min.css'), array(), null);
    wp_enqueue_style('main_styles', get_theme_file_uri('/css/app.min.css'), array(), '1.2.2');
    wp_enqueue_style('wvn-bts', get_theme_file_uri('/css/bts.css'), array('main_styles'), '1.8.49');
    wp_enqueue_style('wvn-overrides', get_theme_file_uri('/css/wvn-overrides.css'), array('wvn-bts'), '1.0.7');
    wp_enqueue_style('wvn-seo-growth', get_theme_file_uri('/css/wvn-seo-growth.css'), array('wvn-overrides'), '1.0.3');
    wp_enqueue_style('wvn-money-responsive', get_theme_file_uri('/css/wvn-money-responsive.css'), array('wvn-seo-growth'), '1.0.1');
    wp_enqueue_style('wvn-page-safety', get_theme_file_uri('/css/wvn-page-safety.css'), array('wvn-money-responsive'), '1.0.1');
    wp_enqueue_style('wvn-intro-editorial', get_theme_file_uri('/css/wvn-intro-editorial.css'), array('wvn-bts'), '1.2.0');

    if (is_front_page()) {
        wp_enqueue_style(
            'wvn-cinematic-home',
            get_theme_file_uri('/css/wvn-cinematic-home.css'),
            array('wvn-page-safety'),
            '1.3.3'
        );
        wp_enqueue_script(
            'wvn-cinematic-home',
            get_theme_file_uri('/js/wvn-cinematic-home.js'),
            array(),
'1.4.2',
            true
        );
        wp_enqueue_style(
            'wvn-home-gallery',
            get_theme_file_uri('/css/wvn-home-gallery.css'),
            array('wvn-cinematic-home', 'wvn-bts'),
            '1.0.3'
        );
        wp_enqueue_style(
            'wvn-testimonial-teasers',
            get_theme_file_uri('/css/wvn-testimonial-teasers.css'),
            array('wvn-cinematic-home', 'wvn-bts'),
            '1.0.0'
        );
        wp_enqueue_script(
            'wvn-home-gallery',
            get_theme_file_uri('/js/wvn-home-gallery.js'),
            array('wvn-bts'),
            '1.0.3',
            true
        );
    } elseif (!is_page_template('page-cinematic-test.php')) {
        wp_enqueue_style(
            'wvn-cinematic-site',
            get_theme_file_uri('/css/wvn-cinematic-site.css'),
            array('wvn-page-safety'),
            '1.0.6'
        );
        wp_enqueue_script(
            'wvn-cinematic-site',
            get_theme_file_uri('/js/wvn-cinematic-site.js'),
            array(),
            '1.0.6',
            true
        );
    }

    if (is_page_template('page-testimonials.php') || is_page('testimonials')) {
        wp_enqueue_style(
            'wvn-testimonials',
            get_theme_file_uri('/css/wvn-testimonials.css'),
            array('wvn-page-safety'),
            '1.1.0'
        );
    }

    if (is_singular('venue')) {
        wp_enqueue_style(
            'wvn-venue',
            get_theme_file_uri('/css/wvn-venue.css'),
            array('wvn-page-safety'),
            '1.0.0'
        );
        wp_enqueue_script(
            'wvn-venue',
            get_theme_file_uri('/js/wvn-venue.js'),
            array(),
            '1.0.0',
            true
        );
    }

    if (is_post_type_archive('portfolio') || is_page('portfolio') || is_page_template('page-portfolio.php')) {
        wp_enqueue_style(
            'wvn-cinematic-home',
            get_theme_file_uri('/css/wvn-cinematic-home.css'),
            array('wvn-page-safety'),
            '1.2.4'
        );
        wp_enqueue_style(
            'wvn-portfolio-page',
            get_theme_file_uri('/css/wvn-portfolio-page.css'),
            array('wvn-cinematic-home'),
            '1.0.3'
        );
        wp_enqueue_script(
            'wvn-cinematic-home',
            get_theme_file_uri('/js/wvn-cinematic-home.js'),
            array(),
            '1.2.4',
            true
        );
        wp_enqueue_script(
            'wvn-portfolio-page',
            get_theme_file_uri('/js/wvn-portfolio-page.js'),
            array('wvn-cinematic-home'),
            '1.0.3',
            true
        );
    }

    if (is_page_template('page-cinematic-test.php')) {
        wp_enqueue_style(
            'wvn-cinematic-test',
            get_theme_file_uri('/css/wvn-cinematic-test.css'),
            array('wvn-page-safety'),
            filemtime(get_theme_file_path('/css/wvn-cinematic-test.css'))
        );
    }

    wp_enqueue_style('custom-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11');
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11', true);
    wp_enqueue_script('jqueryui', 'https://code.jquery.com/jquery-3.6.3.min.js', array('jquery'), '3.6.3', true);
    wp_enqueue_script('bootstrap-scripts', get_theme_file_uri('js/bootstrap.min.js'), array('jquery'), '1.1', true);
    wp_enqueue_script('custom-scripts', get_theme_file_uri('js/scripts.js'), array('jquery', 'swiper'), '3.6.3', true);
    wp_enqueue_script('wvn-bts', get_theme_file_uri('/js/bts.js'), array(), '1.8.1', true);
    wp_localize_script('wvn-bts', 'wvnAjax', array('url' => admin_url('admin-ajax.php')));
    wp_enqueue_style('owl-carousel-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array(), '2.3.4');
    wp_enqueue_script('owl-carousel-js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), '2.3.4', true);
    wp_enqueue_script('custom-carousel-init', get_theme_file_uri('/js/carousel-init.js'), array('jquery', 'owl-carousel-js'), null, true);
    wp_enqueue_style('lightgallery', 'https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css', array(), '2.7.1');
    wp_enqueue_script('lightgallery', 'https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.umd.js', array('jquery'), '2.7.1', true);
    if (is_user_logged_in()) {
        wp_enqueue_style('loggedin-styles', get_theme_file_uri('css/logged-in.css'));
    }
    wp_deregister_style('classic-theme-styles');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'theme_files');

add_filter('body_class', function ($classes) {
    if (!is_front_page() && !is_page_template('page-cinematic-test.php')) {
        $classes[] = 'wvn-cin-site';
    }
    return $classes;
});

add_action('wp_enqueue_scripts', function () {
    if (!is_page_template('page-cinematic-test.php')) {
        return;
    }

    wp_enqueue_script(
        'gsap',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js',
        array(),
        '3.12.5',
        true
    );
    wp_enqueue_script(
        'gsap-scrolltrigger',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js',
        array('gsap'),
        '3.12.5',
        true
    );
    wp_enqueue_script(
        'lenis',
        'https://cdn.jsdelivr.net/npm/lenis@1.1.20/dist/lenis.min.js',
        array(),
        '1.1.20',
        true
    );
    wp_enqueue_script(
        'wvn-cinematic-test',
        get_theme_file_uri('/js/wvn-cinematic-test.js'),
        array('gsap', 'gsap-scrolltrigger', 'lenis'),
        filemtime(get_theme_file_path('/js/wvn-cinematic-test.js')),
        true
    );
}, 20);

add_action('init', 'register_menus');

/* Create the isolated cinematic test page once. */
require_once get_theme_file_path('/inc/cinematic-test-page.php');

/**
 * Prioritize the actual LCP hero image and establish connections for the
 * external providers used by the visual identity and frontend components.
 */
function wvn_frontend_resource_hints() {
    if (!is_admin()) {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        echo '<link rel="preconnect" href="https://use.typekit.net" crossorigin>' . "\n";
        echo '<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>' . "\n";
        echo '<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>' . "\n";
    }
    if (is_front_page() && function_exists('wvn_hero_image')) {
        echo '<link rel="preload" as="image" href="' . esc_url(wvn_hero_image()) . '" fetchpriority="high">' . "\n";
    }
}
add_action('wp_head', 'wvn_frontend_resource_hints', 1);

/**
 * Keep third-party frontend assets out of the blocking path where possible.
 * Dependencies remain declared so WordPress preserves execution order.
 */
function wvn_defer_frontend_scripts($tag, $handle, $src) {
    $defer = array(
        'swiper',
        'bootstrap-scripts',
        'custom-scripts',
        'wvn-bts',
        'wvn-cinematic-home',
        'wvn-cinematic-site',
        'wvn-portfolio-page',
        'wvn-home-gallery',
        'owl-carousel-js',
        'custom-carousel-init',
        'lightgallery',
        'gsap',
        'gsap-scrolltrigger',
        'lenis',
        'wvn-cinematic-test',
    );
    if (in_array($handle, $defer, true) && false === strpos($tag, ' defer')) {
        return '<script src="' . esc_url($src) . '" defer></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'wvn_defer_frontend_scripts', 10, 3);

function wvn_editor_support() {
    add_editor_style('/css/app.min.css');
    add_editor_style('/css/bts.css');
}
add_action('after_setup_theme', 'wvn_editor_support');

/* SEO growth layer: landing-page metadata + contextual internal links. */
require_once get_theme_file_path('/inc/seo-growth.php');

/* Verified real-wedding case-study publisher. */
require_once get_theme_file_path('/inc/real-wedding-case-study.php');

/* One-time SEO Journal publisher for the current content run. */
require_once get_theme_file_path('/inc/seo-blog-20260916.php');

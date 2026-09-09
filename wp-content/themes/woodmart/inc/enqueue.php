<?php
/* Load Theme Files */
function theme_files() {
    wp_enqueue_style('wvn-fonts', 'https://fonts.googleapis.com/css2?family=Aboreto&display=swap', array(), null);
    wp_enqueue_style('font', 'https://use.typekit.net/mgk5doc.css', array(), null);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2');
    wp_enqueue_style('icons', get_theme_file_uri('/css/icons.min.css'), array(), null);
    wp_enqueue_style('main_styles', get_theme_file_uri('/css/app.min.css'), array(), '1.2.2');
    wp_enqueue_style('wvn-bts', get_theme_file_uri('/css/bts.css'), array(), '1.8.27');
    wp_enqueue_style('custom-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11');
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11', true);
    wp_enqueue_script('jqueryui', 'https://code.jquery.com/jquery-3.6.3.min.js', array('jquery'), '3.6.3', true);
    wp_enqueue_script('bootstrap-scripts', get_theme_file_uri('js/bootstrap.min.js'), array('jquery'), '1.1', true);
    wp_enqueue_script('custom-scripts', get_theme_file_uri('js/scripts.js'), array('jquery', 'swiper'), '3.6.3', true);
    wp_enqueue_script('wvn-bts', get_theme_file_uri('/js/bts.js'), array(), '1.7.0', true);
    wp_localize_script('wvn-bts', 'wvnAjax', array('url' => admin_url('admin-ajax.php')));
    wp_enqueue_style('owl-carousel-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', array(), '2.3.4');
    wp_enqueue_script('owl-carousel-js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), '2.3.4', true);
    wp_enqueue_script('custom-carousel-init', get_theme_file_uri('/js/carousel-init.js'), array('jquery', 'owl-carousel-js'), null, true);
    wp_enqueue_style('lightgallery', 'https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css', array(), '2.7.1');
    wp_enqueue_script('lightgallery', 'https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.umd.js', array('jquery'), '2.7.1', true);
    if(is_user_logged_in()) {
        wp_enqueue_style('loggedin-styles', get_theme_file_uri('css/logged-in.css'));
    }
    wp_deregister_style('classic-theme-styles');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'theme_files');
add_action('init', 'register_menus');

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
    $defer = array('swiper', 'bootstrap-scripts', 'custom-scripts', 'wvn-bts', 'owl-carousel-js', 'custom-carousel-init', 'lightgallery');
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

<?php
/* Load Theme Files */
function theme_files() {
    wp_enqueue_style('wvn-fonts', 'https://fonts.googleapis.com/css2?family=Aboreto&display=swap', array(), null);
    wp_enqueue_style('font', 'https://use.typekit.net/mgk5doc.css');
    wp_enqueue_style('icons', get_theme_file_uri('/css/icons.min.css'));
    wp_enqueue_style('main_styles', get_theme_file_uri('/css/app.min.css?ver=1.2.2'));
    wp_enqueue_style('wvn-bts', get_theme_file_uri('/css/bts.css'), array(), '1.8.14');
    wp_enqueue_style('custom-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js');
    wp_enqueue_script('jqueryui', 'https://code.jquery.com/jquery-3.6.3.min.js', array('jquery'), '3.6.3', true);
    wp_enqueue_script('bootstrap-scripts', get_theme_file_uri('js/bootstrap.min.js'), array('jquery'), '1.1', true);
    wp_enqueue_script('custom-scripts', get_theme_file_uri('js/scripts.js'), array('jquery'), '3.6.3', true);
    wp_enqueue_script('wvn-bts', get_theme_file_uri('/js/bts.js'), array(), '1.6.9', true);
    wp_localize_script('wvn-bts', 'wvnAjax', array('url' => admin_url('admin-ajax.php')));
    wp_enqueue_style('owl-carousel-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
    wp_enqueue_script('owl-carousel-js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), null, true);
    wp_enqueue_script('custom-carousel-init', get_theme_file_uri('/js/carousel-init.js'), array('jquery', 'owl-carousel-js'), null, true);
    wp_enqueue_style('lightgallery', 'https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css');
    wp_enqueue_script('lightgallery', 'https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.umd.js', array('jquery'), null, true);
    if(is_user_logged_in()) {
        wp_enqueue_style('loggedin-styles', get_theme_file_uri('css/logged-in.css'));
    }
    wp_deregister_style('classic-theme-styles');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'theme_files');
add_action('init', 'register_menus');


function wvn_editor_support() {
    add_editor_style('/css/app.min.css');
    add_editor_style('/css/bts.css');
}
add_action('after_setup_theme', 'wvn_editor_support');


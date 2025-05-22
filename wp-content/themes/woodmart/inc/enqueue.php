<?php
/* Load Theme Files */
function theme_files() {
    wp_enqueue_style('font', 'https://use.typekit.net/mgk5doc.css');
    wp_enqueue_style('icons', get_theme_file_uri('/css/icons.min.css'));
    wp_enqueue_style('main_styles', get_theme_file_uri('/css/app.min.css?ver=1.2.2'));
    wp_enqueue_style('custom-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js');
    wp_enqueue_script('jqueryui', 'https://code.jquery.com/jquery-3.6.3.min.js', array('jquery'), '3.6.3', true);
    wp_enqueue_script('bootstrap-scripts', get_theme_file_uri('js/bootstrap.min.js'), array('jquery'), '1.1', true);
    wp_enqueue_script('custom-scripts', get_theme_file_uri('js/scripts.js'), array('jquery'), '3.6.3', true);
    if(is_user_logged_in()) {
        wp_enqueue_style('loggedin-styles', get_theme_file_uri('css/logged-in.css'));
    }
    wp_deregister_style('classic-theme-styles');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'theme_files');
add_action('init', 'register_menus');


/* Load Custom Styles in Editor */
function load_editor_styles () {
    wp_enqueue_style('font', 'https://use.typekit.net/mgk5doc.css');
    wp_enqueue_style('icons', get_theme_file_uri('/css/icons.min.css'));
    wp_enqueue_style('styles', get_theme_file_uri('/css/style.css'));
    wp_enqueue_style('custom-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap');
    wp_enqueue_style('custom-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js');
    wp_enqueue_script('custom-scripts', get_theme_file_uri('js/scripts.js'), array('jquery'), '3.6.3', true);
    wp_enqueue_style('owl-carousel-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
    wp_enqueue_style('owl-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css');

    // Owl Carousel JS (after jQuery)
    wp_enqueue_script('owl-carousel-js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), null, true);

    // Your custom JS to initialize carousel
    wp_enqueue_script('custom-carousel-init', get_template_directory_uri() . '/js/carousel-init.js', array('jquery', 'owl-carousel-js'), null, true);
    wp_enqueue_style('lightgallery', 'https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css');
    wp_enqueue_script('lightgallery', 'https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.umd.js', array('jquery'), null, true);
    wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' );
    // Initialize
    wp_add_inline_script('lightgallery', '
        document.addEventListener("DOMContentLoaded", function() {
            lightGallery(document.querySelector(".gallery-lightbox"), {
                selector: "a",
                download: false
            });
        });
    ');
    add_editor_style( '/css/app.min.css' );
    wp_enqueue_style('wp_editor_updates', get_theme_file_uri('/css/wp-editor.css'));
    wp_deregister_style('classic-theme-styles');
    wp_dequeue_style('classic-theme-styles');
}
add_action('after_setup_theme', 'load_editor_styles');


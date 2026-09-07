<?php
/**
 * Chetan Parihar Weddings — theme bootstrap.
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WBC_THEME_VERSION', '2.7.0');
define('WBC_THEME_DIR', get_template_directory());
define('WBC_THEME_URI', get_template_directory_uri());

require WBC_THEME_DIR . '/inc/helpers.php';
require WBC_THEME_DIR . '/inc/admin.php';
require WBC_THEME_DIR . '/inc/seo.php';
require WBC_THEME_DIR . '/inc/journal-automation.php';

function wbc_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('custom-logo', array('height' => 140, 'width' => 420, 'flex-height' => true, 'flex-width' => true));
    add_theme_support('align-wide');
    add_image_size('wbc-portrait', 900, 1200, true);
    add_image_size('wbc-wide', 1600, 1000, true);
    add_image_size('wbc-card', 800, 1000, true);
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'weddingsbychetanparihar'),
        'footer'  => __('Footer Menu', 'weddingsbychetanparihar'),
    ));
}
add_action('after_setup_theme', 'wbc_theme_setup');

function wbc_assets() {
    wp_enqueue_style(
        'wbc-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Great+Vibes&family=Outfit:wght@300;400;500;600&display=swap',
        array(),
        null
    );
    wp_enqueue_style('wbc-site', WBC_THEME_URI . '/assets/css/site.css', array('wbc-fonts'), WBC_THEME_VERSION);
    wp_enqueue_script('wbc-site', WBC_THEME_URI . '/assets/js/site.js', array(), WBC_THEME_VERSION, true);
    wp_localize_script('wbc-site', 'wbcAjax', array(
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('wbc_contact'),
    ));
}
add_action('wp_enqueue_scripts', 'wbc_assets');

function wbc_body_classes($classes) {
    $classes[] = 'wbc-body';
    if (is_front_page()) {
        $classes[] = 'is-home';
    }
    return $classes;
}
add_filter('body_class', 'wbc_body_classes');

function wbc_excerpt_more() {
    return '…';
}
add_filter('excerpt_more', 'wbc_excerpt_more');

function wbc_after_switch_theme() {
    wbc_register_post_types();
    wbc_register_taxonomies();
    wbc_seed_pages();
    wbc_seed_content();
    flush_rewrite_rules(false);
}
add_action('after_switch_theme', 'wbc_after_switch_theme');

function wbc_rewrite_flush_once() {
    if (get_option('wbc_rewrite_flushed_v2')) {
        return;
    }
    wbc_register_post_types();
    wbc_register_taxonomies();
    flush_rewrite_rules(false);
    update_option('wbc_rewrite_flushed_v2', '1');
}
add_action('init', 'wbc_rewrite_flush_once', 99);

function wbc_maybe_seed() {
    if (!get_option('wbc_seed_content_v2')) {
        wbc_seed_pages();
        wbc_seed_content();
    }
    wbc_refresh_media_pack();
}
add_action('init', 'wbc_maybe_seed', 30);

function wbc_archive_query($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }
    if (is_post_type_archive(array('wbc_wedding', 'wbc_service', 'wbc_destination'))) {
        $query->set('posts_per_page', 24);
        $query->set('orderby', array('menu_order' => 'ASC', 'date' => 'DESC'));
    }
}
add_action('pre_get_posts', 'wbc_archive_query');

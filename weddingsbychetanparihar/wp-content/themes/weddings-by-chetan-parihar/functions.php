<?php
/**
 * Weddings by Chetan Parihar theme setup.
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WCP_THEME_VERSION', '0.1.0');

function wcp_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('custom-logo', array(
        'height'      => 120,
        'width'       => 120,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'wcp'),
        'footer'  => __('Footer Menu', 'wcp'),
    ));
}
add_action('after_setup_theme', 'wcp_setup');

function wcp_assets()
{
    wp_enqueue_style(
        'wcp-theme',
        get_stylesheet_uri(),
        array(),
        WCP_THEME_VERSION
    );
}
add_action('wp_enqueue_scripts', 'wcp_assets');

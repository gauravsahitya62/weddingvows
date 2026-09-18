<?php

/* Theme Features */
function theme_features()
{
    add_theme_support('title-tag');
    add_theme_support('align-wide');
    add_theme_support('disable-custom-font-sizes');
    add_theme_support('disable-custom-colors');
    add_theme_support('disable-custom-gradients');
    add_theme_support('editor-styles');
    add_editor_style('css/editor.css');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_post_type_support('page', 'excerpt');
    register_nav_menu('menu-main', 'Main Menu');
    register_nav_menu('menu-utility', 'Utility Menu');
    register_nav_menu('menu-classes', 'Classes Menu');
}
add_action('after_setup_theme', 'theme_features');

$theme_inc_dir = 'inc';
$theme_includes = array(
    '/bts-data.php',
    '/acf-home.php',
    '/acf-portfolio.php',
    '/acf-services.php',
    '/acf-guide.php',
    '/blog.php',
    '/seo.php',
    '/seo-blogs.php',
    '/custom-post-types.php',                   // Register Custom Post types & Taxonomies
    '/nav-walker.php',                          // Register Menu Walkers 
    '/enqueue.php',                             // Enqueue scripts and styles.
    '/widgets.php',                             // Contains the Widgets
    '/templates.php',                           // Contains the Templates
    '/patterns.php',                            // Contains Patterns
    '/theme-features.php',                      // Contains the Theme Features
    '/block-styles.php',                        // Contains the Updated Block Styles
    '/cinematic-test-page.php',                // Isolated cinematic test page bootstrap.
    '/homepage-seo.php',                          // Homepage SEO metadata and schema.
    '/portfolio-page.php',                     // Weddings / portfolio cinematic page.
);
foreach ($theme_includes as $file) {
    require_once get_theme_file_path($theme_inc_dir . $file);
}
// Register Standard Blocks
require_once get_theme_file_path($theme_inc_dir . '/acf-standard-blocks.php');
add_action('acf/init', 'hfm_acf_init_standard_blocks');

// Register Custom Blocks
require_once get_theme_file_path($theme_inc_dir . '/acf-custom-blocks.php');
add_action('acf/init', 'hfm_acf_init_custom_blocks');

@ini_set('upload_max_size', '256M');
@ini_set('post_max_size', '256M');
@ini_set('max_execution_time', '300');


add_filter('wpseo_breadcrumb_separator', function () {
    return '<i class="fa fa-chevron-right" aria-hidden="true"></i>'; // Replace with your preferred Font Awesome icon class
});

function register_menus() {
    register_nav_menus([
        'left-menu' => __('Left Menu'),
        'right-menu' => __('Right Menu')
    ]);
}

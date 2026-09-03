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
    '/acf-services.php',
    '/blog.php',
    '/seo.php',
    '/custom-post-types.php',                   // Register Custom Post types & Taxonomies
    '/nav-walker.php',                          // Register Menu Walkers 
    '/enqueue.php',                             // Enqueue scripts and styles.
    '/widgets.php',                             // Contains the Widgets
    '/templates.php',                           // Contains the Templates
    '/patterns.php',                            // Contains Patterns
    '/theme-features.php',                      // Contains the Theme Features
    '/block-styles.php',                        // Contains the Updated Block Styles
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

function create_wedding_portfolio_post_type() {
    register_post_type('portfolio',
        array(
            'labels' => array(
                'name' => __('Wedding Portfolio'),
                'singular_name' => __('Wedding Portfolio')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'portfolio'), // Change slug to portfolio
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'create_wedding_portfolio_post_type');

add_action('wp_ajax_nopriv_submit_quick_contact', 'submit_quick_contact_form');
add_action('wp_ajax_submit_quick_contact', 'submit_quick_contact_form');

function submit_quick_contact_form() {
    $name = sanitize_text_field($_POST['full_name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $note = sanitize_textarea_field($_POST['message'] ?? '');

    $to = 'gauravsahitya62@gmail.com'; // Replace with your email
    $subject = 'New Contact Form Submission';
    $message = "Name: $name\nPhone: $phone\nEmail: $email";
    if ($note) {
        $message .= "\nMessage: $note";
    }
    $headers = ['Content-Type: text/plain; charset=UTF-8'];

    wp_mail($to, $subject, $message, $headers);

    echo 'success';
    wp_die();
}

/**
 * Keep the virtual WordPress robots.txt endpoint aligned with the canonical sitemap.
 * The repository also contains a physical robots.txt, which takes precedence on typical Apache setups.
 */
function wvn_theme_robots_override($output, $public) {
    if (!$public) {
        return "User-agent: *\nDisallow: /\n";
    }

    return "# Wedding Vows by Nikhil\n"
        . "# https://weddingvowsbynikhil.com\n\n"
        . "User-agent: *\n"
        . "Allow: /\n"
        . "Disallow: /wp-admin/\n"
        . "Allow: /wp-admin/admin-ajax.php\n"
        . "Disallow: /wp-login.php\n"
        . "Disallow: /xmlrpc.php\n"
        . "Disallow: /readme.html\n"
        . "Disallow: /trackback/\n"
        . "Disallow: /feed/\n"
        . "Disallow: /*/feed$\n"
        . "Disallow: /search/\n"
        . "Disallow: /*?s=\n\n"
        . "Sitemap: " . home_url('/wvn-sitemap.xml') . "\n";
}
add_filter('robots_txt', 'wvn_theme_robots_override', 110, 2);

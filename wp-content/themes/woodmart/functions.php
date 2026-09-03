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
    '/custom-post-types.php',
    '/nav-walker.php',
    '/enqueue.php',
    '/widgets.php',
    '/templates.php',
    '/patterns.php',
    '/theme-features.php',
    '/block-styles.php',
);
foreach ($theme_includes as $file) {
    require_once get_theme_file_path($theme_inc_dir . $file);
}
require_once get_theme_file_path($theme_inc_dir . '/acf-standard-blocks.php');
add_action('acf/init', 'hfm_acf_init_standard_blocks');
require_once get_theme_file_path($theme_inc_dir . '/acf-custom-blocks.php');
add_action('acf/init', 'hfm_acf_init_custom_blocks');

@ini_set('upload_max_size', '256M');
@ini_set('post_max_size', '256M');
@ini_set('max_execution_time', '300');

add_filter('wpseo_breadcrumb_separator', function () {
    return '<i class="fa fa-chevron-right" aria-hidden="true"></i>';
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
            'rewrite' => array('slug' => 'portfolio'),
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

    $to = 'gauravsahitya62@gmail.com';
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

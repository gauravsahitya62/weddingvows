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
    register_post_type('portfolio', array(
        'labels' => array(
            'name'               => __('Portfolio'),
            'singular_name'      => __('Portfolio'),
            'menu_name'          => __('Portfolio'),
            'name_admin_bar'     => __('Portfolio'),
            'add_new'            => __('Add New'),
            'add_new_item'       => __('Add New Wedding'),
            'edit_item'          => __('Edit Wedding'),
            'new_item'           => __('New Wedding'),
            'view_item'          => __('View Wedding'),
            'search_items'       => __('Search Portfolio'),
            'not_found'          => __('No portfolio items found'),
            'not_found_in_trash' => __('No portfolio items found in Trash'),
            'all_items'          => __('All Portfolio'),
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'show_in_admin_bar'  => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-heart',
        'capability_type'    => 'post',
        'map_meta_cap'       => true,
        'rewrite'            => array('slug' => 'portfolio'),
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    ));

    if (get_option('_wvn_portfolio_cpt_v3') !== '1') {
        flush_rewrite_rules(false);
        update_option('_wvn_portfolio_cpt_v3', '1');
    }
}
add_action('init', 'create_wedding_portfolio_post_type', 5);

function wvn_seed_portfolio_posts() {
    if (get_option('_wvn_portfolio_seed_v1')) {
        return;
    }
    $existing = get_posts(array(
        'post_type'      => 'portfolio',
        'posts_per_page' => 1,
        'post_status'    => 'any',
        'fields'         => 'ids',
    ));
    if ($existing) {
        update_option('_wvn_portfolio_seed_v1', '1');
        return;
    }

    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $samples = array(
        array('title' => 'Jehana & Kanishk', 'venue' => 'Udaipur, Rajasthan', 'image' => '2025/04/NVP_JEHANAXKANISHK_WEDDING-1450.jpg'),
        array('title' => 'A Royal Evening', 'venue' => 'Palace Courtyard, Udaipur', 'image' => '2025/04/2J0A7886-1200x800-1.jpg'),
        array('title' => 'Candlelit Vows', 'venue' => 'Heritage Venue, Udaipur', 'image' => '2025/04/2J0A1820-1200x800-1.jpg'),
        array('title' => 'Marigold Procession', 'venue' => 'Udaipur, Rajasthan', 'image' => '2025/04/2J0A1818.jpg'),
        array('title' => 'The First Look', 'venue' => 'Udaipur, Rajasthan', 'image' => '2025/04/2J0A0682.jpg'),
        array('title' => 'Guest Welcome', 'venue' => 'Udaipur, Rajasthan', 'image' => '2025/04/2J0A0986-534x800-1.jpg'),
        array('title' => 'Palace Vows', 'venue' => 'Udaipur, Rajasthan', 'image' => '2025/04/2J0A2532-533x800-1.jpg'),
    );

    foreach ($samples as $sample) {
        $post_id = wp_insert_post(array(
            'post_title'   => $sample['title'],
            'post_excerpt' => $sample['venue'],
            'post_content' => '',
            'post_status'  => 'publish',
            'post_type'    => 'portfolio',
        ));
        if (!$post_id || is_wp_error($post_id)) {
            continue;
        }
        $image_url = function_exists('wvn_media') ? wvn_media($sample['image']) : '';
        if ($image_url) {
            $image_id = media_sideload_image($image_url, $post_id, $sample['title'], 'id');
            if (!is_wp_error($image_id) && $image_id) {
                set_post_thumbnail($post_id, (int) $image_id);
            }
        }
    }
    update_option('_wvn_portfolio_seed_v1', '1');
}
add_action('init', 'wvn_seed_portfolio_posts', 30);

add_action('wp_ajax_nopriv_submit_quick_contact', 'submit_quick_contact_form');
add_action('wp_ajax_submit_quick_contact', 'submit_quick_contact_form');

function submit_quick_contact_form() {
    $name = sanitize_text_field($_POST['full_name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $note = sanitize_textarea_field($_POST['message'] ?? '');

    $to = 'weddingvowsbynikhil@gmail.com';
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

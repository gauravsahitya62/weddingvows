<?php
/**
 * Gallery media categories.
 *
 * Stored on Media Library attachments so images and videos share one stable,
 * editable taxonomy. No automatic category migration is performed.
 */

function wvn_register_gallery_media_taxonomy() {
    register_taxonomy('wvn_gallery_category', array('attachment'), array(
        'labels' => array(
            'name' => 'Gallery Categories',
            'singular_name' => 'Gallery Category',
            'search_items' => 'Search Gallery Categories',
            'all_items' => 'All Gallery Categories',
            'edit_item' => 'Edit Gallery Category',
            'update_item' => 'Update Gallery Category',
            'add_new_item' => 'Add Gallery Category',
            'new_item_name' => 'New Gallery Category',
            'menu_name' => 'Gallery Categories',
        ),
        'public' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'rewrite' => false,
        'query_var' => false,
        'capabilities' => array(
            'manage_terms' => 'edit_posts',
            'edit_terms' => 'edit_posts',
            'delete_terms' => 'edit_posts',
            'assign_terms' => 'edit_posts',
        ),
    ));
}
add_action('init', 'wvn_register_gallery_media_taxonomy');

function wvn_register_gallery_media_category_field() {
    if (!function_exists('acf_add_local_field_group') || !taxonomy_exists('wvn_gallery_category')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_wvn_gallery_media_taxonomy',
        'title' => 'Gallery media categories',
        'style' => 'default',
        'position' => 'side',
        'active' => true,
        'show_in_rest' => 1,
        'location' => array(
            array(
                array(
                    'param' => 'attachment',
                    'operator' => '==',
                    'value' => 'all',
                ),
            ),
        ),
        'fields' => array(
            array(
                'key' => 'field_wvn_gallery_media_category',
                'label' => 'Categories',
                'name' => 'wvn_gallery_category',
                'type' => 'taxonomy',
                'taxonomy' => 'wvn_gallery_category',
                'field_type' => 'multi_select',
                'return_format' => 'object',
                'add_term' => 1,
                'save_terms' => 1,
                'load_terms' => 1,
                'instructions' => 'Assign one or more categories. Manage names under Media → Gallery Categories. Works for images and videos.',
            ),
        ),
    ));
}
add_action('acf/init', 'wvn_register_gallery_media_category_field', 20);

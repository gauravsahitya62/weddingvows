<?php

/* Register Post Types */

function wvn_register_portfolio_post_type() {
    register_post_type('portfolio', array(
        'labels' => array(
            'name'               => __('Portfolio'),
            'singular_name'      => __('Wedding'),
            'menu_name'          => __('Portfolio'),
            'name_admin_bar'     => __('Wedding'),
            'add_new'            => __('Add New'),
            'add_new_item'       => __('Add New Wedding'),
            'edit_item'          => __('Edit Wedding'),
            'new_item'           => __('New Wedding'),
            'view_item'          => __('View Wedding'),
            'view_items'         => __('View Weddings'),
            'search_items'       => __('Search Weddings'),
            'not_found'          => __('No weddings found'),
            'not_found_in_trash' => __('No weddings found in Trash'),
            'all_items'          => __('All Weddings'),
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_rest'        => true,
        'has_archive'         => 'portfolio',
        'rewrite'             => array(
            'slug'       => 'portfolio',
            'with_front' => false,
        ),
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-format-gallery',
    ));
}
add_action('init', 'wvn_register_portfolio_post_type', 5);

function wvn_register_projects_post_type() {
    register_post_type('projects', array(
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'projects'),
        'has_archive' => true,
        'public' => true,
        'publicly_queryable' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Projects',
            'add_new_item' => 'Add New Project',
            'all_items' => 'All Projects',
            'singular' => 'Project'
        ),
        'menu_icon' => 'dashicons-align-left',
        'template' => array(
            array('core/pattern', array(
                'slug' => 'itc/project-detail',
            ))
        )
    ));
}
add_action('init', 'wvn_register_projects_post_type');

function custom_post_type_events() {
    $args = array(
        'labels' => array(
            'name'          => __('Events'),
            'singular_name' => __('Event'),
            'add_new'       => __('Add New Event'),
            'add_new_item'  => __('Add New Event'),
            'edit_item'     => __('Edit Event'),
            'new_item'      => __('New Event'),
            'view_item'     => __('View Event'),
            'search_items'  => __('Search Events'),
            'not_found'     => __('No events found'),
            'not_found_in_trash' => __('No events found in Trash'),
        ),
        'public'        => true,
        'has_archive'   => true,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-calendar',
        'supports'      => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite'       => array('slug' => 'events'),
        'show_in_rest'  => true,
    );

    register_post_type('events', $args);
}
add_action('init', 'custom_post_type_events');

function remove_custom_post_type_obituaries() {
    global $wp_post_types;

    if (isset($wp_post_types['obituaries'])) {
        unset($wp_post_types['obituaries']);
    }
}
add_action('init', 'remove_custom_post_type_obituaries', 100);

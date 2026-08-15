<?php

/* Register Post Types */
function theme_post_types()
{
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
			array( 'core/pattern', array(
				'slug' => 'itc/project-detail',
			) )
		)
    ));
}
add_action('init', 'theme_post_types');

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
        'menu_icon'     => 'dashicons-calendar', // Uses WordPress' built-in calendar icon
        'supports'      => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite'       => array('slug' => 'events'),
        'show_in_rest'  => true, // Enables Gutenberg support
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



<?php
/* Widgets  */
function theme_widgets_init() {
  register_sidebar(array(
		'name'          => 'Header Content',
		'id'            => 'header_content',
        'before_widget' => '',
        'after_widget' => '',
	));
  register_sidebar(array(
		'name'          => 'Footer Column One',
		'id'            => 'footer_one',
        'before_widget' => '',
        'after_widget' => '',
	));
  register_sidebar(array(
		'name'          => 'Footer Column Two',
		'id'            => 'footer_two',
        'before_widget' => '',
        'after_widget' => '',
	));
  register_sidebar(array(
		'name'          => 'Footer Column Three',
		'id'            => 'footer_three',
        'before_widget' => '',
        'after_widget' => '',
	));
  register_sidebar(array(
		'name'          => 'Photo Collage',
		'id'            => 'photo_collage',
        'before_widget' => '',
        'after_widget' => '',
	));
  register_sidebar(array(
		'name'          => 'Social Links',
		'id'            => 'social_links',
        'before_widget' => '',
        'after_widget' => '',
	));
  register_sidebar(array(
		'name'          => 'Global Sidebar',
		'id'            => 'global_sidebar',
        'before_widget' => '',
        'after_widget' => '',
	));
}
add_action( 'widgets_init', 'theme_widgets_init' );
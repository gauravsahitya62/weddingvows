<?php
/**
 * Create the isolated cinematic test page once. The page uses a dedicated
 * template and never changes the existing homepage or editorial pages.
 */
function wvn_create_cinematic_test_page() {
    $existing = get_page_by_path('cinematic-test', OBJECT, 'page');
    if ($existing) {
        return;
    }

    $page_id = wp_insert_post(array(
        'post_title'  => 'Cinematic Test — Wedding Vows by Nikhil',
        'post_name'   => 'cinematic-test',
        'post_status' => 'publish',
        'post_type'   => 'page',
        'post_content'=> '',
    ));

    if ($page_id && !is_wp_error($page_id)) {
        update_post_meta($page_id, '_wp_page_template', 'page-cinematic-test.php');
    }
}
add_action('init', 'wvn_create_cinematic_test_page', 50);

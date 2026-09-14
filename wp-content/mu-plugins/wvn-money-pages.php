<?php
/**
 * Forces the premium money-page presentation for commercial SEO pages.
 */

function wvn_money_page_slugs() {
    return array(
        'wedding-planner-udaipur',
        'destination-wedding-planner-udaipur',
        'luxury-wedding-planner-udaipur',
        'destination-wedding-udaipur',
        'wedding-venues-udaipur',
        'palace-wedding-venues-in-udaipur',
        'udaipur-wedding-cost',
        'event-planner-udaipur',
    );
}

function wvn_money_page_template($template) {
    if (is_page() && in_array(get_post_field('post_name', get_queried_object_id()), wvn_money_page_slugs(), true)) {
        $candidate = get_theme_file_path('/page-money-landing.php');
        if (file_exists($candidate)) {
            return $candidate;
        }
    }
    return $template;
}
add_filter('template_include', 'wvn_money_page_template', 99);

function wvn_enqueue_money_page_assets() {
    if (!is_page() || !in_array(get_post_field('post_name', get_queried_object_id()), wvn_money_page_slugs(), true)) {
        return;
    }

    wp_enqueue_style(
        'wvn-money-pages',
        get_theme_file_uri('/css/wvn-money-pages.css'),
        array('wvn-overrides'),
        '2.0.0'
    );
}
add_action('wp_enqueue_scripts', 'wvn_enqueue_money_page_assets', 30);

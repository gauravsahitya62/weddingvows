<?php
/**
 * Plugin Name: WVN Local SEO Meta Bridge
 * Description: Keeps durable local SEO page metadata aligned with the site's main SEO framework.
 */

if (!defined('ABSPATH')) {
    exit;
}

function wvn_local_seo_meta_page() {
    if (!is_page()) {
        return null;
    }

    $slug = get_post_field('post_name', get_queried_object_id());
    if (!function_exists('wvn_local_seo_pages')) {
        return null;
    }

    $pages = wvn_local_seo_pages();
    return !empty($pages[$slug]) ? $pages[$slug] : null;
}

function wvn_local_seo_meta_current($seo) {
    $page = wvn_local_seo_meta_page();
    if (!$page) {
        return $seo;
    }

    $seo['title'] = $page['seo_title'];
    $seo['description'] = $page['description'];
    $seo['type'] = 'website';
    return $seo;
}
add_filter('wvn_seo_current', 'wvn_local_seo_meta_current', 90);

function wvn_local_seo_meta_robots() {
    $page = wvn_local_seo_meta_page();
    if (!$page) {
        return;
    }

    echo '<meta name="robots" content="index,follow,max-image-preview:large">' . "\n";
}
add_action('wp_head', 'wvn_local_seo_meta_robots', 4);

<?php
/**
 * Plugin Name: WVN Final SEO Hardening
 * Description: Final production guardrails for canonical output, robots directives, and sitemap ownership.
 */

if (!defined('ABSPATH')) { exit; }

function wvn_final_seo_disable_legacy_sitemap() {
    if (function_exists('wvn_seo_render_sitemap')) { remove_action('template_redirect', 'wvn_seo_render_sitemap', 0); }
}
add_action('init', 'wvn_final_seo_disable_legacy_sitemap', 100);

function wvn_final_seo_robots($robots) {
    if (is_search() || is_404() || is_attachment() || is_author() || is_date() || is_tag() || is_paged()) {
        $robots['noindex'] = true;
        $robots['nofollow'] = true;
    }
    $robots['max-image-preview'] = 'large';
    $robots['max-snippet'] = -1;
    $robots['max-video-preview'] = -1;
    return $robots;
}
add_filter('wp_robots', 'wvn_final_seo_robots', 100);

function wvn_final_seo_remove_feed_links() {
    if (!is_admin()) {
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);
    }
}
add_action('wp_head', 'wvn_final_seo_remove_feed_links', 1);

function wvn_final_seo_webpage_schema() {
    if (is_search() || is_404() || is_feed() || is_admin()) { return; }
    $url = wp_get_canonical_url() ?: home_url('/');
    $title = wp_get_document_title();
    $seo = function_exists('wvn_seo_current') ? wvn_seo_current() : array();
    $description = !empty($seo['description']) ? $seo['description'] : get_bloginfo('description');
    $data = array('@context' => 'https://schema.org', '@type' => 'WebPage', '@id' => trailingslashit($url) . '#webpage', 'url' => $url, 'name' => $title, 'description' => wp_strip_all_tags($description), 'inLanguage' => 'en-IN');
    if (function_exists('wvn_seo_profile')) {
        $profile = wvn_seo_profile();
        $data['publisher'] = array('@id' => trailingslashit($profile['url']) . '#organization');
    }
    echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'wvn_final_seo_webpage_schema', 31);

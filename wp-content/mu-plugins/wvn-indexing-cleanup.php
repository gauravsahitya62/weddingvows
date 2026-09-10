<?php
/**
 * Wedding Vows by Nikhil: keep legacy/test URLs out of the index while
 * preserving useful link equity and the current editorial URL structure.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('template_redirect', function () {
    if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
        return;
    }

    $request_uri = wp_parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $path = trim((string) $request_uri, '/');

    $redirects = array(
        // Legacy service URL -> current canonical service page.
        'how-we-do-it' => home_url('/what-we-do/'),

        // Normalize the historical no-trailing-slash about URL.
        'who-we-are' => home_url('/who-we-are/'),

        // Never allow an internal/test portfolio item to become a search result.
        'portfolio/test' => home_url('/portfolio/'),
    );

    if (isset($redirects[$path])) {
        wp_safe_redirect($redirects[$path], 301, 'Wedding Vows SEO URL Cleanup');
        exit;
    }
}, 1);

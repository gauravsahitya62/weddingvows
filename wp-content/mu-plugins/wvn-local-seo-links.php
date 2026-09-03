<?php
/**
 * Plugin Name: WVN Local SEO Internal Links
 * Description: Adds contextual links between Udaipur venue authority pages.
 */

if (!defined('ABSPATH')) {
    exit;
}

function wvn_local_seo_venue_links() {
    return array(
        'Taj Lake Palace Wedding' => '/taj-lake-palace-wedding/',
        'Jagmandir Wedding Udaipur' => '/jagmandir-wedding-udaipur/',
        'Oberoi Udaivilas Wedding' => '/oberoi-udaivilas-wedding/',
        'Leela Palace Udaipur Wedding' => '/leela-palace-udaipur-wedding/',
        'Raffles Udaipur Wedding' => '/raffles-udaipur-wedding/',
        'Fairmont Udaipur Wedding' => '/fairmont-udaipur-wedding/',
    );
}

function wvn_local_seo_add_venue_links($content) {
    if (!is_page(array('wedding-venues-udaipur', 'palace-wedding-venues-in-udaipur', 'weddings-in-udaipur'))) {
        return $content;
    }

    $items = array();
    foreach (wvn_local_seo_venue_links() as $label => $url) {
        $items[] = '<li><a href="' . esc_url($url) . '">' . esc_html($label) . '</a></li>';
    }

    return $content
        . '<section class="wvn-venue-links" aria-labelledby="wvn-venue-links-title">'
        . '<h2 id="wvn-venue-links-title">Explore individual Udaipur wedding venues</h2>'
        . '<ul>' . implode('', $items) . '</ul>'
        . '</section>';
}
add_filter('the_content', 'wvn_local_seo_add_venue_links', 25);

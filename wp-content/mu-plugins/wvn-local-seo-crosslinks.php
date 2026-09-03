<?php
/**
 * Plugin Name: WVN Local SEO Crosslinks
 * Description: Adds useful venue-specific links to the main Udaipur venue guides.
 */

if (!defined('ABSPATH')) {
    exit;
}

function wvn_local_seo_crosslinks($content) {
    if (!is_page()) {
        return $content;
    }

    $slug = get_post_field('post_name', get_queried_object_id());
    if (!in_array($slug, array('wedding-venues-udaipur', 'palace-wedding-venues-in-udaipur'), true)) {
        return $content;
    }

    $links = array(
        array('label' => 'Taj Lake Palace Wedding', 'url' => '/taj-lake-palace-wedding/'),
        array('label' => 'Jagmandir Wedding Udaipur', 'url' => '/jagmandir-wedding-udaipur/'),
        array('label' => 'Oberoi Udaivilas Wedding', 'url' => '/oberoi-udaivilas-wedding/'),
        array('label' => 'Leela Palace Udaipur Wedding', 'url' => '/leela-palace-udaipur-wedding/'),
        array('label' => 'Raffles Udaipur Wedding', 'url' => '/raffles-udaipur-wedding/'),
        array('label' => 'Fairmont Udaipur Wedding', 'url' => '/fairmont-udaipur-wedding/'),
    );

    $html = '<section class="wvn-local-seo-crosslinks" aria-labelledby="wvn-venue-guides-title">';
    $html .= '<h2 id="wvn-venue-guides-title">Venue-specific wedding guides</h2>';
    $html .= '<p>Planning around a particular property? Use these venue guides for practical notes on guest logistics, functions, décor and coordination.</p><ul>';
    foreach ($links as $link) {
        $html .= '<li><a href="' . esc_url(home_url($link['url'])) . '">' . esc_html($link['label']) . '</a></li>';
    }
    $html .= '</ul></section>';

    return $content . $html;
}
add_filter('the_content', 'wvn_local_seo_crosslinks', 20);

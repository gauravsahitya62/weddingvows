<?php
/**
 * Homepage SEO metadata for Wedding Vows by Nikhil.
 * Keeps the existing homepage design and markup unchanged.
 */

function wvn_homepage_seo_title($value) {
    if (is_front_page()) {
        return 'Wedding & Event Planner in Udaipur | Wedding Vows by Nikhil';
    }
    return $value;
}
add_filter('pre_get_document_title', 'wvn_homepage_seo_title', 40);
add_filter('wpseo_title', 'wvn_homepage_seo_title', 40);
add_filter('wpseo_opengraph_title', 'wvn_homepage_seo_title', 40);
add_filter('wpseo_twitter_title', 'wvn_homepage_seo_title', 40);

function wvn_homepage_seo_description($value) {
    if (is_front_page()) {
        return 'Plan your Udaipur destination wedding with Wedding Vows by Nikhil. Explore palace and luxury weddings, venue planning, décor, guest hospitality and end-to-end wedding and event management.';
    }
    return $value;
}
add_filter('wpseo_metadesc', 'wvn_homepage_seo_description', 40);
add_filter('wpseo_opengraph_desc', 'wvn_homepage_seo_description', 40);
add_filter('wpseo_twitter_description', 'wvn_homepage_seo_description', 40);

function wvn_homepage_seo_schema() {
    if (!is_front_page()) {
        return;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WeddingPlanner',
        'name' => 'Wedding Vows by Nikhil',
        'url' => home_url('/'),
        'description' => 'Wedding and destination event planning in Udaipur, including palace and luxury weddings, venue sourcing, design, guest hospitality and on-ground coordination.',
        'areaServed' => array(
            array('@type' => 'City', 'name' => 'Udaipur'),
            array('@type' => 'AdministrativeArea', 'name' => 'Rajasthan'),
        ),
        'sameAs' => array(
            'https://www.instagram.com/',
        ),
    );

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'wvn_homepage_seo_schema', 19);

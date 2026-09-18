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
        return 'Wedding planner in Udaipur for luxury destination weddings and events. Explore palace weddings, venue sourcing, décor, guest hospitality and end-to-end planning by Wedding Vows by Nikhil.';
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
        'description' => 'Wedding and event planner in Udaipur for luxury destination weddings, palace celebrations, venue sourcing, décor, guest hospitality and on-ground coordination across Rajasthan.',
        'areaServed' => array(
            array('@type' => 'City', 'name' => 'Udaipur'),
            array('@type' => 'AdministrativeArea', 'name' => 'Rajasthan'),
        ),
        'sameAs' => array(
            'https://www.instagram.com/weddingvowsbynikhil',
            'https://www.facebook.com/share/16DJ386egg/?mibextid=wwXIfr',
            'https://www.youtube.com/@weddingvowsbynikhil',
            'https://www.wedmegood.com/profile/Wedding-Vows-by-Nikhil-25668282',
        ),
    );

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'wvn_homepage_seo_schema', 19);


function wvn_homepage_seo_content() {
    if (!is_front_page()) {
        return;
    }

    echo '<section class="wvn-home-seo-copy" aria-labelledby="wvn-home-seo-heading">';
    echo '<div class="wvn-home-seo-copy__inner">';
    echo '<p class="wvn-kicker">Wedding planning in Udaipur</p>';
    echo '<h2 id="wvn-home-seo-heading">Wedding &amp; Event Planner in Udaipur</h2>';
    echo '<p>Wedding Vows by Nikhil plans destination weddings and events in Udaipur, from palace celebrations and lakeside ceremonies to intimate and large multi-day weddings. Our team coordinates venue sourcing, wedding décor and design, guest hospitality, production and on-ground execution.</p>';
    echo '<p>Planning a destination wedding in Udaipur? Explore our <a href="' . esc_url(home_url('/weddings-in-udaipur/')) . '">Udaipur wedding planning guide</a>, compare <a href="' . esc_url(home_url('/wedding-venues-udaipur/')) . '">wedding venues in Udaipur</a>, review <a href="' . esc_url(home_url('/udaipur-wedding-cost/')) . '">Udaipur wedding costs</a>, or see our <a href="' . esc_url(home_url('/portfolio/')) . '">real wedding portfolio</a>.</p>';
    echo '</div>';
    echo '</section>';
}
add_action('wp_footer', 'wvn_homepage_seo_content', 8);


function wvn_homepage_about_schema() {
    if (!is_front_page()) {
        return;
    }

    $profile = function_exists('wvn_seo_profile') ? wvn_seo_profile() : array();
    $org = array(
        '@context' => 'https://schema.org',
        '@type' => array('LocalBusiness', 'ProfessionalService'),
        'name' => 'Wedding Vows by Nikhil',
        'url' => home_url('/'),
        'logo' => !empty($profile['logo']) ? $profile['logo'] : '',
        'image' => !empty($profile['image']) ? $profile['image'] : '',
        'telephone' => !empty($profile['phone']) ? $profile['phone'] : '',
        'email' => !empty($profile['email']) ? $profile['email'] : '',
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => !empty($profile['street']) ? $profile['street'] : '',
            'addressLocality' => 'Udaipur',
            'addressRegion' => 'Rajasthan',
            'postalCode' => '313001',
            'addressCountry' => 'IN',
        ),
        'areaServed' => array(
            array('@type' => 'City', 'name' => 'Udaipur'),
            array('@type' => 'AdministrativeArea', 'name' => 'Rajasthan'),
            array('@type' => 'Country', 'name' => 'India'),
        ),
        'sameAs' => !empty($profile['same_as']) ? $profile['same_as'] : array(),
    );

    echo '<script type="application/ld+json">' . wp_json_encode($org, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'wvn_homepage_about_schema', 20);

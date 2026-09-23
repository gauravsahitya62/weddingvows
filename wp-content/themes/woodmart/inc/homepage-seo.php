<?php
/**
 * Homepage SEO metadata for Wedding Vows by Nikhil.
 * Keeps the existing homepage design and markup unchanged.
 */

function wvn_homepage_seo_title($value) {
    if (is_front_page()) {
        return 'Destination Wedding Planner in Udaipur | Wedding & Event Planner';
    }
    return $value;
}
add_filter('pre_get_document_title', 'wvn_homepage_seo_title', 40);
add_filter('wpseo_title', 'wvn_homepage_seo_title', 40);
add_filter('wpseo_opengraph_title', 'wvn_homepage_seo_title', 40);
add_filter('wpseo_twitter_title', 'wvn_homepage_seo_title', 40);

function wvn_homepage_seo_description($value) {
    if (is_front_page()) {
        return 'Destination wedding planner in Udaipur for palace, lakeside and luxury weddings. Wedding Vows by Nikhil handles venues, décor, hospitality and planning.';
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
        '@type' => 'ProfessionalService',
        'additionalType' => 'https://schema.org/WeddingPlanner',
        'name' => 'Wedding Vows by Nikhil',
        'url' => home_url('/'),
        'description' => 'Destination wedding planner and event planner in Udaipur for luxury palace weddings, lakeside celebrations, venue sourcing, décor, guest hospitality and on-ground coordination across Rajasthan.',
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

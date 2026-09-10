<?php
/**
 * SEO growth layer for Wedding Vows by Nikhil.
 * Adds keyword-led landing-page metadata and contextual internal links
 * without replacing the existing SEO implementation.
 */

function wvn_growth_landing_seo($value, $type = 'title') {
    if (!is_page() || !function_exists('wvn_seo_landing_config')) {
        return $value;
    }

    $slug = get_post_field('post_name', get_queried_object_id());
    if (!$slug) {
        return $value;
    }

    $cfg = wvn_seo_landing_config($slug);
    if (!is_array($cfg)) {
        return $value;
    }

    if ($type === 'title' && !empty($cfg['seo_title'])) {
        return $cfg['seo_title'];
    }
    if ($type === 'description' && !empty($cfg['description'])) {
        return $cfg['description'];
    }

    return $value;
}

function wvn_growth_document_title($parts) {
    $title = wvn_growth_landing_seo('', 'title');
    return $title ? array('title' => $title) : $parts;
}
add_filter('document_title_parts', 'wvn_growth_document_title', 45);

function wvn_growth_wpseo_title($title) {
    return wvn_growth_landing_seo($title, 'title');
}
add_filter('wpseo_title', 'wvn_growth_wpseo_title', 45);
add_filter('wpseo_opengraph_title', 'wvn_growth_wpseo_title', 45);
add_filter('wpseo_twitter_title', 'wvn_growth_wpseo_title', 45);

function wvn_growth_wpseo_desc($desc) {
    return wvn_growth_landing_seo($desc, 'description');
}
add_filter('wpseo_metadesc', 'wvn_growth_wpseo_desc', 45);
add_filter('wpseo_opengraph_desc', 'wvn_growth_wpseo_desc', 45);
add_filter('wpseo_twitter_description', 'wvn_growth_wpseo_desc', 45);

function wvn_growth_post_meta() {
    if (is_admin() || !is_singular('post')) {
        return;
    }

    $post_id = get_the_ID();
    $published = get_post_time(DATE_W3C, true, $post_id);
    $modified = get_post_modified_time(DATE_W3C, true, $post_id);

    echo '<meta name="author" content="Nikhil Salvi">' . "\n";
    if ($published) {
        echo '<meta property="article:published_time" content="' . esc_attr($published) . '">' . "\n";
    }
    if ($modified) {
        echo '<meta property="article:modified_time" content="' . esc_attr($modified) . '">' . "\n";
    }
}
add_action('wp_head', 'wvn_growth_post_meta', 6);

function wvn_growth_related_links($content) {
    if (is_admin() || !is_singular('post') || !in_the_loop() || !is_main_query()) {
        return $content;
    }

    $links = array(
        array('label' => 'Weddings in Udaipur: venues, costs & planning', 'url' => home_url('/weddings-in-udaipur/')),
        array('label' => 'Destination wedding planner in Udaipur', 'url' => home_url('/destination-wedding-planner-udaipur/')),
        array('label' => 'Wedding planning services', 'url' => home_url('/what-we-do/')),
        array('label' => 'Real Udaipur weddings', 'url' => home_url('/portfolio/')),
    );

    $title = strtolower(get_the_title());
    $filtered = array();
    foreach ($links as $link) {
        if (strpos($title, 'destination wedding planner') !== false && strpos($link['label'], 'Destination wedding planner') !== false) {
            continue;
        }
        $filtered[] = $link;
    }

    $html = '<aside class="wvn-seo-related" aria-label="Related Udaipur wedding planning resources">';
    $html .= '<p class="wvn-seo-related-kicker">Continue planning</p>';
    $html .= '<h2>Udaipur wedding planning guides</h2>';
    $html .= '<div class="wvn-seo-related-grid">';
    foreach (array_slice($filtered, 0, 4) as $link) {
        $html .= '<a href="' . esc_url($link['url']) . '">' . esc_html($link['label']) . ' <span aria-hidden="true">↗</span></a>';
    }
    $html .= '</div></aside>';

    return $content . $html;
}
add_filter('the_content', 'wvn_growth_related_links', 30);

function wvn_growth_ping_core_sitemaps() {
    if (!function_exists('wp_get_sitemap_providers')) {
        return;
    }
}

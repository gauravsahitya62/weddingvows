<?php
/**
 * Real wedding case-study SEO layer for Wedding Vows by Nikhil.
 * Enhances existing Portfolio entries without creating or overwriting content.
 */

if (!defined('ABSPATH')) {
    exit;
}

function wvn_case_study_seo_links($content) {
    if (is_admin() || !is_singular('portfolio') || !in_the_loop() || !is_main_query()) {
        return $content;
    }

    $links = array(
        array('label' => 'Wedding planner in Udaipur', 'url' => home_url('/wedding-planner-udaipur/')),
        array('label' => 'Udaipur destination wedding guide', 'url' => home_url('/weddings-in-udaipur/')),
        array('label' => 'Destination wedding planner in Udaipur', 'url' => home_url('/destination-wedding-planner-udaipur/')),
        array('label' => 'Plan your wedding with us', 'url' => home_url('/contact-us/')),
    );

    $html = '<aside class="wvn-seo-related" aria-label="Wedding planning resources">';
    $html .= '<p class="wvn-seo-related-kicker">Continue planning</p>';
    $html .= '<h2>Planning a similar Udaipur wedding?</h2>';
    $html .= '<div class="wvn-seo-related-grid">';
    foreach ($links as $link) {
        $html .= '<a href="' . esc_url($link['url']) . '">' . esc_html($link['label']) . ' <span aria-hidden="true">↗</span></a>';
    }
    $html .= '</div></aside>';

    return $content . $html;
}
add_filter('the_content', 'wvn_case_study_seo_links', 35);

function wvn_case_study_seo_meta() {
    if (is_admin() || !is_singular('portfolio')) {
        return;
    }

    $post_id = get_queried_object_id();
    $title = get_the_title($post_id);
    $description = wp_strip_all_tags(get_the_excerpt($post_id));
    if (!$description) {
        $description = wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $post_id)), 28, '…');
    }

    echo '<meta name="author" content="Nikhil Salvi">' . "\n";
    if ($description) {
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    }
}
add_action('wp_head', 'wvn_case_study_seo_meta', 5);

function wvn_case_study_seo_schema() {
    if (is_admin() || !is_singular('portfolio')) {
        return;
    }

    $post_id = get_queried_object_id();
    $title = get_the_title($post_id);
    $url = get_permalink($post_id);
    $description = wp_strip_all_tags(get_the_excerpt($post_id));
    if (!$description) {
        $description = wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $post_id)), 35, '…');
    }
    $image = get_the_post_thumbnail_url($post_id, 'full');
    $published = get_post_time(DATE_W3C, true, $post_id);
    $modified = get_post_modified_time(DATE_W3C, true, $post_id);

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $title,
        'description' => $description,
        'mainEntityOfPage' => array('@type' => 'WebPage', '@id' => $url),
        'author' => array('@type' => 'Person', 'name' => 'Nikhil Salvi'),
        'publisher' => array('@type' => 'Organization', 'name' => 'Wedding Vows by Nikhil', 'url' => home_url('/')),
        'datePublished' => $published,
        'dateModified' => $modified,
        'url' => $url,
    );

    if ($image) {
        $schema['image'] = array($image);
    }

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
add_action('wp_head', 'wvn_case_study_seo_schema', 19);

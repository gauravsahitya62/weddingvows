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

/**
 * Add one distinct, evergreen Journal article without touching existing posts.
 * Intent: choosing an Udaipur wedding venue by guest count and event needs.
 */
function wvn_seed_guest_count_venue_article() {
    if (get_option('wvn_guest_count_venue_article_v1') === '1') {
        return;
    }

    $slug = 'udaipur-wedding-venues-by-guest-count';
    if (get_page_by_path($slug, OBJECT, 'post')) {
        update_option('wvn_guest_count_venue_article_v1', '1', false);
        return;
    }

    $content = '<p>Choosing a wedding venue in Udaipur starts with the guest list, not the Instagram save folder. A property that feels perfect for 80 guests can become difficult for 200 once rooms, dining, ceremony capacity and guest movement are considered.</p>'
        . '<h2>For 50–80 guests: prioritize character and privacy</h2>'
        . '<p>Smaller celebrations can make better use of intimate heritage properties, private courtyards and boutique luxury hotels. Look for spaces where your guests can stay close to the main functions rather than paying for a large campus you do not need.</p>'
        . '<h2>For 80–150 guests: balance rooms and function spaces</h2>'
        . '<p>This is where the room block becomes as important as the ceremony setting. Check how many rooms can be committed to the wedding, where welcome and dining functions can happen, and whether guests can move between events without complicated transfers.</p>'
        . '<h2>For 150–250 guests: plan the logistics before the décor</h2>'
        . '<p>Larger groups need a venue with practical circulation, multiple function areas and enough accommodation nearby. Ask about arrival flow, shuttle requirements, kitchen and catering logistics, sound restrictions, production access and contingency spaces before you lock the design.</p>'
        . '<h2>For 250+ guests: think destination campus, not just venue</h2>'
        . '<p>At this size, a beautiful ceremony space is only one part of the decision. A larger resort or a combination of nearby properties may provide better room inventory, back-of-house access, dining capacity and guest movement. The best choice is the property that can carry the whole wedding week without making guests feel like they are constantly travelling.</p>'
        . '<h2>Five questions to ask before booking</h2>'
        . '<ol><li>How many rooms can be held for our dates?</li><li>Which spaces fit each function and guest count?</li><li>What are the venue rules for décor, music and outside vendors?</li><li>How will airport, hotel and event transfers work?</li><li>What is the rain, heat or indoor backup plan?</li></ol>'
        . '<h2>Match the venue to the wedding you actually want</h2>'
        . '<p>Udaipur offers palace hotels, island settings, heritage properties and large luxury resorts, but the right venue depends on your guest list and the rhythm of your celebrations. Start with accommodation and function capacity, then compare the visual experience and budget.</p>'
        . '<p>For a broader comparison of venues, costs and planning considerations, explore our <a href="' . esc_url(home_url('/weddings-in-udaipur/')) . '">Weddings in Udaipur guide</a>. If you already know your guest count and dates, our <a href="' . esc_url(home_url('/wedding-planner-udaipur/')) . '">Udaipur wedding planning team</a> can help you shortlist the right properties.</p>';

    $post_id = wp_insert_post(wp_slash(array(
        'post_title' => 'Udaipur Wedding Venues by Guest Count: How to Choose the Right Fit',
        'post_name' => $slug,
        'post_excerpt' => 'A practical guide to choosing Udaipur wedding venues for 50, 100, 150, 250 and 250+ guests, with room, function and logistics considerations.',
        'post_content' => $content,
        'post_status' => 'publish',
        'post_type' => 'post',
        'comment_status' => 'closed',
    )), true);

    if (!is_wp_error($post_id)) {
        update_post_meta($post_id, '_wvn_seo_focus', 'Udaipur wedding venues by guest count');
        update_post_meta($post_id, '_wvn_seo_description', 'How to choose wedding venues in Udaipur by guest count, room inventory, function capacity and guest logistics.');
        update_post_meta($post_id, '_wvn_seo_seeded', '1');
        update_option('wvn_guest_count_venue_article_v1', '1', false);
    }
}
add_action('init', 'wvn_seed_guest_count_venue_article', 32);

<?php
/**
 * Plugin Name: WVN Local SEO Authority
 * Description: Adds durable Udaipur venue and wedding-cost landing pages without depending on theme templates.
 */

if (!defined('ABSPATH')) {
    exit;
}

function wvn_local_seo_pages() {
    return array(
        'wedding-venues-udaipur' => array(
            'title' => 'Wedding Venues in Udaipur',
            'seo_title' => 'Wedding Venues in Udaipur | Palace, Lake & Resort Venues',
            'description' => 'Compare the best wedding venues in Udaipur, from Taj Lake Palace and Jagmandir to luxury resorts and intimate heritage properties.',
            'content' => '<p>Choosing among the <strong>wedding venues in Udaipur</strong> is the first major decision after your guest list. A beautiful photograph is only one part of the choice: room inventory, ceremony capacity, function spaces, hotel policies, transfers and production access can change the entire wedding experience.</p><h2>Palace wedding venues in Udaipur</h2><p><strong>Taj Lake Palace</strong> and <strong>Jagmandir Island Palace</strong> offer the unmistakable Lake Pichola setting. <strong>The Leela Palace Udaipur</strong>, <strong>Taj Fateh Prakash Palace</strong> and <strong>Oberoi Udaivilas</strong> are strong comparisons when accommodation, multiple functions and luxury hospitality need to work together.</p><h2>Luxury resort wedding venues</h2><p><strong>The Ananta Udaipur</strong>, <strong>Fairmont Udaipur Palace</strong>, <strong>Raffles Udaipur</strong>, <strong>Aurika Udaipur</strong> and <strong>ITC Mementos Udaipur</strong> can suit families looking for a larger destination campus, contemporary facilities or more room inventory.</p><h2>How to shortlist a Udaipur wedding venue</h2><ol><li>Start with your guest count and required room block.</li><li>Check the ceremony and sangeet capacity separately.</li><li>Ask what décor, sound and outside-vendor rules apply.</li><li>Map airport transfers and guest movement between functions.</li><li>Compare the complete venue-and-accommodation cost, not only the room rate.</li></ol><p>Our <a href="/weddings-in-udaipur/">Udaipur wedding guide</a> includes indicative costs and venue comparisons. If you already know your dates, <a href="/contact-us/">talk to Wedding Vows by Nikhil</a> about venue shortlisting and on-ground planning.</p>'
        ),
        'udaipur-wedding-cost' => array(
            'title' => 'Udaipur Wedding Cost',
            'seo_title' => 'Udaipur Wedding Cost | Budget Guide for 150–200 Guests',
            'description' => 'Understand Udaipur wedding costs for 150–200 guests, including venue, rooms, catering, décor, production, photography and planning.',
            'content' => '<p>The <strong>cost of a wedding in Udaipur</strong> depends heavily on the venue, room block and production level. As a planning benchmark, a two-day destination wedding for around 150–200 guests can range from <strong>₹50 lakhs to ₹3+ crores</strong>.</p><h2>Where the budget goes</h2><table><thead><tr><th>Budget head</th><th>Indicative range</th></tr></thead><tbody><tr><td>Venue & accommodation</td><td>₹50 lakhs–₹3+ crores</td></tr><tr><td>Catering</td><td>₹15–30 lakhs per day</td></tr><tr><td>Décor, lighting & production</td><td>₹8–45 lakhs</td></tr><tr><td>Photography & films</td><td>₹4–15 lakhs</td></tr><tr><td>Planning & execution</td><td>Scoped to the wedding</td></tr></tbody></table><h2>How to build the budget correctly</h2><p>Reserve the venue and room block first. Then allocate catering, décor and production, entertainment, photography and guest logistics. A palace buyout, peak-season date or high room requirement can move the total substantially.</p><p>Read the detailed <a href="/weddings-in-udaipur/">weddings in Udaipur guide</a> for venue notes, or <a href="/contact-us/">speak with our planning team</a> for a wedding-specific estimate.</p>'
        ),
        'palace-wedding-venues-in-udaipur' => array(
            'title' => 'Palace Wedding Venues in Udaipur',
            'seo_title' => 'Palace Wedding Venues in Udaipur | Luxury Palace Guide',
            'description' => 'A practical guide to palace wedding venues in Udaipur, including Lake Pichola properties, palace hotels, guest capacity and planning considerations.',
            'content' => '<p>A <strong>palace wedding in Udaipur</strong> works because the architecture already gives every function a sense of place. The planning challenge is matching that setting to guest count, accommodation, ceremony format and production requirements.</p><h2>Taj Lake Palace</h2><p>An iconic island palace on Lake Pichola, suited to couples who want an intimate heritage setting and a dramatic lake arrival. Accommodation and event capacity should be checked against the final guest list before committing.</p><h2>Jagmandir Island Palace</h2><p>A heritage island setting that can make pheras and evening celebrations feel distinctly Udaipur. Guest transfers and event logistics deserve early planning because the venue is reached across the lake.</p><h2>The Leela Palace Udaipur</h2><p>A lakeside palace hotel that can work well when the wedding needs luxury accommodation, multiple functions and a larger guest journey on one property.</p><h2>Oberoi Udaivilas & Taj Fateh Prakash Palace</h2><p>These properties give couples different versions of the palace experience: resort-scale luxury at Oberoi Udaivilas and city-palace heritage at Taj Fateh Prakash. Compare room inventory, lawns, indoor backup spaces and event policies before choosing.</p><h2>Planning a palace wedding</h2><p>Start with the venue contract, room block and function capacities. Then design décor around the architecture rather than hiding it. Our <a href="/weddings-in-udaipur/">Udaipur venue and cost guide</a> is the next step, or <a href="/contact-us/">contact Wedding Vows by Nikhil</a> for local venue planning.</p>'
        )
    );
}

function wvn_local_seo_seed_pages() {
    if (get_option('wvn_local_seo_pages_v1') === '1') {
        return;
    }
    foreach (wvn_local_seo_pages() as $slug => $page) {
        $existing = get_page_by_path($slug, OBJECT, 'page');
        if ($existing) {
            continue;
        }
        $id = wp_insert_post(wp_slash(array(
            'post_title' => $page['title'],
            'post_name' => $slug,
            'post_content' => $page['content'],
            'post_excerpt' => $page['description'],
            'post_status' => 'publish',
            'post_type' => 'page',
            'comment_status' => 'closed',
        )), true);
        if (!is_wp_error($id)) {
            update_post_meta($id, '_wvn_local_seo_page', '1');
        }
    }
    update_option('wvn_local_seo_pages_v1', '1', false);
}
add_action('init', 'wvn_local_seo_seed_pages', 25);

function wvn_local_seo_title($parts) {
    if (!is_page()) {
        return $parts;
    }
    $slug = get_post_field('post_name', get_queried_object_id());
    $pages = wvn_local_seo_pages();
    return !empty($pages[$slug]['seo_title']) ? array('title' => $pages[$slug]['seo_title']) : $parts;
}
add_filter('document_title_parts', 'wvn_local_seo_title', 70);
add_filter('wpseo_title', function ($title) {
    if (!is_page()) { return $title; }
    $slug = get_post_field('post_name', get_queried_object_id());
    $pages = wvn_local_seo_pages();
    return !empty($pages[$slug]['seo_title']) ? $pages[$slug]['seo_title'] : $title;
}, 70);
add_filter('wpseo_metadesc', function ($description) {
    if (!is_page()) { return $description; }
    $slug = get_post_field('post_name', get_queried_object_id());
    $pages = wvn_local_seo_pages();
    return !empty($pages[$slug]['description']) ? $pages[$slug]['description'] : $description;
}, 70);

function wvn_local_seo_schema() {
    if (!is_page()) {
        return;
    }
    $slug = get_post_field('post_name', get_queried_object_id());
    $pages = wvn_local_seo_pages();
    if (empty($pages[$slug])) {
        return;
    }
    $page = $pages[$slug];
    $url = trailingslashit(get_permalink());
    $home = trailingslashit(home_url('/'));
    $graph = array(
        array(
            '@type' => 'WebPage',
            '@id' => $url . '#webpage',
            'url' => $url,
            'name' => $page['title'],
            'description' => $page['description'],
            'inLanguage' => 'en-IN',
            'isPartOf' => array('@id' => $home . '#website'),
            'breadcrumb' => array('@id' => $url . '#breadcrumb'),
        ),
        array(
            '@type' => 'Service',
            '@id' => $url . '#service',
            'name' => $page['title'],
            'serviceType' => $page['title'],
            'description' => $page['description'],
            'areaServed' => array('@type' => 'City', 'name' => 'Udaipur'),
            'provider' => array('@id' => $home . '#organization'),
        ),
        array(
            '@type' => 'BreadcrumbList',
            '@id' => $url . '#breadcrumb',
            'itemListElement' => array(
                array('@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $home),
                array('@type' => 'ListItem', 'position' => 2, 'name' => $page['title'], 'item' => $url),
            ),
        ),
    );
    echo '<script type="application/ld+json">' . wp_json_encode(array('@context' => 'https://schema.org', '@graph' => $graph), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'wvn_local_seo_schema', 31);

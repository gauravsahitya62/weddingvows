<?php
/**
 * Forces the premium money-page presentation for commercial SEO pages.
 * Also seeds missing booster pages so they never 404 as empty footer-only shells.
 */

function wvn_money_page_slugs() {
    return array(
        'wedding-planner-udaipur',
        'destination-wedding-planner-udaipur',
        'luxury-wedding-planner-udaipur',
        'destination-wedding-udaipur',
        'wedding-venues-udaipur',
        'palace-wedding-venues-in-udaipur',
        'udaipur-wedding-cost',
        'event-planner-udaipur',
    );
}

function wvn_money_page_seed_defs() {
    return array(
        'wedding-planner-udaipur' => array(
            'title'   => 'Wedding Planner in Udaipur',
            'excerpt' => 'Udaipur wedding planner for palace, lakeside and destination celebrations — venue, design, hospitality and on-ground execution with one local team.',
            'content' => '<p>Wedding Vows by Nikhil is an Udaipur-based wedding planning team for couples who want venue decisions, guest hospitality, design and event-day execution held in one plan.</p>',
        ),
        'destination-wedding-planner-udaipur' => array(
            'title'   => 'Destination Wedding Planner in Udaipur',
            'excerpt' => 'Destination wedding planner in Udaipur for outstation and international couples — venue, rooms, hospitality, design and execution with one local team.',
            'content' => '<p>For families planning from another city or country, we turn Udaipur venue choices, guest logistics and multi-day celebrations into one connected plan.</p>',
        ),
        'luxury-wedding-planner-udaipur' => array(
            'title'   => 'Luxury Wedding Planner in Udaipur',
            'excerpt' => 'Luxury wedding planner in Udaipur for palace and premium destination celebrations — design, hospitality, production and precise execution.',
            'content' => '<p>Luxury in Udaipur is more than a beautiful venue. It is the way design, hospitality and production stay precise from the first arrival to the last farewell.</p>',
        ),
        'destination-wedding-udaipur' => array(
            'title'   => 'Destination Wedding in Udaipur',
            'excerpt' => 'Plan a destination wedding in Udaipur with guidance on venues, guest flow, hospitality, budgets and local execution.',
            'content' => '<p>A destination wedding in Udaipur works best when venue, rooms, guest movement and celebration design are planned together from the start.</p>',
        ),
        'wedding-venues-udaipur' => array(
            'title'   => 'Wedding Venues in Udaipur',
            'excerpt' => 'Compare wedding venues in Udaipur by guest count, room blocks, ceremony spaces and guest experience — from lake palaces to luxury resorts.',
            'content' => '<p>The right wedding venue in Udaipur is the property that fits your guest list, room block and celebration flow — not simply the most photographed address.</p>',
        ),
        'palace-wedding-venues-in-udaipur' => array(
            'title'   => 'Palace Wedding Venues in Udaipur',
            'excerpt' => 'Explore palace wedding venues in Udaipur, from Lake Pichola island settings to palace hotels and heritage courtyards, with practical booking advice.',
            'content' => '<p>A palace wedding in Udaipur should feel regal without making the guest journey complicated. Compare heritage character, rooms, function spaces and production realities before you commit.</p>',
        ),
        'udaipur-wedding-cost' => array(
            'title'   => 'Udaipur Wedding Cost',
            'excerpt' => 'Understand Udaipur wedding costs by guest count and budget category, including venue, rooms, catering, décor, production, photography and planning.',
            'content' => '<p>There is no single Udaipur wedding cost. Your guest count, venue tier, room block, number of functions and level of décor and production move the budget more than any single line item.</p>',
        ),
        'event-planner-udaipur' => array(
            'title'   => 'Event Planner in Udaipur',
            'excerpt' => 'Event planner in Udaipur for weddings, private celebrations and destination events, with planning, design, production, hospitality and on-ground coordination.',
            'content' => '<p>Wedding Vows by Nikhil plans weddings and destination events in Udaipur with one local team coordinating the venue, design, vendors, guest experience and event-day execution.</p>',
        ),
    );
}

/**
 * Ensure every money/SEO booster page exists and is published.
 * Missing pages previously rendered as 404 shells (footer only).
 */
function wvn_seed_money_pages() {
    $defs = wvn_money_page_seed_defs();
    $created = false;
    $missing = false;

    foreach ($defs as $slug => $cfg) {
        $existing = get_page_by_path($slug, OBJECT, 'page');
        if ($existing instanceof WP_Post) {
            if ($existing->post_status !== 'publish') {
                wp_update_post(array(
                    'ID'          => $existing->ID,
                    'post_status' => 'publish',
                ));
                $created = true;
            }
            continue;
        }

        $missing = true;
        $page_id = wp_insert_post(wp_slash(array(
            'post_title'     => $cfg['title'],
            'post_name'      => $slug,
            'post_content'   => $cfg['content'],
            'post_excerpt'   => $cfg['excerpt'],
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'comment_status' => 'closed',
        )), true);

        if (!is_wp_error($page_id)) {
            update_post_meta($page_id, '_wvn_money_page_seeded', '1');
            $created = true;
        }
    }

    if ($created || $missing || get_option('wvn_money_pages_seed_v2') !== '1') {
        if ($created || $missing) {
            flush_rewrite_rules(false);
        }
        update_option('wvn_money_pages_seed_v2', '1', false);
    }
}
add_action('init', 'wvn_seed_money_pages', 26);

function wvn_money_page_template($template) {
    if (is_page() && in_array(get_post_field('post_name', get_queried_object_id()), wvn_money_page_slugs(), true)) {
        $candidate = get_theme_file_path('/page-money-landing.php');
        if (file_exists($candidate)) {
            return $candidate;
        }
    }
    return $template;
}
add_filter('template_include', 'wvn_money_page_template', 99);

function wvn_enqueue_money_page_assets() {
    if (!is_page() || !in_array(get_post_field('post_name', get_queried_object_id()), wvn_money_page_slugs(), true)) {
        return;
    }

    wp_enqueue_style(
        'wvn-money-pages',
        get_theme_file_uri('/css/wvn-money-pages.css'),
        array('wvn-overrides'),
        '2.0.1'
    );
}
add_action('wp_enqueue_scripts', 'wvn_enqueue_money_page_assets', 30);

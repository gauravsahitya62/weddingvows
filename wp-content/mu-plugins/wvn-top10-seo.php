<?php
/**
 * Focused on-page SEO improvements for Udaipur commercial pages.
 * Loads automatically as a WordPress must-use plugin and leaves existing
 * theme architecture intact.
 */

if (!defined('ABSPATH')) {
    exit;
}

function wvn_top10_target_page() {
    return is_page(array(
        'wedding-planner-udaipur',
        'destination-wedding-planner-udaipur',
        'destination-wedding-udaipur',
        'event-planner-udaipur',
    ));
}

function wvn_top10_page_meta($title, $description) {
    if (!wvn_top10_target_page()) {
        return null;
    }

    $slug = get_post_field('post_name', get_queried_object_id());
    if ($slug === 'wedding-planner-udaipur') {
        return array(
            'title' => 'Best Wedding Planner in Udaipur | Wedding Vows by Nikhil',
            'description' => 'Looking for the best wedding planner in Udaipur? Wedding Vows by Nikhil plans palace, lakeside and luxury destination weddings with local planning, guest hospitality, design and on-ground execution.',
        );
    }

    if ($slug === 'destination-wedding-planner-udaipur') {
        return array(
            'title' => 'Destination Wedding Planner in Udaipur | Wedding Vows by Nikhil',
            'description' => 'Destination wedding planner in Udaipur for couples planning from India or abroad, with venue sourcing, guest hospitality, wedding design, production and on-ground coordination.',
        );
    }

    if ($slug === 'destination-wedding-udaipur') {
        return array(
            'title' => 'Destination Wedding in Udaipur | Venues, Costs & Planning',
            'description' => 'Plan a destination wedding in Udaipur with practical guidance on palace and resort venues, guest logistics, major cost heads, seasons and local wedding planning.',
        );
    }

    if ($slug === 'event-planner-udaipur') {
        return array(
            'title' => 'Best Event Planner in Udaipur | Wedding Vows by Nikhil',
            'description' => 'Event planner in Udaipur for weddings, private celebrations and destination events, with planning, design, production, hospitality and on-ground coordination.',
        );
    }

    return null;
}

function wvn_top10_document_title($parts) {
    $meta = wvn_top10_page_meta('', '');
    return $meta ? array('title' => $meta['title']) : $parts;
}
add_filter('document_title_parts', 'wvn_top10_document_title', 80);

function wvn_top10_wpseo_title($title) {
    $meta = wvn_top10_page_meta('', '');
    return $meta ? $meta['title'] : $title;
}
add_filter('wpseo_title', 'wvn_top10_wpseo_title', 80);
add_filter('wpseo_opengraph_title', 'wvn_top10_wpseo_title', 80);
add_filter('wpseo_twitter_title', 'wvn_top10_wpseo_title', 80);

function wvn_top10_wpseo_description($description) {
    $meta = wvn_top10_page_meta('', '');
    return $meta ? $meta['description'] : $description;
}
add_filter('wpseo_metadesc', 'wvn_top10_wpseo_description', 80);
add_filter('wpseo_opengraph_desc', 'wvn_top10_wpseo_description', 80);
add_filter('wpseo_twitter_description', 'wvn_top10_wpseo_description', 80);

function wvn_top10_page_enhancement($content) {
    if (is_admin() || !is_page() || !in_the_loop() || !is_main_query()) {
        return $content;
    }

    $slug = get_post_field('post_name', get_queried_object_id());
    $blocks = '';

    if ($slug === 'wedding-planner-udaipur') {
        $blocks = '<section class="wvn-seo-proof"><p class="wvn-kicker">For couples planning in Udaipur</p><h2 class="wvn-display">What to expect from a strong local wedding planner</h2><p>Choosing a wedding planner is about more than décor. A local planning team should be able to connect venue decisions, guest movement, hospitality, design, production and the wedding-day run sheet into one plan.</p><h3>Venue knowledge that starts with the guest list</h3><p>Udaipur has palace hotels, lake-facing properties, heritage venues and large luxury resorts. The right recommendation depends on guest count, room inventory, function capacity, budget and how easily guests can move between events.</p><h3>Planning support from arrival to farewell</h3><p>For destination celebrations, the planning layer continues beyond the functions: airport arrivals, room blocks, welcome experiences, transport, vendor access and timing all need to work together.</p><p>See the <a href="' . esc_url(home_url('/weddings-in-udaipur/')) . '">Weddings in Udaipur guide</a>, explore our <a href="' . esc_url(home_url('/portfolio/')) . '">real wedding portfolio</a>, or <a href="' . esc_url(home_url('/destination-wedding-planner-udaipur/')) . '">see our destination wedding planning approach</a>.</p></section>';
    } elseif ($slug === 'destination-wedding-planner-udaipur') {
        $blocks = '<section class="wvn-seo-proof"><p class="wvn-kicker">Planning from another city or country</p><h2 class="wvn-display">A destination wedding needs one connected plan</h2><p>For couples and families travelling to Udaipur, the planner has to connect venue sourcing, accommodation, guest hospitality, function design, production and on-ground execution.</p><h3>Built around the destination, not a generic checklist</h3><p>Local planning means decisions can account for Udaipur venue rules, room blocks, transfer routes, production access, local vendors and the practical rhythm of a multi-day celebration.</p><h3>A clearer experience for international and outstation couples</h3><p>Families planning from the US, UK or another Indian city can use one planning team for the local coordination that is hardest to manage remotely, while key decisions remain clear and documented.</p><p>Start with the <a href="' . esc_url(home_url('/weddings-in-udaipur/')) . '">Udaipur wedding guide</a>, review <a href="' . esc_url(home_url('/wedding-planner-udaipur/')) . '">wedding planning services</a>, or browse <a href="' . esc_url(home_url('/portfolio/')) . '">real weddings</a>.</p></section>';
    } elseif ($slug === 'destination-wedding-udaipur') {
        $blocks = '<section class="wvn-seo-proof"><p class="wvn-kicker">Planning guide</p><h2 class="wvn-display">Start with venue, rooms and guest flow</h2><p>The most useful early decisions are not only visual. Before locking décor, compare accommodation capacity, function spaces, guest transfers, venue rules and the overall flow of a multi-day celebration.</p><h3>Then build the budget around real requirements</h3><p>Separate venue and rooms, catering, décor and production, photography and planning so the major cost drivers stay visible as the guest list and functions evolve.</p><p>Need help turning the shortlist into a workable plan? Visit our <a href="' . esc_url(home_url('/wedding-planner-udaipur/')) . '">wedding planner in Udaipur</a> page or <a href="' . esc_url(home_url('/destination-wedding-planner-udaipur/')) . '">destination wedding planner</a> page.</p></section>';
    } elseif ($slug === 'event-planner-udaipur') {
        $blocks = '<section class="wvn-seo-proof"><p class="wvn-kicker">Udaipur event planning</p><h2 class="wvn-display">Planning, production and guest experience in one team</h2><p>Complex events become easier to execute when venue, design, entertainment, production, hospitality and the event-day run sheet are planned together instead of handed between disconnected teams.</p><h3>Local coordination matters</h3><p>Udaipur events can involve palace properties, resort campuses, guest transfers and detailed production schedules. A locally connected planning team can coordinate those moving parts closer to the venue and vendor teams.</p><p>Explore our <a href="' . esc_url(home_url('/portfolio/')) . '">real wedding portfolio</a> or <a href="' . esc_url(home_url('/contact-us/')) . '">tell us about your event</a>.</p></section>';
    }

    return $blocks ? $content . $blocks : $content;
}
add_filter('the_content', 'wvn_top10_page_enhancement', 32);

function wvn_top10_related_post_links($content) {
    if (is_admin() || !is_singular('post') || !in_the_loop() || !is_main_query()) {
        return $content;
    }

    $title = strtolower(get_the_title());
    $links = array();

    if (strpos($title, 'udaipur') !== false || strpos($title, 'wedding') !== false) {
        $links[] = array('text' => 'Best wedding planner in Udaipur', 'url' => home_url('/wedding-planner-udaipur/'));
    }
    if (strpos($title, 'destination') !== false || strpos($title, 'guest') !== false || strpos($title, 'hospitality') !== false) {
        $links[] = array('text' => 'Destination wedding planner in Udaipur', 'url' => home_url('/destination-wedding-planner-udaipur/'));
    }

    if (!$links) {
        return $content;
    }

    $html = '<div class="wvn-seo-inline-links"><p class="wvn-seo-related-kicker">Plan the next step</p><p>';
    foreach ($links as $index => $link) {
        if ($index > 0) {
            $html .= ' · ';
        }
        $html .= '<a href="' . esc_url($link['url']) . '">' . esc_html($link['text']) . '</a>';
    }
    $html .= '</p></div>';

    return $content . $html;
}
add_filter('the_content', 'wvn_top10_related_post_links', 31);

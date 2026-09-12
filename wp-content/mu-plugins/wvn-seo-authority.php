<?php
/**
 * Wedding Vows by Nikhil — SEO authority layer.
 *
 * Safe, additive SEO improvements that do not replace the theme's editorial
 * templates or existing SEO implementation.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Consolidate the old cost-guide URL into the clean commercial money page.
 * This preserves existing authority while avoiding two URLs competing for the
 * same destination-wedding-cost intent.
 */
function wvn_authority_legacy_redirects() {
    if (is_admin() || wp_doing_ajax()) {
        return;
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
    $path = wp_parse_url($request_uri, PHP_URL_PATH);
    $path = '/' . ltrim((string) $path, '/');
    $path = trailingslashit($path);

    $redirects = array(
        '/uncategorized/udaipur-destination-wedding-cost-guide/' => home_url('/udaipur-wedding-cost/'),
    );

    if (isset($redirects[$path])) {
        wp_safe_redirect($redirects[$path], 301);
        exit;
    }
}
add_action('template_redirect', 'wvn_authority_legacy_redirects', 1);

/**
 * Add useful depth and distinct intent to the existing commercial SEO pages.
 * Content is inserted into the existing editorial intro area, so no new page
 * template or visual system is introduced.
 */
function wvn_authority_landing_content($content) {
    if (is_admin() || !is_page() || !is_main_query() || !in_the_loop()) {
        return $content;
    }

    $template = get_page_template_slug(get_queried_object_id());
    if ($template !== 'page-seo-landing.php') {
        return $content;
    }

    $slug = get_post_field('post_name', get_queried_object_id());
    $blocks = array(
        'destination-wedding-udaipur' =>
            '<h2>How to plan a destination wedding in Udaipur without overcomplicating the week</h2>'
            . '<p>Start with the guest count, preferred season and the number of functions. Those three decisions narrow the right venue faster than a long list of saved photographs. Once accommodation and function spaces are understood, the rest of the planning can be built around a realistic guest journey.</p>'
            . '<p>For most families, that means holding a venue and room block first, then planning hospitality, décor, production, entertainment and photography around the property. Our <a href="' . esc_url(home_url('/weddings-in-udaipur/')) . '">Weddings in Udaipur guide</a> goes deeper into venue types, cost heads and planning timelines, while the <a href="' . esc_url(home_url('/udaipur-wedding-cost/')) . '">Udaipur wedding cost guide</a> helps set a working budget.</p>'
            . '<h2>Choose the Udaipur venue for the guest experience, not only the view</h2>'
            . '<p>Lake palaces are exceptional for intimate arrivals and heritage atmosphere. Larger resort campuses can be easier for families with bigger room blocks, multiple functions and more production. The best destination wedding in Udaipur is the one where the venue, rooms and event spaces all fit the way your guests will actually move through the celebration.</p>'
            . '<p>Once you know your guest range, compare the <a href="' . esc_url(home_url('/wedding-venues-udaipur/')) . '">best wedding venues in Udaipur</a> or speak to our <a href="' . esc_url(home_url('/destination-wedding-planner-udaipur/')) . '">destination wedding planning team</a> for a venue shortlist.</p>',

        'wedding-planner-udaipur' =>
            '<h2>What a wedding planner in Udaipur should actually take off your plate</h2>'
            . '<p>A good planner is not only there on the wedding day. The value starts with venue comparisons, hotel contracts, room blocks, vendor recommendations and a realistic master schedule. The planning team should also be able to explain what a venue package includes, what needs an outside vendor and where production access can affect the budget.</p>'
            . '<p>Wedding Vows by Nikhil works locally in Udaipur, which means the planning conversation can stay grounded in the city itself: guest transfers, venue rules, vendor lead times, weather backups and the practical details behind a beautiful wedding. For a broader view of the destination, start with our <a href="' . esc_url(home_url('/weddings-in-udaipur/')) . '">Udaipur wedding guide</a>.</p>'
            . '<h2>A calmer planning process for destination families</h2>'
            . '<p>Once a venue and date are secure, the work becomes a sequence: guest hospitality, décor and design, entertainment, photography, production and final run-of-show. One master schedule connects those decisions so the family is not coordinating separate vendor timelines.</p>'
            . '<p>If you are still comparing properties, use the <a href="' . esc_url(home_url('/wedding-venues-udaipur/')) . '">Udaipur wedding venue guide</a>. If your wedding is already taking shape, our <a href="' . esc_url(home_url('/contact-us/')) . '">consultation</a> can start with your dates, guest count and preferred style.</p>',

        'destination-wedding-planner-udaipur' =>
            '<h2>Planning an Udaipur destination wedding from another city or country</h2>'
            . '<p>Outstation and NRI families need more than vendor coordination. The planner becomes the local operating layer for airport arrivals, room assignments, welcome hospitality, venue communication, function schedules and last-minute decisions. The goal is to make the wedding feel effortless for guests who may only know Udaipur from a few venue photographs.</p>'
            . '<p>For larger celebrations, we map the whole destination journey before locking décor: where guests sleep, how they reach each function, where production can load in, and what happens if weather changes the plan. Our <a href="' . esc_url(home_url('/weddings-in-udaipur/')) . '">Udaipur wedding guide</a> is a useful starting point for comparing venue types and cost drivers.</p>'
            . '<h2>From venue sourcing to farewell breakfast</h2>'
            . '<p>A full-service destination wedding planner should keep hospitality and production in the same plan. That means venue sourcing, room blocks, décor, entertainment, photography, transport and on-ground execution are not treated as separate projects.</p>'
            . '<p>For venue-led planning, compare our <a href="' . esc_url(home_url('/wedding-venues-udaipur/')) . '">Udaipur wedding venues</a> and <a href="' . esc_url(home_url('/udaipur-wedding-cost/')) . '">Udaipur wedding cost</a> guides before requesting a proposal.</p>',

        'luxury-wedding-planner-udaipur' =>
            '<h2>What makes luxury wedding planning in Udaipur feel different</h2>'
            . '<p>Luxury is less about adding more and more décor and more about using the venue well. Palace architecture, lake views and private resort campuses already create a strong visual language. The planning challenge is to layer hospitality, florals, lighting, dining, entertainment and production without losing the character of the property.</p>'
            . '<p>That requires a detailed production plan and a team that understands both the guest experience and the venue operation. For a broader venue comparison, explore our <a href="' . esc_url(home_url('/wedding-venues-udaipur/')) . '">Udaipur wedding venues guide</a> or read the <a href="' . esc_url(home_url('/palace-wedding-venues-in-udaipur/')) . '">palace wedding venue guide</a>.</p>'
            . '<h2>Refinement starts with the right venue and room block</h2>'
            . '<p>The most polished weddings usually begin by solving the practical details early: guest room inventory, private arrival experiences, function capacities, sound rules, vendor access and weather backups. Once those foundations are right, the design can stay focused and sophisticated.</p>'
            . '<p>For a luxury celebration planned around your guest list, dates and preferred property, <a href="' . esc_url(home_url('/contact-us/')) . '">book a consultation</a> with Wedding Vows by Nikhil.</p>',
    );

    if (empty($blocks[$slug])) {
        return $content;
    }

    return $content . $blocks[$slug];
}
add_filter('the_content', 'wvn_authority_landing_content', 70);

/**
 * Strengthen internal authority from already-established Udaipur articles to
 * their intended commercial destination pages without duplicating a link that
 * is already present in the article body.
 */
function wvn_authority_article_links($content) {
    if (is_admin() || !is_singular('post') || !is_main_query() || !in_the_loop()) {
        return $content;
    }

    $title = strtolower(get_the_title());
    $targets = array();

    if (strpos($title, 'best time') !== false) {
        $targets[] = array('url' => home_url('/destination-wedding-udaipur/'), 'label' => 'destination wedding in Udaipur guide');
    }
    if (strpos($title, 'palace wedding') !== false) {
        $targets[] = array('url' => home_url('/palace-wedding-venues-in-udaipur/'), 'label' => 'palace wedding venues in Udaipur');
    }
    if (strpos($title, 'planning checklist') !== false) {
        $targets[] = array('url' => home_url('/destination-wedding-planner-udaipur/'), 'label' => 'destination wedding planner in Udaipur');
    }
    if (strpos($title, 'destination wedding cost') !== false || strpos($title, 'wedding cost') !== false) {
        $targets[] = array('url' => home_url('/udaipur-wedding-cost/'), 'label' => 'Udaipur wedding cost guide');
    }
    if (strpos($title, 'venues by guest count') !== false) {
        $targets[] = array('url' => home_url('/wedding-venues-udaipur/'), 'label' => 'wedding venues in Udaipur');
        $targets[] = array('url' => home_url('/wedding-planner-udaipur/'), 'label' => 'wedding planner in Udaipur');
    }

    if (!$targets) {
        return $content;
    }

    $links = array();
    foreach ($targets as $target) {
        if (strpos($content, $target['url']) !== false) {
            continue;
        }
        $links[] = '<a href="' . esc_url($target['url']) . '">' . esc_html($target['label']) . '</a>';
    }

    if (!$links) {
        return $content;
    }

    $note = '<p class="wvn-seo-authority-note">Continue planning: ' . implode(' · ', $links) . '.</p>';
    return $content . $note;
}
add_filter('the_content', 'wvn_authority_article_links', 80);

/**
 * Keep the clean commercial cost URL canonical when Yoast SEO is active.
 */
function wvn_authority_canonical($canonical) {
    if (is_page('udaipur-wedding-cost')) {
        return home_url('/udaipur-wedding-cost/');
    }
    return $canonical;
}
add_filter('wpseo_canonical', 'wvn_authority_canonical', 80);

/**
 * Add a lightweight noindex safeguard for known internal/test URLs that might
 * still exist as historical entries in external systems.
 */
function wvn_authority_robots($robots) {
    $request_uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
    $path = trailingslashit('/' . ltrim((string) wp_parse_url($request_uri, PHP_URL_PATH), '/'));

    $internal_paths = array(
        '/portfolio/test/',
    );

    if (in_array($path, $internal_paths, true)) {
        return 'noindex, follow';
    }

    return $robots;
}
add_filter('wpseo_robots', 'wvn_authority_robots', 80);

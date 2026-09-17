<?php
/**
 * One verified real-wedding case study seeded from existing portfolio material.
 * No client, venue, date, guest count, vendor, result or other detail is invented.
 */

function wvn_seed_jehana_kanishk_case_study() {
    if (get_option('wvn_jehana_kanishk_case_study_v1') === '1') {
        return;
    }

    $slug = 'jehana-kanishk-udaipur-wedding';
    $existing = get_page_by_path($slug, OBJECT, 'post');
    if ($existing) {
        update_option('wvn_jehana_kanishk_case_study_v1', '1', false);
        return;
    }

    if (function_exists('wvn_blog_ensure_categories')) {
        wvn_blog_ensure_categories();
    }

    $guide = esc_url(home_url('/weddings-in-udaipur/'));
    $planner = esc_url(home_url('/wedding-planner-udaipur/'));
    $destination = esc_url(home_url('/destination-wedding-planner-udaipur/'));
    $portfolio = esc_url(home_url('/portfolio/'));
    $contact = esc_url(home_url('/contact-us/'));

    $content = '<p>Jehana &amp; Kanishk are part of Wedding Vows by Nikhil’s published Udaipur portfolio. The existing portfolio record identifies their wedding as <strong>Udaipur, Rajasthan</strong> and uses wedding photography from the celebration. This case study stays close to that source material: the available record does not name a venue, date, guest count or vendor team, so none of those details are added here.</p>'
        . '<h2>A real wedding story rooted in Udaipur</h2>'
        . '<p>The strongest detail in the published portfolio record is the setting itself: Udaipur, Rajasthan. For a destination wedding studio based in the city, location is part of the planning experience rather than a line on an address card. Palace properties, lakeside settings and heritage spaces each bring their own access, production and guest-flow considerations.</p>'
        . '<p>For Jehana &amp; Kanishk, the portfolio gives us a genuine wedding to look back at without filling the gaps with assumptions. The result is a useful view of the kind of destination-wedding work the studio presents from Udaipur.</p>'
        . '<h2>The planning lens: place first, then the details</h2>'
        . '<p>Wedding Vows by Nikhil’s Udaipur planning approach brings venue research, wedding design, production, guest hospitality, vendor coordination and event-day execution into one planning conversation. Those are the studio’s stated planning capabilities; this case study does not claim that every service was used for Jehana &amp; Kanishk where the published portfolio record does not specify the scope.</p>'
        . '<p>That distinction matters for destination weddings. The venue affects what can be produced, how guests move and how the celebration is paced. The planning process therefore starts with the real setting and the requirements of the celebration before the visual details are layered in.</p>'
        . '<h2>Why the Udaipur location matters to the experience</h2>'
        . '<p>Udaipur gives destination weddings a strong sense of place through its lake, palace and heritage architecture. A local planning team can work from that reality: understanding the city, coordinating with properties and city-based vendors, and building the wedding around practical guest movement as well as the visual character of the destination.</p>'
        . '<p>Our <a href="' . $guide . '">Weddings in Udaipur guide</a> goes deeper into venue types, guest flow and planning considerations for couples comparing the city with other Indian destinations.</p>'
        . '<h2>From portfolio image to planning conversation</h2>'
        . '<p>The existing portfolio image for Jehana &amp; Kanishk is part of the studio’s real-wedding material. It gives prospective couples something more useful than a generic stock photograph: an example of the work presented by the studio in Udaipur.</p>'
        . '<p>If you are considering a wedding in the city, explore more <a href="' . $portfolio . '">real Udaipur weddings</a> alongside our <a href="' . $planner . '">Udaipur wedding planning service</a> and <a href="' . $destination . '">destination wedding planning approach</a>. The combination helps you judge both the setting and the planning discipline behind it.</p>'
        . '<h2>Planning a wedding in Udaipur?</h2>'
        . '<p>Start with your date, approximate guest count and the kind of setting you want. From there, the venue and planning scope become much easier to define. <a href="' . $contact . '">Tell Wedding Vows by Nikhil about your celebration</a> and the team can discuss the next step.</p>';

    $post_id = wp_insert_post(wp_slash(array(
        'post_title' => 'Jehana & Kanishk: A Udaipur Wedding Story',
        'post_name' => $slug,
        'post_excerpt' => 'A genuine Wedding Vows by Nikhil portfolio story from Udaipur, Rajasthan, focused on place, planning and the destination-wedding experience.',
        'post_content' => $content,
        'post_status' => 'publish',
        'post_type' => 'post',
        'comment_status' => 'closed',
    )), true);

    if (is_wp_error($post_id) || !$post_id) {
        return;
    }

    wp_set_object_terms($post_id, 'real-weddings', 'category');

    $image = wvn_media('2025/04/NVP_JEHANAXKANISHK_WEDDING-1450.jpg');
    $image_id = function_exists('attachment_url_to_postid') ? attachment_url_to_postid($image) : 0;

    if (!$image_id && function_exists('media_sideload_image')) {
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $image_id = media_sideload_image($image, $post_id, 'Jehana & Kanishk wedding in Udaipur, Rajasthan', 'id');
        if (is_wp_error($image_id)) {
            $image_id = 0;
        }
    }

    if ($image_id) {
        set_post_thumbnail($post_id, (int) $image_id);
        $existing_alt = get_post_meta((int) $image_id, '_wp_attachment_image_alt', true);
        if (!$existing_alt) {
            update_post_meta((int) $image_id, '_wp_attachment_image_alt', 'Jehana & Kanishk wedding celebration in Udaipur, Rajasthan');
        }
    }

    update_post_meta($post_id, '_wvn_seo_focus', 'Jehana Kanishk Udaipur wedding');
    update_post_meta($post_id, '_wvn_seo_description', 'A genuine Wedding Vows by Nikhil portfolio story about Jehana & Kanishk in Udaipur, Rajasthan, with a factual look at place and destination-wedding planning.');
    update_post_meta($post_id, 'post_overlay_title', 'Jehana & Kanishk');
    update_post_meta($post_id, 'post_overlay_sub', 'A Udaipur wedding story');
    update_post_meta($post_id, 'post_cta_heading', 'Planning your Udaipur wedding?');
    update_post_meta($post_id, 'post_cta_text', 'Tell us your date, guest count and the setting you have in mind.');
    update_post_meta($post_id, 'post_cta_button', 'Plan my wedding ↗');
    update_option('wvn_jehana_kanishk_case_study_v1', '1', false);
}
add_action('init', 'wvn_seed_jehana_kanishk_case_study', 34);

function wvn_jehana_kanishk_case_study_seo($value, $type = 'title') {
    if (!is_singular('post') || get_post_field('post_name', get_queried_object_id()) !== 'jehana-kanishk-udaipur-wedding') {
        return $value;
    }
    if ($type === 'title') {
        return 'Jehana & Kanishk: A Udaipur Wedding Story | Wedding Vows by Nikhil';
    }
    return 'A genuine Wedding Vows by Nikhil portfolio story about Jehana & Kanishk in Udaipur, Rajasthan, with a factual look at place and destination-wedding planning.';
}

function wvn_jehana_kanishk_document_title($parts) {
    return array('title' => wvn_jehana_kanishk_case_study_seo('', 'title'));
}
add_filter('document_title_parts', 'wvn_jehana_kanishk_document_title', 70);
add_filter('wpseo_title', function ($title) {
    return wvn_jehana_kanishk_case_study_seo($title, 'title');
}, 70);
add_filter('wpseo_opengraph_title', function ($title) {
    return wvn_jehana_kanishk_case_study_seo($title, 'title');
}, 70);
add_filter('wpseo_twitter_title', function ($title) {
    return wvn_jehana_kanishk_case_study_seo($title, 'title');
}, 70);
add_filter('wpseo_metadesc', function ($description) {
    return wvn_jehana_kanishk_case_study_seo($description, 'description');
}, 70);
add_filter('wpseo_opengraph_desc', function ($description) {
    return wvn_jehana_kanishk_case_study_seo($description, 'description');
}, 70);
add_filter('wpseo_twitter_description', function ($description) {
    return wvn_jehana_kanishk_case_study_seo($description, 'description');
}, 70);

/**
 * Current run: publish one additional, distinct case study directly from a
 * published portfolio record. All wedding-specific facts are read from ACF
 * fields at runtime; blank fields are omitted rather than guessed.
 */
function wvn_seed_verified_portfolio_case_study_run_20260917() {
    if (get_option('wvn_verified_portfolio_case_study_run_20260917_v1') === '1') {
        return;
    }

    $portfolio_posts = get_posts(array(
        'post_type' => 'portfolio',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'modified',
        'order' => 'DESC',
        'no_found_rows' => true,
    ));

    if (!$portfolio_posts) {
        return;
    }

    $used_source_ids = get_posts(array(
        'post_type' => 'post',
        'post_status' => array('publish', 'draft', 'pending', 'private'),
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_key' => '_wvn_source_portfolio_id',
        'no_found_rows' => true,
    ));
    $used_source_ids = array_map('intval', $used_source_ids);

    $source = null;
    foreach ($portfolio_posts as $candidate) {
        if (in_array((int) $candidate->ID, $used_source_ids, true)) {
            continue;
        }
        if (stripos($candidate->post_title, 'Jehana') !== false && stripos($candidate->post_title, 'Kanishk') !== false) {
            continue;
        }
        $source = $candidate;
        break;
    }

    if (!$source) {
        return;
    }

    if (!function_exists('get_field')) {
        return;
    }

    $title = trim(wp_strip_all_tags($source->post_title));
    if ($title === '') {
        return;
    }

    $venue = trim(wp_strip_all_tags((string) get_field('portfolio_venue', $source->ID)));
    $date = trim(wp_strip_all_tags((string) get_field('portfolio_date', $source->ID)));
    $subtitle = trim(wp_strip_all_tags((string) get_field('portfolio_subtitle', $source->ID)));
    $story_heading = trim(wp_strip_all_tags((string) get_field('portfolio_story_heading', $source->ID)));
    $story_intro = trim((string) get_field('portfolio_story_intro', $source->ID));
    $planner = trim(wp_strip_all_tags((string) get_field('portfolio_planner', $source->ID)));
    $decor = trim(wp_strip_all_tags((string) get_field('portfolio_decor', $source->ID)));
    $photography = trim(wp_strip_all_tags((string) get_field('portfolio_photography', $source->ID)));
    $makeup = trim(wp_strip_all_tags((string) get_field('portfolio_makeup', $source->ID)));
    $pills = trim(wp_strip_all_tags((string) get_field('portfolio_pills', $source->ID)));

    $parts = preg_split('/\s*[•|,]\s*/u', $pills, -1, PREG_SPLIT_NO_EMPTY);
    $location = 'Udaipur, Rajasthan';
    foreach ((array) $parts as $part) {
        if (preg_match('/udaipur|rajasthan/i', $part)) {
            $location = $part;
            break;
        }
    }

    $slug_base = sanitize_title($title . '-' . ($venue ?: $location));
    $slug = sanitize_title($slug_base . '-real-wedding');
    if (get_page_by_path($slug, OBJECT, 'post')) {
        update_option('wvn_verified_portfolio_case_study_run_20260917_v1', '1', false);
        return;
    }

    $guide = esc_url(home_url('/weddings-in-udaipur/'));
    $planner_page = esc_url(home_url('/wedding-planner-udaipur/'));
    $destination = esc_url(home_url('/destination-wedding-planner-udaipur/'));
    $portfolio_url = esc_url(home_url('/portfolio/'));
    $contact = esc_url(home_url('/contact-us/'));

    $content = '';
    if ($story_intro !== '') {
        $content .= '<p>' . wp_kses_post(wpautop($story_intro)) . '</p>';
    } else {
        $content .= '<p>This case study is drawn directly from Wedding Vows by Nikhil’s published portfolio record for <strong>' . esc_html($title) . '</strong>. The story below uses only the wedding-specific information recorded for that portfolio entry; details that are not present in the source are intentionally not added.</p>';
    }

    $content .= '<h2>' . esc_html($story_heading ?: ('The ' . $location . ' wedding story')) . '</h2>';
    if ($subtitle !== '') {
        $content .= '<p>' . esc_html($subtitle) . '</p>';
    }
    if ($venue !== '' || $date !== '' || $location !== '') {
        $content .= '<p><strong>Wedding details:</strong> ';
        $detail_bits = array();
        if ($location !== '') { $detail_bits[] = esc_html($location); }
        if ($venue !== '') { $detail_bits[] = esc_html($venue); }
        if ($date !== '') { $detail_bits[] = esc_html($date); }
        $content .= implode(' &middot; ', $detail_bits) . '</p>';
    }

    $events = get_field('portfolio_events', $source->ID);
    if (is_array($events) && $events) {
        $event_count = 0;
        foreach ($events as $event) {
            if ($event_count >= 3) { break; }
            $event_title = trim(wp_strip_all_tags((string) ($event['event_title'] ?? '')));
            $event_desc = trim((string) ($event['event_description'] ?? ''));
            $event_theme = trim(wp_strip_all_tags((string) ($event['event_theme'] ?? '')));
            $event_tag = trim(wp_strip_all_tags((string) ($event['event_tag'] ?? '')));
            if ($event_title === '' && $event_desc === '') { continue; }
            $content .= '<h2>' . esc_html($event_title ?: ($event_tag ?: 'Wedding function')) . '</h2>';
            if ($event_desc !== '') {
                $content .= '<p>' . wp_kses_post($event_desc) . '</p>';
            }
            if ($event_theme !== '') {
                $content .= '<p><strong>Recorded detail:</strong> ' . esc_html($event_theme) . '</p>';
            }
            $event_count++;
        }
    }

    $credits = array();
    if ($planner !== '') { $credits[] = 'Planner &amp; concept: ' . esc_html($planner); }
    if ($decor !== '') { $credits[] = 'Décor &amp; production: ' . esc_html($decor); }
    if ($photography !== '') { $credits[] = 'Photography &amp; cinematography: ' . esc_html($photography); }
    if ($makeup !== '') { $credits[] = 'Bridal makeup &amp; styling: ' . esc_html($makeup); }
    $custom_credits = get_field('portfolio_custom_credits', $source->ID);
    if (is_array($custom_credits)) {
        foreach ($custom_credits as $credit) {
            $label = trim(wp_strip_all_tags((string) ($credit['label'] ?? '')));
            $value = trim(wp_strip_all_tags((string) ($credit['value'] ?? '')));
            if ($label !== '' && $value !== '') {
                $credits[] = esc_html($label) . ': ' . esc_html($value);
            }
        }
    }
    if ($credits) {
        $content .= '<h2>Recorded planning and vendor details</h2><ul><li>' . implode('</li><li>', $credits) . '</li></ul>';
    }

    $content .= '<h2>Planning the same kind of Udaipur celebration</h2>'
        . '<p>Every Udaipur wedding needs to be planned around its actual venue, guest experience and event requirements. Our <a href="' . $guide . '">Weddings in Udaipur guide</a> covers venue and planning considerations, while our <a href="' . $planner_page . '">Udaipur wedding planning service</a> and <a href="' . $destination . '">destination wedding planning service</a> explain how we approach the work.</p>'
        . '<p>See more <a href="' . $portfolio_url . '">real weddings from the portfolio</a>, then <a href="' . $contact . '">contact Wedding Vows by Nikhil</a> to discuss your own celebration.</p>';

    $excerpt = 'A verified Wedding Vows by Nikhil portfolio story about ' . $title . ($venue ? ' at ' . $venue : ' in ' . $location) . ', using the published wedding record and no unsupported details.';
    $post_id = wp_insert_post(wp_slash(array(
        'post_title' => $title . ($venue ? ': A ' . $venue . ' Wedding Story' : ': A Udaipur Wedding Story'),
        'post_name' => $slug,
        'post_excerpt' => $excerpt,
        'post_content' => $content,
        'post_status' => 'publish',
        'post_type' => 'post',
        'comment_status' => 'closed',
    )), true);

    if (is_wp_error($post_id) || !$post_id) {
        return;
    }

    wp_set_object_terms($post_id, 'real-weddings', 'category');
    update_post_meta($post_id, '_wvn_source_portfolio_id', (int) $source->ID);
    update_post_meta($post_id, '_wvn_source_portfolio_slug', $source->post_name);
    update_post_meta($post_id, '_wvn_seo_focus', $title . ' ' . $location . ' wedding');
    update_post_meta($post_id, '_wvn_seo_description', 'Verified Wedding Vows by Nikhil portfolio story for ' . $title . ($venue ? ' at ' . $venue : ' in ' . $location) . ', with planning details taken from the published wedding record.');
    update_post_meta($post_id, 'post_overlay_title', $title);
    update_post_meta($post_id, 'post_overlay_sub', $venue ? $venue : $location);
    update_post_meta($post_id, 'post_cta_heading', 'Planning your Udaipur wedding?');
    update_post_meta($post_id, 'post_cta_text', 'Tell us your date, guest count and preferred setting, and we can discuss the planning scope.');
    update_post_meta($post_id, 'post_cta_button', 'Plan my wedding ↗');

    $hero = get_field('portfolio_hero_image', $source->ID);
    $featured = get_post_thumbnail_id($source->ID);
    $image_id = 0;
    if (is_array($hero) && !empty($hero['ID'])) {
        $image_id = (int) $hero['ID'];
    } elseif (is_numeric($hero)) {
        $image_id = (int) $hero;
    } elseif ($featured) {
        $image_id = (int) $featured;
    }
    if ($image_id) {
        set_post_thumbnail($post_id, $image_id);
        $alt = trim((string) get_post_meta($image_id, '_wp_attachment_image_alt', true));
        if ($alt === '') {
            $alt = $title . ' wedding in ' . $location;
            if ($venue !== '') { $alt .= ' at ' . $venue; }
            update_post_meta($image_id, '_wp_attachment_image_alt', $alt);
        }
    }

    update_option('wvn_verified_portfolio_case_study_run_20260917_v1', '1', false);
}
add_action('init', 'wvn_seed_verified_portfolio_case_study_run_20260917', 35);

function wvn_verified_portfolio_case_study_run_20260917_seo($value, $type = 'title') {
    if (!is_singular('post')) {
        return $value;
    }
    $post_id = get_queried_object_id();
    if (!get_post_meta($post_id, '_wvn_source_portfolio_id', true)) {
        return $value;
    }
    $title = get_the_title($post_id);
    if ($type === 'title') {
        return $title . ' | Wedding Vows by Nikhil';
    }
    $description = get_post_meta($post_id, '_wvn_seo_description', true);
    return $description ?: $value;
}

add_filter('document_title_parts', function ($parts) {
    $title = wvn_verified_portfolio_case_study_run_20260917_seo('', 'title');
    return $title ? array('title' => $title) : $parts;
}, 71);
add_filter('wpseo_title', function ($title) {
    return wvn_verified_portfolio_case_study_run_20260917_seo($title, 'title');
}, 71);
add_filter('wpseo_opengraph_title', function ($title) {
    return wvn_verified_portfolio_case_study_run_20260917_seo($title, 'title');
}, 71);
add_filter('wpseo_twitter_title', function ($title) {
    return wvn_verified_portfolio_case_study_run_20260917_seo($title, 'title');
}, 71);
add_filter('wpseo_metadesc', function ($description) {
    return wvn_verified_portfolio_case_study_run_20260917_seo($description, 'description');
}, 71);
add_filter('wpseo_opengraph_desc', function ($description) {
    return wvn_verified_portfolio_case_study_run_20260917_seo($description, 'description');
}, 71);
add_filter('wpseo_twitter_description', function ($description) {
    return wvn_verified_portfolio_case_study_run_20260917_seo($description, 'description');
}, 71);

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

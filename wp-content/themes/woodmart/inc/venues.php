<?php
/**
 * Venue helpers — homepage slider + single template data.
 */

function wvn_venue_image_url($value, $fallback = '') {
    if (function_exists('wvn_image_url')) {
        return wvn_image_url($value, $fallback);
    }
    if (is_array($value) && !empty($value['url'])) {
        return $value['url'];
    }
    return $fallback;
}

function wvn_venue_field($key, $post_id = 0, $default = '') {
    $post_id = $post_id ?: get_the_ID();
    if (function_exists('get_field')) {
        $val = get_field($key, $post_id);
        if ($val !== null && $val !== false && $val !== '') {
            return $val;
        }
    }
    return $default;
}

/**
 * Venues for homepage cinematic slider (same shape as cites cards).
 */
function wvn_venues_for_home($limit = 8) {
    $q = new WP_Query(array(
        'post_type'      => 'venue',
        'post_status'    => 'publish',
        'posts_per_page' => (int) $limit,
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
    ));

    $items = array();
    foreach ($q->posts as $post) {
        $id = $post->ID;
        $hero = wvn_venue_field('venue_hero_image', $id, null);
        $img = wvn_venue_image_url($hero, '');
        if (!$img) {
            $thumb = get_the_post_thumbnail_url($id, 'large');
            $img = $thumb ?: '';
        }
        if (!$img) {
            $img = (string) get_post_meta($id, '_wvn_venue_seed_image', true);
        }
        if (!$img) {
            $img = function_exists('wvn_hero_image') ? wvn_hero_image() : '';
        }
        $location = (string) wvn_venue_field('venue_location', $id, 'Udaipur');
        $capacity = (string) wvn_venue_field('venue_capacity', $id, '');
        $rooms = (string) wvn_venue_field('venue_rooms_count', $id, '');
        $blurb = (string) wvn_venue_field('venue_card_blurb', $id, '');
        if ($blurb === '') {
            $blurb = $post->post_excerpt ?: wp_trim_words(wp_strip_all_tags($post->post_content), 22);
        }
        $meta_parts = array_filter(array(
            $location,
            $capacity !== '' ? $capacity . ' guests' : '',
            $rooms !== '' ? $rooms . ' rooms' : '',
        ));
        $items[] = array(
            'name'     => get_the_title($id),
            'text'     => $blurb,
            'meta'     => implode(' · ', $meta_parts),
            'capacity' => $capacity,
            'rooms'    => $rooms,
            'location' => $location,
            'image'    => $img,
            'url'      => get_permalink($id),
            'kicker'   => 'Venue',
        );
    }
    wp_reset_postdata();
    return $items;
}

/**
 * Normalized data bag for single venue template.
 */
function wvn_venue_detail($post_id = 0) {
    $post_id = $post_id ?: get_the_ID();
    $hero = wvn_venue_field('venue_hero_image', $post_id, null);
    $hero_url = wvn_venue_image_url($hero, get_the_post_thumbnail_url($post_id, 'full') ?: '');
    if (!$hero_url) {
        $hero_url = (string) get_post_meta($post_id, '_wvn_venue_seed_image', true);
    }
    if (!$hero_url && function_exists('wvn_hero_image')) {
        $hero_url = wvn_hero_image();
    }

    $gallery = array();
    $raw_gallery = wvn_venue_field('venue_gallery', $post_id, array());
    if (is_array($raw_gallery)) {
        foreach ($raw_gallery as $img) {
            $url = wvn_venue_image_url($img, '');
            if ($url) {
                $gallery[] = $url;
            }
        }
    }
    if (!$gallery) {
        $seed_g = get_post_meta($post_id, '_wvn_venue_seed_gallery', true);
        if (is_array($seed_g)) {
            $gallery = array_values(array_filter($seed_g));
        }
    }

    $rooms_gallery = array();
    $raw_rooms = wvn_venue_field('venue_rooms_gallery', $post_id, array());
    if (is_array($raw_rooms)) {
        foreach ($raw_rooms as $img) {
            $url = wvn_venue_image_url($img, '');
            if ($url) {
                $rooms_gallery[] = $url;
            }
        }
    }
    if (!$rooms_gallery) {
        $seed_r = get_post_meta($post_id, '_wvn_venue_seed_rooms', true);
        if (is_array($seed_r)) {
            $rooms_gallery = array_values(array_filter($seed_r));
        }
    }

    $pricing = wvn_venue_field('venue_pricing_items', $post_id, array());
    $spaces = wvn_venue_field('venue_spaces', $post_id, array());
    $inclusions = wvn_venue_field('venue_inclusions', $post_id, array());
    $policies = wvn_venue_field('venue_policies', $post_id, array());

    $about = wvn_venue_field('venue_about', $post_id, '');
    if (!$about) {
        $about = apply_filters('the_content', get_post_field('post_content', $post_id));
    }

    return array(
        'title'           => get_the_title($post_id),
        'hero'            => $hero_url,
        'location'        => (string) wvn_venue_field('venue_location', $post_id, 'Udaipur, Rajasthan'),
        'rating'          => (string) wvn_venue_field('venue_rating', $post_id, ''),
        'reviews'         => (string) wvn_venue_field('venue_review_count', $post_id, ''),
        'region'          => (string) wvn_venue_field('venue_region', $post_id, ''),
        'view'            => (string) wvn_venue_field('venue_view', $post_id, ''),
        'duration'        => (string) wvn_venue_field('venue_duration', $post_id, ''),
        'capacity'        => (string) wvn_venue_field('venue_capacity', $post_id, ''),
        'rooms_count'     => (string) wvn_venue_field('venue_rooms_count', $post_id, ''),
        'starting_price'  => (string) wvn_venue_field('venue_starting_price', $post_id, ''),
        'price_range'     => (string) wvn_venue_field('venue_price_range', $post_id, ''),
        'price_note'      => (string) wvn_venue_field('venue_price_note', $post_id, ''),
        'price_disclaimer'=> (string) wvn_venue_field('venue_price_disclaimer', $post_id, ''),
        'pricing'         => is_array($pricing) ? $pricing : array(),
        'gallery'         => $gallery,
        'video_url'       => (string) wvn_venue_field('venue_video_url', $post_id, ''),
        'spaces_intro'    => (string) wvn_venue_field('venue_spaces_intro', $post_id, ''),
        'spaces'          => is_array($spaces) ? $spaces : array(),
        'rooms_heading'   => (string) wvn_venue_field('venue_rooms_heading', $post_id, 'Rooms'),
        'rooms_text'      => (string) wvn_venue_field('venue_rooms_text', $post_id, ''),
        'rooms_gallery'   => $rooms_gallery,
        'inclusions'      => is_array($inclusions) ? $inclusions : array(),
        'policies'        => is_array($policies) ? $policies : array(),
        'about_heading'   => (string) wvn_venue_field('venue_about_heading', $post_id, 'About'),
        'about'           => $about,
        'form_heading'    => (string) wvn_venue_field('venue_form_heading', $post_id, 'Get the latest price'),
        'form_shortcode'  => (string) wvn_venue_field('venue_form_shortcode', $post_id, ''),
    );
}

/**
 * Seed sample venues + homepage cites copy once.
 */
function wvn_seed_sample_venues() {
    if (get_option('_wvn_venues_seeded_v1')) {
        return;
    }
    if (!post_type_exists('venue')) {
        return;
    }

    $existing = get_posts(array(
        'post_type'      => 'venue',
        'post_status'    => 'any',
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ));
    if ($existing) {
        update_option('_wvn_venues_seeded_v1', '1', false);
        return;
    }

    $gallery = function_exists('wvn_gallery_images') ? array_values(array_filter(wvn_gallery_images())) : array();
    $hero_fallback = function_exists('wvn_hero_image') ? wvn_hero_image() : '';

    $samples = array(
        array(
            'title' => 'Taj Lake Palace, Udaipur',
            'blurb' => 'A floating marble palace on Lake Pichola — intimate ceremonies with cinematic lake light.',
            'location' => 'Udaipur, Rajasthan',
            'region' => 'Aravalli Range',
            'view' => 'Lake Pichola',
            'duration' => 'From 2 to 3 days',
            'rating' => '4.8',
            'reviews' => '11',
            'capacity' => '150–250',
            'rooms' => '66',
            'starting' => '₹50L+',
            'price_range' => '₹50 – 65 Lakhs',
            'price_note' => 'For 150–200 guests · taxes extra',
            'spaces' => array(
                array('name' => 'Royal Courtyard', 'meta' => 'Open air · Ceremonies', 'capacity' => '200 guests'),
                array('name' => 'Lake Pavilion', 'meta' => 'Waterside · Reception', 'capacity' => '180 guests'),
            ),
        ),
        array(
            'title' => 'The Leela Palace, Udaipur',
            'blurb' => 'Hilltop grandeur with sweeping lake views — ideal for multi-day destination weddings.',
            'location' => 'Udaipur, Rajasthan',
            'region' => 'Lake Pichola ridge',
            'view' => 'City Palace & lake',
            'duration' => 'From 2 to 4 days',
            'rating' => '4.9',
            'reviews' => '24',
            'capacity' => '300–450',
            'rooms' => '80',
            'starting' => '₹80L+',
            'price_range' => '₹80 – 1.5 Lakhs*',
            'price_note' => '*Indicative package bands · guest count dependent',
            'spaces' => array(
                array('name' => 'Mewar Terrace', 'meta' => 'Sunset · Sangeet', 'capacity' => '400 guests'),
                array('name' => 'Grand Ballroom', 'meta' => 'Indoor · Reception', 'capacity' => '350 guests'),
            ),
        ),
        array(
            'title' => 'Fateh Prakash Palace',
            'blurb' => 'Heritage courtyards and crystal halls — classic Udaipur romance with room for large baraats.',
            'location' => 'Udaipur, Rajasthan',
            'region' => 'City Palace complex',
            'view' => 'Lake & old city',
            'duration' => 'From 2 to 3 days',
            'rating' => '4.7',
            'reviews' => '18',
            'capacity' => '400–600',
            'rooms' => '45',
            'starting' => '₹60L+',
            'price_range' => '₹60 – 95 Lakhs',
            'price_note' => 'For 300–400 guests · taxes extra',
            'spaces' => array(
                array('name' => 'Crystal Gallery Lawn', 'meta' => 'Lawn · Pheras', 'capacity' => '500 guests'),
                array('name' => 'Durbar Hall', 'meta' => 'Heritage · Dinner', 'capacity' => '300 guests'),
            ),
        ),
        array(
            'title' => 'Oberoi Udaivilas',
            'blurb' => 'Luxe lakeside resort energy — refined hospitality for families who want ease and beauty.',
            'location' => 'Udaipur, Rajasthan',
            'region' => 'Lake Pichola shore',
            'view' => 'Jag Mandir & lake',
            'duration' => 'From 2 to 3 days',
            'rating' => '4.9',
            'reviews' => '32',
            'capacity' => '200–350',
            'rooms' => '87',
            'starting' => '₹90L+',
            'price_range' => '₹90 Lakhs – 1.8 Cr',
            'price_note' => 'Buyout & partial buyout options',
            'spaces' => array(
                array('name' => 'Reflection Pool Lawn', 'meta' => 'Resort · Ceremonies', 'capacity' => '300 guests'),
                array('name' => 'Chandni Chowk', 'meta' => 'Courtyard · Sangeet', 'capacity' => '250 guests'),
            ),
        ),
    );

    $can_acf = function_exists('update_field');

    foreach ($samples as $i => $sample) {
        $post_id = wp_insert_post(array(
            'post_type'    => 'venue',
            'post_status'  => 'publish',
            'post_title'   => $sample['title'],
            'post_excerpt' => $sample['blurb'],
            'post_content' => '<p>' . esc_html($sample['title']) . ' is one of Udaipur’s most requested wedding settings. We help you secure dates, design the guest journey, and produce every ceremony with calm precision.</p><p>From first site walk to the last farewell breakfast, our team coordinates hotels, artists, and logistics so your family can host with ease.</p>',
            'menu_order'   => $i + 1,
        ));
        if (is_wp_error($post_id) || !$post_id) {
            continue;
        }

        if ($can_acf) {
            update_field('venue_location', $sample['location'], $post_id);
            update_field('venue_region', $sample['region'], $post_id);
            update_field('venue_view', $sample['view'], $post_id);
            update_field('venue_duration', $sample['duration'], $post_id);
            update_field('venue_rating', $sample['rating'], $post_id);
            update_field('venue_review_count', $sample['reviews'], $post_id);
            update_field('venue_capacity', $sample['capacity'], $post_id);
            update_field('venue_rooms_count', $sample['rooms'], $post_id);
            update_field('venue_starting_price', $sample['starting'], $post_id);
            update_field('venue_card_blurb', $sample['blurb'], $post_id);
            update_field('venue_price_range', $sample['price_range'], $post_id);
            update_field('venue_price_note', $sample['price_note'], $post_id);
            update_field('venue_price_disclaimer', 'Prices vary by season, guest count, and inclusions. Final quotes are shared after a site walk.', $post_id);
            update_field('venue_pricing_items', array(
                array('label' => 'Food (Vegetarian)', 'value' => 'from ₹2,800 / plate'),
                array('label' => 'Food (Non-Vegetarian)', 'value' => 'from ₹3,400 / plate'),
                array('label' => 'Liquor policy', 'value' => 'Hotel permit · corkage available'),
                array('label' => 'Decor policy', 'value' => 'Approved vendors · in-house options'),
            ), $post_id);
            update_field('venue_spaces_intro', 'Signature spaces within the property for ceremonies, sangeet, and reception.', $post_id);
            update_field('venue_spaces', $sample['spaces'], $post_id);
            update_field('venue_rooms_heading', 'Rooms', $post_id);
            update_field('venue_rooms_text', 'A mix of lake-view suites and heritage rooms for the couple and close family, with blocks available for destination guests.', $post_id);
            update_field('venue_inclusions', array(
                array('text' => 'Planning and on-ground execution'),
                array('text' => 'Vendor coordination & timelines'),
                array('text' => 'Guest hospitality support'),
                array('text' => 'Ceremony flow & seating plans'),
                array('text' => 'Stage and décor direction'),
                array('text' => 'Day-of management team'),
            ), $post_id);
            update_field('venue_policies', array(
                array('title' => 'Catering', 'text' => 'In-house kitchen preferred; outside caterers subject to hotel approval.'),
                array('title' => 'Music & sound', 'text' => 'DJ and live acts allowed within property quiet hours.'),
                array('title' => 'Alcohol', 'text' => 'Served as per hotel licence; corkage may apply for outside stock.'),
                array('title' => 'Decor', 'text' => 'Installations require advance drawings and fire-safety clearance.'),
            ), $post_id);
            update_field('venue_about_heading', 'About / A day at ' . $sample['title'], $post_id);
            update_field('venue_form_heading', 'Get the latest price', $post_id);
        }

        // Use rotating gallery URLs as visual placeholders via post meta when no attachment ID.
        $img = $gallery[$i % max(1, count($gallery))] ?? $hero_fallback;
        if ($img) {
            update_post_meta($post_id, '_wvn_venue_seed_image', esc_url_raw($img));
        }

        // Build a fake gallery of URLs for the detail page when ACF gallery is empty.
        if ($can_acf && $gallery) {
            $urls = array();
            for ($g = 0; $g < 6; $g++) {
                $urls[] = $gallery[($i + $g) % count($gallery)];
            }
            update_post_meta($post_id, '_wvn_venue_seed_gallery', $urls);
            update_post_meta($post_id, '_wvn_venue_seed_rooms', array_slice($urls, 0, 2));
        }
    }

    // Point homepage cites copy at venues (overrides prior testimonial defaults).
    $home_id = (int) get_option('page_on_front');
    if ($home_id && $can_acf) {
        update_field('home_cin_cites_eyebrow', 'Venues we love', $home_id);
        update_field('home_cin_cites_heading', 'Palaces, lakes', $home_id);
        update_field('home_cin_cites_heading_em', '& lawns for your day.', $home_id);
        update_field('home_cin_cites_kicker', 'Venue', $home_id);
    }

    update_option('_wvn_venues_seeded_v1', '1', false);
    flush_rewrite_rules(false);
}
add_action('init', 'wvn_seed_sample_venues', 40);

<?php
/**
 * Focused Journal article for the Udaipur destination-wedding cluster.
 * Distinct intent: guest hospitality and arrival planning.
 */

function wvn_seed_hospitality_journal_20260914() {
    if (get_option('_wvn_hospitality_journal_20260914')) {
        return;
    }
    if (!function_exists('wp_insert_post') || !function_exists('wvn_blog_ensure_categories')) {
        return;
    }

    $slug = 'udaipur-wedding-guest-hospitality-airport-transfers-room-blocks-welcome-kits';
    $existing = get_page_by_path($slug, OBJECT, 'post');
    if ($existing) {
        update_option('_wvn_hospitality_journal_20260914', '1', false);
        return;
    }

    wvn_blog_ensure_categories();
    $guide = esc_url(home_url('/weddings-in-udaipur/'));
    $planner = esc_url(home_url('/wedding-planner-udaipur/'));
    $destination = esc_url(home_url('/destination-wedding-planner-udaipur/'));
    $portfolio = esc_url(home_url('/portfolio/'));
    $contact = esc_url(home_url('/contact-us/'));

    $content = '<p>For an Udaipur destination wedding, guest hospitality starts before the first function. The most useful plan is simple: collect arrival details early, block the right rooms, make transfers easy to understand, and give guests one reliable itinerary they can follow.</p>'
        . '<p>The palace or resort may be the reason everyone says yes to Udaipur. Hospitality is what makes the wedding week feel effortless once everyone arrives.</p>'
        . '<h2>Start with the guest list, not the welcome hamper</h2>'
        . '<p>Before designing stationery or welcome gifts, divide guests into practical groups: elders, families with children, friends, international guests, vendors and the wedding party. Each group may have different arrival times, room requirements and transport needs.</p>'
        . '<p>Build one master guest sheet with names, phone numbers, arrival and departure details, room assignments, dietary notes and an emergency contact. Keep one planning owner responsible for updates so the hotel, transport team and family are not working from different versions.</p>'
        . '<h2>Make the airport arrival feel organised</h2>'
        . '<p>Most out-of-town guests will arrive through Maharana Pratap Airport. The objective is not to create a complicated welcome desk; it is to make the next step obvious.</p>'
        . '<ul><li>Send the transfer contact and meeting instructions before the flight.</li><li>Use a consistent vehicle and staff identification system so guests know who to approach.</li><li>Keep a live arrival sheet for delayed flights and late-night arrivals.</li><li>Separate airport transfers from event transport in the master schedule.</li><li>Have a clear backup plan for guests who arrive outside their planned transfer window.</li></ul>'
        . '<p>For international guests, add the hotel address, local emergency contact and a short note on what to expect on arrival. Avoid making guests search through a long wedding PDF while they are travelling.</p>'
        . '<h2>Choose the room block around the wedding, not just the room rate</h2>'
        . '<p>A room block is a logistics decision. Ask how many rooms can realistically be held, which room categories suit families, where breakfast is served, and how close the rooms are to the functions. The cheapest room is not necessarily the lowest-cost choice if it creates repeated transfers or splits the family across properties.</p>'
        . '<p>For a multi-day wedding, map the room block against the itinerary. Guests arriving on Day 1 should not be given a room plan that assumes everyone reaches the hotel at the same time. Keep a small buffer for early arrivals, late departures and rooms needed by the wedding party.</p>'
        . '<p>Our <a href="' . $guide . '">Weddings in Udaipur guide</a> covers venue and planning considerations; once a property is shortlisted, the room block should be reviewed alongside its function spaces and production rules.</p>'
        . '<h2>Give every guest one clear itinerary</h2>'
        . '<p>A good destination-wedding itinerary answers five questions at a glance: where am I going, when should I leave, what should I wear, is food provided, and who do I call if something changes?</p>'
        . '<p>Keep the guest-facing version short. A useful structure is:</p>'
        . '<ol><li><strong>Arrival day:</strong> airport transfer, hotel check-in, welcome moment and dinner.</li><li><strong>Celebration day:</strong> breakfast, mehendi or haldi, rest window, sangeet and return transport.</li><li><strong>Wedding day:</strong> getting-ready windows, baraat departure, ceremony, reception and hotel return.</li><li><strong>Departure:</strong> breakfast, checkout and airport transfer window.</li></ol>'
        . '<p>Put the detailed production schedule in the planner version, not the guest version. Guests need confidence, not a 14-page run sheet.</p>'
        . '<h2>Welcome kits should be useful to the destination</h2>'
        . '<p>A thoughtful welcome kit does not have to be expensive. It should solve a problem a guest actually has in Udaipur.</p>'
        . '<ul><li>A concise itinerary card with key timings and contacts</li><li>Water and a practical snack for arrival</li><li>Wedding-day essentials appropriate to the season</li><li>A small local touch that feels connected to Rajasthan</li><li>Clear information about breakfast, transport and hotel facilities</li></ul>'
        . '<p>For international and outstation families, add practical information rather than more objects: local contact details, transport instructions, venue addresses and the wedding team\'s WhatsApp number.</p>'
        . '<h2>Plan for elders and children before the wedding week begins</h2>'
        . '<p>Guest hospitality is often judged by the people who find travel hardest. Ask elders about mobility requirements before assigning rooms. Keep walking distances in mind when placing ceremony, dining and seating areas. Families travelling with children may need earlier meal options, quiet rooms and flexible transport.</p>'
        . '<p>Build a small hospitality team that can answer these questions without sending every request back to the couple. The couple should be getting married, not becoming the wedding help desk.</p>'
        . '<h2>Keep hospitality connected to the venue plan</h2>'
        . '<p>Venue selection and hospitality cannot be separated. A beautiful island or palace setting may change boat or vehicle logistics. A large resort may simplify room blocks but spread functions across a bigger campus. A boutique property may create a wonderful intimate experience but require nearby rooms for part of the guest list.</p>'
        . '<p>That is why we recommend comparing the <a href="' . $guide . '">venue, accommodation and guest-flow decisions together</a> before signing the final plan.</p>'
        . '<h2>What a local Udaipur planner adds</h2>'
        . '<p>When guests are travelling from Mumbai, Delhi, Bengaluru, the UK, the US or elsewhere, someone on the ground needs to own the small changes: a delayed flight, a missing room key, a transfer that needs to move, or a function that starts later than planned.</p>'
        . '<p>Wedding Vows by Nikhil plans from Udaipur, so hospitality can sit inside the same operating plan as the venue, décor and wedding-day production. See our <a href="' . $planner . '">Udaipur wedding planning services</a> and <a href="' . $destination . '">destination wedding planning approach</a>.</p>'
        . '<h2>The hospitality checklist to use before guests arrive</h2>'
        . '<ul><li>Guest master sheet is final and shared with the responsible teams.</li><li>Arrival and departure details are mapped to transfer windows.</li><li>Room assignments and special requirements are confirmed.</li><li>Every guest has one itinerary and one emergency contact.</li><li>Welcome kits are placed before the guest reaches the room.</li><li>Elder, child and accessibility requirements have named owners.</li><li>Hotel, transport and planner teams have one current schedule.</li><li>A backup plan exists for delayed arrivals and last-minute room changes.</li></ul>'
        . '<p>For more examples of how the guest experience fits into a real celebration, explore our <a href="' . $portfolio . '">real wedding portfolio</a>. If your family is planning a destination wedding in Udaipur, <a href="' . $contact . '">share your date and guest count with us</a> and we can map the hospitality layer before the décor brief begins.</p>';

    $post_id = wp_insert_post(wp_slash(array(
        'post_title' => 'Udaipur Wedding Guest Hospitality: Airport Transfers, Room Blocks & Welcome Kits',
        'post_name' => $slug,
        'post_excerpt' => 'A practical Udaipur destination wedding hospitality guide covering airport arrivals, room blocks, guest itineraries, welcome kits, elders, children and on-ground coordination.',
        'post_content' => $content,
        'post_status' => 'publish',
        'post_type' => 'post',
        'comment_status' => 'closed',
    )), true);

    if (is_wp_error($post_id) || !$post_id) {
        return;
    }

    wp_set_object_terms($post_id, 'planning-tips', 'category');
    update_post_meta($post_id, '_wvn_seo_focus', 'Udaipur wedding guest hospitality');
    update_post_meta($post_id, '_wvn_seo_description', 'A practical guide to guest hospitality for destination weddings in Udaipur, including airport transfers, room blocks, itineraries, welcome kits and family support.');
    update_post_meta($post_id, '_wvn_seo_seeded', '1');
    update_post_meta($post_id, '_wvn_article_image_alt', 'Wedding guests arriving for a destination wedding in Udaipur');

    if (function_exists('update_field')) {
        update_field('post_overlay_title', 'Udaipur wedding guest hospitality', $post_id);
        update_field('post_overlay_sub', 'Airport arrivals, rooms & welcome kits', $post_id);
        update_field('post_cta_heading', 'Make the guest experience feel effortless', $post_id);
        update_field('post_cta_text', 'Share your date and guest count and we will help you plan the hospitality layer around the wedding.', $post_id);
        update_field('post_cta_button', 'Plan my wedding ↗', $post_id);
        update_field('post_faq_heading', 'Udaipur wedding hospitality FAQ', $post_id);
        update_field('post_faqs', array(
            array('q' => 'What should guests receive before a destination wedding in Udaipur?', 'a' => 'Send a concise itinerary, airport and transfer instructions, hotel information, key contacts and any dress or function notes before travel. Keep the guest version short and practical.'),
            array('q' => 'How should airport transfers be organised for a Udaipur wedding?', 'a' => 'Collect arrival details in one master sheet, assign transfer windows, provide a clear airport meeting contact and keep a live process for delayed or changed flights.'),
            array('q' => 'What should go in a Udaipur wedding welcome kit?', 'a' => 'Useful items include the itinerary, water, a practical snack, season-appropriate essentials, local touches and clear information about transport and hotel facilities.'),
            array('q' => 'How do you manage international wedding guests?', 'a' => 'Give international guests simple arrival instructions, a local emergency contact, hotel and transport details and one reliable wedding-team contact. On the ground, a hospitality team should own changes so the couple does not have to.'),
        ), $post_id);
    }

    update_option('_wvn_hospitality_journal_20260914', '1', false);
}
add_action('init', 'wvn_seed_hospitality_journal_20260914', 41);

function wvn_hospitality_journal_seo($seo) {
    if (!is_singular('post') || get_post_field('post_name', get_the_ID()) !== 'udaipur-wedding-guest-hospitality-airport-transfers-room-blocks-welcome-kits') {
        return $seo;
    }
    $seo['title'] = 'Udaipur Wedding Guest Hospitality Guide | Wedding Vows by Nikhil';
    $seo['description'] = 'Planning a destination wedding in Udaipur? Use this guest hospitality guide for airport transfers, room blocks, itineraries, welcome kits and family support.';
    return $seo;
}
add_filter('wvn_seo_current', 'wvn_hospitality_journal_seo', 50);

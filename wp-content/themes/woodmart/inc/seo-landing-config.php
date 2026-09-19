<?php
/**
 * Shared SEO / money landing page content config.
 */

function wvn_seo_landing_config($slug = '') {
    $slug = sanitize_title((string) $slug);
    if ($slug === '') {
        return array();
    }

    $hero = function_exists('wvn_hero_image') ? wvn_hero_image() : '';
    $pages = array(
        'wedding-planner-udaipur' => array(
            'seo_title'   => 'Wedding Planner in Udaipur | Wedding Vows by Nikhil',
            'description' => 'Udaipur wedding planner for palace, lakeside and destination celebrations — venue, design, hospitality and on-ground execution with one local team.',
            'intro'       => 'Wedding Vows by Nikhil is an Udaipur-based wedding planning team for couples who want venue decisions, guest hospitality, design and event-day execution held in one plan.',
            'image'       => $hero,
            'highlights'  => array(
                array('label' => '01 · Local expertise', 'title' => 'Udaipur-first planning', 'text' => 'Venue rules, room blocks, transfers and production access are planned with local knowledge from the first conversation.'),
                array('label' => '02 · Design', 'title' => 'One creative language', 'text' => 'Décor, florals, lighting and stationery are developed as one visual direction across every function.'),
                array('label' => '03 · Hospitality', 'title' => 'Guests feel looked after', 'text' => 'Arrivals, rooms, welcome moments and movement between events are coordinated so families can stay present.'),
                array('label' => '04 · Execution', 'title' => 'Calm on the day', 'text' => 'A detailed run sheet and on-ground team keep vendors, timing and guest flow aligned.'),
            ),
            'faqs' => array(
                array('q' => 'Why hire a wedding planner in Udaipur?', 'a' => 'A local planner connects venue decisions, guest hospitality, design, production and day-of execution — especially important for destination families.'),
                array('q' => 'Do you handle end-to-end planning?', 'a' => 'Yes. From venue shortlists and design direction to vendor coordination, hospitality and on-ground execution.'),
                array('q' => 'Can you work if the venue is already booked?', 'a' => 'Yes. We regularly take over after a venue is confirmed and manage design, vendors, hospitality and event-day operations.'),
            ),
        ),
        'destination-wedding-planner-udaipur' => array(
            'seo_title'   => 'Destination Wedding Planner in Udaipur | Wedding Vows by Nikhil',
            'description' => 'Destination wedding planner in Udaipur for outstation and international couples — venue, rooms, hospitality, design and execution with one local team.',
            'intro'       => 'For families planning from another city or country, we turn Udaipur venue choices, guest logistics and multi-day celebrations into one connected plan.',
            'image'       => function_exists('wvn_media') ? wvn_media('2025/04/2J0A2532-533x800-1.jpg') : $hero,
            'highlights'  => array(
                array('label' => '01 · Destination', 'title' => 'Built for travelling guests', 'text' => 'Room blocks, transfers, welcome hospitality and function timing are planned around how guests actually move through Udaipur.'),
                array('label' => '02 · Coordination', 'title' => 'One team on the ground', 'text' => 'Remote decisions stay clear while venue, vendors and production are managed locally.'),
                array('label' => '03 · Design', 'title' => 'A celebration that feels yours', 'text' => 'Creative direction stays consistent from welcome through the final farewell.'),
                array('label' => '04 · Execution', 'title' => 'Present for every function', 'text' => 'On-ground coordination keeps the wedding week calm for hosts and guests.'),
            ),
            'faqs' => array(
                array('q' => 'Can you plan an Udaipur wedding remotely?', 'a' => 'Yes. We keep planning calls clear and documented while our Udaipur team handles local venue and vendor coordination.'),
                array('q' => 'Do you help with guest hospitality?', 'a' => 'Yes — arrivals, room handling, welcome experiences, transfers and function-day movement.'),
                array('q' => 'How early should we start?', 'a' => 'Eight to twelve months is ideal for peak palace dates, though we can also step in after a venue is booked.'),
            ),
        ),
        'luxury-wedding-planner-udaipur' => array(
            'seo_title'   => 'Luxury Wedding Planner in Udaipur | Wedding Vows by Nikhil',
            'description' => 'Luxury wedding planner in Udaipur for palace and premium destination celebrations — design, hospitality, production and precise execution.',
            'intro'       => 'Luxury in Udaipur is more than a beautiful venue. It is the way design, hospitality and production stay precise from the first arrival to the last farewell.',
            'image'       => function_exists('wvn_media') ? wvn_media('2025/04/2J0A7886-1200x800-1.jpg') : $hero,
            'highlights'  => array(
                array('label' => '01 · Venue', 'title' => 'Palace and premium properties', 'text' => 'Shortlists favour properties that can hold the guest journey, not only the photographs.'),
                array('label' => '02 · Design', 'title' => 'Editorial creative direction', 'text' => 'Florals, lighting, staging and detail design are developed as one elevated language.'),
                array('label' => '03 · Production', 'title' => 'Technical polish', 'text' => 'Sound, lighting, staging and vendor access are planned before guests arrive.'),
                array('label' => '04 · Service', 'title' => 'Discreet hospitality', 'text' => 'Guest experience stays considered without becoming noisy or over-managed.'),
            ),
            'faqs' => array(
                array('q' => 'What makes a luxury Udaipur wedding different?', 'a' => 'The difference is usually in precision — venue fit, creative restraint, hospitality detail and calm execution.'),
                array('q' => 'Do you work with palace hotels?', 'a' => 'Yes. We regularly plan around palace hotels, lakeside properties and premium resorts in Udaipur.'),
                array('q' => 'Can you manage large multi-day weddings?', 'a' => 'Yes. Multi-day destination celebrations are a core part of our Udaipur work.'),
            ),
        ),
        'destination-wedding-udaipur' => array(
            'seo_title'   => 'Destination Wedding in Udaipur | Planning Guide',
            'description' => 'Plan a destination wedding in Udaipur with guidance on venues, guest flow, hospitality, budgets and local execution.',
            'intro'       => 'A destination wedding in Udaipur works best when venue, rooms, guest movement and celebration design are planned together from the start.',
            'image'       => function_exists('wvn_media') ? wvn_media('2025/04/2J0A1820-1200x800-1.jpg') : $hero,
            'highlights'  => array(
                array('label' => '01 · Place', 'title' => 'Choose the right setting', 'text' => 'Palace, lakeside or resort — the right fit depends on guest count and the week’s rhythm.'),
                array('label' => '02 · Guests', 'title' => 'Plan the journey', 'text' => 'Transfers, rooms and welcome hospitality shape how the celebration feels.'),
                array('label' => '03 · Design', 'title' => 'Functions with one story', 'text' => 'Each event should feel connected without becoming repetitive.'),
                array('label' => '04 · Team', 'title' => 'Local execution', 'text' => 'On-ground coordination keeps destination logistics from becoming the family’s job.'),
            ),
            'faqs' => array(
                array('q' => 'Is Udaipur good for destination weddings?', 'a' => 'Yes. The city offers palace, lakeside and resort settings with strong hospitality infrastructure for travelling guests.'),
                array('q' => 'How many days should an Udaipur wedding be?', 'a' => 'Many destination celebrations span two to four days, depending on functions and guest travel.'),
                array('q' => 'Where should we start planning?', 'a' => 'Start with guest count, season and venue shortlist, then build hospitality and design around that foundation.'),
            ),
        ),
        'wedding-venues-udaipur' => array(
            'seo_title'   => 'Wedding Venues in Udaipur | Palaces, Resorts & Planning',
            'description' => 'Compare wedding venues in Udaipur by guest count, room blocks, ceremony spaces and guest experience.',
            'intro'       => 'The right wedding venue in Udaipur fits your guest list, room block and celebration flow — not simply the most photographed address.',
            'image'       => function_exists('wvn_media') ? wvn_media('2025/04/2J0A0682.jpg') : $hero,
            'highlights'  => array(
                array('label' => '01 · Fit', 'title' => 'Guest list first', 'text' => 'Compare rooms and function capacities before falling in love with photographs.'),
                array('label' => '02 · Types', 'title' => 'Palace, lake or resort', 'text' => 'Each venue type changes arrival, transfers, production access and guest comfort.'),
                array('label' => '03 · Checks', 'title' => 'Ask the practical questions', 'text' => 'Sound timings, vendor rules, parking, backups and F&B terms matter as much as views.'),
                array('label' => '04 · Plan', 'title' => 'Venue inside the full week', 'text' => 'A venue should support welcome through farewell without exhausting the family.'),
            ),
            'faqs' => array(
                array('q' => 'Which are the best wedding venues in Udaipur?', 'a' => 'It depends on guest count and celebration type. Couples often compare lake palaces, palace hotels and large luxury resorts.'),
                array('q' => 'What should I ask before booking?', 'a' => 'Room inventory, function capacities, catering rules, décor restrictions, sound timings, vendor access and weather backups.'),
                array('q' => 'Can one venue host the whole wedding?', 'a' => 'Many resort and palace hotels can; island venues may need a more selective function plan.'),
            ),
        ),
        'palace-wedding-venues-in-udaipur' => array(
            'seo_title'   => 'Palace Wedding Venues in Udaipur | Practical Comparison',
            'description' => 'Explore palace wedding venues in Udaipur, from Lake Pichola settings to palace hotels and heritage courtyards.',
            'intro'       => 'A palace wedding in Udaipur should feel regal without making the guest journey complicated.',
            'image'       => function_exists('wvn_media') ? wvn_media('2025/04/2J0A2532-533x800-1.jpg') : $hero,
            'highlights'  => array(
                array('label' => '01 · Character', 'title' => 'Island or palace hotel', 'text' => 'Choose theatre or operational ease based on guest count and schedule.'),
                array('label' => '02 · Logistics', 'title' => 'Boat, access and backups', 'text' => 'Confirm movement, vendor access and weather plans before holding a date.'),
                array('label' => '03 · Scale', 'title' => 'Intimate or large family', 'text' => 'Some heritage settings suit smaller lists; palace hotels can carry larger weeks.'),
                array('label' => '04 · Budget', 'title' => 'Compare complete costs', 'text' => 'Look beyond room rates to production, hospitality and package terms.'),
            ),
            'faqs' => array(
                array('q' => 'What is the best palace wedding venue in Udaipur?', 'a' => 'There is no single answer. Lake-focused venues and larger palace hotels serve different guest lists and schedules.'),
                array('q' => 'Are palace weddings suitable for large guest lists?', 'a' => 'Some palace hotels yes; island venues often suit more intimate celebrations.'),
                array('q' => 'Do palace venues include décor?', 'a' => 'Terms vary. Confirm what is included before comparing proposals.'),
            ),
        ),
        'udaipur-wedding-cost' => array(
            'seo_title'   => 'Udaipur Wedding Cost | Destination Wedding Budget Guide',
            'description' => 'Understand Udaipur wedding costs by guest count, venue, rooms, catering, décor, production and planning.',
            'intro'       => 'There is no single Udaipur wedding cost. Guest count, venue tier, room block and production level move the budget more than any one line item.',
            'image'       => function_exists('wvn_media') ? wvn_media('2025/04/2J0A1818.jpg') : $hero,
            'highlights'  => array(
                array('label' => '01 · Range', 'title' => 'A realistic starting point', 'text' => 'Plan with broad ranges first, then refine once venue and guest count are clear.'),
                array('label' => '02 · Buckets', 'title' => 'Six cost drivers', 'text' => 'Venue/rooms, catering, décor/production, photography, entertainment and planning/hospitality.'),
                array('label' => '03 · Guests', 'title' => 'Count changes everything', 'text' => 'More guests affect rooms, meals, transfers, staffing and function spaces together.'),
                array('label' => '04 · Control', 'title' => 'Decide in the right order', 'text' => 'Lock date, guest range and venue before spending on production details.'),
            ),
            'faqs' => array(
                array('q' => 'How much does a wedding in Udaipur cost?', 'a' => 'A 2-day celebration for around 150–200 guests can range broadly depending on venue, rooms, catering and production scope.'),
                array('q' => 'What is usually the biggest cost?', 'a' => 'Venue and accommodation are often the largest commitment for destination weddings.'),
                array('q' => 'How can we control costs?', 'a' => 'Start with guest count, choose a venue that can host most functions on one campus, and compare complete costs rather than room rates alone.'),
            ),
        ),
        'event-planner-udaipur' => array(
            'seo_title'   => 'Best Event Planner in Udaipur | Wedding Vows by Nikhil',
            'description' => 'Event planner in Udaipur for weddings, private celebrations and destination events — planning, design, production and on-ground coordination.',
            'intro'       => 'Wedding Vows by Nikhil plans weddings and destination events in Udaipur with one local team coordinating venue, design, vendors, guest experience and execution.',
            'image'       => $hero,
            'highlights'  => array(
                array('label' => '01 · Udaipur expertise', 'title' => 'Venue-first decisions', 'text' => 'Palace hotels, heritage properties and resorts each have different access and guest-flow realities.'),
                array('label' => '02 · Design', 'title' => 'A clear creative direction', 'text' => 'Décor, florals, lighting and production stay in one visual language.'),
                array('label' => '03 · Production', 'title' => 'Details behind the show', 'text' => 'Schedules, access, sound, lighting and transitions are coordinated before guests arrive.'),
                array('label' => '04 · Execution', 'title' => 'Calm on event day', 'text' => 'A run sheet and on-ground team keep hosts focused on the celebration.'),
            ),
            'faqs' => array(
                array('q' => 'Do you plan events beyond weddings?', 'a' => 'Yes — private celebrations and destination events in Udaipur alongside weddings.'),
                array('q' => 'Can you manage production-heavy events?', 'a' => 'Yes. Staging, lighting, sound and vendor coordination are part of our planning process.'),
                array('q' => 'How do we start?', 'a' => 'Share your date, guest count, venue preference and the experience you want to create.'),
            ),
        ),
    );

    if (isset($pages[$slug])) {
        return $pages[$slug];
    }

    if (function_exists('wvn_commercial_seo_pages')) {
        $commercial = wvn_commercial_seo_pages();
        if (isset($commercial[$slug]) && is_array($commercial[$slug])) {
            $cfg = $commercial[$slug];
            return array(
                'seo_title'   => $cfg['seo_title'] ?? ($cfg['title'] ?? ''),
                'description' => $cfg['description'] ?? '',
                'intro'       => $cfg['intro'] ?? '',
                'image'       => $hero,
                'highlights'  => array(),
                'faqs'        => $cfg['faqs'] ?? array(),
            );
        }
    }

    return array();
}

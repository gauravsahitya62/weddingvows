<?php
/**
 * What we do / Services page — flexible sections for wp-admin.
 */

function wvn_register_services_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $locations = array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-what-we-do.php',
            ),
        ),
    );
    $page = get_page_by_path('what-we-do');
    if ($page) {
        $locations[] = array(
            array(
                'param' => 'page',
                'operator' => '==',
                'value' => (string) $page->ID,
            ),
        );
    }

    acf_add_local_field_group(array(
        'key' => 'group_wvn_services',
        'title' => 'Services page sections',
        'style' => 'default',
        'position' => 'acf_after_title',
        'description' => 'These sections are the live Services page. Add, remove, or reorder them here.',
        'hide_on_screen' => array('the_content', 'excerpt', 'discussion', 'comments'),
        'location' => $locations,
        'fields' => array(
            array(
                'key' => 'field_wvn_svc_sections',
                'label' => 'Sections',
                'name' => 'service_sections',
                'type' => 'flexible_content',
                'button_label' => 'Add section',
                'layouts' => array(
                    'layout_hero' => array(
                        'key' => 'layout_wvn_svc_hero',
                        'name' => 'hero',
                        'label' => 'Hero',
                        'display' => 'block',
                        'sub_fields' => array(
                            array('key' => 'field_wvn_svc_hero_image', 'label' => 'Background image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'),
                            array('key' => 'field_wvn_svc_hero_crumb', 'label' => 'Breadcrumb', 'name' => 'crumb', 'type' => 'text'),
                            array('key' => 'field_wvn_svc_hero_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
                            array('key' => 'field_wvn_svc_hero_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea', 'rows' => 3),
                        ),
                    ),
                    'layout_intro' => array(
                        'key' => 'layout_wvn_svc_intro',
                        'name' => 'intro',
                        'label' => 'Intro + stats',
                        'display' => 'block',
                        'sub_fields' => array(
                            array('key' => 'field_wvn_svc_intro_kicker', 'label' => 'Kicker', 'name' => 'kicker', 'type' => 'text'),
                            array('key' => 'field_wvn_svc_intro_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
                            array('key' => 'field_wvn_svc_intro_left', 'label' => 'Left column', 'name' => 'left', 'type' => 'textarea', 'rows' => 4, 'wrapper' => array('width' => '50')),
                            array('key' => 'field_wvn_svc_intro_right', 'label' => 'Right column', 'name' => 'right', 'type' => 'textarea', 'rows' => 4, 'wrapper' => array('width' => '50')),
                            array(
                                'key' => 'field_wvn_svc_intro_stats',
                                'label' => 'Statistics',
                                'name' => 'stats',
                                'type' => 'repeater',
                                'layout' => 'table',
                                'button_label' => 'Add stat',
                                'sub_fields' => array(
                                    array('key' => 'field_wvn_svc_stat_value', 'label' => 'Value', 'name' => 'value', 'type' => 'text'),
                                    array('key' => 'field_wvn_svc_stat_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text'),
                                ),
                            ),
                        ),
                    ),
                    'layout_core' => array(
                        'key' => 'layout_wvn_svc_core',
                        'name' => 'core',
                        'label' => 'Core services grid',
                        'display' => 'block',
                        'sub_fields' => array(
                            array('key' => 'field_wvn_svc_core_kicker', 'label' => 'Kicker', 'name' => 'kicker', 'type' => 'text'),
                            array('key' => 'field_wvn_svc_core_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
                            array('key' => 'field_wvn_svc_core_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea', 'rows' => 3),
                            array(
                                'key' => 'field_wvn_svc_core_cards',
                                'label' => 'Cards',
                                'name' => 'cards',
                                'type' => 'repeater',
                                'layout' => 'block',
                                'button_label' => 'Add card',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_wvn_svc_core_style',
                                        'label' => 'Style',
                                        'name' => 'style',
                                        'type' => 'select',
                                        'choices' => array(
                                            'venue' => 'Tall venue (polaroids)',
                                            'tags'  => 'Wide tags',
                                            'photo' => 'Photo card',
                                        ),
                                    ),
                                    array('key' => 'field_wvn_svc_core_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text', 'wrapper' => array('width' => '40')),
                                    array('key' => 'field_wvn_svc_core_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text', 'wrapper' => array('width' => '60')),
                                    array('key' => 'field_wvn_svc_core_card_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea', 'rows' => 2),
                                    array('key' => 'field_wvn_svc_core_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'wrapper' => array('width' => '50')),
                                    array('key' => 'field_wvn_svc_core_image2', 'label' => 'Second image (venue)', 'name' => 'image_2', 'type' => 'image', 'return_format' => 'array', 'wrapper' => array('width' => '50')),
                                    array('key' => 'field_wvn_svc_core_caption', 'label' => 'Polaroid caption', 'name' => 'caption', 'type' => 'text'),
                                    array('key' => 'field_wvn_svc_core_tags', 'label' => 'Tags (one per line)', 'name' => 'tags', 'type' => 'textarea', 'rows' => 4),
                                ),
                            ),
                        ),
                    ),
                    'layout_specials' => array(
                        'key' => 'layout_wvn_svc_specials',
                        'name' => 'specials',
                        'label' => 'Specialities mosaic',
                        'display' => 'block',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_wvn_svc_special_cards',
                                'label' => 'Tiles',
                                'name' => 'cards',
                                'type' => 'repeater',
                                'layout' => 'block',
                                'button_label' => 'Add tile',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_wvn_svc_sp_style',
                                        'label' => 'Style',
                                        'name' => 'style',
                                        'type' => 'select',
                                        'choices' => array(
                                            'photo' => 'Photo',
                                            'intro' => 'Intro / heading',
                                            'star'  => 'Star accent',
                                            'text'  => 'Text card',
                                            'brand' => 'Brand bar',
                                        ),
                                    ),
                                    array(
                                        'key' => 'field_wvn_svc_sp_tone',
                                        'label' => 'Tone',
                                        'name' => 'tone',
                                        'type' => 'select',
                                        'choices' => array(
                                            'deep'  => 'Deep',
                                            'rose'  => 'Rose',
                                            'cream' => 'Cream',
                                            'ink'   => 'Ink',
                                        ),
                                    ),
                                    array('key' => 'field_wvn_svc_sp_number', 'label' => 'Number', 'name' => 'number', 'type' => 'text', 'wrapper' => array('width' => '20')),
                                    array('key' => 'field_wvn_svc_sp_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text', 'wrapper' => array('width' => '40')),
                                    array('key' => 'field_wvn_svc_sp_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea', 'rows' => 3, 'wrapper' => array('width' => '40')),
                                    array('key' => 'field_wvn_svc_sp_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'),
                                    array('key' => 'field_wvn_svc_sp_link', 'label' => 'Link text', 'name' => 'link', 'type' => 'text', 'wrapper' => array('width' => '50')),
                                    array('key' => 'field_wvn_svc_sp_url', 'label' => 'Link URL', 'name' => 'url', 'type' => 'url', 'wrapper' => array('width' => '50')),
                                ),
                            ),
                        ),
                    ),
                    'layout_glance' => array(
                        'key' => 'layout_wvn_svc_glance',
                        'name' => 'glance',
                        'label' => 'Services at a glance',
                        'display' => 'block',
                        'sub_fields' => array(
                            array('key' => 'field_wvn_svc_glance_kicker', 'label' => 'Kicker', 'name' => 'kicker', 'type' => 'text'),
                            array('key' => 'field_wvn_svc_glance_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
                            array('key' => 'field_wvn_svc_glance_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea', 'rows' => 3),
                            array(
                                'key' => 'field_wvn_svc_glance_cols',
                                'label' => 'Columns',
                                'name' => 'columns',
                                'type' => 'repeater',
                                'layout' => 'block',
                                'button_label' => 'Add column',
                                'sub_fields' => array(
                                    array('key' => 'field_wvn_svc_glance_col_heading', 'label' => 'Column heading', 'name' => 'heading', 'type' => 'text'),
                                    array(
                                        'key' => 'field_wvn_svc_glance_items',
                                        'label' => 'Items',
                                        'name' => 'items',
                                        'type' => 'repeater',
                                        'layout' => 'table',
                                        'button_label' => 'Add item',
                                        'sub_fields' => array(
                                            array('key' => 'field_wvn_svc_glance_item_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'),
                                            array('key' => 'field_wvn_svc_glance_item_text', 'label' => 'Text', 'name' => 'text', 'type' => 'text'),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'layout_why' => array(
                        'key' => 'layout_wvn_svc_why',
                        'name' => 'why',
                        'label' => 'Why us',
                        'display' => 'block',
                        'sub_fields' => array(
                            array('key' => 'field_wvn_svc_why_kicker', 'label' => 'Kicker', 'name' => 'kicker', 'type' => 'text'),
                            array('key' => 'field_wvn_svc_why_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
                            array('key' => 'field_wvn_svc_why_text', 'label' => 'Intro', 'name' => 'text', 'type' => 'textarea', 'rows' => 3),
                            array(
                                'key' => 'field_wvn_svc_why_features',
                                'label' => 'Features',
                                'name' => 'features',
                                'type' => 'repeater',
                                'layout' => 'block',
                                'button_label' => 'Add feature',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_wvn_svc_why_icon',
                                        'label' => 'Icon',
                                        'name' => 'icon',
                                        'type' => 'select',
                                        'choices' => array(
                                            'venue'    => 'Venue',
                                            'calendar' => 'Calendar',
                                            'people'   => 'People',
                                            'diamond'  => 'Diamond',
                                        ),
                                        'wrapper' => array('width' => '20'),
                                    ),
                                    array('key' => 'field_wvn_svc_why_ft_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text', 'wrapper' => array('width' => '30')),
                                    array('key' => 'field_wvn_svc_why_ft_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea', 'rows' => 2, 'wrapper' => array('width' => '50')),
                                ),
                            ),
                            array(
                                'key' => 'field_wvn_svc_why_articles',
                                'label' => 'Articles',
                                'name' => 'articles',
                                'type' => 'repeater',
                                'layout' => 'block',
                                'button_label' => 'Add article',
                                'sub_fields' => array(
                                    array('key' => 'field_wvn_svc_why_art_heading', 'label' => 'Heading', 'name' => 'heading', 'type' => 'text'),
                                    array('key' => 'field_wvn_svc_why_art_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea', 'rows' => 4),
                                ),
                            ),
                            array('key' => 'field_wvn_svc_why_button', 'label' => 'Read more label', 'name' => 'button', 'type' => 'text'),
                        ),
                    ),
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'wvn_register_services_fields');

function wvn_svc_lines($value) {
    if (is_array($value)) {
        return array_values(array_filter(array_map('trim', $value)));
    }
    $value = (string) $value;
    if ($value === '') {
        return array();
    }
    return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value))));
}

function wvn_services_sections_default() {
    $palace = wvn_media('2025/04/NVP_JEHANAXKANISHK_WEDDING-1450.jpg');
    $decor  = wvn_media('2025/04/2J0A7886-1200x800-1.jpg');
    $couple = wvn_media('2025/04/2J0A1820-1200x800-1.jpg');
    $guest  = wvn_media('2025/04/2J0A1818.jpg');
    $beauty = wvn_media('2025/04/2J0A2532-533x800-1.jpg');
    $plan   = wvn_media('2025/04/2J0A0682.jpg');
    $party  = wvn_media('2025/04/2J0A0986-534x800-1.jpg');
    $night  = wvn_media('2025/05/IMG_4902-scaled.png');

    return array(
        array(
            'layout'  => 'hero',
            'image'   => $palace,
            'crumb'   => 'Home / Destination wedding services',
            'heading' => 'Destination wedding services in Udaipur',
            'text'    => 'Venues, décor, photography, hospitality and beauty for destination weddings in Udaipur and across India — designed and delivered by one trusted team.',
        ),
        array(
            'layout'  => 'intro',
            'kicker'  => 'One team, every detail',
            'heading' => 'Full-service wedding services, across India',
            'left'    => 'A wedding is hundreds of moving parts — a venue to hold, a world to build, moments to capture, guests to care for. Most couples stitch together a dozen vendors to make it all happen.',
            'right'   => 'Wedding Vows by Nikhil brings it under one roof. As a full-service wedding studio in Udaipur, we plan, design and run every element of your celebration, so you live the day instead of managing it.',
            'stats'   => array(
                array('value' => '100+', 'label' => 'Weddings delivered'),
                array('value' => '5', 'label' => 'Core services, in-house'),
                array('value' => '40+', 'label' => 'Venue & resort partners'),
                array('value' => '1', 'label' => 'Team, end to end'),
            ),
        ),
        array(
            'layout'  => 'core',
            'kicker'  => 'What we do',
            'heading' => 'Our wedding services',
            'text'    => 'Five core disciplines, one seamless team. Every service below is delivered in-house and coordinated end to end, so nothing falls between vendors.',
            'cards'   => array(
                array(
                    'style'   => 'venue',
                    'label'   => '01 — Venues',
                    'title'   => 'Wedding venue',
                    'text'    => 'Heritage palaces, forts, resorts and lawns — secured, staged and dressed to your guest count and style.',
                    'image'   => $palace,
                    'image_2' => $decor,
                    'caption' => 'Palaces',
                    'tags'    => array(),
                ),
                array(
                    'style'   => 'tags',
                    'label'   => '02 — Décor',
                    'title'   => 'Decor & design',
                    'text'    => '',
                    'image'   => '',
                    'image_2' => '',
                    'caption' => '',
                    'tags'    => array('Floral Design', 'Stage & Mandap', 'Lighting Design', 'Tablescapes', 'Draping', 'Entrance Moments', 'Props & Rentals', '3D & CAD Previews'),
                ),
                array(
                    'style'   => 'photo',
                    'label'   => '03 — Visuals',
                    'title'   => 'Photography & film',
                    'text'    => 'Candid, cinematic coverage across every function.',
                    'image'   => $couple,
                    'image_2' => '',
                    'caption' => '',
                    'tags'    => array(),
                ),
                array(
                    'style'   => 'photo',
                    'label'   => '04 — Guest care',
                    'title'   => 'Hospitality & logistics',
                    'text'    => 'Stays, transfers and guest care, end to end.',
                    'image'   => $guest,
                    'image_2' => '',
                    'caption' => '',
                    'tags'    => array(),
                ),
                array(
                    'style'   => 'photo',
                    'label'   => '05 — Beauty',
                    'title'   => 'Makeup & mehendi',
                    'text'    => 'Leading bridal artists and henna designers.',
                    'image'   => $beauty,
                    'image_2' => '',
                    'caption' => '',
                    'tags'    => array(),
                ),
            ),
        ),
        array(
            'layout' => 'specials',
            'cards'  => array(
                array('style' => 'photo', 'tone' => 'deep', 'number' => '01', 'title' => 'Planning & coordination', 'text' => 'Timelines, vendors, management', 'image' => $plan, 'link' => '', 'url' => ''),
                array('style' => 'intro', 'tone' => 'deep', 'number' => '', 'title' => 'Specialities & add-ons', 'text' => 'The details that complete a celebration — entertainment, stationery, guest concierge and travel — held by the same studio that plans the day.', 'image' => '', 'link' => '', 'url' => ''),
                array('style' => 'photo', 'tone' => 'deep', 'number' => '02', 'title' => 'Themed decor & design', 'text' => 'Sets, florals and lighting', 'image' => $decor, 'link' => '', 'url' => ''),
                array('style' => 'star', 'tone' => 'cream', 'number' => '', 'title' => '', 'text' => '', 'image' => '', 'link' => '', 'url' => ''),
                array('style' => 'photo', 'tone' => 'deep', 'number' => '03', 'title' => 'Pre-wedding events', 'text' => 'Sangeet, mehendi and welcome nights', 'image' => $party, 'link' => '', 'url' => ''),
                array('style' => 'text', 'tone' => 'rose', 'number' => '', 'title' => 'Guest concierge', 'text' => 'RSVPs, welcome desks and guest care from arrival to farewell.', 'image' => '', 'link' => 'Learn more', 'url' => home_url('/contact-us/')),
                array('style' => 'text', 'tone' => 'ink', 'number' => '', 'title' => 'Invitations & gifting', 'text' => 'Save the date & e-invites', 'image' => '', 'link' => 'Know more', 'url' => home_url('/contact-us/')),
                array('style' => 'photo', 'tone' => 'deep', 'number' => '04', 'title' => 'Transport & travel', 'text' => 'Flights, transfers & stays', 'image' => $night, 'link' => '', 'url' => ''),
                array('style' => 'brand', 'tone' => 'cream', 'number' => '', 'title' => 'Wedding Vows by Nikhil', 'text' => '', 'image' => '', 'link' => '', 'url' => ''),
            ),
        ),
        array(
            'layout'  => 'glance',
            'kicker'  => 'The full list',
            'heading' => 'Every service at a glance',
            'text'    => 'A quick reference to everything we deliver in-house — the core five, plus the specialities that complete your day.',
            'columns' => array(
                array(
                    'heading' => 'Core services',
                    'items'   => array(
                        array('title' => 'Wedding Venue', 'text' => 'palaces, resorts and lawns, secured and staged.'),
                        array('title' => 'Decor & Design', 'text' => 'bespoke sets, florals and lighting.'),
                        array('title' => 'Photography & Film', 'text' => 'candid, cinematic coverage across functions.'),
                        array('title' => 'Hospitality & Logistics', 'text' => 'stays, transfers and on-ground coordination.'),
                        array('title' => 'Makeup & Mehendi', 'text' => 'leading bridal artists and henna designers.'),
                    ),
                ),
                array(
                    'heading' => 'Specialities & support',
                    'items'   => array(
                        array('title' => 'Planning & Coordination', 'text' => 'budgets, timelines and vendor management.'),
                        array('title' => 'Entertainment & Sound', 'text' => 'artists, DJs and stage production.'),
                        array('title' => 'Catering & Cuisine', 'text' => 'curated menus, live counters and service.'),
                        array('title' => 'Invitations & Gifting', 'text' => 'stationery, hampers and signage.'),
                        array('title' => 'Guest Concierge', 'text' => 'RSVPs, welcome desks and guest care.'),
                        array('title' => 'Transport & Travel', 'text' => 'transfers, fleets and travel desks.'),
                    ),
                ),
            ),
        ),
        array(
            'layout'   => 'why',
            'kicker'   => 'Why us',
            'heading'  => 'Why choose Wedding Vows by Nikhil as your wedding service provider',
            'text'     => 'One accountable team, one contract, one vision — instead of a dozen vendors pulling in different directions. Here is what that changes.',
            'features' => array(
                array('icon' => 'venue', 'title' => 'Everything in-house', 'text' => 'Venue, décor, photography, hospitality and beauty under one roof — briefed once, delivered together.'),
                array('icon' => 'calendar', 'title' => 'One point of contact', 'text' => 'A single planner owns your day, so nothing is lost between suppliers or left to chance.'),
                array('icon' => 'people', 'title' => 'Transparent budgets', 'text' => 'Bundled services and clear costs, with no vendor mark-ups hidden in the middle.'),
                array('icon' => 'diamond', 'title' => 'Proven across India', 'text' => 'Palace, resort, beach and city weddings delivered end-to-end, at every scale.'),
            ),
            'articles' => array(
                array(
                    'heading' => 'What does a full-service wedding service provider do?',
                    'text'    => 'A full-service wedding service provider handles every element of your wedding under one roof — from securing the venue and building the décor to photography, catering, hospitality and bridal beauty. Instead of hiring and managing separate vendors, you brief one team that plans, coordinates and delivers the entire celebration.',
                ),
                array(
                    'heading' => 'Wedding services we offer in India',
                    'text'    => 'Wedding Vows by Nikhil offers five core wedding services in India — wedding venues, décor and design, photography and film, hospitality and logistics, and makeup and mehendi — supported by planning, entertainment, catering, stationery, guest concierge and transport. Every service is delivered in-house and coordinated end to end.',
                ),
                array(
                    'heading' => 'Why choose one provider over multiple vendors?',
                    'text'    => 'Multiple vendors mean multiple briefs, invoices and gaps. One studio keeps the design, timeline and guest experience in a single conversation — so the mandap, the music and the welcome dinner feel like the same wedding.',
                ),
            ),
            'button' => 'Read more',
        ),
    );
}

function wvn_svc_default_card($title) {
    static $index = null;
    if ($index === null) {
        $index = array();
        foreach (wvn_services_sections_default() as $section) {
            if (empty($section['cards']) || !is_array($section['cards'])) {
                continue;
            }
            foreach ($section['cards'] as $card) {
                $key = strtolower(trim((string) ($card['title'] ?? '')));
                if ($key !== '') {
                    $index[$key] = $card;
                }
            }
        }
    }
    $key = strtolower(trim((string) $title));
    return $index[$key] ?? array();
}

function wvn_svc_map_cards($rows) {
    $cards = array();
    if (!is_array($rows)) {
        return $cards;
    }
    foreach ($rows as $row) {
        $fallback = wvn_svc_default_card($row['title'] ?? '');
        $cards[] = array(
            'style'   => $row['style'] ?? ($fallback['style'] ?? 'photo'),
            'tone'    => $row['tone'] ?? ($fallback['tone'] ?? 'deep'),
            'label'   => $row['label'] ?? '',
            'number'  => $row['number'] ?? '',
            'title'   => $row['title'] ?? '',
            'text'    => $row['text'] ?? '',
            'image'   => wvn_image_url($row['image'] ?? '', $fallback['image'] ?? ''),
            'image_2' => wvn_image_url($row['image_2'] ?? '', $fallback['image_2'] ?? ''),
            'caption' => $row['caption'] ?? ($fallback['caption'] ?? ''),
            'tags'    => wvn_svc_lines($row['tags'] ?? ($fallback['tags'] ?? '')),
            'link'    => $row['link'] ?? '',
            'url'     => $row['url'] ?? '',
        );
    }
    return $cards;
}

function wvn_services_sections() {
    $id = get_the_ID();
    if (function_exists('have_rows') && $id && have_rows('service_sections', $id)) {
        $sections = array();
        while (have_rows('service_sections', $id)) {
            the_row();
            $layout = get_row_layout();
            if ($layout === 'hero') {
                $sections[] = array(
                    'layout'  => 'hero',
                    'image'   => wvn_image_url(get_sub_field('image'), wvn_media('2025/04/NVP_JEHANAXKANISHK_WEDDING-1450.jpg')),
                    'crumb'   => get_sub_field('crumb'),
                    'heading' => get_sub_field('heading'),
                    'text'    => get_sub_field('text'),
                );
            } elseif ($layout === 'intro') {
                $stats = array();
                $rows = get_sub_field('stats');
                if (is_array($rows)) {
                    foreach ($rows as $row) {
                        $stats[] = array('value' => $row['value'] ?? '', 'label' => $row['label'] ?? '');
                    }
                }
                $sections[] = array(
                    'layout'  => 'intro',
                    'kicker'  => get_sub_field('kicker'),
                    'heading' => get_sub_field('heading'),
                    'left'    => get_sub_field('left'),
                    'right'   => get_sub_field('right'),
                    'stats'   => $stats,
                );
            } elseif ($layout === 'core') {
                $sections[] = array(
                    'layout'  => 'core',
                    'kicker'  => get_sub_field('kicker'),
                    'heading' => get_sub_field('heading'),
                    'text'    => get_sub_field('text'),
                    'cards'   => wvn_svc_map_cards(get_sub_field('cards')),
                );
            } elseif ($layout === 'specials') {
                $sections[] = array(
                    'layout' => 'specials',
                    'cards'  => wvn_svc_map_cards(get_sub_field('cards')),
                );
            } elseif ($layout === 'glance') {
                $columns = array();
                $cols = get_sub_field('columns');
                if (is_array($cols)) {
                    foreach ($cols as $col) {
                        $items = array();
                        if (!empty($col['items']) && is_array($col['items'])) {
                            foreach ($col['items'] as $item) {
                                $items[] = array('title' => $item['title'] ?? '', 'text' => $item['text'] ?? '');
                            }
                        }
                        $columns[] = array('heading' => $col['heading'] ?? '', 'items' => $items);
                    }
                }
                $sections[] = array(
                    'layout'  => 'glance',
                    'kicker'  => get_sub_field('kicker'),
                    'heading' => get_sub_field('heading'),
                    'text'    => get_sub_field('text'),
                    'columns' => $columns,
                );
            } elseif ($layout === 'why') {
                $features = array();
                $rows = get_sub_field('features');
                if (is_array($rows)) {
                    foreach ($rows as $row) {
                        $features[] = array(
                            'icon'  => $row['icon'] ?? 'venue',
                            'title' => $row['title'] ?? '',
                            'text'  => $row['text'] ?? '',
                        );
                    }
                }
                $articles = array();
                $rows = get_sub_field('articles');
                if (is_array($rows)) {
                    foreach ($rows as $row) {
                        $articles[] = array('heading' => $row['heading'] ?? '', 'text' => $row['text'] ?? '');
                    }
                }
                $sections[] = array(
                    'layout'   => 'why',
                    'kicker'   => get_sub_field('kicker'),
                    'heading'  => get_sub_field('heading'),
                    'text'     => get_sub_field('text'),
                    'features' => $features,
                    'articles' => $articles,
                    'button'   => get_sub_field('button'),
                );
            }
        }
        if ($sections) {
            return $sections;
        }
    }
    return wvn_services_sections_default();
}

function wvn_seed_services_page() {
    if (!function_exists('update_field')) {
        return;
    }
    $page = get_page_by_path('what-we-do');
    if (!$page) {
        $id = wp_insert_post(array(
            'post_title'   => 'What we do',
            'post_name'    => 'what-we-do',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ));
        $page = $id && !is_wp_error($id) ? get_post($id) : null;
    }
    if (!$page) {
        return;
    }
    if (get_page_template_slug($page->ID) !== 'page-what-we-do.php') {
        update_post_meta($page->ID, '_wp_page_template', 'page-what-we-do.php');
    }
    if (get_post_meta($page->ID, '_wvn_services_seeded', true)) {
        return;
    }
    if (function_exists('have_rows') && have_rows('service_sections', $page->ID)) {
        update_post_meta($page->ID, '_wvn_services_seeded', '1');
        return;
    }
    $rows = array();
    foreach (wvn_services_sections_default() as $section) {
        $row = $section;
        $row['acf_fc_layout'] = $section['layout'];
        unset($row['layout']);
        if (!empty($row['image'])) {
            $row['image'] = '';
        }
        if (!empty($row['cards']) && is_array($row['cards'])) {
            foreach ($row['cards'] as &$card) {
                $card['image'] = '';
                $card['image_2'] = '';
                if (!empty($card['tags']) && is_array($card['tags'])) {
                    $card['tags'] = implode("\n", $card['tags']);
                }
            }
            unset($card);
        }
        $rows[] = $row;
    }
    update_field('field_wvn_svc_sections', $rows, $page->ID);
    update_post_meta($page->ID, '_wvn_services_seeded', '1');
}
add_action('acf/init', 'wvn_seed_services_page', 30);

function wvn_svc_icon($name) {
    $icons = array(
        'venue'    => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M4 20V10l8-6 8 6v10"/><path d="M9 20v-6h6v6"/></svg>',
        'calendar' => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="m9 15 2 2 4-4"/></svg>',
        'people'   => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><circle cx="9" cy="8" r="3"/><path d="M3 19c.6-3 2.8-5 6-5s5.4 2 6 5"/><circle cx="17" cy="9" r="2.4"/><path d="M16 19c.3-1.8 1.4-3.2 3.2-4"/></svg>',
        'diamond'  => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M3 9 8 4h8l5 5-9 11L3 9z"/><path d="M3 9h18M8 4l4 5 4-5"/></svg>',
    );
    return $icons[$name] ?? $icons['venue'];
}

function wvn_svc_star() {
    return '<svg class="wvn-svc-star" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 1.6 13.8 10 22.4 12 13.8 14 12 22.4 10.2 14 1.6 12 10.2 10z"/></svg>';
}

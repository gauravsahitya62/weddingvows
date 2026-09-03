<?php
/**
 * ACF Field Registration for "Weddings in Udaipur" Guide Page.
 */

function wvn_register_udaipur_guide_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $locations = array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-weddings-udaipur.php',
            ),
        ),
    );

    $page = get_page_by_path('weddings-in-udaipur');
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
        'key' => 'group_wvn_udaipur_guide',
        'title' => 'Weddings in Udaipur Guide Content',
        'style' => 'default',
        'position' => 'acf_after_title',
        'description' => 'Edit all content, venues, cost breakdowns, and FAQs for the Weddings in Udaipur page.',
        'hide_on_screen' => array('the_content', 'excerpt', 'discussion', 'comments'),
        'location' => $locations,
        'fields' => array(
            array(
                'key' => 'field_wvn_ug_tab_intro',
                'label' => 'Header & Intro',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_ug_kicker',
                'label' => 'Kicker',
                'name' => 'guide_kicker',
                'type' => 'text',
                'default_value' => 'Udaipur destination weddings',
            ),
            array(
                'key' => 'field_wvn_ug_heading',
                'label' => 'Main Heading',
                'name' => 'guide_heading',
                'type' => 'text',
                'default_value' => 'Weddings in Udaipur',
            ),
            array(
                'key' => 'field_wvn_ug_lede',
                'label' => 'Lede / Subtitle',
                'name' => 'guide_lede',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'A local planner’s guide to venues, guest counts, and what a celebration actually costs — written from our studio in Bhuwana.',
            ),
            array(
                'key' => 'field_wvn_ug_intro_body',
                'label' => 'Intro & Story Content (WYSIWYG)',
                'name' => 'guide_intro_body',
                'type' => 'wysiwyg',
                'toolbar' => 'full',
                'media_upload' => 1,
            ),

            array(
                'key' => 'field_wvn_ug_tab_venues',
                'label' => 'Venues',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_ug_venues_heading',
                'label' => 'Venues Section Heading',
                'name' => 'guide_venues_heading',
                'type' => 'text',
                'default_value' => 'Top wedding venues in Udaipur',
            ),
            array(
                'key' => 'field_wvn_ug_venues_desc',
                'label' => 'Venues Section Description',
                'name' => 'guide_venues_desc',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'These are the properties couples ask for most often. The right one depends on guest count, whether you need a full hotel buyout, and which rituals need a lawn versus a courtyard.',
            ),
            array(
                'key' => 'field_wvn_ug_venue_groups',
                'label' => 'Venue Categories & Items',
                'name' => 'guide_venue_groups',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Venue Category',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_ug_vg_label',
                        'label' => 'Category Name',
                        'name' => 'label',
                        'type' => 'text',
                        'instructions' => 'e.g. Heritage palaces, Hilltop & luxury resorts, Boutique heritage',
                    ),
                    array(
                        'key' => 'field_wvn_ug_vg_items',
                        'label' => 'Venues in this Category',
                        'name' => 'items',
                        'type' => 'repeater',
                        'layout' => 'table',
                        'button_label' => 'Add Venue',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_wvn_ug_v_name',
                                'label' => 'Venue Name',
                                'name' => 'name',
                                'type' => 'text',
                            ),
                            array(
                                'key' => 'field_wvn_ug_v_note',
                                'label' => 'Description / Planner Note',
                                'name' => 'note',
                                'type' => 'text',
                            ),
                        ),
                    ),
                ),
            ),

            array(
                'key' => 'field_wvn_ug_tab_costs',
                'label' => 'Cost Breakdown',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_ug_costs_heading',
                'label' => 'Costs Section Heading',
                'name' => 'guide_costs_heading',
                'type' => 'text',
                'default_value' => 'Estimated cost of a wedding in Udaipur (150–200 guests)',
            ),
            array(
                'key' => 'field_wvn_ug_costs_intro',
                'label' => 'Costs Intro Text',
                'name' => 'guide_costs_intro',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Figures below are planning ranges for a two-day destination wedding, not a hotel tariff card. Season, buyout versus lawn hire, and whether guests stay on campus move the total more than any single décor choice.',
            ),
            array(
                'key' => 'field_wvn_ug_costs_table',
                'label' => 'Cost Estimate Rows',
                'name' => 'guide_costs_table',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add Cost Row',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_ug_c_item',
                        'label' => 'Service / Line Item',
                        'name' => 'item',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_wvn_ug_c_range',
                        'label' => 'Typical Range',
                        'name' => 'range',
                        'type' => 'text',
                    ),
                ),
            ),
            array(
                'key' => 'field_wvn_ug_costs_footer',
                'label' => 'Costs Bottom Note',
                'name' => 'guide_costs_footer',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'A quieter boutique wedding can sit near the lower end. A palace or hilltop resort with a full room block, destination catering, and a produced sangeet sits toward the upper end. We put every line in writing before artists are booked.',
            ),

            array(
                'key' => 'field_wvn_ug_tab_steps',
                'label' => 'Planning Process',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_ug_steps_heading',
                'label' => 'Steps Section Heading',
                'name' => 'guide_steps_heading',
                'type' => 'text',
                'default_value' => 'How a destination wedding in Udaipur is planned',
            ),
            array(
                'key' => 'field_wvn_ug_steps',
                'label' => 'Planning Steps',
                'name' => 'guide_steps',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add Step',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_ug_st_title',
                        'label' => 'Step Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_wvn_ug_st_desc',
                        'label' => 'Step Details',
                        'name' => 'desc',
                        'type' => 'textarea',
                        'rows' => 2,
                    ),
                ),
            ),

            array(
                'key' => 'field_wvn_ug_tab_faqs',
                'label' => 'FAQs & CTA',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_ug_faq_heading',
                'label' => 'FAQs Section Heading',
                'name' => 'guide_faq_heading',
                'type' => 'text',
                'default_value' => 'Questions families ask',
            ),
            array(
                'key' => 'field_wvn_ug_faqs',
                'label' => 'Frequently Asked Questions',
                'name' => 'guide_faqs',
                'type' => 'repeater',
                'layout' => 'row',
                'button_label' => 'Add Question',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_ug_fq_q',
                        'label' => 'Question',
                        'name' => 'q',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_wvn_ug_fq_a',
                        'label' => 'Answer',
                        'name' => 'a',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                ),
            ),
            array(
                'key' => 'field_wvn_ug_cta_heading',
                'label' => 'CTA Heading',
                'name' => 'guide_cta_heading',
                'type' => 'text',
                'default_value' => 'Plan your wedding in Udaipur',
            ),
            array(
                'key' => 'field_wvn_ug_cta_text',
                'label' => 'CTA Text',
                'name' => 'guide_cta_text',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Share your season, guest count, and whether you are looking at a palace, a lakeside hotel, or a heritage courtyard. We will reply with a clear next step.',
            ),
            array(
                'key' => 'field_wvn_ug_cta_btn_text',
                'label' => 'CTA Button Text',
                'name' => 'guide_cta_btn_text',
                'type' => 'text',
                'default_value' => 'Book a consultation ↗',
            ),
            array(
                'key' => 'field_wvn_ug_cta_btn_url',
                'label' => 'CTA Button URL',
                'name' => 'guide_cta_btn_url',
                'type' => 'text',
                'default_value' => '/contact-us/',
            ),
        ),
    ));
}
add_action('acf/init', 'wvn_register_udaipur_guide_fields');

/**
 * Seed default guide fields into ACF so they immediately populate in wp-admin
 */
function wvn_seed_udaipur_guide_fields() {
    if (!function_exists('update_field') || get_option('_wvn_udaipur_guide_fields_v1')) {
        return;
    }

    $page = get_page_by_path('weddings-in-udaipur');
    if (!$page) {
        return;
    }

    $pid = $page->ID;

    // Intro body
    $intro_body = '<p>Udaipur is one of India’s most requested destination wedding cities: lake palaces, hilltop resorts, and heritage courtyards within a compact guest journey. Families come for the setting. They stay because the city can host a two- to four-day wedding without moving everyone across the state.</p>' . "\n\n"
        . '<p><strong>Hosting a 2-day wedding for 150 to 200 guests in Udaipur typically ranges from ₹50 lakhs to ₹3+ crores</strong>, depending on whether you take a palace buyout, a luxury resort campus, or a boutique heritage property — and how much of décor, catering, and rooms sit inside the hotel quote.</p>' . "\n\n"
        . '<p>Wedding Vows by Nikhil is based in Udaipur. We shortlist venues against dates and headcount, then plan décor, hospitality, and the run of show so the number you approve is the wedding you host. <a href="' . esc_url(home_url('/contact-us/')) . '">Talk to us about your dates</a>.</p>' . "\n\n"
        . '<h2>Why Udaipur is famous for weddings</h2>' . "\n\n"
        . '<p>The city photographs like a palace film, but the practical reasons matter more. Lake Pichola and the palaces give ceremonies a clear sense of place. Most luxury hotels can hold mehendi, sangeet, pheras and a send-off on one campus, so grandparents are not in traffic between functions. The airport is close enough for destination guests, and neighbourhoods such as Malla Talai, Fatehpura and Hiran Magri already cluster outdoor lawns, resorts and intimate heritage stays.</p>' . "\n\n"
        . '<p>Peak season (October–February, plus selected monsoon dates for lakeside photographs) fills eight to twelve months ahead. If the guest list is 150+, start with rooms and ceremony lawns, not the Instagram still.</p>';

    update_field('guide_kicker', 'Udaipur destination weddings', $pid);
    update_field('guide_heading', 'Weddings in Udaipur', $pid);
    update_field('guide_lede', 'A local planner’s guide to venues, guest counts, and what a celebration actually costs — written from our studio in Bhuwana.', $pid);
    update_field('guide_intro_body', $intro_body, $pid);

    update_field('guide_venues_heading', 'Top wedding venues in Udaipur', $pid);
    update_field('guide_venues_desc', 'These are the properties couples ask for most often. The right one depends on guest count, whether you need a full hotel buyout, and which rituals need a lawn versus a courtyard. We walk sites with you — how we help you choose a palace.', $pid);

    $venue_groups = function_exists('wvn_udaipur_guide_venues') ? wvn_udaipur_guide_venues() : array();
    update_field('guide_venue_groups', $venue_groups, $pid);

    update_field('guide_costs_heading', 'Estimated cost of a wedding in Udaipur (150–200 guests)', $pid);
    update_field('guide_costs_intro', 'Figures below are planning ranges for a two-day destination wedding, not a hotel tariff card. Season, buyout versus lawn hire, and whether guests stay on campus move the total more than any single décor choice.', $pid);
    
    $costs = function_exists('wvn_udaipur_guide_costs') ? wvn_udaipur_guide_costs() : array();
    update_field('guide_costs_table', $costs, $pid);
    update_field('guide_costs_footer', 'A quieter boutique wedding can sit near the lower end. A palace or hilltop resort with a full room block, destination catering, and a produced sangeet sits toward the upper end. We put every line in writing before artists are booked.', $pid);

    $steps = array(
        array(
            'title' => 'Dates and headcount.',
            'desc'  => 'Season and rooms decide the venue list. Peak palace weekends in Udaipur are often held a year out.',
        ),
        array(
            'title' => 'Venue walk.',
            'desc'  => 'Ceremony lawn, sangeet indoor option, and how many rooms you must block.',
        ),
        array(
            'title' => 'Guest journey.',
            'desc'  => 'Airport transfers, welcome dinner, and a quiet morning before pheras — the parts directories rarely price.',
        ),
        array(
            'title' => 'Design and vendors.',
            'desc'  => 'Mandap, lighting, hospitality desks, and the artists.',
        ),
        array(
            'title' => 'On-ground days.',
            'desc'  => 'One team on the floor until the last farewell.',
        ),
    );
    update_field('guide_steps_heading', 'How a destination wedding in Udaipur is planned', $pid);
    update_field('guide_steps', $steps, $pid);

    $faqs = function_exists('wvn_udaipur_guide_faqs') ? wvn_udaipur_guide_faqs() : array();
    update_field('guide_faq_heading', 'Questions families ask', $pid);
    update_field('guide_faqs', $faqs, $pid);

    update_field('guide_cta_heading', 'Plan your wedding in Udaipur', $pid);
    update_field('guide_cta_text', 'Share your season, guest count, and whether you are looking at a palace, a lakeside hotel, or a heritage courtyard. We will reply with a clear next step.', $pid);
    update_field('guide_cta_btn_text', 'Book a consultation ↗', $pid);
    update_field('guide_cta_btn_url', '/contact-us/', $pid);

    update_option('_wvn_udaipur_guide_fields_v1', '1');
}
add_action('acf/init', 'wvn_seed_udaipur_guide_fields', 50);

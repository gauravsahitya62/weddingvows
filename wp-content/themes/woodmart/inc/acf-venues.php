<?php
/**
 * ACF fields for Venue CPT — matches venue detail page sections.
 */

function wvn_register_venue_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_wvn_venue_detail',
        'title' => 'Venue Details',
        'style' => 'default',
        'position' => 'acf_after_title',
        'description' => 'Hero stats, pricing, gallery, spaces, rooms, inclusions, policies and about copy for this venue.',
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'venue',
                ),
            ),
        ),
        'fields' => array(
            // —— Hero ——
            array('key' => 'field_wvn_venue_tab_hero', 'label' => 'Hero', 'type' => 'tab'),
            array(
                'key' => 'field_wvn_venue_hero_image',
                'label' => 'Hero image',
                'name' => 'venue_hero_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Full-width banner. Falls back to Featured Image.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_venue_location',
                'label' => 'Location',
                'name' => 'venue_location',
                'type' => 'text',
                'default_value' => 'Udaipur, Rajasthan',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_venue_rating',
                'label' => 'Rating',
                'name' => 'venue_rating',
                'type' => 'text',
                'placeholder' => '4.8',
                'wrapper' => array('width' => '25'),
            ),
            array(
                'key' => 'field_wvn_venue_reviews',
                'label' => 'Review count',
                'name' => 'venue_review_count',
                'type' => 'text',
                'placeholder' => '11',
                'wrapper' => array('width' => '25'),
            ),
            array(
                'key' => 'field_wvn_venue_region',
                'label' => 'Region / landmark',
                'name' => 'venue_region',
                'type' => 'text',
                'placeholder' => 'Aravalli Range',
                'wrapper' => array('width' => '25'),
            ),
            array(
                'key' => 'field_wvn_venue_view',
                'label' => 'View',
                'name' => 'venue_view',
                'type' => 'text',
                'placeholder' => 'Lake Pichola',
                'wrapper' => array('width' => '25'),
            ),
            array(
                'key' => 'field_wvn_venue_duration',
                'label' => 'Duration',
                'name' => 'venue_duration',
                'type' => 'text',
                'placeholder' => 'From 2 to 3 days',
                'wrapper' => array('width' => '25'),
            ),
            array(
                'key' => 'field_wvn_venue_capacity',
                'label' => 'Capacity',
                'name' => 'venue_capacity',
                'type' => 'text',
                'placeholder' => '300–400',
                'wrapper' => array('width' => '25'),
            ),
            array(
                'key' => 'field_wvn_venue_rooms_count',
                'label' => 'Rooms count',
                'name' => 'venue_rooms_count',
                'type' => 'text',
                'placeholder' => '56',
                'wrapper' => array('width' => '25'),
            ),
            array(
                'key' => 'field_wvn_venue_starting_price',
                'label' => 'Starting price (hero)',
                'name' => 'venue_starting_price',
                'type' => 'text',
                'placeholder' => '₹80L+',
                'wrapper' => array('width' => '25'),
            ),
            array(
                'key' => 'field_wvn_venue_card_blurb',
                'label' => 'Homepage card blurb',
                'name' => 'venue_card_blurb',
                'type' => 'textarea',
                'rows' => 3,
                'instructions' => 'Short line shown on the homepage venues slider.',
                'wrapper' => array('width' => '100'),
            ),

            // —— Pricing ——
            array('key' => 'field_wvn_venue_tab_pricing', 'label' => 'Pricing', 'type' => 'tab'),
            array(
                'key' => 'field_wvn_venue_price_range',
                'label' => 'Price range headline',
                'name' => 'venue_price_range',
                'type' => 'text',
                'placeholder' => '₹80 – 1.5 Lakhs',
                'instructions' => 'Large price shown at the top of Pricing.',
            ),
            array(
                'key' => 'field_wvn_venue_price_note',
                'label' => 'Price note',
                'name' => 'venue_price_note',
                'type' => 'text',
                'placeholder' => 'For 200–300 guests · taxes extra',
            ),
            array(
                'key' => 'field_wvn_venue_price_disclaimer',
                'label' => 'Pricing disclaimer',
                'name' => 'venue_price_disclaimer',
                'type' => 'textarea',
                'rows' => 2,
                'placeholder' => 'Prices vary by season, guest count and inclusions.',
            ),
            array(
                'key' => 'field_wvn_venue_pricing_items',
                'label' => 'Pricing breakdown',
                'name' => 'venue_pricing_items',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add pricing row',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_venue_price_label',
                        'label' => 'Label',
                        'name' => 'label',
                        'type' => 'text',
                        'placeholder' => 'Food (Vegetarian)',
                    ),
                    array(
                        'key' => 'field_wvn_venue_price_value',
                        'label' => 'Value',
                        'name' => 'value',
                        'type' => 'text',
                        'placeholder' => 'from ₹2,500 / plate',
                    ),
                ),
            ),

            // —— Gallery ——
            array('key' => 'field_wvn_venue_tab_gallery', 'label' => 'Photos & Videos', 'type' => 'tab'),
            array(
                'key' => 'field_wvn_venue_gallery',
                'label' => 'Photo gallery',
                'name' => 'venue_gallery',
                'type' => 'gallery',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_wvn_venue_video_url',
                'label' => 'Video URL (optional)',
                'name' => 'venue_video_url',
                'type' => 'url',
                'instructions' => 'YouTube / Vimeo / MP4 link shown with the gallery.',
            ),

            // —— Spaces ——
            array('key' => 'field_wvn_venue_tab_spaces', 'label' => 'Venues / Spaces', 'type' => 'tab'),
            array(
                'key' => 'field_wvn_venue_spaces_intro',
                'label' => 'Spaces intro',
                'name' => 'venue_spaces_intro',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'field_wvn_venue_spaces',
                'label' => 'Spaces list',
                'name' => 'venue_spaces',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add space',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_venue_space_name',
                        'label' => 'Name',
                        'name' => 'name',
                        'type' => 'text',
                        'wrapper' => array('width' => '40'),
                    ),
                    array(
                        'key' => 'field_wvn_venue_space_meta',
                        'label' => 'Subtitle',
                        'name' => 'meta',
                        'type' => 'text',
                        'placeholder' => 'Ballroom · Indoor',
                        'wrapper' => array('width' => '35'),
                    ),
                    array(
                        'key' => 'field_wvn_venue_space_capacity',
                        'label' => 'Capacity',
                        'name' => 'capacity',
                        'type' => 'text',
                        'placeholder' => '400 guests',
                        'wrapper' => array('width' => '25'),
                    ),
                ),
            ),

            // —— Rooms ——
            array('key' => 'field_wvn_venue_tab_rooms', 'label' => 'Rooms', 'type' => 'tab'),
            array(
                'key' => 'field_wvn_venue_rooms_heading',
                'label' => 'Rooms heading',
                'name' => 'venue_rooms_heading',
                'type' => 'text',
                'default_value' => 'Rooms',
            ),
            array(
                'key' => 'field_wvn_venue_rooms_text',
                'label' => 'Rooms description',
                'name' => 'venue_rooms_text',
                'type' => 'textarea',
                'rows' => 4,
            ),
            array(
                'key' => 'field_wvn_venue_rooms_gallery',
                'label' => 'Room photos',
                'name' => 'venue_rooms_gallery',
                'type' => 'gallery',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // —— Inclusions ——
            array('key' => 'field_wvn_venue_tab_inclusions', 'label' => 'Wedding Inclusions', 'type' => 'tab'),
            array(
                'key' => 'field_wvn_venue_inclusions',
                'label' => 'Inclusions',
                'name' => 'venue_inclusions',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add inclusion',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_venue_inclusion_text',
                        'label' => 'Item',
                        'name' => 'text',
                        'type' => 'text',
                    ),
                ),
            ),

            // —— Policies ——
            array('key' => 'field_wvn_venue_tab_policies', 'label' => 'Policies', 'type' => 'tab'),
            array(
                'key' => 'field_wvn_venue_policies',
                'label' => 'Policies',
                'name' => 'venue_policies',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add policy',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_venue_policy_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'wrapper' => array('width' => '35'),
                    ),
                    array(
                        'key' => 'field_wvn_venue_policy_text',
                        'label' => 'Description',
                        'name' => 'text',
                        'type' => 'textarea',
                        'rows' => 2,
                        'wrapper' => array('width' => '65'),
                    ),
                ),
            ),

            // —— About ——
            array('key' => 'field_wvn_venue_tab_about', 'label' => 'About', 'type' => 'tab'),
            array(
                'key' => 'field_wvn_venue_about_heading',
                'label' => 'About heading',
                'name' => 'venue_about_heading',
                'type' => 'text',
                'placeholder' => 'A day at this venue',
            ),
            array(
                'key' => 'field_wvn_venue_about',
                'label' => 'About content',
                'name' => 'venue_about',
                'type' => 'wysiwyg',
                'tabs' => 'all',
                'toolbar' => 'basic',
                'media_upload' => 0,
                'instructions' => 'Falls back to the main editor content if empty.',
            ),

            // —— Form ——
            array('key' => 'field_wvn_venue_tab_form', 'label' => 'Enquiry form', 'type' => 'tab'),
            array(
                'key' => 'field_wvn_venue_form_heading',
                'label' => 'Form heading',
                'name' => 'venue_form_heading',
                'type' => 'text',
                'default_value' => 'Get the latest price',
            ),
            array(
                'key' => 'field_wvn_venue_form_shortcode',
                'label' => 'Contact Form 7 shortcode (optional)',
                'name' => 'venue_form_shortcode',
                'type' => 'text',
                'instructions' => 'Paste a CF7 shortcode to replace the built-in enquiry form.',
            ),
        ),
    ));
}
add_action('acf/init', 'wvn_register_venue_fields');

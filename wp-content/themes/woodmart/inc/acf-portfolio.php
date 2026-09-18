<?php
/**
 * ACF Field Group for Wedding Portfolio Custom Post Type
 */

function wvn_register_portfolio_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_wvn_portfolio_single',
        'title' => 'Wedding Portfolio Details',
        'style' => 'default',
        'position' => 'acf_after_title',
        'description' => 'Configure the hero, story overview, 3-photo event sections, vendor credits, and gallery for this real wedding.',
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'portfolio',
                ),
            ),
        ),
        'fields' => array(
            // --- TAB: Overview & Hero ---
            array(
                'key' => 'field_wvn_port_tab_overview',
                'label' => 'Hero & Overview',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_port_hero_image',
                'label' => 'Hero Banner Image (Optional)',
                'name' => 'portfolio_hero_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Top wide banner image. If left empty, the Featured Image will be used.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_port_subtitle',
                'label' => 'Hero Subtitle / Venue Line',
                'name' => 'portfolio_subtitle',
                'type' => 'text',
                'instructions' => 'e.g. Destination Wedding at Taj Aravali Resort & Spa, Udaipur',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_port_pills',
                'label' => 'Highlight Tags (Meta Pills)',
                'name' => 'portfolio_pills',
                'type' => 'text',
                'instructions' => 'e.g. 3 Days • Udaipur • 400 Guests (separated by bullet • or commas)',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_port_story_heading',
                'label' => 'Story Section Heading',
                'name' => 'portfolio_story_heading',
                'type' => 'text',
                'instructions' => 'e.g. A Royal Affair In The City Of Lakes',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_port_story_intro',
                'label' => 'Story / Intro Text',
                'name' => 'portfolio_story_intro',
                'type' => 'textarea',
                'rows' => 5,
                'instructions' => 'Introductory story about the couple and the vision for their wedding.',
            ),

            // --- TAB: 3-Photo Event Sections (Repeater) ---
            array(
                'key' => 'field_wvn_port_tab_events',
                'label' => 'Wedding Functions / Events (3 Photos + Text)',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_port_events',
                'label' => 'Wedding Events / Functions',
                'name' => 'portfolio_events',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Wedding Event / Function',
                'instructions' => 'Each entry creates a dedicated event block with a 3-photo collage layout and rich story text.',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_port_evt_tag',
                        'label' => 'Event Kicker / Tag',
                        'name' => 'event_tag',
                        'type' => 'text',
                        'instructions' => 'e.g. DAY 1 • MEHENDI & SUNDOWNER',
                        'wrapper' => array('width' => '40'),
                    ),
                    array(
                        'key' => 'field_wvn_port_evt_title',
                        'label' => 'Event Title',
                        'name' => 'event_title',
                        'type' => 'text',
                        'instructions' => 'e.g. Pastel Carnival & Traditional Beats',
                        'wrapper' => array('width' => '60'),
                    ),
                    array(
                        'key' => 'field_wvn_port_evt_desc',
                        'label' => 'Event Story & Description',
                        'name' => 'event_description',
                        'type' => 'textarea',
                        'rows' => 4,
                        'instructions' => 'Narrative detailing the mood, decor, guest experiences, and unforgettable moments.',
                    ),
                    array(
                        'key' => 'field_wvn_port_evt_theme',
                        'label' => 'Highlights / Details Line (Optional)',
                        'name' => 'event_theme',
                        'type' => 'text',
                        'instructions' => 'e.g. Theme: Rajasthani Heritage | Venue: Palace Courtyard',
                    ),
                    array(
                        'key' => 'field_wvn_port_evt_img1',
                        'label' => 'Photo 1 (Large Main Photo)',
                        'name' => 'photo_1',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'instructions' => 'The main portrait / hero photo of this function.',
                        'wrapper' => array('width' => '33.33'),
                    ),
                    array(
                        'key' => 'field_wvn_port_evt_img2',
                        'label' => 'Photo 2 (Top Secondary)',
                        'name' => 'photo_2',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'instructions' => 'Secondary photo (top right).',
                        'wrapper' => array('width' => '33.33'),
                    ),
                    array(
                        'key' => 'field_wvn_port_evt_img3',
                        'label' => 'Photo 3 (Bottom Secondary)',
                        'name' => 'photo_3',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'instructions' => 'Secondary photo (bottom right).',
                        'wrapper' => array('width' => '33.33'),
                    ),
                    array(
                        'key' => 'field_wvn_port_evt_layout',
                        'label' => 'Layout Alignment',
                        'name' => 'layout_alignment',
                        'type' => 'select',
                        'choices' => array(
                            'photo_left' => 'Photos Left, Text Right',
                            'photo_right' => 'Text Left, Photos Right',
                        ),
                        'default_value' => 'photo_left',
                        'wrapper' => array('width' => '50'),
                    ),
                ),
            ),

            // --- TAB: Details & Vendor Credits ---
            array(
                'key' => 'field_wvn_port_tab_credits',
                'label' => 'Wedding Details & Credits',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_port_venue',
                'label' => 'Venue / Location',
                'name' => 'portfolio_venue',
                'type' => 'text',
                'instructions' => 'e.g. Taj Aravali Resort & Spa, Udaipur',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_port_date',
                'label' => 'Wedding Date / Duration',
                'name' => 'portfolio_date',
                'type' => 'text',
                'instructions' => 'e.g. November 2025 • 3 Days',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_port_planner',
                'label' => 'Planner & Concept',
                'name' => 'portfolio_planner',
                'type' => 'text',
                'default_value' => 'Wedding Vows by Nikhil',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_port_decor',
                'label' => 'Décor & Production',
                'name' => 'portfolio_decor',
                'type' => 'text',
                'instructions' => 'e.g. Wedding Vows Design Studio',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_port_photo_vendor',
                'label' => 'Photography & Cinematography',
                'name' => 'portfolio_photography',
                'type' => 'text',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_port_makeup',
                'label' => 'Bridal Makeup & Styling',
                'name' => 'portfolio_makeup',
                'type' => 'text',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_port_custom_credits',
                'label' => 'Additional Credits / Vendors',
                'name' => 'portfolio_custom_credits',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add Credit Item',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_port_cred_label',
                        'label' => 'Role / Category',
                        'name' => 'label',
                        'type' => 'text',
                        'instructions' => 'e.g. Entertainment, Outfits, Catering, DJ',
                    ),
                    array(
                        'key' => 'field_wvn_port_cred_value',
                        'label' => 'Vendor / Artist Name',
                        'name' => 'value',
                        'type' => 'text',
                    ),
                ),
            ),

            // --- TAB: Moments Gallery ---
            array(
                'key' => 'field_wvn_port_tab_gallery',
                'label' => 'Moments Gallery',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_port_gallery_title',
                'label' => 'Gallery Section Heading',
                'name' => 'portfolio_gallery_title',
                'type' => 'text',
                'default_value' => 'Moments From The Celebration',
            ),
            array(
                'key' => 'field_wvn_port_gallery_images',
                'label' => 'Additional Gallery Photos',
                'name' => 'gallery_images',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add Photo',
                'instructions' => 'These photos appear in the Moments mosaic on the wedding page AND in the click-to-open gallery slider on the Portfolio page. Add and reorder images here to control what guests see when they click a wedding card. Featured Image + Hero + Event photos are included automatically.',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_port_gal_img',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                    ),
                    array(
                        'key' => 'field_wvn_port_gal_caption',
                        'label' => 'Caption (Optional)',
                        'name' => 'caption',
                        'type' => 'text',
                    ),
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'wvn_register_portfolio_fields');

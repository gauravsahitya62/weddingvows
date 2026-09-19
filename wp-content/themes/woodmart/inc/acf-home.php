<?php
/**
 * Homepage fields for wp-admin (ACF).
 * Edit Pages → Home to change copy and images.
 */

function wvn_register_home_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $locations = array(
        array(
            array(
                'param' => 'page_type',
                'operator' => '==',
                'value' => 'front_page',
            ),
        ),
    );

    $front_id = (int) get_option('page_on_front');
    if ($front_id) {
        $locations[] = array(
            array(
                'param' => 'page',
                'operator' => '==',
                'value' => (string) $front_id,
            ),
        );
    }

    foreach (array('home', 'Home') as $slug) {
        $page = get_page_by_path(sanitize_title($slug));
        if ($page && (int) $page->ID !== $front_id) {
            $locations[] = array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => (string) $page->ID,
                ),
            );
        }
    }

    // Match pages titled "Home" even if Reading → front page is misconfigured.
    $matched_ids = $front_id ? array($front_id) : array();
    $named_q = new WP_Query(array(
        'post_type'      => 'page',
        'post_status'    => array('publish', 'draft', 'private'),
        'posts_per_page' => 20,
        'orderby'        => 'ID',
        'order'          => 'ASC',
    ));
    while ($named_q->have_posts()) {
        $named_q->the_post();
        $pid = (int) get_the_ID();
        $title = get_the_title();
        $slug = get_post_field('post_name', $pid);
        if ($title === 'Home' || $slug === 'home' || strpos($title, 'Home') === 0) {
            if (!in_array($pid, $matched_ids, true)) {
                $matched_ids[] = $pid;
                $locations[] = array(
                    array(
                        'param' => 'page',
                        'operator' => '==',
                        'value' => (string) $pid,
                    ),
                );
            }
        }
    }
    wp_reset_postdata();

    acf_add_local_field_group(array(
        'key' => 'group_wvn_home',
        'title' => 'Homepage content',
        'style' => 'default',
        'position' => 'acf_after_title',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'description' => 'These fields are the homepage. Edit them to change the live site.',
        'active' => true,
        'show_in_rest' => 0,
        'hide_on_screen' => array('the_content', 'excerpt', 'discussion', 'comments'),
        'location' => $locations,
        'fields' => array(
            array(
                'key' => 'field_wvn_tab_hero',
                'label' => 'Hero',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_hero_media_type',
                'label' => 'Hero media type',
                'name' => 'home_hero_media_type',
                'type' => 'select',
                'choices' => array(
                    'image' => 'Photo',
                    'video' => 'Video',
                ),
                'default_value' => 'image',
                'return_format' => 'value',
                'instructions' => 'Choose whether the homepage hero shows a photo or a looping video.',
            ),
            array(
                'key' => 'field_wvn_hero_image',
                'label' => 'Hero image',
                'name' => 'home_hero_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'instructions' => 'Used when media type is Photo. Also used as the video poster/fallback.',
            ),
            array(
                'key' => 'field_wvn_hero_video',
                'label' => 'Hero video',
                'name' => 'home_hero_video',
                'type' => 'file',
                'return_format' => 'array',
                'library' => 'all',
                'mime_types' => 'mp4,webm,mov',
                'instructions' => 'Upload an MP4/WebM when media type is Video. Keep files under ~15MB for a smooth homepage load.',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_wvn_hero_media_type',
                            'operator' => '==',
                            'value' => 'video',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_wvn_hero_copy',
                'label' => 'Hero line',
                'name' => 'home_hero_copy',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'field_wvn_tab_intro',
                'label' => 'The Art of Celebration',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_art_main_content',
                'label' => 'A. Main Content',
                'name' => '',
                'type' => 'message',
                'message' => '<strong>Main Content</strong><br>Update the copy used by the editorial section. Optional fields can be left empty.',
            ),
            array(
                'key' => 'field_wvn_intro_kicker',
                'label' => 'Eyebrow / section label',
                'name' => 'home_intro_kicker',
                'type' => 'text',
                'default_value' => 'Wedding Vows by Nikhil',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_intro_heading',
                'label' => 'Legacy heading (kept for existing content)',
                'name' => 'home_intro_heading',
                'type' => 'text',
                'default_value' => 'Destination Wedding Planner in Udaipur',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_intro_lead',
                'label' => 'Introductory paragraph',
                'name' => 'home_intro_lead',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_wvn_intro_subheading',
                'label' => 'Supporting heading / subtitle',
                'name' => 'home_intro_subheading',
                'type' => 'text',
                'default_value' => 'Thoughtfully Planned, Beautifully Yours',
            ),
            array(
                'key' => 'field_wvn_intro_text',
                'label' => 'Supporting paragraph (legacy)',
                'name' => 'home_intro_text',
                'type' => 'textarea',
                'rows' => 4,
            ),
            array(
                'key' => 'field_wvn_intro_image',
                'label' => 'Featured image (legacy)',
                'name' => 'home_intro_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Legacy single-image field. Leave empty when using the Art of Celebration collage images below.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_intro_image_alt',
                'label' => 'Featured image alt text (legacy)',
                'name' => 'home_intro_image_alt',
                'type' => 'text',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_intro_cta_text',
                'label' => 'Primary button label',
                'name' => 'home_intro_cta_text',
                'type' => 'text',
                'default_value' => 'Plan your wedding',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_intro_cta_url',
                'label' => 'Primary button URL',
                'name' => 'home_intro_cta_url',
                'type' => 'url',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_founder_group',
                'label' => 'Founder',
                'name' => '',
                'type' => 'message',
                'message' => '<strong>Founder</strong><br>Shown beneath the main copy.',
            ),
            array(
                'key' => 'field_wvn_art_founder',
                'label' => 'Founder name',
                'name' => 'home_intro_founder',
                'type' => 'text',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_founder_role',
                'label' => 'Founder designation',
                'name' => 'home_intro_founder_role',
                'type' => 'text',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_images_group',
                'label' => 'B. Images',
                'name' => '',
                'type' => 'message',
                'message' => '<strong>Images</strong><br>Use the WordPress Media Library selector for each position. Media Library Alt Text is used for accessibility; the main portrait also has an optional override below.',
            ),
            array(
                'key' => 'field_wvn_art_main_image',
                'label' => 'Main portrait / featured image',
                'name' => 'home_intro_image_left',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Large portrait on the left side of the collage.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_secondary_image',
                'label' => 'Secondary image',
                'name' => 'home_intro_image_right_top',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Upper-right image in the collage.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_support_left',
                'label' => 'Supporting collage image — left',
                'name' => 'home_intro_image_left_bot',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Overlapping supporting image below the main portrait.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_support_right',
                'label' => 'Supporting collage image — right',
                'name' => 'home_intro_image_right_bot',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Wide supporting image on the lower-right.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_landscape',
                'label' => 'Decorative landscape image',
                'name' => 'home_intro_landscape',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Background image behind the collage. Leave empty to keep the existing gallery fallback.',
            ),
            array(
                'key' => 'field_wvn_art_alt',
                'label' => 'Main image alt text override',
                'name' => 'home_intro_art_alt',
                'type' => 'text',
                'instructions' => 'Optional accessibility override for the main portrait. Leave empty to use the built-in descriptive fallback.',
            ),
            array(
                'key' => 'field_wvn_art_cta_group',
                'label' => 'C. Calls to Action',
                'name' => '',
                'type' => 'message',
                'message' => '<strong>Calls to Action</strong><br>The primary button uses the existing fields above; the optional secondary button is managed here.',
            ),
            array(
                'key' => 'field_wvn_art_secondary_cta_label',
                'label' => 'Secondary button label',
                'name' => 'home_intro_secondary_cta_text',
                'type' => 'text',
                'instructions' => 'Leave empty to hide the secondary action.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_secondary_cta_url',
                'label' => 'Secondary button URL',
                'name' => 'home_intro_secondary_cta_url',
                'type' => 'url',
                'instructions' => 'Leave empty to hide the secondary action.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_decorative_group',
                'label' => 'D. Decorative Elements',
                'name' => '',
                'type' => 'message',
                'message' => '<strong>Decorative Elements</strong><br>All of these fields are optional. Leave them empty to remove the corresponding visual detail without creating blank space.',
            ),
            array(
                'key' => 'field_wvn_art_note_left',
                'label' => 'Side caption — left',
                'name' => 'home_intro_note_left',
                'type' => 'text',
                'instructions' => 'Optional handwritten-style caption.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_note_right',
                'label' => 'Side caption — right',
                'name' => 'home_intro_note_right',
                'type' => 'text',
                'instructions' => 'Optional side caption.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_note_detail',
                'label' => 'Detail caption',
                'name' => 'home_intro_note_detail',
                'type' => 'text',
                'instructions' => 'Optional detail caption.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_location',
                'label' => 'Location label',
                'name' => 'home_intro_location',
                'type' => 'text',
                'instructions' => 'Optional location mark, e.g. Udaipur / India.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_scroll',
                'label' => 'Scroll label',
                'name' => 'home_intro_scroll',
                'type' => 'text',
                'instructions' => 'Optional bottom cue.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_footer_mark',
                'label' => 'Handwritten / decorative footer text',
                'name' => 'home_intro_footer_mark',
                'type' => 'text',
                'instructions' => 'Optional decorative footer text.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_art_display_group',
                'label' => 'E. Display Settings',
                'name' => '',
                'type' => 'message',
                'message' => '<strong>Display Settings</strong><br>Choose a preset layout and focal point instead of editing CSS.',
            ),
            array(
                'key' => 'field_wvn_art_layout_variant',
                'label' => 'Layout variant',
                'name' => 'home_intro_layout_variant',
                'type' => 'select',
                'choices' => array(
                    'editorial' => 'Editorial collage (current)',
                    'minimal' => 'Editorial collage — minimal decorative notes',
                ),
                'default_value' => 'editorial',
                'return_format' => 'value',
            ),
            array(
                'key' => 'field_wvn_art_image_position',
                'label' => 'Main image focal position',
                'name' => 'home_intro_image_position',
                'type' => 'select',
                'choices' => array(
                    'center' => 'Center',
                    'top' => 'Top',
                    'center 35%' => 'Upper centre',
                    'bottom' => 'Bottom',
                ),
                'default_value' => 'center',
                'return_format' => 'value',
                'instructions' => 'Simple editor-friendly object-position control for the main portrait.',
            ),
            array(
                'key' => 'field_wvn_art_legacy_notice',
                'label' => 'Legacy fields',
                'name' => '',
                'type' => 'message',
                'message' => 'Existing Intro content fields remain below for compatibility. Do not delete them; the live layout uses the structured fields above.',
            ),
            array(
                'key' => 'field_wvn_intro_content',
                'label' => 'Intro content (legacy)',
                'name' => 'home_intro_content',
                'type' => 'wysiwyg',
                'instructions' => 'Legacy field — the homepage now uses the structured Intro fields above. Leave empty.',
                'tabs' => 'all',
                'toolbar' => 'basic',
                'media_upload' => 0,
                'delay' => 0,
            ),
            array(
                'key' => 'field_wvn_tab_collective',
                'label' => 'Collective',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_collective_kicker',
                'label' => 'Kicker',
                'name' => 'home_collective_kicker',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_collective_heading',
                'label' => 'Heading',
                'name' => 'home_collective_heading',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_collective_note',
                'label' => 'Note',
                'name' => 'home_collective_note',
                'type' => 'message',
                'message' => 'Wedding cards come from <strong>Portfolio</strong> posts (title, excerpt as venue, featured image). Add or edit them under <strong>Portfolio</strong> in the left sidebar (heart icon).',
            ),
            array(
                'key' => 'field_wvn_tab_planner',
                'label' => 'Planner',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_planner_image',
                'label' => 'Photo',
                'name' => 'home_planner_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_wvn_planner_heading',
                'label' => 'Heading',
                'name' => 'home_planner_heading',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_planner_kicker',
                'label' => 'Kicker',
                'name' => 'home_planner_kicker',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_planner_text',
                'label' => 'Copy',
                'name' => 'home_planner_text',
                'type' => 'textarea',
                'rows' => 5,
            ),
            array(
                'key' => 'field_wvn_planner_sign',
                'label' => 'Signature line',
                'name' => 'home_planner_sign',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_planner_link_text',
                'label' => 'Link text',
                'name' => 'home_planner_link_text',
                'type' => 'text',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_planner_link_url',
                'label' => 'Link URL',
                'name' => 'home_planner_link_url',
                'type' => 'url',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_tab_achieve',
                'label' => 'Testimonials Book',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_achieve_heading',
                'label' => 'Section Heading',
                'name' => 'home_achieve_heading',
                'type' => 'text',
                'instructions' => 'e.g. In Their Words',
            ),
            array(
                'key' => 'field_wvn_achieve_lede',
                'label' => 'Section Subheading / Intro text',
                'name' => 'home_achieve_lede',
                'type' => 'textarea',
                'rows' => 3,
                'instructions' => 'Short intro above the testimonials book.',
            ),
            array(
                'key' => 'field_wvn_press_cover',
                'label' => 'Book cover image',
                'name' => 'home_press_cover',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Wedding / couple photo for the book cover. Leave empty to use a gallery image.',
            ),
            array(
                'key' => 'field_wvn_press_cover_title',
                'label' => 'Cover title',
                'name' => 'home_press_cover_title',
                'type' => 'text',
                'instructions' => 'e.g. Testimonials',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_press_cover_note',
                'label' => 'Cover note / button text',
                'name' => 'home_press_cover_note',
                'type' => 'text',
                'instructions' => 'e.g. TAP TO OPEN',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_press_pages',
                'label' => 'Book pages (inside leaves)',
                'name' => 'home_press_pages',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add page',
                'instructions' => 'Pages displayed when the user opens and flips through the 3D book.',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_press_brand',
                        'label' => 'Brand / Tag',
                        'name' => 'brand',
                        'type' => 'text',
                        'wrapper' => array('width' => '30'),
                    ),
                    array(
                        'key' => 'field_wvn_press_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'wrapper' => array('width' => '70'),
                    ),
                    array(
                        'key' => 'field_wvn_press_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                    ),
                    array(
                        'key' => 'field_wvn_press_text',
                        'label' => 'Text',
                        'name' => 'text',
                        'type' => 'textarea',
                        'rows' => 4,
                    ),
                ),
            ),
            array(
                'key' => 'field_wvn_press_end_brand',
                'label' => 'Last page brand / tagline',
                'name' => 'home_press_end_brand',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_press_end_title',
                'label' => 'Last page title',
                'name' => 'home_press_end_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_press_end_text',
                'label' => 'Last page text',
                'name' => 'home_press_end_text',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_wvn_press_logos',
                'label' => 'Bottom text strip / logos',
                'name' => 'home_press_logos',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add item',
                'instructions' => 'Words or brands listed beneath the book (e.g. THE TEAM BEHIND THE MAGIC, WedMeGood, etc.).',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_press_logo_label',
                        'label' => 'Text / Name',
                        'name' => 'label',
                        'type' => 'text',
                    ),
                ),
            ),
            array(
                'key' => 'field_wvn_tab_services',
                'label' => 'Services',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_services_kicker',
                'label' => 'Kicker',
                'name' => 'home_services_kicker',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_services_heading',
                'label' => 'Heading',
                'name' => 'home_services_heading',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_services_lede',
                'label' => 'Intro text',
                'name' => 'home_services_lede',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_wvn_services',
                'label' => 'Service cards',
                'name' => 'home_services',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add service',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_service_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_wvn_service_text',
                        'label' => 'Text',
                        'name' => 'text',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                    array(
                        'key' => 'field_wvn_service_image',
                        'label' => 'Card image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'wrapper' => array('width' => '50'),
                    ),
                    array(
                        'key' => 'field_wvn_service_bg',
                        'label' => 'Background image',
                        'name' => 'bg',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'wrapper' => array('width' => '50'),
                    ),
                ),
            ),
            array(
                'key' => 'field_wvn_tab_showreel',
                'label' => 'Showreel',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_showreel_image',
                'label' => 'Cover image',
                'name' => 'home_showreel_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_wvn_showreel_caption',
                'label' => 'Caption',
                'name' => 'home_showreel_caption',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_showreel_video',
                'label' => 'Video file',
                'name' => 'home_showreel_video',
                'type' => 'file',
                'return_format' => 'array',
                'mime_types' => 'mp4,webm,mov',
            ),
            array(
                'key' => 'field_wvn_showreel_button_text',
                'label' => 'Button Text',
                'name' => 'home_showreel_button_text',
                'type' => 'text',
                'instructions' => 'Text on the button (e.g. "See more").',
                'default_value' => 'See more',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_showreel_button_url',
                'label' => 'Button URL (YouTube page / link)',
                'name' => 'home_showreel_button_url',
                'type' => 'url',
                'instructions' => 'YouTube video or channel URL. Leaving this empty will hide the button.',
                'placeholder' => 'https://www.youtube.com/...',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_tab_cinematic',
                'label' => 'Cinematic',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_cin_note',
                'label' => 'Cinematic homepage scroll',
                'name' => '',
                'type' => 'message',
                'message' => 'Controls the Story mosaic → VOWS reveal → Testimonials coverflow. For Story and VOWS backgrounds, choose Video or Photo, then upload the matching media. Leave empty fields to keep built-in fallbacks.',
            ),
            array(
                'key' => 'field_wvn_cin_story_media',
                'label' => 'Story background type',
                'name' => 'home_cin_story_media',
                'type' => 'button_group',
                'choices' => array(
                    'video' => 'Video',
                    'photo' => 'Photo',
                ),
                'default_value' => 'video',
                'return_format' => 'value',
                'layout' => 'horizontal',
            ),
            array(
                'key' => 'field_wvn_cin_story_film',
                'label' => 'Story video',
                'name' => 'home_cin_story_film',
                'type' => 'file',
                'return_format' => 'array',
                'mime_types' => 'mp4,webm,mov',
                'instructions' => 'Background video under the mosaic. Prefer landscape 16:9.',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_wvn_cin_story_media',
                            'operator' => '==',
                            'value' => 'video',
                        ),
                    ),
                ),
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_cin_story_poster',
                'label' => 'Story photo / video poster',
                'name' => 'home_cin_story_poster',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Used as the full background when type is Photo, or as the video poster when type is Video.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_cin_mosaic',
                'label' => 'Mosaic tiles (6 images)',
                'name' => 'home_cin_mosaic',
                'type' => 'gallery',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'min' => 0,
                'max' => 6,
                'instructions' => 'Upload up to 6 images. First 3 = top row, last 3 = bottom row.',
            ),
            array(
                'key' => 'field_wvn_cin_start_eyebrow',
                'label' => 'Story card eyebrow',
                'name' => 'home_cin_start_eyebrow',
                'type' => 'text',
                'default_value' => '▷ The Story We Create',
            ),
            array(
                'key' => 'field_wvn_cin_start_heading',
                'label' => 'Story card heading',
                'name' => 'home_cin_start_heading',
                'type' => 'text',
                'default_value' => 'It begins with',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_cin_start_heading_em',
                'label' => 'Story card heading (italic)',
                'name' => 'home_cin_start_heading_em',
                'type' => 'text',
                'default_value' => 'a vision,',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_cin_start_sub',
                'label' => 'Story card subtitle',
                'name' => 'home_cin_start_sub',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'a feeling, a dream waiting to be brought to life.',
            ),
            array(
                'key' => 'field_wvn_cin_vows_media',
                'label' => 'VOWS background type',
                'name' => 'home_cin_vows_media',
                'type' => 'button_group',
                'choices' => array(
                    'video' => 'Video',
                    'photo' => 'Photo',
                ),
                'default_value' => 'video',
                'return_format' => 'value',
                'layout' => 'horizontal',
            ),
            array(
                'key' => 'field_wvn_cin_vows_film',
                'label' => 'VOWS video',
                'name' => 'home_cin_vows_film',
                'type' => 'file',
                'return_format' => 'array',
                'mime_types' => 'mp4,webm,mov',
                'instructions' => 'Film shown through the VOWS cutout. Use a landscape clip.',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_wvn_cin_vows_media',
                            'operator' => '==',
                            'value' => 'video',
                        ),
                    ),
                ),
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_cin_vows_poster',
                'label' => 'VOWS photo / video poster',
                'name' => 'home_cin_vows_poster',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Used as the full background when type is Photo, or as the video poster when type is Video.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_cin_vows_word',
                'label' => 'VOWS cutout word',
                'name' => 'home_cin_vows_word',
                'type' => 'text',
                'default_value' => 'Vows',
                'wrapper' => array('width' => '33'),
            ),
            array(
                'key' => 'field_wvn_cin_vows_eyebrow',
                'label' => 'VOWS panel eyebrow',
                'name' => 'home_cin_vows_eyebrow',
                'type' => 'text',
                'default_value' => 'The Vows Standard',
                'wrapper' => array('width' => '33'),
            ),
            array(
                'key' => 'field_wvn_cin_vows_cta',
                'label' => 'VOWS button text',
                'name' => 'home_cin_vows_cta',
                'type' => 'text',
                'default_value' => 'Book a Consultation',
                'wrapper' => array('width' => '34'),
            ),
            array(
                'key' => 'field_wvn_cin_vows_headline',
                'label' => 'VOWS headline (line 1)',
                'name' => 'home_cin_vows_headline',
                'type' => 'text',
                'default_value' => 'Every Vow. Every Detail.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_cin_vows_headline_em',
                'label' => 'VOWS headline (accent line)',
                'name' => 'home_cin_vows_headline_em',
                'type' => 'text',
                'default_value' => 'Beautifully Kept.',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_cin_vows_cta_url',
                'label' => 'VOWS button URL',
                'name' => 'home_cin_vows_cta_url',
                'type' => 'url',
                'instructions' => 'Defaults to the CTA button URL if empty.',
            ),
            array(
                'key' => 'field_wvn_cin_cites_eyebrow',
                'label' => 'Testimonials eyebrow',
                'name' => 'home_cin_cites_eyebrow',
                'type' => 'text',
                'default_value' => 'In Their Words',
                'wrapper' => array('width' => '33'),
            ),
            array(
                'key' => 'field_wvn_cin_cites_heading',
                'label' => 'Testimonials heading',
                'name' => 'home_cin_cites_heading',
                'type' => 'text',
                'default_value' => 'Stories whispered',
                'wrapper' => array('width' => '33'),
            ),
            array(
                'key' => 'field_wvn_cin_cites_heading_em',
                'label' => 'Testimonials heading (italic)',
                'name' => 'home_cin_cites_heading_em',
                'type' => 'text',
                'default_value' => 'after the last dance.',
                'wrapper' => array('width' => '34'),
            ),
            array(
                'key' => 'field_wvn_cin_cites_kicker',
                'label' => 'Card kicker',
                'name' => 'home_cin_cites_kicker',
                'type' => 'text',
                'default_value' => 'Couple story',
                'instructions' => 'Small label above each testimonial quote.',
            ),
            array(
                'key' => 'field_wvn_tab_quotes',
                'label' => 'Testimonials',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_quotes_kicker',
                'label' => 'Kicker',
                'name' => 'home_quotes_kicker',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_quotes_heading',
                'label' => 'Heading',
                'name' => 'home_quotes_heading',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_quotes_lede',
                'label' => 'Intro text',
                'name' => 'home_quotes_lede',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'field_wvn_quotes',
                'label' => 'Reviews',
                'name' => 'home_quotes',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add review',
                'instructions' => 'Used by the cinematic testimonials coverflow. Choose Photo or Video per review, then upload the matching media.',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_quote_name',
                        'label' => 'Name',
                        'name' => 'name',
                        'type' => 'text',
                        'wrapper' => array('width' => '40'),
                    ),
                    array(
                        'key' => 'field_wvn_quote_time',
                        'label' => 'Time / venue',
                        'name' => 'time',
                        'type' => 'text',
                        'wrapper' => array('width' => '30'),
                    ),
                    array(
                        'key' => 'field_wvn_quote_dark',
                        'label' => 'Dark card',
                        'name' => 'dark',
                        'type' => 'true_false',
                        'ui' => 1,
                        'wrapper' => array('width' => '30'),
                    ),
                    array(
                        'key' => 'field_wvn_quote_text',
                        'label' => 'Quote',
                        'name' => 'text',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                    array(
                        'key' => 'field_wvn_quote_media',
                        'label' => 'Card media type',
                        'name' => 'media',
                        'type' => 'button_group',
                        'choices' => array(
                            'photo' => 'Photo',
                            'video' => 'Video',
                        ),
                        'default_value' => 'photo',
                        'return_format' => 'value',
                        'layout' => 'horizontal',
                    ),
                    array(
                        'key' => 'field_wvn_quote_image',
                        'label' => 'Card photo / video poster',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'instructions' => 'Shown when type is Photo, or used as poster when type is Video.',
                        'wrapper' => array('width' => '50'),
                    ),
                    array(
                        'key' => 'field_wvn_quote_video',
                        'label' => 'Card video',
                        'name' => 'video',
                        'type' => 'file',
                        'return_format' => 'array',
                        'mime_types' => 'mp4,webm,mov',
                        'instructions' => 'Shown as a looping muted video when type is Video.',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_wvn_quote_media',
                                    'operator' => '==',
                                    'value' => 'video',
                                ),
                            ),
                        ),
                        'wrapper' => array('width' => '50'),
                    ),
                    array(
                        'key' => 'field_wvn_quote_tags',
                        'label' => 'Tags',
                        'name' => 'tags',
                        'type' => 'text',
                        'instructions' => 'Comma-separated, e.g. On Time Service, Quality of Work',
                    ),
                ),
            ),
            array(
                'key' => 'field_wvn_tab_cta',
                'label' => 'CTA',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_cta_heading',
                'label' => 'Heading',
                'name' => 'home_cta_heading',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_cta_text',
                'label' => 'Text',
                'name' => 'home_cta_text',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_wvn_cta_button',
                'label' => 'Button text',
                'name' => 'home_cta_button',
                'type' => 'text',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_cta_url',
                'label' => 'Button URL',
                'name' => 'home_cta_url',
                'type' => 'url',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_tab_stories',
                'label' => 'Stories',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_stories_kicker',
                'label' => 'Kicker',
                'name' => 'home_stories_kicker',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_stories_heading',
                'label' => 'Heading',
                'name' => 'home_stories_heading',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_stories',
                'label' => 'Story tiles',
                'name' => 'home_stories',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add story',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_story_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_wvn_story_caption',
                        'label' => 'Caption',
                        'name' => 'caption',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_wvn_story_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                    ),
                    array(
                        'key' => 'field_wvn_story_video',
                        'label' => 'Video',
                        'name' => 'video',
                        'type' => 'file',
                        'return_format' => 'array',
                        'mime_types' => 'mp4,webm,mov',
                    ),
                ),
            ),
            array(
                'key' => 'field_wvn_tab_gallery',
                'label' => 'Gallery',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_gallery_kicker',
                'label' => 'Kicker',
                'name' => 'home_gallery_kicker',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_gallery_heading',
                'label' => 'Heading',
                'name' => 'home_gallery_heading',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_gallery_lede',
                'label' => 'Intro text',
                'name' => 'home_gallery_lede',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'field_wvn_gallery',
                'label' => 'Images',
                'name' => 'home_gallery',
                'type' => 'gallery',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'insert' => 'append',
            ),
            array(
                'key' => 'field_wvn_tab_faq',
                'label' => 'FAQs',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_faq_kicker',
                'label' => 'Kicker',
                'name' => 'home_faq_kicker',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_faq_heading',
                'label' => 'Heading',
                'name' => 'home_faq_heading',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_faq_lede',
                'label' => 'Intro text',
                'name' => 'home_faq_lede',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'field_wvn_faqs',
                'label' => 'Questions',
                'name' => 'home_faqs',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add question',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_faq_q',
                        'label' => 'Question',
                        'name' => 'q',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_wvn_faq_a',
                        'label' => 'Answer',
                        'name' => 'a',
                        'type' => 'textarea',
                        'rows' => 3,
                    ),
                ),
            ),
            // --- TAB: Footer ---
            array(
                'key' => 'field_wvn_tab_footer',
                'label' => 'Footer',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_footer_tagline',
                'label' => 'Brand description / tagline',
                'name' => 'home_footer_tagline',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Destination wedding planner in Udaipur — palace, lakeside and heritage celebrations across Rajasthan and India.',
            ),
            array(
                'key' => 'field_wvn_footer_explore_title',
                'label' => 'Explore Column Title',
                'name' => 'home_footer_explore_title',
                'type' => 'text',
                'default_value' => 'Explore',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_footer_services_title',
                'label' => 'Services Column Title',
                'name' => 'home_footer_services_title',
                'type' => 'text',
                'default_value' => 'Services',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_footer_explore_links',
                'label' => 'Explore Column Links',
                'name' => 'home_footer_explore_links',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add Explore Link',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_footer_exp_label',
                        'label' => 'Link Label',
                        'name' => 'label',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_wvn_footer_exp_url',
                        'label' => 'URL',
                        'name' => 'url',
                        'type' => 'text',
                    ),
                ),
            ),
            array(
                'key' => 'field_wvn_footer_services_links',
                'label' => 'Services Column Links',
                'name' => 'home_footer_services_links',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add Service Link',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_footer_svc_label',
                        'label' => 'Link Label',
                        'name' => 'label',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_wvn_footer_svc_url',
                        'label' => 'URL',
                        'name' => 'url',
                        'type' => 'text',
                    ),
                ),
            ),
            array(
                'key' => 'field_wvn_footer_address',
                'label' => 'Footer Address / Legal line',
                'name' => 'home_footer_address',
                'type' => 'text',
                'default_value' => '53, Sun city, Delhite, Behind Celebration Mall, Bhuwana, Udaipur, Rajasthan 313001',
            ),
        ),
    ));
}
add_action('acf/init', 'wvn_register_home_fields');

function wvn_seed_home_page() {
    if (!function_exists('update_field') || get_option('_wvn_home_seeded_v1')) {
        return;
    }
    $id = (int) get_option('page_on_front');
    if (!$id) {
        $page = get_page_by_path('home');
        $id = $page ? (int) $page->ID : 0;
    }
    if (!$id) {
        return;
    }
    $texts = array(
        'home_hero_copy'            => 'We work behind the scenes, because your wedding deserves to be planned beautifully.',
        'home_intro_content'        => '',
        'home_intro_kicker'         => 'Wedding Vows by Nikhil',
        'home_intro_heading'        => 'Destination Wedding Planner in Udaipur',
        'home_intro_lead'           => 'Wedding Vows by Nikhil plans destination weddings in Udaipur — palace courtyards, lakeside ceremonies, and multi-day celebrations shaped around your family, rituals, and guest journey.',
        'home_intro_subheading'     => 'Thoughtfully Planned, Beautifully Yours',
        'home_intro_text'           => 'From venue sourcing and wedding design to décor, guest hospitality, and on-ground coordination, one studio stays with you from the first site walk to the last farewell — so every celebration feels bespoke, calm, and wholly yours.',
        'home_intro_cta_text'       => 'Plan your wedding',
        'home_intro_cta_url'        => home_url('/contact-us/'),
        'home_intro_image_alt'      => 'Udaipur destination wedding celebration planned by Wedding Vows by Nikhil',
        'home_collective_kicker'    => 'WVN Wedding Collective',
        'home_collective_heading'   => 'Before we tell you our story, let our weddings speak for us.',
        'home_planner_heading'      => 'Meet the planner',
        'home_planner_kicker'       => 'Weddings aren’t planned by companies, they’re planned by people.',
        'home_planner_text'         => 'Nikhil Salvi leads Wedding Vows by Nikhil and personally oversees every celebration we create. From the first conversation to the last farewell, one team stays with you — designing, coordinating, and executing on the ground in Udaipur and beyond.',
        'home_planner_sign'         => 'Nikhil Salvi — Founder',
        'home_planner_link_text'    => 'Book a consultation ↗',
        'home_planner_link_url'     => home_url('/contact-us/'),
        'home_achieve_heading'      => 'In Their Words',
        'home_achieve_lede'         => 'Real stories from the couples and families we’ve celebrated with — open the book to read more.',
        'home_press_cover_title'    => 'Testimonials',
        'home_press_cover_note'     => 'Tap to open',
        'home_press_end_brand'      => 'Wedding Vows by Nikhil',
        'home_press_end_title'      => 'Your celebration, in their words',
        'home_press_end_text'       => 'These are the moments families remember — the calm before pheras, the guests who felt looked after, and the details that made the day feel entirely theirs.',
        'home_services_kicker'      => 'What we do',
        'home_services_heading'     => 'End-to-end, one team',
        'home_services_lede'        => 'We offer complete destination wedding planning, so you only ever deal with one team — from the first venue visit to the final farewell.',
        'home_showreel_caption'     => 'The Real Story Behind a Dream Wedding',
        'home_showreel_button_text' => 'See more',
        'home_showreel_button_url'  => 'https://www.youtube.com/@weddingvowsbynikhil',
        'home_quotes_kicker'        => 'Testimonials',
        'home_quotes_heading'       => 'See what our couples say',
        'home_quotes_lede'          => 'Real stories from the families we’ve had the honour to celebrate with.',
        'home_cta_heading'          => 'Let’s plan your wedding with confidence',
        'home_cta_text'             => 'Connect with our expert wedding planner to discuss your ideas, timelines, and requirements. Let us handle the planning, while you enjoy the celebration.',
        'home_cta_button'           => 'Book a Consultation ↗',
        'home_cta_url'              => home_url('/contact-us/'),
        'home_stories_kicker'       => 'Couple stories',
        'home_stories_heading'      => 'Hear it straight from our couples',
        'home_gallery_kicker'       => 'Gallery',
        'home_gallery_heading'      => 'Moments, captured beyond time',
        'home_gallery_lede'         => 'A glimpse into the celebrations we have quietly orchestrated—from first looks to the last dance.',
        'home_faq_kicker'           => 'FAQs',
        'home_faq_heading'          => 'Questions, answered in advance',
        'home_faq_lede'             => 'Let your wedding planner answer the things couples ask us most — before you even have to ask.',
        'home_cin_start_eyebrow'    => '▷ The Story We Create',
        'home_cin_start_heading'    => 'It begins with',
        'home_cin_start_heading_em' => 'a vision,',
        'home_cin_start_sub'        => 'a feeling, a dream waiting to be brought to life.',
        'home_cin_vows_word'        => 'Vows',
        'home_cin_vows_eyebrow'     => 'The Vows Standard',
        'home_cin_vows_headline'    => 'Every Vow. Every Detail.',
        'home_cin_vows_headline_em' => 'Beautifully Kept.',
        'home_cin_vows_cta'         => 'Book a Consultation',
        'home_cin_cites_eyebrow'    => 'Venues we love',
        'home_cin_cites_heading'    => 'Palaces, lakes',
        'home_cin_cites_heading_em' => '& lawns for your day.',
        'home_cin_cites_kicker'     => 'Venue',
        'home_cin_story_media'      => 'video',
        'home_cin_vows_media'       => 'video',
    );
    foreach ($texts as $name => $value) {
        $current = get_field($name, $id);
        if ($current === null || $current === false || $current === '') {
            update_field($name, $value, $id);
        }
    }
    if (!wvn_home_rows('home_faqs')) {
        update_field('home_faqs', wvn_faqs(), $id);
    }
    if (!wvn_home_rows('home_quotes')) {
        $quotes = wvn_testimonials();
        foreach ($quotes as &$quote) {
            $quote['tags'] = implode(', ', $quote['tags']);
            $quote['dark'] = !empty($quote['dark']) ? 1 : 0;
        }
        unset($quote);
        update_field('home_quotes', $quotes, $id);
    }
    if (!wvn_home_rows('home_services')) {
        $services = wvn_services();
        foreach ($services as &$service) {
            $service['image'] = attachment_url_to_postid($service['image']) ?: '';
            $service['bg'] = attachment_url_to_postid($service['bg']) ?: '';
        }
        unset($service);
        update_field('home_services', $services, $id);
    }
    if (!wvn_home_rows('home_press_logos')) {
        $logos = array();
        foreach (wvn_press_logos() as $label) {
            $logos[] = array('label' => $label);
        }
        update_field('home_press_logos', $logos, $id);
    }
    update_option('_wvn_home_seeded_v1', '1');
}
add_action('acf/init', 'wvn_seed_home_page', 40);

/** Fill empty cinematic text fields on existing homes (runs once). */
function wvn_seed_cinematic_home_fields() {
    if (!function_exists('update_field') || get_option('_wvn_home_seeded_cin_v1')) {
        return;
    }
    $id = (int) get_option('page_on_front');
    if (!$id) {
        $page = get_page_by_path('home');
        $id = $page ? (int) $page->ID : 0;
    }
    if (!$id) {
        return;
    }
    $texts = array(
        'home_cin_start_eyebrow'    => '▷ The Story We Create',
        'home_cin_start_heading'    => 'It begins with',
        'home_cin_start_heading_em' => 'a vision,',
        'home_cin_start_sub'        => 'a feeling, a dream waiting to be brought to life.',
        'home_cin_vows_word'        => 'Vows',
        'home_cin_vows_eyebrow'     => 'The Vows Standard',
        'home_cin_vows_headline'    => 'Every Vow. Every Detail.',
        'home_cin_vows_headline_em' => 'Beautifully Kept.',
        'home_cin_vows_cta'         => 'Book a Consultation',
        'home_cin_cites_eyebrow'    => 'Venues we love',
        'home_cin_cites_heading'    => 'Palaces, lakes',
        'home_cin_cites_heading_em' => '& lawns for your day.',
        'home_cin_cites_kicker'     => 'Venue',
        'home_cin_story_media'      => 'video',
        'home_cin_vows_media'       => 'video',
    );
    foreach ($texts as $name => $value) {
        $current = get_field($name, $id);
        if ($current === null || $current === false || $current === '') {
            update_field($name, $value, $id);
        }
    }
    update_option('_wvn_home_seeded_cin_v1', '1');
}
add_action('acf/init', 'wvn_seed_cinematic_home_fields', 45);

/**
 * Retheme Achievements / Nikhil story book into a testimonials pressbook (once).
 */
function wvn_seed_testimonials_book_v1() {
    if (!function_exists('update_field') || get_option('_wvn_testimonials_book_v1') === '1') {
        return;
    }
    $id = (int) get_option('page_on_front');
    if (!$id) {
        $page = get_page_by_path('home');
        $id = $page ? (int) $page->ID : 0;
    }
    if (!$id) {
        return;
    }

    $legacy = array(
        'home_achieve_heading'   => array('Achievements', 'THE PEOPLE BEHIND YOUR CELEBRATION', 'The People Behind Your Celebration'),
        'home_achieve_lede'      => array(
            'We offer complete destination wedding planning, so you only ever deal with one team — from the first venue visit to the final farewell.',
            'BEHIND EVERY CELEBRATION IS A DEDICATED TEAM BRINGING EVERY DETAIL TO LIFE - WITH CARE, CREATIVITY, AND SEAMLESS EXECUTION.',
        ),
        'home_press_cover_title' => array('Featured in', 'WVN - STORY', 'WVN — STORY', 'WVN-STORY'),
        'home_press_end_title'   => array('The story continues in person'),
        'home_press_end_text'    => array(
            'Press coverage is only a glimpse. The work is in the rooms, the timing, and the people who stay with you until the last farewell.',
        ),
    );
    $next = array(
        'home_achieve_heading'   => 'In Their Words',
        'home_achieve_lede'      => 'Real stories from the couples and families we’ve celebrated with — open the book to read more.',
        'home_press_cover_title' => 'Testimonials',
        'home_press_cover_note'  => 'Tap to open',
        'home_press_end_brand'   => 'Wedding Vows by Nikhil',
        'home_press_end_title'   => 'Your celebration, in their words',
        'home_press_end_text'    => 'These are the moments families remember — the calm before pheras, the guests who felt looked after, and the details that made the day feel entirely theirs.',
    );

    foreach ($next as $name => $value) {
        $current = get_field($name, $id);
        $current_s = is_string($current) ? trim($current) : '';
        $is_empty = ($current === null || $current === false || $current_s === '');
        $is_legacy = isset($legacy[$name]) && in_array($current_s, $legacy[$name], true);
        if ($is_empty || $is_legacy) {
            update_field($name, $value, $id);
        }
    }

    // Drop founder cover so the book uses wedding imagery.
    $cover = get_field('home_press_cover', $id);
    $cover_url = '';
    if (is_array($cover) && !empty($cover['url'])) {
        $cover_url = $cover['url'];
    } elseif (is_numeric($cover)) {
        $cover_url = (string) wp_get_attachment_url((int) $cover);
    } elseif (is_string($cover)) {
        $cover_url = $cover;
    }
    $founder = function_exists('wvn_founder_image') ? wvn_founder_image() : '';
    if ($founder && $cover_url && untrailingslashit($cover_url) === untrailingslashit($founder)) {
        update_field('home_press_cover', '', $id);
    }

    update_option('_wvn_testimonials_book_v1', '1');
}
add_action('acf/init', 'wvn_seed_testimonials_book_v1', 46);

/**
 * Ivory editorial intro upgrade (collage layout).
 */
function wvn_seed_editorial_intro_v2() {
    if (!function_exists('update_field') || get_option('_wvn_intro_editorial_v2') === '1') {
        return;
    }
    $id = (int) get_option('page_on_front');
    if (!$id) {
        $page = get_page_by_path('home');
        $id = $page ? (int) $page->ID : 0;
    }
    if (!$id) {
        return;
    }

    $fields = array(
        'home_intro_content'       => '',
        'home_intro_kicker'        => 'The Art of Celebration',
        'home_intro_heading'       => 'Wedding Planner in Udaipur for Celebrations Beyond the Ordinary',
        'home_intro_heading_accent'=> 'Beyond the Ordinary',
        'home_intro_lead'          => 'Wedding Vows by Nikhil creates thoughtfully planned destination weddings in Udaipur, bringing together beautiful settings, meaningful traditions, and carefully considered details. From palace celebrations to intimate gatherings, every wedding is shaped around your story.',
        'home_intro_cta_text'      => 'Plan your celebration',
        'home_intro_cta_url'       => home_url('/contact-us/'),
        'home_intro_story_text'    => 'Our story',
        'home_intro_story_url'     => home_url('/portfolio/'),
        'home_intro_founder'       => 'Nikhil Salvi',
        'home_intro_founder_role'  => 'Founder & Creative Director',
    );
    foreach ($fields as $name => $value) {
        update_field($name, $value, $id);
    }
    update_option('_wvn_intro_editorial_v2', '1', false);
}
add_action('acf/init', 'wvn_seed_editorial_intro_v2', 56);

/**
 * Luxury editorial hero copy refresh (once).
 */
function wvn_seed_editorial_intro_v3() {
    if (!function_exists('update_field') || get_option('_wvn_intro_editorial_v3') === '1') {
        return;
    }
    $id = (int) get_option('page_on_front');
    if (!$id) {
        $page = get_page_by_path('home');
        $id = $page ? (int) $page->ID : 0;
    }
    if (!$id) {
        return;
    }

    $fields = array(
        'home_intro_kicker'         => 'The Art of Celebration',
        'home_intro_title_line'     => 'Wedding Planner',
        'home_intro_title_em'       => 'in',
        'home_intro_title_place'    => 'Udaipur',
        'home_intro_subheading'     => 'Celebrations Beyond the Ordinary',
        'home_intro_lead'           => 'At Wedding Vows by Nikhil, we create thoughtfully planned destination weddings in Udaipur, where royal heritage, breathtaking backdrops, and meaningful details come together to craft experiences that feel uniquely yours.',
        'home_intro_cta_text'       => 'Plan your celebration',
        'home_intro_story_text'     => 'Our story',
        'home_intro_founder'        => 'Nikhil Salvi',
        'home_intro_founder_role'   => 'Founder & Creative Director',
        'home_intro_index'         => '01',
        'home_intro_index_meta'     => 'People / Places / Precious Moments',
        'home_intro_note_left'      => 'A celebration shaped by place',
        'home_intro_note_right'     => 'Extraordinary Celebrations in Extraordinary Places',
        'home_intro_note_detail'    => 'Beautiful Details / Meaningful Memories',
        'home_intro_location'       => 'Udaipur / India',
        'home_intro_scroll'         => 'Scroll to discover',
        'home_intro_footer_mark'    => 'Love lives here',
    );
    foreach ($fields as $name => $value) {
        update_field($name, $value, $id);
    }
    update_option('_wvn_intro_editorial_v3', '1', false);
}
add_action('acf/init', 'wvn_seed_editorial_intro_v3', 57);

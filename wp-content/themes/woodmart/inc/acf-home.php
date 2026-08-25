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
                'key' => 'field_wvn_hero_image',
                'label' => 'Hero image',
                'name' => 'home_hero_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
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
                'label' => 'Intro',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_intro_content',
                'label' => 'Intro content',
                'name' => 'home_intro_content',
                'type' => 'wysiwyg',
                'instructions' => 'Use Paragraph for the kicker line, Heading 1 for the main title, and Paragraph for body copy. Switch to Text for HTML.',
                'tabs' => 'all',
                'toolbar' => 'full',
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
                'label' => 'Achievements',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_wvn_achieve_heading',
                'label' => 'Heading',
                'name' => 'home_achieve_heading',
                'type' => 'text',
            ),
            array(
                'key' => 'field_wvn_achieve_lede',
                'label' => 'Intro text',
                'name' => 'home_achieve_lede',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_wvn_press_cover',
                'label' => 'Book cover image',
                'name' => 'home_press_cover',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_wvn_press_cover_title',
                'label' => 'Cover title',
                'name' => 'home_press_cover_title',
                'type' => 'text',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_press_cover_note',
                'label' => 'Cover note',
                'name' => 'home_press_cover_note',
                'type' => 'text',
                'wrapper' => array('width' => '50'),
            ),
            array(
                'key' => 'field_wvn_press_pages',
                'label' => 'Book pages',
                'name' => 'home_press_pages',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add page',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_press_brand',
                        'label' => 'Brand',
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
                'label' => 'Last page brand',
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
                'label' => 'Logo names',
                'name' => 'home_press_logos',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add name',
                'sub_fields' => array(
                    array(
                        'key' => 'field_wvn_press_logo_label',
                        'label' => 'Name',
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
                        'label' => 'Time',
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
        'home_intro_content'        => '<p>Your destination wedding planner in India</p><h1>For couples and families who want their wedding to be extraordinary. We plan weddings that are completely stress-free and design wedding spaces that speak your language — minimal or maximal, it’s yours.</h1><p>Wedding Vows by Nikhil is a young, creative team working alongside first-in-class vendors, including dedicated designers who work with local artisans to craft spaces that breathe Indian heritage in your décor.</p>',
        'home_collective_kicker'    => 'WVN Wedding Collective',
        'home_collective_heading'   => 'Before we tell you our story, let our weddings speak for us.',
        'home_planner_heading'      => 'Meet the planner',
        'home_planner_kicker'       => 'Weddings aren’t planned by companies, they’re planned by people.',
        'home_planner_text'         => 'Nikhil Salvi leads Wedding Vows by Nikhil and personally oversees every celebration we create. From the first conversation to the last farewell, one team stays with you — designing, coordinating, and executing on the ground in Udaipur and beyond.',
        'home_planner_sign'         => 'Nikhil Salvi — Founder',
        'home_planner_link_text'    => 'Book a consultation ↗',
        'home_planner_link_url'     => home_url('/contact-us/'),
        'home_achieve_heading'      => 'Achievements',
        'home_achieve_lede'         => 'We offer complete destination wedding planning, so you only ever deal with one team — from the first venue visit to the final farewell.',
        'home_press_cover_title'    => 'Featured in',
        'home_press_cover_note'     => 'Tap to open',
        'home_press_end_brand'      => 'Wedding Vows by Nikhil',
        'home_press_end_title'      => 'The story continues in person',
        'home_press_end_text'       => 'Press coverage is only a glimpse. The work is in the rooms, the timing, and the people who stay with you until the last farewell.',
        'home_services_kicker'      => 'What we do',
        'home_services_heading'     => 'End-to-end, one team',
        'home_services_lede'        => 'We offer complete destination wedding planning, so you only ever deal with one team — from the first venue visit to the final farewell.',
        'home_showreel_caption'     => 'The Real Story Behind a Dream Wedding',
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
        'home_gallery_heading'      => 'Moments, captured behind the scenes',
        'home_gallery_lede'         => 'A glimpse into the celebrations we have quietly orchestrated — from first looks to the last dance.',
        'home_faq_kicker'           => 'FAQs',
        'home_faq_heading'          => 'Questions, answered in advance',
        'home_faq_lede'             => 'Let your wedding planner answer the things couples ask us most — before you even have to ask.',
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

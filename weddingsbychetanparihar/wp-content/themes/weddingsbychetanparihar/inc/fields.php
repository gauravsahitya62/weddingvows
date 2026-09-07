<?php
/**
 * Visible admin fields for pages and studio content.
 */

if (!defined('ABSPATH')) {
    exit;
}

function wbc_classic_post_types() {
    return array('page', 'post', 'wbc_wedding', 'wbc_service', 'wbc_destination', 'wbc_process', 'wbc_press', 'wbc_testimonial', 'wbc_faq');
}

function wbc_use_classic_editor($use, $post_type) {
    if (in_array($post_type, wbc_classic_post_types(), true)) {
        return false;
    }
    return $use;
}
add_filter('use_block_editor_for_post_type', 'wbc_use_classic_editor', 20, 2);

function wbc_is_front_edit($post) {
    return $post && ((int) get_option('page_on_front') === (int) $post->ID || $post->post_name === 'home');
}

function wbc_is_about_edit($post) {
    return $post && ($post->post_name === 'about' || get_page_template_slug($post) === 'page-about.php');
}

function wbc_is_contact_edit($post) {
    return $post && ($post->post_name === 'contact' || get_page_template_slug($post) === 'page-contact.php');
}

function wbc_is_journal_edit($post) {
    if (!$post || $post->post_type !== 'page') {
        return false;
    }
    return (int) get_option('page_for_posts') === (int) $post->ID || $post->post_name === 'journal';
}

function wbc_media_box_types() {
    return array('page', 'post', 'wbc_wedding', 'wbc_service', 'wbc_destination');
}

function wbc_editor_box_title($post) {
    if (!$post) {
        return __('Photos, video & page copy', 'weddingsbychetanparihar');
    }
    if (wbc_is_front_edit($post)) {
        return __('Homepage sections', 'weddingsbychetanparihar');
    }
    if (wbc_is_about_edit($post)) {
        return __('About sections', 'weddingsbychetanparihar');
    }
    if (wbc_is_journal_edit($post)) {
        return __('Blog sections', 'weddingsbychetanparihar');
    }
    if (wbc_is_contact_edit($post)) {
        return __('Contact sections', 'weddingsbychetanparihar');
    }
    if ($post->post_type === 'wbc_wedding') {
        return __('Wedding page', 'weddingsbychetanparihar');
    }
    if ($post->post_type === 'wbc_service') {
        return __('Service page', 'weddingsbychetanparihar');
    }
    if ($post->post_type === 'post') {
        return __('Journal note', 'weddingsbychetanparihar');
    }
    return __('Photos, video & page copy', 'weddingsbychetanparihar');
}

function wbc_register_editor_boxes($post_type = '', $post = null) {
    $title = wbc_editor_box_title($post);
    foreach (wbc_media_box_types() as $type) {
        add_meta_box('wbc_media_box', $title, 'wbc_media_box', $type, 'normal', 'high');
    }
}
add_action('add_meta_boxes', 'wbc_register_editor_boxes', 1, 2);

function wbc_admin_body_class($classes) {
    $post_id = isset($_GET['post']) ? (int) $_GET['post'] : 0;
    $post = $post_id ? get_post($post_id) : null;
    if (!$post) {
        return $classes;
    }
    if (wbc_is_front_edit($post)) {
        $classes .= ' wbc-home-edit';
    }
    if (wbc_is_about_edit($post) || wbc_is_journal_edit($post) || wbc_is_contact_edit($post)) {
        $classes .= ' wbc-section-edit';
    }
    if (wbc_is_journal_edit($post) || wbc_is_contact_edit($post)) {
        $classes .= ' wbc-journal-edit';
    }
    if (in_array($post->post_type, array('wbc_wedding', 'wbc_service', 'post'), true)) {
        $classes .= ' wbc-entry-edit';
    }
    return $classes;
}
add_filter('admin_body_class', 'wbc_admin_body_class');

function wbc_remove_raw_custom_fields() {
    foreach (array_merge(array('page', 'post'), wbc_media_box_types()) as $type) {
        remove_meta_box('postcustom', $type, 'normal');
    }
}
add_action('add_meta_boxes', 'wbc_remove_raw_custom_fields', 99);

function wbc_editor_defaults() {
    $defaults = array(
        'wbc_hero_kicker'         => 'Udaipur, India',
        'wbc_hero_title'          => 'Destination weddings, held with stillness.',
        'wbc_hero_text'           => 'Palace, heritage, and celebration design — planned in-house from the first story to the last farewell.',
        'wbc_hero_cta'            => 'Begin the conversation',
        'wbc_intro_kicker'        => 'Our Services',
        'wbc_intro_title'         => 'The Art of the Celebration',
        'wbc_intro_text'          => 'Full-service wedding planning and design for extraordinary people and unforgettable moments.',
        'wbc_intro_cta'           => 'Explore Services',
        'wbc_intro_image_alt'     => 'A twilight celebration pavilion planned by Chetan Parihar Weddings',
        'wbc_portfolio_kicker'    => 'Latest celebrations',
        'wbc_portfolio_title'     => 'See the work — stories told through rooms, rituals, and light.',
        'wbc_kind_kicker'         => 'Kind words',
        'wbc_founder_kicker'      => 'A studio, not a production house',
        'wbc_founder_title'       => 'Meet the planner',
        'wbc_founder_bio'         => 'Chetan Parihar leads a Udaipur-based studio that plans destination weddings with a design-first eye and a calm ground team.',
        'wbc_dest_kicker'         => 'Udaipur, and beyond',
        'wbc_dest_title'          => 'Destination planning with a home city, and a wide map.',
        'wbc_services_kicker'     => 'Planning & design',
        'wbc_services_title'      => 'Impeccable logistics, inspired creative direction, and design held in-house.',
        'wbc_stat_1_value'        => '1',
        'wbc_stat_1_label'        => 'Team, end to end',
        'wbc_stat_2_value'        => '8+',
        'wbc_stat_2_label'        => 'Cities planned',
        'wbc_stat_3_value'        => 'Pin to plane',
        'wbc_stat_3_label'        => 'Planning depth',
        'wbc_stat_4_value'        => 'Udaipur',
        'wbc_stat_4_label'        => 'Home studio',
        'wbc_process_kicker'      => 'A uniquely comprehensive process',
        'wbc_process_title'       => 'From the first story to the last farewell.',
        'wbc_process_text'        => 'Impeccable logistics, inspired creative direction, and design held in-house — from story to soirée.',
        'wbc_editorial_kicker'    => 'Our promise',
        'wbc_editorial_title'     => 'We coordinate so you can celebrate.',
        'wbc_editorial_text'      => 'Couples are asking for weddings that feel intentional, personal and immersive. This studio is built the same way.',
        'wbc_faq_kicker'          => 'Answers',
        'wbc_faq_title'           => 'Questions couples ask before they book.',
        'wbc_footer_mark'         => 'C',
        'wbc_founding_year'       => '2018',
        'wbc_cta_kicker'          => 'Contact us',
        'wbc_cta_title'           => 'Tell us where the celebration begins.',
        'wbc_cta_text'            => 'Share the date, city, guest count and the kind of wedding you imagine. Enquiries are stored in wp-admin under Contact Leads and emailed to the studio.',
        'wbc_email'               => 'hello@chetanpariharweddings.com',
        'wbc_form_kicker'         => 'Enquiry',
        'wbc_form_button'         => 'Send enquiry',
        'wbc_form_success'        => 'Thank you. Your enquiry has reached the studio.',
        'wbc_form_error'          => 'Please share your name and either email or phone.',
        'wbc_form_subject'        => 'New wedding enquiry from {name}',
        'wbc_form_name_label'     => 'Name',
        'wbc_form_email_label'    => 'Email',
        'wbc_form_phone_label'    => 'Phone',
        'wbc_form_date_label'     => 'Wedding date',
        'wbc_form_city_label'     => 'City / destination',
        'wbc_form_guests_label'   => 'Guest count',
        'wbc_form_budget_label'   => 'Approximate budget',
        'wbc_form_message_label'  => 'Message',
        'wbc_form_city_placeholder' => 'Udaipur, Jaipur, Goa…',
        'wbc_form_guests_placeholder' => '180',
        'wbc_form_budget_placeholder' => 'Planning + decor range',
        'wbc_form_message_placeholder' => 'Rituals, venues you love, guest cities…',
        'wbc_form_email_show'     => 'yes',
        'wbc_form_phone_show'     => 'yes',
        'wbc_form_date_show'      => 'yes',
        'wbc_form_city_show'      => 'yes',
        'wbc_form_guests_show'    => 'yes',
        'wbc_form_budget_show'    => 'yes',
        'wbc_form_message_show'   => 'yes',
        'wbc_about_kicker'        => 'Chetan Parihar Weddings',
        'wbc_about_title'         => 'A Udaipur studio for destination weddings that feel personal.',
        'wbc_about_text'          => 'Chetan Parihar Weddings specialises in destination weddings, corporate celebrations and event styling.',
        'wbc_about_cta'           => 'Begin the conversation',
        'wbc_visit_kicker'        => 'Visit the studio',
        'wbc_visit_title'         => 'Udaipur is home. The map is wider.',
        'wbc_pillars_kicker'      => 'How the studio works',
        'wbc_pillars_title'       => 'The same discipline that holds the homepage holds every wedding.',
        'wbc_services_page_kicker'=> 'Planning & design',
        'wbc_services_page_title' => 'Wedding planning, design and guest care — one studio.',
        'wbc_services_page_text'  => 'Venue, decor, production, hospitality and vendors are held as a single conversation so families are never stitching twelve teams together.',
        'wbc_services_page_cta'   => 'Start an enquiry',
        'wbc_weddings_page_kicker'=> 'Portfolio',
        'wbc_weddings_page_title' => 'Real weddings by Chetan Parihar Weddings',
        'wbc_weddings_page_text'  => 'Palace, heritage, lakeside and destination celebrations — each story told through rooms, rituals and light.',
        'wbc_weddings_page_cta'   => 'Plan a weekend',
        'wbc_journal_kicker'      => 'Journal',
        'wbc_journal_title'       => 'Wedding planning notes for thoughtful celebrations.',
        'wbc_journal_text'        => 'Destination guides, design notes, venue thinking and practical timelines from Chetan Parihar Weddings.',
        'wbc_journal_cta'         => 'Read the latest note',
        'wbc_cover_media_type'    => 'photo',
        'wbc_kind_media_type'     => 'photo',
        'wbc_process_media_type'  => 'video',
        'wbc_editorial_media_type'=> 'video',
        'wbc_cta_media_type'      => 'video',
    );
    foreach (wbc_default_pillars() as $i => $pillar) {
        $defaults['wbc_pillar_' . $i . '_title'] = $pillar['title'];
        $defaults['wbc_pillar_' . $i . '_text'] = $pillar['text'];
    }
    return $defaults;
}

function wbc_editor_media_slot($key) {
    $map = array(
        'wbc_cover_image'      => array('image', 'hero'),
        'wbc_cover_video'      => array('video', 'hero'),
        'wbc_cover_media_type' => array('type', 'hero'),
        'wbc_hero_image'       => array('image', 'hero'),
        'wbc_hero_video'       => array('video', 'hero'),
        'wbc_hero_media_type'  => array('type', 'hero'),
        'wbc_kind_image'       => array('image', 'kind'),
        'wbc_kind_video'       => array('video', 'kind'),
        'wbc_kind_media_type'  => array('type', 'kind'),
        'wbc_founder_image'    => array('image', 'founder'),
        'wbc_about_image'      => array('image', 'about'),
        'wbc_services_page_image' => array('image', 'service-1'),
        'wbc_weddings_page_image' => array('image', 'wedding-1'),
        'wbc_journal_image'    => array('image', 'journal-1'),
        'wbc_process_image'    => array('image', 'process'),
        'wbc_process_video'    => array('video', 'process'),
        'wbc_process_media_type'=> array('type', 'process'),
        'wbc_editorial_image'  => array('image', 'editorial'),
        'wbc_editorial_video'  => array('video', 'editorial'),
        'wbc_editorial_media_type'=> array('type', 'editorial'),
        'wbc_cta_image'        => array('image', 'cta'),
        'wbc_cta_video'        => array('video', 'cta'),
        'wbc_cta_media_type'   => array('type', 'cta'),
        'wbc_intro_image'      => array('image', 'ceremony'),
        'wbc_footer_image_1'   => array('image', 'strip-1'),
        'wbc_footer_image_2'   => array('image', 'strip-2'),
        'wbc_footer_image_3'   => array('image', 'strip-3'),
        'wbc_footer_image_4'   => array('image', 'strip-4'),
        'wbc_footer_image_5'   => array('image', 'strip-5'),
    );
    return isset($map[$key]) ? $map[$key] : null;
}

function wbc_editor_kind_fallback($key) {
    $quotes = wbc_get_ordered_posts('wbc_testimonial', 1);
    if (!$quotes) {
        return '';
    }
    $quote = $quotes[0];
    if ($key === 'wbc_kind_quote') {
        return wp_strip_all_tags($quote->post_content);
    }
    if ($key === 'wbc_kind_cite') {
        $event = wbc_meta($quote->ID, 'wbc_event');
        $name = wp_specialchars_decode(get_the_title($quote), ENT_QUOTES);
        return $event ? $name . ' — ' . $event : $name;
    }
    return '';
}

function wbc_editor_value($post_id, $key, $fallback_mod = '') {
    $intro_keys = array(
        'wbc_intro_kicker'    => 'kicker',
        'wbc_intro_title'     => 'title',
        'wbc_intro_text'      => 'text',
        'wbc_intro_cta'       => 'cta',
        'wbc_intro_image_alt' => 'alt',
    );
    if (isset($intro_keys[$key])) {
        return wbc_intro_value($intro_keys[$key], $key);
    }
    if ($post_id) {
        $value = wbc_meta($post_id, $key);
        if ($value !== '') {
            return $value;
        }
    }
    if ($fallback_mod) {
        $mod = (string) get_theme_mod($fallback_mod, '');
        if ($mod !== '') {
            return $mod;
        }
    }
    $mod = (string) get_theme_mod($key, '');
    if ($mod !== '') {
        return $mod;
    }
    if (in_array($key, array('wbc_kind_quote', 'wbc_kind_cite'), true)) {
        $quote = wbc_editor_kind_fallback($key);
        if ($quote !== '') {
            return $quote;
        }
    }
    $defaults = wbc_editor_defaults();
    if (!empty($defaults[$key])) {
        return $defaults[$key];
    }
    $slot = wbc_editor_media_slot($key);
    if ($slot) {
        if ($slot[0] === 'image') {
            return wbc_default_image($slot[1]);
        }
        if ($slot[0] === 'video' && in_array($slot[1], array('hero', 'cta', 'process', 'editorial'), true)) {
            return wbc_default_video($slot[1]);
        }
        if ($slot[0] === 'type') {
            return $slot[1] === 'kind' ? 'photo' : 'video';
        }
    }
    return '';
}

function wbc_admin_field_text($post_id, $key, $label, $type = 'text', $help = '', $placeholder = '', $fallback_mod = '') {
    $value = wbc_editor_value($post_id, $key, $fallback_mod);
    echo '<p class="wbc-admin-field"><label for="' . esc_attr($key) . '"><strong>' . esc_html($label) . '</strong></label>';
    if ($type === 'textarea') {
        echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="4" class="widefat" placeholder="' . esc_attr($placeholder) . '">' . esc_textarea($value) . '</textarea>';
    } else {
        echo '<input id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" type="' . esc_attr($type) . '" value="' . esc_attr($value) . '" class="widefat" placeholder="' . esc_attr($placeholder) . '">';
    }
    if ($help) {
        echo '<span class="description">' . esc_html($help) . '</span>';
    }
    echo '</p>';
}

function wbc_admin_field_choice($post_id, $key, $label, $choices, $fallback_mod = '') {
    $value = wbc_editor_value($post_id, $key, $fallback_mod);
    if ($value === '' || !isset($choices[$value])) {
        $keys = array_keys($choices);
        $value = (string) reset($keys);
    }
    echo '<p class="wbc-admin-field"><strong>' . esc_html($label) . '</strong><span class="wbc-admin-radios">';
    foreach ($choices as $choice => $choice_label) {
        echo '<label><input type="radio" name="' . esc_attr($key) . '" value="' . esc_attr($choice) . '"' . checked($value, $choice, false) . '> ' . esc_html($choice_label) . '</label>';
    }
    echo '</span></p>';
}

function wbc_admin_media_preview_html($url, $kind = 'image') {
    $url = trim((string) $url);
    if ($url === '') {
        return '';
    }
    if ($kind === 'image') {
        return '<img src="' . esc_url($url) . '" alt="">';
    }
    $youtube = wbc_youtube_id($url);
    if ($youtube) {
        return '<iframe src="https://www.youtube-nocookie.com/embed/' . esc_attr($youtube) . '" title="Video preview" allow="encrypted-media" allowfullscreen></iframe>';
    }
    $vimeo = wbc_vimeo_id($url);
    if ($vimeo) {
        return '<iframe src="https://player.vimeo.com/video/' . esc_attr($vimeo) . '" title="Video preview" allow="autoplay; fullscreen" allowfullscreen></iframe>';
    }
    return '<video src="' . esc_url($url) . '" controls muted playsinline preload="metadata"></video>';
}

function wbc_admin_field_media($post_id, $key, $label, $kind = 'image', $help = '', $fallback_mod = '') {
    $value = wbc_editor_value($post_id, $key, $fallback_mod);
    $is_image = $kind === 'image';
    echo '<div class="wbc-admin-media" data-wbc-media>';
    echo '<p class="wbc-admin-field"><strong>' . esc_html($label) . '</strong></p>';
    echo '<div class="wbc-admin-preview" data-wbc-media-preview>';
    echo wbc_admin_media_preview_html($value, $kind);
    echo '</div>';
    echo '<p class="wbc-admin-media-actions">';
    echo '<input id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" type="hidden" value="' . esc_attr($value) . '" data-wbc-media-input>';
    echo '<button type="button" class="button" data-wbc-media-pick data-kind="' . esc_attr($kind) . '">' . esc_html($is_image ? 'Choose photo' : 'Choose video') . '</button>';
    echo '<button type="button" class="button-link" data-wbc-media-clear>Remove</button>';
    echo '</p>';
    if ($help) {
        echo '<p class="description">' . esc_html($help) . '</p>';
    }
    echo '</div>';
}

function wbc_admin_footer_link_row($item = array(), $as_template = false) {
    $icon = isset($item['icon']) ? $item['icon'] : '';
    $url = isset($item['url']) ? $item['url'] : '';
    $label = isset($item['label']) ? $item['label'] : '';
    if ($as_template) {
        echo '<template data-wbc-repeater-template>';
    }
    echo '<div class="wbc-admin-repeat-row" data-wbc-repeater-row>';
    echo '<div class="wbc-admin-media" data-wbc-media>';
    echo '<p class="wbc-admin-field"><strong>Icon</strong></p>';
    echo '<div class="wbc-admin-preview" data-wbc-media-preview>';
    echo wbc_admin_media_preview_html($icon, 'image');
    echo '</div>';
    echo '<p class="wbc-admin-media-actions">';
    echo '<input name="wbc_footer_link_icon[]" type="hidden" value="' . esc_attr($icon) . '" data-wbc-media-input>';
    echo '<button type="button" class="button" data-wbc-media-pick data-kind="image">Choose icon</button>';
    echo '<button type="button" class="button-link" data-wbc-media-clear>Remove</button>';
    echo '</p>';
    echo '</div>';
    echo '<p class="wbc-admin-field"><label><strong>Link</strong></label>';
    echo '<input name="wbc_footer_link_url[]" type="url" value="' . esc_attr($url) . '" class="widefat" placeholder="https://"></p>';
    echo '<p class="wbc-admin-field"><label><strong>Label</strong></label>';
    echo '<input name="wbc_footer_link_label[]" type="text" value="' . esc_attr($label) . '" class="widefat" placeholder="WhatsApp, Brochure…"></p>';
    echo '<p><button type="button" class="button-link-delete" data-wbc-repeater-remove>Remove this icon</button></p>';
    echo '</div>';
    if ($as_template) {
        echo '</template>';
    }
}

function wbc_admin_footer_links_field() {
    $items = wbc_footer_links();
    echo '<div class="wbc-admin-repeat" data-wbc-repeater>';
    echo '<p class="wbc-admin-lead">Icons on the right of the footer bar. Add as many as you need.</p>';
    echo '<div data-wbc-repeater-list>';
    if ($items) {
        foreach ($items as $item) {
            wbc_admin_footer_link_row($item);
        }
    } else {
        wbc_admin_footer_link_row();
    }
    echo '</div>';
    echo '<p><button type="button" class="button" data-wbc-repeater-add>Add icon</button></p>';
    wbc_admin_footer_link_row(array(), true);
    echo '</div>';
}

function wbc_admin_intro_icon_row($item = array(), $as_template = false) {
    $icon = isset($item['icon']) ? $item['icon'] : '';
    $url = isset($item['url']) ? $item['url'] : '';
    $label = isset($item['label']) ? $item['label'] : '';
    $kind = isset($item['kind']) ? $item['kind'] : '';
    if ($as_template) {
        echo '<template data-wbc-repeater-template>';
    }
    echo '<div class="wbc-admin-repeat-row" data-wbc-repeater-row>';
    echo '<div class="wbc-admin-media" data-wbc-media>';
    echo '<p class="wbc-admin-field"><strong>Icon</strong></p>';
    echo '<div class="wbc-admin-preview" data-wbc-media-preview>';
    echo wbc_admin_media_preview_html($icon, 'image');
    echo '</div>';
    echo '<p class="wbc-admin-media-actions">';
    echo '<input name="wbc_intro_icon[]" type="hidden" value="' . esc_attr($icon) . '" data-wbc-media-input>';
    echo '<input name="wbc_intro_icon_kind[]" type="hidden" value="' . esc_attr($kind) . '">';
    echo '<button type="button" class="button" data-wbc-media-pick data-kind="image">Choose icon</button>';
    echo '<button type="button" class="button-link" data-wbc-media-clear>Remove</button>';
    echo '</p>';
    echo '</div>';
    echo '<p class="wbc-admin-field"><label><strong>Label</strong></label>';
    echo '<input name="wbc_intro_icon_label[]" type="text" value="' . esc_attr($label) . '" class="widefat" placeholder="Planning, Design & Decor…"></p>';
    echo '<p class="wbc-admin-field"><label><strong>Link</strong></label>';
    echo '<input name="wbc_intro_icon_url[]" type="url" value="' . esc_attr($url) . '" class="widefat" placeholder="https:// — optional"></p>';
    echo '<p><button type="button" class="button-link-delete" data-wbc-repeater-remove>Remove this icon</button></p>';
    echo '</div>';
    if ($as_template) {
        echo '</template>';
    }
}

function wbc_admin_intro_icons_field() {
    $items = wbc_intro_icons();
    echo '<div class="wbc-admin-repeat" data-wbc-repeater>';
    echo '<p class="wbc-admin-lead">The icon row under the framed photo. Upload an icon, add a label, and optionally a link.</p>';
    echo '<div data-wbc-repeater-list>';
    if ($items) {
        foreach ($items as $item) {
            wbc_admin_intro_icon_row($item);
        }
    } else {
        wbc_admin_intro_icon_row();
    }
    echo '</div>';
    echo '<p><button type="button" class="button" data-wbc-repeater-add>Add icon</button></p>';
    wbc_admin_intro_icon_row(array(), true);
    echo '</div>';
}

function wbc_admin_tab_nav($tabs, $store = 'wbc-admin-tab') {
    echo '<div class="wbc-tabs" data-wbc-tabs data-store="' . esc_attr($store) . '"><div class="wbc-tabs-nav" role="tablist">';
    $first = true;
    foreach ($tabs as $key => $label) {
        echo '<button type="button" class="wbc-tabs-btn' . ($first ? ' is-on' : '') . '" data-tab="' . esc_attr($key) . '" role="tab">' . esc_html($label) . '</button>';
        $first = false;
    }
    echo '</div>';
}

function wbc_admin_panel($key, $first = false) {
    echo '<div class="wbc-tabs-panel' . ($first ? ' is-on' : '') . '" data-panel="' . esc_attr($key) . '">';
}

function wbc_admin_panel_end() {
    echo '</div>';
}

function wbc_admin_gallery_field($post_id) {
    $ids = wbc_gallery_ids($post_id);
    echo '<div class="wbc-admin-gallery" data-wbc-gallery-field>';
    echo '<p class="wbc-admin-field"><strong>Gallery</strong></p>';
    echo '<div class="wbc-admin-gallery-thumbs" data-wbc-gallery-thumbs>';
    foreach ($ids as $id) {
        $thumb = wp_get_attachment_image_url($id, 'medium');
        if ($thumb) {
            echo '<img src="' . esc_url($thumb) . '" alt="">';
        }
    }
    echo '</div>';
    echo '<p class="wbc-admin-media-actions">';
    echo '<input id="wbc_gallery_ids" name="wbc_gallery_ids" type="hidden" value="' . esc_attr(implode(',', $ids)) . '" data-wbc-gallery-input>';
    echo '<button type="button" class="button" data-wbc-gallery>Choose photos</button>';
    echo '<button type="button" class="button-link" data-wbc-gallery-clear>Remove</button>';
    echo '</p>';
    echo '<p class="description">These photos appear on the wedding page. The cover photo is set in the Cover tab.</p>';
    echo '</div>';
}

function wbc_admin_band_fields($post_id, $prefix, $with_copy = true) {
    if ($with_copy) {
        echo '<div class="wbc-admin-cols"><div>';
        wbc_admin_field_text($post_id, $prefix . '_kicker', 'Small label');
        wbc_admin_field_text($post_id, $prefix . '_title', 'Title', 'textarea');
        wbc_admin_field_text($post_id, $prefix . '_text', 'Text', 'textarea');
        echo '</div><div>';
    }
    wbc_admin_field_choice($post_id, $prefix . '_media_type', 'Show', array('photo' => 'Photo', 'video' => 'Video'));
    wbc_admin_field_media($post_id, $prefix . '_image', 'Photo', 'image');
    wbc_admin_field_media($post_id, $prefix . '_video', 'Video', 'video');
    if ($with_copy) {
        echo '</div></div>';
    }
}

function wbc_media_box($post) {
    wp_nonce_field('wbc_save_meta', 'wbc_meta_nonce');
    $front = wbc_is_front_edit($post);
    $about = wbc_is_about_edit($post);

    if ($front) {
        wbc_admin_tab_nav(array(
            'hero'         => 'Hero',
            'intro'        => 'Intro',
            'portfolio'    => 'Portfolio',
            'kind'         => 'Kind words',
            'planner'      => 'Planner',
            'destinations' => 'Destinations',
            'services'     => 'Services',
            'process'      => 'Process',
            'editorial'    => 'Editorial',
            'faq'          => 'FAQ',
            'footer'       => 'Footer',
            'contact'      => 'Contact',
        ));

        wbc_admin_panel('hero', true);
        echo '<p class="wbc-admin-lead">Full-screen opening photo or film, plus the words on the left.</p>';
        echo '<div class="wbc-admin-cols"><div>';
        wbc_admin_field_text($post->ID, 'wbc_hero_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_hero_title', 'Title', 'textarea');
        wbc_admin_field_text($post->ID, 'wbc_hero_text', 'Text', 'textarea');
        wbc_admin_field_text($post->ID, 'wbc_hero_cta', 'Button label');
        echo '</div><div>';
        wbc_admin_field_choice($post->ID, 'wbc_cover_media_type', 'Show', array('photo' => 'Photo', 'video' => 'Video'), 'wbc_hero_media_type');
        wbc_admin_field_media($post->ID, 'wbc_cover_image', 'Photo', 'image', '', 'wbc_hero_image');
        wbc_admin_field_media($post->ID, 'wbc_cover_video', 'Video', 'video', '', 'wbc_hero_video');
        echo '</div></div>';
        wbc_admin_panel_end();

        wbc_admin_panel('intro');
        echo '<p class="wbc-admin-lead">The celebration block under the hero — words on the left, framed photo on the right, and the icon row beneath.</p>';
        echo '<div class="wbc-admin-cols"><div>';
        wbc_admin_field_text($post->ID, 'wbc_intro_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_intro_title', 'Title', 'textarea');
        wbc_admin_field_text($post->ID, 'wbc_intro_text', 'Text', 'textarea');
        wbc_admin_field_text($post->ID, 'wbc_intro_cta', 'Button label');
        wbc_admin_field_text($post->ID, 'wbc_intro_cta_url', 'Button link', 'url', 'Leave blank to open the Services page.');
        echo '</div><div>';
        wbc_admin_field_media($post->ID, 'wbc_intro_image', 'Framed photo', 'image');
        wbc_admin_field_text($post->ID, 'wbc_intro_image_alt', 'Photo alt text');
        echo '</div></div>';
        wbc_admin_intro_icons_field();
        wbc_admin_panel_end();

        wbc_admin_panel('portfolio');
        echo '<p class="wbc-admin-lead">Heading above the wedding filmstrip. Add weddings under Weddings.</p>';
        wbc_admin_field_text($post->ID, 'wbc_portfolio_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_portfolio_title', 'Title', 'textarea');
        wbc_admin_panel_end();

        wbc_admin_panel('kind');
        echo '<p class="wbc-admin-lead">The featured review photo or film. Quotes come from Testimonials.</p>';
        echo '<div class="wbc-admin-cols"><div>';
        wbc_admin_field_text($post->ID, 'wbc_kind_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_kind_quote', 'Quote', 'textarea');
        wbc_admin_field_text($post->ID, 'wbc_kind_cite', 'Names');
        echo '</div><div>';
        wbc_admin_field_choice($post->ID, 'wbc_kind_media_type', 'Show', array('photo' => 'Photo', 'video' => 'Video'));
        wbc_admin_field_media($post->ID, 'wbc_kind_image', 'Photo', 'image');
        wbc_admin_field_media($post->ID, 'wbc_kind_video', 'Video', 'video');
        echo '</div></div>';
        wbc_admin_panel_end();

        wbc_admin_panel('planner');
        echo '<p class="wbc-admin-lead">The planner card on the homepage.</p>';
        echo '<div class="wbc-admin-cols"><div>';
        wbc_admin_field_text($post->ID, 'wbc_founder_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_founder_title', 'Title', 'textarea');
        wbc_admin_field_text($post->ID, 'wbc_founder_bio', 'Text', 'textarea');
        echo '</div><div>';
        wbc_admin_field_media($post->ID, 'wbc_founder_image', 'Photo', 'image');
        echo '</div></div>';
        wbc_admin_panel_end();

        wbc_admin_panel('destinations');
        echo '<p class="wbc-admin-lead">Heading above the destination cards. Places come from Destinations.</p>';
        wbc_admin_field_text($post->ID, 'wbc_dest_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_dest_title', 'Title', 'textarea');
        wbc_admin_panel_end();

        wbc_admin_panel('services');
        echo '<p class="wbc-admin-lead">Heading above the services row, plus the four stat cards. Service names come from Services.</p>';
        wbc_admin_field_text($post->ID, 'wbc_services_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_services_title', 'Title', 'textarea');
        echo '<div class="wbc-admin-cols">';
        foreach (wbc_default_stats() as $s => $stat) {
            echo '<div>';
            echo '<p class="wbc-admin-lead">Stat ' . (int) $s . '</p>';
            wbc_admin_field_text($post->ID, 'wbc_stat_' . $s . '_value', 'Value');
            wbc_admin_field_text($post->ID, 'wbc_stat_' . $s . '_label', 'Label');
            echo '</div>';
        }
        echo '</div>';
        wbc_admin_panel_end();

        wbc_admin_panel('process');
        echo '<p class="wbc-admin-lead">The process photo or film fills the section as a parallax background. Heading and steps sit on top of it.</p>';
        wbc_admin_band_fields($post->ID, 'wbc_process');
        wbc_admin_panel_end();

        wbc_admin_panel('editorial');
        echo '<p class="wbc-admin-lead">The promise section.</p>';
        wbc_admin_band_fields($post->ID, 'wbc_editorial');
        wbc_admin_panel_end();

        wbc_admin_panel('faq');
        echo '<p class="wbc-admin-lead">Optional background photo with parallax. Remove the photo to use the parchment gold background instead. Individual answers are edited under FAQs.</p>';
        echo '<div class="wbc-admin-cols"><div>';
        wbc_admin_field_text($post->ID, 'wbc_faq_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_faq_title', 'Title', 'textarea');
        echo '</div><div>';
        wbc_admin_field_media($post->ID, 'wbc_faq_image', 'Background photo', 'image', 'Leave empty for the default section background.');
        echo '</div></div>';
        wbc_admin_panel_end();

        wbc_admin_panel('footer');
        echo '<p class="wbc-admin-lead">The white bar at the top of the footer. Upload a logo to replace the letter mark. Leave a social URL blank to keep the icon without a link.</p>';
        echo '<div class="wbc-admin-cols"><div>';
        wbc_admin_field_text($post->ID, 'wbc_pinterest', 'Pinterest URL', 'url');
        wbc_admin_field_text($post->ID, 'wbc_facebook', 'Facebook URL', 'url');
        wbc_admin_field_text($post->ID, 'wbc_instagram', 'Instagram URL', 'url');
        wbc_admin_field_text($post->ID, 'wbc_tiktok', 'TikTok URL', 'url');
        echo '</div><div>';
        wbc_admin_field_media($post->ID, 'wbc_footer_logo', 'Logo', 'image', 'Shown in the centre of the footer bar.');
        wbc_admin_field_text($post->ID, 'wbc_footer_mark', 'Fallback letter', 'text', 'Used only if no logo is uploaded.');
        wbc_admin_field_text($post->ID, 'wbc_founding_year', 'Established year', 'text', 'Used only if no logo is uploaded.');
        echo '</div></div>';
        wbc_admin_footer_links_field();
        echo '<p class="wbc-admin-lead">The five photos in the footer strip, on every page.</p>';
        echo '<div class="wbc-admin-cols">';
        for ($i = 1; $i <= 5; $i++) {
            echo '<div>';
            wbc_admin_field_media($post->ID, 'wbc_footer_image_' . $i, 'Photo ' . $i, 'image');
            echo '</div>';
        }
        echo '</div>';
        wbc_admin_panel_end();

        wbc_admin_panel('contact');
        echo '<p class="wbc-admin-lead">The contact band at the bottom of the page.</p>';
        wbc_admin_band_fields($post->ID, 'wbc_cta');
        wbc_admin_panel_end();

        echo '</div>';
        return;
    }

    if ($about) {
        wbc_admin_tab_nav(array(
            'hero'    => 'Hero',
            'studio'  => 'Studio',
            'pillars' => 'Pillars',
            'visit'   => 'Visit',
        ));

        wbc_admin_panel('hero', true);
        echo '<p class="wbc-admin-lead">The opening photo and words at the top of About.</p>';
        echo '<div class="wbc-admin-cols"><div>';
        wbc_admin_field_text($post->ID, 'wbc_about_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_about_title', 'Title', 'textarea');
        wbc_admin_field_text($post->ID, 'wbc_about_text', 'Text', 'textarea');
        wbc_admin_field_text($post->ID, 'wbc_about_cta', 'Button label');
        echo '</div><div>';
        wbc_admin_field_media($post->ID, 'wbc_about_image', 'Photo', 'image');
        echo '</div></div>';
        wbc_admin_panel_end();

        wbc_admin_panel('studio');
        echo '<p class="wbc-admin-lead">The planner story beside the founder photograph. The page editor below this box is the paragraph under the studio.</p>';
        echo '<div class="wbc-admin-cols"><div>';
        wbc_admin_field_text($post->ID, 'wbc_founder_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_founder_title', 'Title', 'textarea');
        wbc_admin_field_text($post->ID, 'wbc_founder_bio', 'Text', 'textarea');
        echo '</div><div>';
        wbc_admin_field_media($post->ID, 'wbc_founder_image', 'Photo', 'image');
        echo '</div></div>';
        wbc_admin_panel_end();

        wbc_admin_panel('pillars');
        echo '<p class="wbc-admin-lead">The four studio cards.</p>';
        wbc_admin_field_text($post->ID, 'wbc_pillars_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_pillars_title', 'Title', 'textarea');
        echo '<div class="wbc-admin-cols">';
        foreach (wbc_default_pillars() as $i => $pillar) {
            echo '<div>';
            echo '<p class="wbc-admin-lead">Card ' . (int) $i . '</p>';
            wbc_admin_field_text($post->ID, 'wbc_pillar_' . $i . '_title', 'Title');
            wbc_admin_field_text($post->ID, 'wbc_pillar_' . $i . '_text', 'Text', 'textarea');
            echo '</div>';
        }
        echo '</div>';
        wbc_admin_panel_end();

        wbc_admin_panel('visit');
        echo '<p class="wbc-admin-lead">The visit card. Address and hours come from Appearance → Customize → Brand & Contact.</p>';
        wbc_admin_field_text($post->ID, 'wbc_visit_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_visit_title', 'Title', 'textarea');
        wbc_admin_panel_end();

        echo '</div>';
        return;
    }

    if (wbc_is_journal_edit($post)) {
        wbc_admin_tab_nav(array('hero' => 'Hero'));
        wbc_admin_panel('hero', true);
        echo '<p class="wbc-admin-lead">The opening of the blog. Individual notes are edited under Posts.</p>';
        echo '<div class="wbc-admin-cols"><div>';
        wbc_admin_field_text($post->ID, 'wbc_journal_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_journal_title', 'Title', 'textarea');
        wbc_admin_field_text($post->ID, 'wbc_journal_text', 'Text', 'textarea');
        wbc_admin_field_text($post->ID, 'wbc_journal_cta', 'Button label');
        echo '</div><div>';
        wbc_admin_field_media($post->ID, 'wbc_journal_image', 'Photo', 'image');
        echo '</div></div>';
        wbc_admin_panel_end();
        echo '</div>';
        return;
    }

    if (wbc_is_contact_edit($post)) {
        $leads_url = admin_url('edit.php?post_type=wbc_lead');
        wbc_admin_tab_nav(array(
            'intro' => 'Intro',
            'form'  => 'Form',
            'email' => 'Email',
            'band'  => 'Band',
        ));

        wbc_admin_panel('intro', true);
        echo '<p class="wbc-admin-lead">The words above the enquiry form. Submissions appear under <a href="' . esc_url($leads_url) . '">Contact Leads</a>.</p>';
        wbc_admin_field_text($post->ID, 'wbc_form_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_cta_title', 'Title', 'textarea');
        wbc_admin_field_text($post->ID, 'wbc_cta_text', 'Text', 'textarea');
        wbc_admin_panel_end();

        wbc_admin_panel('form');
        echo '<p class="wbc-admin-lead">Labels, placeholders, and which fields appear on the contact form.</p>';
        wbc_admin_field_text($post->ID, 'wbc_form_button', 'Button label');
        wbc_admin_field_text($post->ID, 'wbc_form_success', 'Thank-you message', 'textarea');
        wbc_admin_field_text($post->ID, 'wbc_form_error', 'Missing-details message', 'textarea');
        echo '<div class="wbc-admin-cols">';
        foreach (wbc_contact_form_fields() as $key => $field) {
            echo '<div>';
            echo '<p class="wbc-admin-lead">' . esc_html($field['label']) . '</p>';
            wbc_admin_field_text($post->ID, 'wbc_form_' . $key . '_label', 'Label');
            wbc_admin_field_text($post->ID, 'wbc_form_' . $key . '_placeholder', 'Placeholder');
            if (empty($field['locked'])) {
                wbc_admin_field_choice($post->ID, 'wbc_form_' . $key . '_show', 'Show on form', array('yes' => 'Yes', 'no' => 'No'));
            }
            echo '</div>';
        }
        echo '</div>';
        wbc_admin_panel_end();

        wbc_admin_panel('email');
        echo '<p class="wbc-admin-lead">Each enquiry is saved as a Contact Lead and emailed here. Use {name} in the subject to include the sender.</p>';
        wbc_admin_field_text($post->ID, 'wbc_email', 'Send submissions to', 'email', 'This is also the studio email shown on the contact card and in the footer.');
        wbc_admin_field_text($post->ID, 'wbc_form_subject', 'Email subject');
        wbc_admin_panel_end();

        wbc_admin_panel('band');
        echo '<p class="wbc-admin-lead">The photo or film at the top of Contact, and the same band at the bottom of other pages.</p>';
        wbc_admin_field_text($post->ID, 'wbc_cta_kicker', 'Band label');
        wbc_admin_band_fields($post->ID, 'wbc_cta', false);
        wbc_admin_panel_end();

        echo '</div>';
        return;
    }

    if ($post->post_type === 'wbc_wedding') {
        wbc_admin_tab_nav(array(
            'cover'   => 'Cover',
            'details' => 'Details',
            'gallery' => 'Gallery',
        ));

        wbc_admin_panel('cover', true);
        echo '<p class="wbc-admin-lead">The photo and words at the top of this wedding. Title comes from the title field above.</p>';
        echo '<div class="wbc-admin-cols"><div>';
        wbc_admin_field_text($post->ID, 'wbc_page_kicker', 'Small label', 'text', 'Leave blank to use the city.');
        wbc_admin_field_text($post->ID, 'wbc_page_intro', 'Text', 'textarea', 'Leave blank to use the excerpt.');
        echo '</div><div>';
        wbc_admin_field_choice($post->ID, 'wbc_cover_media_type', 'Show', array('photo' => 'Photo', 'video' => 'Video'));
        wbc_admin_field_media($post->ID, 'wbc_cover_image', 'Photo', 'image');
        wbc_admin_field_media($post->ID, 'wbc_cover_video', 'Video', 'video');
        echo '</div></div>';
        wbc_admin_panel_end();

        wbc_admin_panel('details');
        echo '<p class="wbc-admin-lead">The facts strip under the photo.</p>';
        echo '<div class="wbc-admin-cols"><div>';
        wbc_admin_field_text($post->ID, 'wbc_couple', 'Couple names');
        wbc_admin_field_text($post->ID, 'wbc_venue', 'Venue');
        wbc_admin_field_text($post->ID, 'wbc_location', 'City / location');
        wbc_admin_field_text($post->ID, 'wbc_season', 'Season or month');
        echo '</div><div>';
        wbc_admin_field_text($post->ID, 'wbc_guest_count', 'Guest count');
        wbc_admin_field_text($post->ID, 'wbc_style', 'Style label', 'text', 'Palace, Heritage, Coastal, Intimate…');
        wbc_admin_field_text($post->ID, 'wbc_video_url', 'Film / reel URL', 'url');
        wbc_admin_field_text($post->ID, 'wbc_planner_note', 'Planning note', 'textarea');
        echo '</div></div>';
        wbc_admin_panel_end();

        wbc_admin_panel('gallery');
        wbc_admin_gallery_field($post->ID);
        wbc_admin_panel_end();

        echo '</div>';
        return;
    }

    if ($post->post_type === 'wbc_service') {
        wbc_admin_tab_nav(array(
            'cover' => 'Cover',
            'copy'  => 'Copy',
        ));

        wbc_admin_panel('cover', true);
        echo '<p class="wbc-admin-lead">The photo at the top of this service. The name comes from the title field above.</p>';
        wbc_admin_field_choice($post->ID, 'wbc_cover_media_type', 'Show', array('photo' => 'Photo', 'video' => 'Video'));
        wbc_admin_field_media($post->ID, 'wbc_cover_image', 'Photo', 'image');
        wbc_admin_field_media($post->ID, 'wbc_cover_video', 'Video', 'video');
        wbc_admin_panel_end();

        wbc_admin_panel('copy');
        echo '<p class="wbc-admin-lead">The small label and the line under the title. The longer story is the editor below.</p>';
        wbc_admin_field_text($post->ID, 'wbc_service_kicker', 'Small label');
        wbc_admin_field_text($post->ID, 'wbc_page_intro', 'Text', 'textarea', 'Leave blank to use the excerpt.');
        wbc_admin_panel_end();

        echo '</div>';
        return;
    }

    if ($post->post_type === 'post') {
        wbc_admin_tab_nav(array('cover' => 'Cover'));
        wbc_admin_panel('cover', true);
        echo '<p class="wbc-admin-lead">The photo and intro on this journal note. The title comes from the title field above.</p>';
        echo '<div class="wbc-admin-cols"><div>';
        wbc_admin_field_text($post->ID, 'wbc_page_kicker', 'Small label', 'text', 'Leave blank to use the date.');
        wbc_admin_field_text($post->ID, 'wbc_page_intro', 'Text', 'textarea', 'Leave blank to use the excerpt.');
        echo '</div><div>';
        wbc_admin_field_choice($post->ID, 'wbc_cover_media_type', 'Show', array('photo' => 'Photo', 'video' => 'Video'));
        wbc_admin_field_media($post->ID, 'wbc_cover_image', 'Photo', 'image');
        wbc_admin_field_media($post->ID, 'wbc_cover_video', 'Video', 'video');
        echo '</div></div>';
        wbc_admin_panel_end();
        echo '</div>';
        return;
    }

    echo '<p class="wbc-admin-lead">Change the cover and the words at the top of this page.</p>';

    echo '<fieldset class="wbc-admin-set"><legend>Cover</legend>';
    wbc_admin_field_choice($post->ID, 'wbc_cover_media_type', 'Show', array('photo' => 'Photo', 'video' => 'Video'));
    wbc_admin_field_media($post->ID, 'wbc_cover_image', 'Photo', 'image');
    wbc_admin_field_media($post->ID, 'wbc_cover_video', 'Video', 'video');
    echo '</fieldset>';

    echo '<fieldset class="wbc-admin-set"><legend>Copy</legend>';
    wbc_admin_field_text($post->ID, 'wbc_page_kicker', 'Small label');
    wbc_admin_field_text($post->ID, 'wbc_page_headline', 'Title', 'textarea');
    wbc_admin_field_text($post->ID, 'wbc_page_intro', 'Text', 'textarea');
    echo '</fieldset>';
}

function wbc_save_editor_fields($post_id) {
    if (!isset($_POST['wbc_meta_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['wbc_meta_nonce'])), 'wbc_save_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $text = array(
        'wbc_cover_media_type', 'wbc_page_kicker', 'wbc_hero_kicker', 'wbc_hero_cta', 'wbc_intro_kicker', 'wbc_intro_cta', 'wbc_intro_image_alt', 'wbc_portfolio_kicker',
        'wbc_services_kicker', 'wbc_dest_kicker',
        'wbc_stat_1_value', 'wbc_stat_1_label', 'wbc_stat_2_value', 'wbc_stat_2_label',
        'wbc_stat_3_value', 'wbc_stat_3_label', 'wbc_stat_4_value', 'wbc_stat_4_label',
        'wbc_process_kicker', 'wbc_editorial_kicker', 'wbc_cta_kicker', 'wbc_faq_kicker', 'wbc_kind_media_type',
        'wbc_kind_kicker', 'wbc_kind_cite',
        'wbc_process_media_type', 'wbc_editorial_media_type', 'wbc_cta_media_type',
        'wbc_about_kicker', 'wbc_about_cta', 'wbc_visit_kicker', 'wbc_pillars_kicker',
        'wbc_journal_kicker', 'wbc_journal_cta',
        'wbc_services_page_kicker', 'wbc_services_page_cta',
        'wbc_weddings_page_kicker', 'wbc_weddings_page_cta',
        'wbc_pillar_1_title', 'wbc_pillar_2_title', 'wbc_pillar_3_title', 'wbc_pillar_4_title',
        'wbc_email', 'wbc_form_kicker', 'wbc_form_button', 'wbc_form_subject',
        'wbc_footer_mark', 'wbc_founding_year',
        'wbc_form_name_label', 'wbc_form_name_placeholder',
        'wbc_form_email_label', 'wbc_form_email_placeholder', 'wbc_form_email_show',
        'wbc_form_phone_label', 'wbc_form_phone_placeholder', 'wbc_form_phone_show',
        'wbc_form_date_label', 'wbc_form_date_placeholder', 'wbc_form_date_show',
        'wbc_form_city_label', 'wbc_form_city_placeholder', 'wbc_form_city_show',
        'wbc_form_guests_label', 'wbc_form_guests_placeholder', 'wbc_form_guests_show',
        'wbc_form_budget_label', 'wbc_form_budget_placeholder', 'wbc_form_budget_show',
        'wbc_form_message_label', 'wbc_form_message_placeholder', 'wbc_form_message_show',
    );
    $long = array(
        'wbc_page_headline', 'wbc_page_intro', 'wbc_hero_title', 'wbc_hero_text', 'wbc_intro_title', 'wbc_intro_text',
        'wbc_services_title', 'wbc_dest_title',
        'wbc_portfolio_title', 'wbc_process_title', 'wbc_process_text', 'wbc_editorial_title',
        'wbc_editorial_text', 'wbc_faq_title', 'wbc_cta_title', 'wbc_cta_text', 'wbc_about_title', 'wbc_about_text',
        'wbc_founder_kicker', 'wbc_founder_title', 'wbc_founder_bio', 'wbc_kind_quote',
        'wbc_visit_title', 'wbc_pillars_title',
        'wbc_journal_title', 'wbc_journal_text',
        'wbc_services_page_title', 'wbc_services_page_text',
        'wbc_weddings_page_title', 'wbc_weddings_page_text',
        'wbc_pillar_1_text', 'wbc_pillar_2_text', 'wbc_pillar_3_text', 'wbc_pillar_4_text',
        'wbc_form_success', 'wbc_form_error',
    );
    $urls = array(
        'wbc_cover_image', 'wbc_cover_video', 'wbc_kind_image', 'wbc_kind_video',
        'wbc_process_image', 'wbc_process_video', 'wbc_editorial_image', 'wbc_editorial_video',
        'wbc_cta_image', 'wbc_cta_video', 'wbc_founder_image', 'wbc_about_image',
        'wbc_journal_image', 'wbc_services_page_image', 'wbc_weddings_page_image',
        'wbc_intro_image', 'wbc_intro_cta_url',
        'wbc_faq_image', 'wbc_footer_logo', 'wbc_footer_image_1', 'wbc_footer_image_2', 'wbc_footer_image_3', 'wbc_footer_image_4', 'wbc_footer_image_5',
        'wbc_pinterest', 'wbc_facebook', 'wbc_instagram', 'wbc_tiktok',
    );

    foreach ($text as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_text_field(wp_unslash($_POST[$key])));
        }
    }
    foreach ($long as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_textarea_field(wp_unslash($_POST[$key])));
        }
    }
    foreach ($urls as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, esc_url_raw(wp_unslash($_POST[$key])));
        }
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'page') {
        return;
    }

    $sync = array();
    if (wbc_is_front_edit($post)) {
        $cover_image = wbc_meta($post_id, 'wbc_cover_image');
        $cover_video = wbc_meta($post_id, 'wbc_cover_video');
        $cover_type  = wbc_meta($post_id, 'wbc_cover_media_type');
        if ($cover_image) {
            $sync['wbc_hero_image'] = $cover_image;
        }
        if ($cover_video) {
            $sync['wbc_hero_video'] = $cover_video;
        }
        if ($cover_type) {
            $sync['wbc_hero_media_type'] = $cover_type;
        }
        $sync_keys = array_merge($text, $long, $urls);
        foreach ($sync_keys as $key) {
            if (in_array($key, array('wbc_cover_image', 'wbc_cover_video', 'wbc_cover_media_type', 'wbc_page_kicker', 'wbc_page_headline', 'wbc_page_intro'), true)) {
                continue;
            }
            if (isset($_POST[$key])) {
                $raw = wp_unslash($_POST[$key]);
                $sync[$key] = in_array($key, $urls, true) ? esc_url_raw($raw) : (in_array($key, $long, true) ? sanitize_textarea_field($raw) : sanitize_text_field($raw));
            }
        }
    }
    if (wbc_is_about_edit($post)) {
        $about_keys = array(
            'wbc_about_kicker', 'wbc_about_title', 'wbc_about_text', 'wbc_about_cta', 'wbc_about_image',
            'wbc_founder_image', 'wbc_founder_kicker', 'wbc_founder_title', 'wbc_founder_bio',
            'wbc_visit_kicker', 'wbc_visit_title', 'wbc_pillars_kicker', 'wbc_pillars_title',
            'wbc_pillar_1_title', 'wbc_pillar_1_text', 'wbc_pillar_2_title', 'wbc_pillar_2_text',
            'wbc_pillar_3_title', 'wbc_pillar_3_text', 'wbc_pillar_4_title', 'wbc_pillar_4_text',
        );
        foreach ($about_keys as $key) {
            if (isset($_POST[$key])) {
                $raw = wp_unslash($_POST[$key]);
                $sync[$key] = strpos($key, 'image') !== false ? esc_url_raw($raw) : sanitize_textarea_field($raw);
            }
        }
    }
    if (wbc_is_journal_edit($post)) {
        foreach (array('wbc_journal_kicker', 'wbc_journal_title', 'wbc_journal_text', 'wbc_journal_cta', 'wbc_journal_image') as $key) {
            if (isset($_POST[$key])) {
                $raw = wp_unslash($_POST[$key]);
                $sync[$key] = strpos($key, 'image') !== false ? esc_url_raw($raw) : sanitize_textarea_field($raw);
            }
        }
    }
    if (wbc_is_contact_edit($post)) {
        $contact_keys = array(
            'wbc_cta_kicker', 'wbc_cta_title', 'wbc_cta_text', 'wbc_cta_image', 'wbc_cta_video', 'wbc_cta_media_type',
            'wbc_email', 'wbc_form_kicker', 'wbc_form_button', 'wbc_form_subject', 'wbc_form_success', 'wbc_form_error',
            'wbc_form_name_label', 'wbc_form_name_placeholder',
            'wbc_form_email_label', 'wbc_form_email_placeholder', 'wbc_form_email_show',
            'wbc_form_phone_label', 'wbc_form_phone_placeholder', 'wbc_form_phone_show',
            'wbc_form_date_label', 'wbc_form_date_placeholder', 'wbc_form_date_show',
            'wbc_form_city_label', 'wbc_form_city_placeholder', 'wbc_form_city_show',
            'wbc_form_guests_label', 'wbc_form_guests_placeholder', 'wbc_form_guests_show',
            'wbc_form_budget_label', 'wbc_form_budget_placeholder', 'wbc_form_budget_show',
            'wbc_form_message_label', 'wbc_form_message_placeholder', 'wbc_form_message_show',
        );
        foreach ($contact_keys as $key) {
            if (isset($_POST[$key])) {
                $raw = wp_unslash($_POST[$key]);
                if (strpos($key, 'image') !== false || strpos($key, 'video') !== false) {
                    $sync[$key] = esc_url_raw($raw);
                } elseif ($key === 'wbc_email') {
                    $sync[$key] = sanitize_email($raw);
                } else {
                    $sync[$key] = sanitize_textarea_field($raw);
                }
            }
        }
    }

    foreach ($sync as $key => $value) {
        if ($value !== '' || in_array($key, array('wbc_footer_logo', 'wbc_intro_image', 'wbc_intro_cta_url', 'wbc_faq_image'), true)) {
            set_theme_mod($key, $value);
        }
    }

    if ($post && wbc_is_front_edit($post)) {
        $intro_icons = isset($_POST['wbc_intro_icon']) ? (array) wp_unslash($_POST['wbc_intro_icon']) : array();
        $intro_urls = isset($_POST['wbc_intro_icon_url']) ? (array) wp_unslash($_POST['wbc_intro_icon_url']) : array();
        $intro_labels = isset($_POST['wbc_intro_icon_label']) ? (array) wp_unslash($_POST['wbc_intro_icon_label']) : array();
        $intro_kinds = isset($_POST['wbc_intro_icon_kind']) ? (array) wp_unslash($_POST['wbc_intro_icon_kind']) : array();
        $saved_intro = array();
        $intro_count = max(count($intro_icons), count($intro_urls), count($intro_labels), count($intro_kinds));
        for ($i = 0; $i < $intro_count; $i++) {
            $icon = isset($intro_icons[$i]) ? esc_url_raw($intro_icons[$i]) : '';
            $url = isset($intro_urls[$i]) ? esc_url_raw($intro_urls[$i]) : '';
            $label = isset($intro_labels[$i]) ? sanitize_text_field($intro_labels[$i]) : '';
            $kind = isset($intro_kinds[$i]) ? sanitize_key($intro_kinds[$i]) : '';
            if ($icon === '' && $url === '' && $label === '') {
                continue;
            }
            $saved_intro[] = array(
                'icon'  => $icon,
                'url'   => $url,
                'label' => $label,
                'kind'  => $kind,
            );
        }
        set_theme_mod('wbc_intro_icons', $saved_intro);
        update_post_meta($post_id, 'wbc_intro_icons', wp_json_encode($saved_intro));

        $icons = isset($_POST['wbc_footer_link_icon']) ? (array) wp_unslash($_POST['wbc_footer_link_icon']) : array();
        $urls = isset($_POST['wbc_footer_link_url']) ? (array) wp_unslash($_POST['wbc_footer_link_url']) : array();
        $labels = isset($_POST['wbc_footer_link_label']) ? (array) wp_unslash($_POST['wbc_footer_link_label']) : array();
        $links = array();
        $count = max(count($icons), count($urls), count($labels));
        for ($i = 0; $i < $count; $i++) {
            $icon = isset($icons[$i]) ? esc_url_raw($icons[$i]) : '';
            $url = isset($urls[$i]) ? esc_url_raw($urls[$i]) : '';
            $label = isset($labels[$i]) ? sanitize_text_field($labels[$i]) : '';
            if ($icon === '' && $url === '') {
                continue;
            }
            $links[] = array(
                'icon'  => $icon,
                'url'   => $url,
                'label' => $label,
            );
        }
        set_theme_mod('wbc_footer_links', $links);
        update_post_meta($post_id, 'wbc_footer_links', wp_json_encode($links));
    }
}
add_action('save_post', 'wbc_save_editor_fields', 20);

function wbc_listing_slots() {
    return array(
        'services' => array(
            'parent' => 'edit.php?post_type=wbc_service',
            'slug'   => 'wbc-services-listing',
            'title'  => __('Services listing', 'weddingsbychetanparihar'),
            'lead'   => 'The opening of the Services page. Service cards come from Services.',
        ),
        'weddings' => array(
            'parent' => 'edit.php?post_type=wbc_wedding',
            'slug'   => 'wbc-weddings-listing',
            'title'  => __('Weddings listing', 'weddingsbychetanparihar'),
            'lead'   => 'The opening of Real Weddings. Individual stories come from Weddings.',
        ),
    );
}

function wbc_register_listing_pages() {
    foreach (wbc_listing_slots() as $slot) {
        add_submenu_page(
            $slot['parent'],
            $slot['title'],
            __('Listing page', 'weddingsbychetanparihar'),
            'edit_theme_options',
            $slot['slug'],
            'wbc_render_listing_page'
        );
    }
}
add_action('admin_menu', 'wbc_register_listing_pages');

function wbc_current_listing_slot() {
    $page = isset($_GET['page']) ? sanitize_key(wp_unslash($_GET['page'])) : '';
    foreach (wbc_listing_slots() as $slot => $info) {
        if ($info['slug'] === $page) {
            return $slot;
        }
    }
    return '';
}

function wbc_render_listing_page() {
    if (!current_user_can('edit_theme_options')) {
        return;
    }
    $slot = wbc_current_listing_slot();
    $info = $slot ? wbc_listing_slots()[$slot] : null;
    if (!$info) {
        return;
    }
    if (!empty($_GET['updated'])) {
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Listing page saved.', 'weddingsbychetanparihar') . '</p></div>';
    }
    echo '<div class="wrap wbc-listing-admin">';
    echo '<h1>' . esc_html($info['title']) . '</h1>';
    echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
    echo '<input type="hidden" name="action" value="wbc_save_listing">';
    echo '<input type="hidden" name="wbc_listing_slot" value="' . esc_attr($slot) . '">';
    wp_nonce_field('wbc_save_listing', 'wbc_listing_nonce');
    echo '<div class="postbox" style="margin-top:16px;max-width:1100px"><div class="inside">';
    echo '<p class="wbc-admin-lead">' . esc_html($info['lead']) . '</p>';
    echo '<div class="wbc-admin-cols"><div>';
    wbc_admin_field_text(0, wbc_listing_key($slot, 'kicker'), 'Small label');
    wbc_admin_field_text(0, wbc_listing_key($slot, 'title'), 'Title', 'textarea');
    wbc_admin_field_text(0, wbc_listing_key($slot, 'text'), 'Text', 'textarea');
    wbc_admin_field_text(0, wbc_listing_key($slot, 'cta'), 'Button label');
    echo '</div><div>';
    wbc_admin_field_media(0, wbc_listing_key($slot, 'image'), 'Photo', 'image');
    echo '</div></div>';
    echo '<p><button type="submit" class="button button-primary">' . esc_html__('Save listing page', 'weddingsbychetanparihar') . '</button></p>';
    echo '</div></div></form></div>';
}

function wbc_save_listing_page() {
    if (!current_user_can('edit_theme_options')) {
        wp_die(esc_html__('You cannot edit this listing page.', 'weddingsbychetanparihar'));
    }
    check_admin_referer('wbc_save_listing', 'wbc_listing_nonce');
    $slot = isset($_POST['wbc_listing_slot']) ? sanitize_key(wp_unslash($_POST['wbc_listing_slot'])) : '';
    $info = $slot && isset(wbc_listing_slots()[$slot]) ? wbc_listing_slots()[$slot] : null;
    if (!$info) {
        wp_safe_redirect(admin_url());
        exit;
    }
    foreach (array('kicker', 'title', 'text', 'cta', 'image') as $field) {
        $key = wbc_listing_key($slot, $field);
        if (!isset($_POST[$key])) {
            continue;
        }
        $raw = wp_unslash($_POST[$key]);
        $value = $field === 'image' ? esc_url_raw($raw) : sanitize_textarea_field($raw);
        set_theme_mod($key, $value);
    }
    wp_safe_redirect(add_query_arg(array('page' => $info['slug'], 'updated' => '1'), admin_url($info['parent'])));
    exit;
}
add_action('admin_post_wbc_save_listing', 'wbc_save_listing_page');

function wbc_entry_cover($post_id = 0, $fallback = 'hero') {
    $post_id = $post_id ?: get_the_ID();
    $cover = wbc_meta($post_id, 'wbc_cover_image');
    if ($cover) {
        return $cover;
    }
    $thumb = $post_id ? get_the_post_thumbnail_url($post_id, 'full') : '';
    if ($thumb) {
        return $thumb;
    }
    if ($fallback === 'about') {
        return wbc_mod('wbc_about_image', wbc_default_image('about'));
    }
    return wbc_image_url($post_id, $fallback);
}

function wbc_entry_video($post_id = 0) {
    $post_id = $post_id ?: get_the_ID();
    return wbc_meta($post_id, 'wbc_cover_video');
}

function wbc_entry_uses_video($post_id = 0) {
    $post_id = $post_id ?: get_the_ID();
    return wbc_meta($post_id, 'wbc_cover_media_type', 'photo') === 'video' && wbc_entry_video($post_id);
}

function wbc_render_entry_media($post_id, $args = array()) {
    $args = wp_parse_args($args, array(
        'alt'      => get_the_title($post_id),
        'fallback' => 'hero',
        'eager'    => false,
    ));
    $image = wbc_entry_cover($post_id, $args['fallback']);
    $video = wbc_entry_video($post_id);
    $youtube = wbc_youtube_id($video);
    $vimeo = wbc_vimeo_id($video);

    if (wbc_entry_uses_video($post_id)) {
        if ($youtube) {
            $src = 'https://www.youtube-nocookie.com/embed/' . rawurlencode($youtube) . '?autoplay=1&mute=1&loop=1&controls=0&playsinline=1&rel=0&modestbranding=1&playlist=' . rawurlencode($youtube);
            echo '<iframe class="wbc-band-embed" src="' . esc_url($src) . '" title="' . esc_attr($args['alt']) . '" allow="autoplay; encrypted-media" allowfullscreen tabindex="-1"></iframe>';
            return;
        }
        if ($vimeo) {
            $src = 'https://player.vimeo.com/video/' . rawurlencode($vimeo) . '?background=1&autoplay=1&muted=1&loop=1';
            echo '<iframe class="wbc-band-embed" src="' . esc_url($src) . '" title="' . esc_attr($args['alt']) . '" allow="autoplay; fullscreen" allowfullscreen tabindex="-1"></iframe>';
            return;
        }
        echo '<video autoplay muted loop playsinline poster="' . esc_url($image) . '"><source src="' . esc_url($video) . '"></video>';
        return;
    }

    $eager = $args['eager'] ? ' fetchpriority="high"' : ' loading="lazy"';
    echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($args['alt']) . '"' . $eager . ' decoding="async">';
}

function wbc_entry_kicker($post_id, $default = '') {
    return wbc_meta($post_id, 'wbc_page_kicker', $default);
}

function wbc_entry_headline($post_id, $default = '') {
    $headline = wbc_meta($post_id, 'wbc_page_headline');
    return $headline !== '' ? $headline : ($default !== '' ? $default : get_the_title($post_id));
}

function wbc_entry_intro($post_id, $default = '') {
    return wbc_meta($post_id, 'wbc_page_intro', $default);
}

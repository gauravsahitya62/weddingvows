<?php
/**
 * Admin-managed content: CPTs, taxonomies, meta, Customizer, leads.
 */

if (!defined('ABSPATH')) {
    exit;
}

function wbc_register_post_types() {
    $public_supports = array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions', 'custom-fields');

    register_post_type('wbc_wedding', array(
        'labels' => array(
            'name' => __('Weddings', 'weddingsbychetanparihar'),
            'singular_name' => __('Wedding', 'weddingsbychetanparihar'),
            'add_new_item' => __('Add New Wedding', 'weddingsbychetanparihar'),
        ),
        'public' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-heart',
        'has_archive' => 'weddings',
        'rewrite' => array('slug' => 'weddings'),
        'supports' => $public_supports,
    ));

    register_post_type('wbc_service', array(
        'labels' => array(
            'name' => __('Services', 'weddingsbychetanparihar'),
            'singular_name' => __('Service', 'weddingsbychetanparihar'),
        ),
        'public' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-star-filled',
        'has_archive' => 'services',
        'rewrite' => array('slug' => 'services'),
        'supports' => $public_supports,
    ));

    register_post_type('wbc_destination', array(
        'labels' => array(
            'name' => __('Destinations', 'weddingsbychetanparihar'),
            'singular_name' => __('Destination', 'weddingsbychetanparihar'),
        ),
        'public' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-location-alt',
        'has_archive' => 'destinations',
        'rewrite' => array('slug' => 'destinations'),
        'supports' => $public_supports,
    ));

    register_post_type('wbc_process', array(
        'labels' => array(
            'name' => __('Process Steps', 'weddingsbychetanparihar'),
            'singular_name' => __('Process Step', 'weddingsbychetanparihar'),
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-editor-ol',
        'supports' => array('title', 'editor', 'page-attributes', 'revisions'),
    ));

    register_post_type('wbc_press', array(
        'labels' => array(
            'name' => __('Press & Awards', 'weddingsbychetanparihar'),
            'singular_name' => __('Press Item', 'weddingsbychetanparihar'),
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-awards',
        'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'revisions'),
    ));

    register_post_type('wbc_testimonial', array(
        'labels' => array(
            'name' => __('Testimonials', 'weddingsbychetanparihar'),
            'singular_name' => __('Testimonial', 'weddingsbychetanparihar'),
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => array('title', 'editor', 'page-attributes', 'revisions'),
    ));

    register_post_type('wbc_faq', array(
        'labels' => array(
            'name' => __('FAQs', 'weddingsbychetanparihar'),
            'singular_name' => __('FAQ', 'weddingsbychetanparihar'),
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-editor-help',
        'supports' => array('title', 'editor', 'page-attributes', 'revisions'),
    ));

    register_post_type('wbc_lead', array(
        'labels' => array(
            'name' => __('Contact Leads', 'weddingsbychetanparihar'),
            'singular_name' => __('Contact Lead', 'weddingsbychetanparihar'),
            'add_new_item' => __('Add Lead', 'weddingsbychetanparihar'),
            'edit_item' => __('Enquiry', 'weddingsbychetanparihar'),
            'search_items' => __('Search enquiries', 'weddingsbychetanparihar'),
            'not_found' => __('No enquiries yet.', 'weddingsbychetanparihar'),
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-email-alt2',
        'capability_type' => 'post',
        'supports' => array('title'),
    ));
}
add_action('init', 'wbc_register_post_types', 5);

function wbc_register_taxonomies() {
    register_taxonomy('wbc_style', array('wbc_wedding'), array(
        'labels' => array(
            'name' => __('Wedding Styles', 'weddingsbychetanparihar'),
            'singular_name' => __('Style', 'weddingsbychetanparihar'),
        ),
        'public' => true,
        'show_in_rest' => true,
        'hierarchical' => false,
        'rewrite' => array('slug' => 'style'),
    ));
}
add_action('init', 'wbc_register_taxonomies', 6);

function wbc_meta_boxes() {
    $seo_types = array('post', 'page', 'wbc_wedding', 'wbc_service', 'wbc_destination');
    foreach ($seo_types as $type) {
        add_meta_box('wbc_seo_box', __('SEO / AEO', 'weddingsbychetanparihar'), 'wbc_seo_box', $type, 'normal', 'high');
    }
    add_meta_box('wbc_wedding_details', __('Wedding Details', 'weddingsbychetanparihar'), 'wbc_wedding_details_box', 'wbc_wedding', 'normal', 'high');
    add_meta_box('wbc_service_details', __('Service Details', 'weddingsbychetanparihar'), 'wbc_service_details_box', 'wbc_service', 'side');
    add_meta_box('wbc_destination_details', __('Destination GEO', 'weddingsbychetanparihar'), 'wbc_destination_details_box', 'wbc_destination', 'normal', 'high');
    add_meta_box('wbc_process_details', __('Step Label', 'weddingsbychetanparihar'), 'wbc_process_details_box', 'wbc_process', 'side');
    add_meta_box('wbc_press_details', __('Publication', 'weddingsbychetanparihar'), 'wbc_press_details_box', 'wbc_press', 'side');
    add_meta_box('wbc_testimonial_details', __('Review Details', 'weddingsbychetanparihar'), 'wbc_testimonial_details_box', 'wbc_testimonial', 'side');
    add_meta_box('wbc_lead_details', __('Lead Details', 'weddingsbychetanparihar'), 'wbc_lead_details_box', 'wbc_lead', 'normal', 'high');
}
add_action('add_meta_boxes', 'wbc_meta_boxes');

function wbc_remove_moved_boxes() {
    remove_meta_box('wbc_wedding_details', 'wbc_wedding', 'normal');
    remove_meta_box('wbc_service_details', 'wbc_service', 'side');
}
add_action('add_meta_boxes', 'wbc_remove_moved_boxes', 20);

function wbc_field($post_id, $key, $label, $type = 'text', $help = '') {
    $value = wbc_meta($post_id, $key);
    echo '<p class="wbc-admin-field"><label for="' . esc_attr($key) . '"><strong>' . esc_html($label) . '</strong></label>';
    if ($type === 'textarea') {
        echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="4" class="widefat">' . esc_textarea($value) . '</textarea>';
    } else {
        echo '<input id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" type="' . esc_attr($type) . '" value="' . esc_attr($value) . '" class="widefat">';
    }
    if ($help) {
        echo '<span class="description">' . esc_html($help) . '</span>';
    }
    echo '</p>';
}

function wbc_seo_box($post) {
    wp_nonce_field('wbc_save_meta', 'wbc_meta_nonce');
    wbc_field($post->ID, 'wbc_seo_title', 'SEO title', 'text', 'Leave blank to use the automatic title. Keep under 60 characters.');
    wbc_field($post->ID, 'wbc_seo_description', 'Meta description', 'textarea', 'The sentence search results should show. 140–160 characters.');
    wbc_field($post->ID, 'wbc_seo_answer', 'Direct answer (AEO / GEO)', 'textarea', 'One sentence an answer engine or AI assistant can quote.');
    wbc_field($post->ID, 'wbc_seo_focus', 'Focus topic', 'text', 'e.g. Udaipur destination wedding planner');
    wbc_field($post->ID, 'wbc_seo_image', 'Share image URL', 'url', 'Optional. Overrides the featured image for Google, WhatsApp and social shares.');
    $noindex = wbc_meta($post->ID, 'wbc_seo_noindex') === '1';
    echo '<p class="wbc-admin-field"><label><input name="wbc_seo_noindex" type="checkbox" value="1"' . checked($noindex, true, false) . '> Hide this page from search and sitemaps</label></p>';
}

function wbc_wedding_details_box($post) {
    wp_nonce_field('wbc_save_meta', 'wbc_meta_nonce');
    wbc_field($post->ID, 'wbc_couple', 'Couple names');
    wbc_field($post->ID, 'wbc_venue', 'Venue');
    wbc_field($post->ID, 'wbc_location', 'City / location');
    wbc_field($post->ID, 'wbc_season', 'Season or month');
    wbc_field($post->ID, 'wbc_guest_count', 'Guest count');
    wbc_field($post->ID, 'wbc_style', 'Style label', 'text', 'Palace, Heritage, Coastal, Intimate…');
    wbc_field($post->ID, 'wbc_video_url', 'Film / reel URL', 'url');
    echo '<p class="wbc-admin-field"><label><strong>Gallery</strong></label>';
    echo '<input id="wbc_gallery_ids" name="wbc_gallery_ids" type="text" value="' . esc_attr(wbc_meta($post->ID, 'wbc_gallery_ids')) . '" class="widefat">';
    echo '<button type="button" class="button" data-wbc-gallery>Select images</button>';
    echo '<span class="description">Featured image is the cover. Gallery IDs are stored automatically.</span></p>';
    wbc_field($post->ID, 'wbc_planner_note', 'Planning note', 'textarea');
}

function wbc_service_details_box($post) {
    wp_nonce_field('wbc_save_meta', 'wbc_meta_nonce');
    wbc_field($post->ID, 'wbc_service_kicker', 'Small label');
}

function wbc_destination_details_box($post) {
    wp_nonce_field('wbc_save_meta', 'wbc_meta_nonce');
    wbc_field($post->ID, 'wbc_region', 'Region / country');
    wbc_field($post->ID, 'wbc_best_season', 'Best wedding season');
    wbc_field($post->ID, 'wbc_venue_types', 'Venue types');
    wbc_field($post->ID, 'wbc_latitude', 'Latitude', 'text', 'Used for GEO schema.');
    wbc_field($post->ID, 'wbc_longitude', 'Longitude');
}

function wbc_process_details_box($post) {
    wp_nonce_field('wbc_save_meta', 'wbc_meta_nonce');
    wbc_field($post->ID, 'wbc_step_label', 'Step label', 'text', 'ONE, TWO, 01…');
}

function wbc_press_details_box($post) {
    wp_nonce_field('wbc_save_meta', 'wbc_meta_nonce');
    wbc_field($post->ID, 'wbc_publication', 'Publication');
    wbc_field($post->ID, 'wbc_year', 'Year');
    wbc_field($post->ID, 'wbc_press_url', 'Article URL', 'url');
}

function wbc_testimonial_details_box($post) {
    wp_nonce_field('wbc_save_meta', 'wbc_meta_nonce');
    wbc_field($post->ID, 'wbc_rating', 'Rating (1–5)', 'number');
    wbc_field($post->ID, 'wbc_event', 'Wedding / event');
}

function wbc_lead_details_box($post) {
    wp_nonce_field('wbc_save_lead', 'wbc_lead_nonce');
    $rows = array(
        'name'    => 'Name',
        'email'   => 'Email',
        'phone'   => 'Phone',
        'date'    => 'Wedding date',
        'city'    => 'City / destination',
        'guests'  => 'Guest count',
        'budget'  => 'Budget',
        'message' => 'Message',
    );
    echo '<div class="wbc-lead-view">';
    foreach ($rows as $key => $label) {
        $value = $key === 'message' ? $post->post_content : wbc_meta($post->ID, $key);
        if ($key === 'name' && $value === '') {
            $value = get_the_title($post);
        }
        echo '<p><strong>' . esc_html($label) . '</strong><span>' . ($value !== '' ? nl2br(esc_html($value)) : '—') . '</span></p>';
    }
    echo '</div>';
    $status = wbc_meta($post->ID, 'wbc_lead_status', 'new');
    echo '<p class="wbc-admin-field"><label for="wbc_lead_status"><strong>Status</strong></label>';
    echo '<select id="wbc_lead_status" name="wbc_lead_status">';
    foreach (array('new' => 'New', 'open' => 'In progress', 'done' => 'Closed') as $value => $label) {
        echo '<option value="' . esc_attr($value) . '"' . selected($status, $value, false) . '>' . esc_html($label) . '</option>';
    }
    echo '</select></p>';
    echo '<p class="wbc-admin-field"><label for="wbc_lead_note"><strong>Studio note</strong></label>';
    echo '<textarea id="wbc_lead_note" name="wbc_lead_note" rows="4" class="widefat">' . esc_textarea(wbc_meta($post->ID, 'wbc_lead_note')) . '</textarea></p>';
}

function wbc_save_post_meta($post_id) {
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
        'wbc_seo_title', 'wbc_seo_focus', 'wbc_couple', 'wbc_venue', 'wbc_location', 'wbc_season', 'wbc_guest_count',
        'wbc_style', 'wbc_gallery_ids', 'wbc_service_kicker', 'wbc_region', 'wbc_best_season',
        'wbc_venue_types', 'wbc_latitude', 'wbc_longitude', 'wbc_step_label', 'wbc_publication',
        'wbc_year', 'wbc_rating', 'wbc_event',
    );
    $long = array('wbc_seo_description', 'wbc_seo_answer', 'wbc_planner_note');
    $urls = array('wbc_video_url', 'wbc_press_url', 'wbc_seo_image');

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
    if (isset($_POST['wbc_meta_nonce'])) {
        update_post_meta($post_id, 'wbc_seo_noindex', isset($_POST['wbc_seo_noindex']) ? '1' : '');
    }
}
add_action('save_post', 'wbc_save_post_meta');

function wbc_admin_assets($hook) {
    $listing = in_array($hook, array(
        'wbc_service_page_wbc-services-listing',
        'wbc_wedding_page_wbc-weddings-listing',
    ), true);
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    $leads = $screen && $screen->post_type === 'wbc_lead';
    if (!in_array($hook, array('post.php', 'post-new.php'), true) && !$listing && !$leads) {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_style('wbc-admin', WBC_THEME_URI . '/assets/css/admin.css', array(), WBC_THEME_VERSION);
    wp_enqueue_script('wbc-admin', WBC_THEME_URI . '/assets/js/admin.js', array('jquery'), WBC_THEME_VERSION, true);
}
add_action('admin_enqueue_scripts', 'wbc_admin_assets');

function wbc_lead_columns($columns) {
    unset($columns['date']);
    $columns['email'] = 'Email';
    $columns['phone'] = 'Phone';
    $columns['city'] = 'City';
    $columns['date_wanted'] = 'Wedding date';
    $columns['status'] = 'Status';
    $columns['received'] = 'Received';
    return $columns;
}
add_filter('manage_wbc_lead_posts_columns', 'wbc_lead_columns');

function wbc_lead_column_content($column, $post_id) {
    if ($column === 'status') {
        $labels = array('new' => 'New', 'open' => 'In progress', 'done' => 'Closed');
        $status = wbc_meta($post_id, 'wbc_lead_status', 'new');
        echo esc_html($labels[$status] ?? 'New');
        return;
    }
    if ($column === 'received') {
        echo esc_html(get_the_date('Y-m-d H:i', $post_id));
        return;
    }
    $map = array('email' => 'email', 'phone' => 'phone', 'city' => 'city', 'date_wanted' => 'date');
    if (isset($map[$column])) {
        echo esc_html(wbc_meta($post_id, $map[$column]));
    }
}
add_action('manage_wbc_lead_posts_custom_column', 'wbc_lead_column_content', 10, 2);

function wbc_save_lead_meta($post_id) {
    if (!isset($_POST['wbc_lead_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['wbc_lead_nonce'])), 'wbc_save_lead')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    $status = isset($_POST['wbc_lead_status']) ? sanitize_key(wp_unslash($_POST['wbc_lead_status'])) : 'new';
    if (!in_array($status, array('new', 'open', 'done'), true)) {
        $status = 'new';
    }
    update_post_meta($post_id, 'wbc_lead_status', $status);
    if (isset($_POST['wbc_lead_note'])) {
        update_post_meta($post_id, 'wbc_lead_note', sanitize_textarea_field(wp_unslash($_POST['wbc_lead_note'])));
    }
}
add_action('save_post_wbc_lead', 'wbc_save_lead_meta');

function wbc_lead_admin_menu() {
    $page = wbc_contact_page_id();
    if ($page) {
        add_submenu_page(
            'edit.php?post_type=wbc_lead',
            __('Form & email', 'weddingsbychetanparihar'),
            __('Form & email', 'weddingsbychetanparihar'),
            'edit_pages',
            'wbc-contact-form',
            '__return_null'
        );
    }
    remove_submenu_page('edit.php?post_type=wbc_lead', 'post-new.php?post_type=wbc_lead');
}
add_action('admin_menu', 'wbc_lead_admin_menu', 20);

function wbc_lead_form_settings_redirect() {
    if (!isset($_GET['page']) || $_GET['page'] !== 'wbc-contact-form') {
        return;
    }
    $page = wbc_contact_page_id();
    if ($page) {
        wp_safe_redirect(admin_url('post.php?post=' . $page . '&action=edit'));
        exit;
    }
}
add_action('admin_init', 'wbc_lead_form_settings_redirect');

function wbc_lead_list_notice() {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen || $screen->id !== 'edit-wbc_lead') {
        return;
    }
    $page = wbc_contact_page_id();
    $to = wbc_studio_email();
    echo '<div class="notice notice-info"><p>Enquiries from the contact form are listed here. They are also emailed to <strong>' . esc_html($to) . '</strong>.';
    if ($page) {
        echo ' <a href="' . esc_url(admin_url('post.php?post=' . $page . '&action=edit')) . '">Edit the form and recipient email</a>.';
    }
    echo '</p></div>';
}
add_action('admin_notices', 'wbc_lead_list_notice');

function wbc_lead_row_actions($actions, $post) {
    if ($post->post_type !== 'wbc_lead') {
        return $actions;
    }
    unset($actions['inline hide-if-no-js']);
    return $actions;
}
add_filter('post_row_actions', 'wbc_lead_row_actions', 10, 2);

function wbc_customize_register($wp_customize) {
    $wp_customize->add_panel('wbc_panel', array(
        'title' => __('Chetan Parihar Weddings', 'weddingsbychetanparihar'),
        'priority' => 20,
    ));

    $sections = array(
        'wbc_brand'   => 'Brand & Contact',
        'wbc_founder' => 'Founder / About',
        'wbc_home'    => 'Homepage copy',
        'wbc_media'   => 'Hero & parallax media',
        'wbc_stats'   => 'Trust stats',
        'wbc_social'  => 'Social & directories',
        'wbc_seo'     => 'SEO / AEO / GEO profile',
    );
    foreach ($sections as $id => $title) {
        $wp_customize->add_section($id, array('title' => __($title, 'weddingsbychetanparihar'), 'panel' => 'wbc_panel'));
    }

    $fields = array(
        'wbc_brand' => array(
            'wbc_brand_name' => array('Brand name', 'Chetan Parihar Weddings', 'text'),
            'wbc_tagline' => array('Tagline', 'Destination wedding planning and celebration design from Udaipur.', 'text'),
            'wbc_phone' => array('Phone', '+91 76667 78899', 'text'),
            'wbc_email' => array('Email', 'hello@chetanpariharweddings.com', 'text'),
            'wbc_street' => array('Street address', '31, New Polo Ground, Saheli Nagar', 'text'),
            'wbc_city' => array('City', 'Udaipur', 'text'),
            'wbc_state' => array('State', 'Rajasthan', 'text'),
            'wbc_postcode' => array('Postcode', '313001', 'text'),
            'wbc_country' => array('Country', 'India', 'text'),
            'wbc_whatsapp_url' => array('WhatsApp URL', '', 'url'),
            'wbc_hours' => array('Opening hours', 'Mo-Sa 10:00-19:00', 'text'),
        ),
        'wbc_founder' => array(
            'wbc_founder_name' => array('Founder name', 'Chetan Parihar', 'text'),
            'wbc_founder_title' => array('Founder title', 'Founder & principal planner', 'text'),
            'wbc_founder_kicker' => array('Planner kicker', 'Weddings are planned by people, not companies.', 'text'),
            'wbc_founder_bio' => array('Founder bio', 'Chetan Parihar leads a Udaipur-based studio that plans destination weddings with a design-first eye and a calm ground team. From the first venue walk to the last farewell, one conversation holds the weekend.', 'textarea'),
            'wbc_about_title' => array('About page title', 'A Udaipur studio for destination weddings that feel personal.', 'textarea'),
            'wbc_about_text' => array('About page text', 'Chetan Parihar Weddings specialises in destination weddings, corporate celebrations and event styling. Decor and design sit at the centre; planning, hospitality and vendors follow so families are never stitching twelve conversations together.', 'textarea'),
        ),
        'wbc_home' => array(
            'wbc_hero_line' => array('Hero line over image', 'We work behind the scenes, because your wedding deserves to be planned beautifully.', 'textarea'),
            'wbc_intro_kicker' => array('Intro kicker', 'Our Services', 'text'),
            'wbc_intro_title' => array('Intro title', 'The Art of the Celebration', 'textarea'),
            'wbc_intro_text' => array('Intro text', 'Full-service wedding planning and design for extraordinary people and unforgettable moments.', 'textarea'),
            'wbc_intro_cta' => array('Intro button', 'Explore Services', 'text'),
            'wbc_portfolio_kicker' => array('Portfolio kicker', 'The work', 'text'),
            'wbc_portfolio_title' => array('Portfolio title', 'Before we tell you our story, let the weddings speak.', 'textarea'),
            'wbc_services_kicker' => array('Services kicker', 'What we manage', 'text'),
            'wbc_services_title' => array('Services title', 'One studio across venue, design, planning and guest care.', 'textarea'),
            'wbc_dest_kicker' => array('Destinations kicker', 'Where we plan', 'text'),
            'wbc_dest_title' => array('Destinations title', 'Udaipur at the centre. India, and further, when the wedding asks for it.', 'textarea'),
            'wbc_process_kicker' => array('Process kicker', 'A uniquely comprehensive process', 'text'),
            'wbc_process_title' => array('Process title', 'From the first story to the last farewell.', 'textarea'),
            'wbc_process_text' => array('Process band text', 'Impeccable logistics, inspired creative direction, and design held in-house — from story to soirée.', 'textarea'),
            'wbc_editorial_kicker' => array('Editorial kicker', 'The promise', 'text'),
            'wbc_editorial_title' => array('Editorial title', 'We coordinate so you can celebrate.', 'textarea'),
            'wbc_editorial_text' => array('Editorial text', 'Couples in 2026 are asking for weddings that feel intentional, personal and immersive. This studio is built the same way: fewer generic promises, more clear answers, real work, and a single accountable team.', 'textarea'),
            'wbc_cta_kicker' => array('Contact band label', 'Contact us', 'text'),
            'wbc_cta_title' => array('CTA title', 'Tell us the date, the city, and the feeling you want to keep.', 'textarea'),
            'wbc_cta_text' => array('CTA text', 'Share a few first details. The studio will reply with a clear planning path, venue thinking, and next steps.', 'textarea'),
        ),
        'wbc_stats' => array(
            'wbc_stat_1_value' => array('Stat 1 value', '1', 'text'),
            'wbc_stat_1_label' => array('Stat 1 label', 'Team, end to end', 'text'),
            'wbc_stat_2_value' => array('Stat 2 value', '8+', 'text'),
            'wbc_stat_2_label' => array('Stat 2 label', 'Cities planned', 'text'),
            'wbc_stat_3_value' => array('Stat 3 value', 'Pin to plane', 'text'),
            'wbc_stat_3_label' => array('Stat 3 label', 'Planning depth', 'text'),
            'wbc_stat_4_value' => array('Stat 4 value', 'Udaipur', 'text'),
            'wbc_stat_4_label' => array('Stat 4 label', 'Home studio', 'text'),
        ),
        'wbc_media' => array(
            'wbc_hero_media_type' => array('Hero media type', 'video', 'radio', array('photo' => 'Photo', 'video' => 'Video')),
            'wbc_hero_video' => array('Hero video URL (MP4, YouTube, or Vimeo)', wbc_default_video('hero'), 'url'),
            'wbc_cta_media_type' => array('Contact band media type', 'video', 'radio', array('photo' => 'Photo', 'video' => 'Video')),
            'wbc_cta_video' => array('Contact band video URL', wbc_default_video('cta'), 'url'),
            'wbc_editorial_media_type' => array('Editorial media type', 'video', 'radio', array('photo' => 'Photo', 'video' => 'Video')),
            'wbc_editorial_video' => array('Editorial video URL', wbc_default_video('editorial'), 'url'),
            'wbc_process_media_type' => array('Process band media type', 'video', 'radio', array('photo' => 'Photo', 'video' => 'Video')),
            'wbc_process_video' => array('Process band video URL', wbc_default_video('process'), 'url'),
            'wbc_kind_media_type' => array('Kind words media type', 'photo', 'radio', array('photo' => 'Photo', 'video' => 'Video')),
            'wbc_kind_video' => array('Kind words video URL', '', 'url'),
        ),
        'wbc_social' => array(
            'wbc_instagram' => array('Instagram URL', '', 'url'),
            'wbc_facebook' => array('Facebook URL', '', 'url'),
            'wbc_youtube' => array('YouTube URL', '', 'url'),
            'wbc_pinterest' => array('Pinterest URL', '', 'url'),
            'wbc_tiktok' => array('TikTok URL', '', 'url'),
            'wbc_wedmegood' => array('WedMeGood URL', 'https://www.wedmegood.com/profile/Chetan-Parihar-Weddings-106898', 'url'),
        ),
        'wbc_seo' => array(
            'wbc_seo_description' => array('Default meta description', 'Chetan Parihar Weddings is a Udaipur destination wedding planner specialising in palace, heritage and celebration design across Rajasthan, Gujarat, Goa and India.', 'textarea'),
            'wbc_seo_knowledge' => array('Entity statement (AEO / GEO)', 'Chetan Parihar Weddings is a destination wedding planning and decor studio based in Udaipur, Rajasthan, India. Founder Chetan Parihar leads one in-house team for venue, design, hospitality, vendors and on-ground execution.', 'textarea'),
            'wbc_seo_home_title' => array('Homepage title fallback', 'Destination Wedding Planner in Udaipur | Chetan Parihar Weddings', 'text'),
            'wbc_seo_weddings_title' => array('Weddings archive title', 'Real Destination Weddings & Portfolio | Chetan Parihar Weddings', 'text'),
            'wbc_seo_weddings_description' => array('Weddings archive description', 'Explore palace, heritage, lakeside and destination wedding stories planned from Udaipur across Rajasthan, Goa and India.', 'textarea'),
            'wbc_seo_services_title' => array('Services archive title', 'Wedding Planning, Decor & Hospitality | Chetan Parihar Weddings', 'text'),
            'wbc_seo_services_description' => array('Services archive description', 'Venue curation, decor and design, planning, hospitality, vendors and on-ground execution from a Udaipur studio.', 'textarea'),
            'wbc_seo_destinations_title' => array('Destinations archive title', 'Destination Wedding Cities in India | Chetan Parihar Weddings', 'text'),
            'wbc_seo_destinations_description' => array('Destinations archive description', 'Destination wedding planning in Udaipur, Jaipur, Jodhpur, Goa, Ahmedabad and Surat with a Udaipur-based studio.', 'textarea'),
            'wbc_seo_journal_title' => array('Journal title', 'Wedding Planning Journal | Chetan Parihar Weddings', 'text'),
            'wbc_seo_journal_description' => array('Journal description', 'Guides for destination wedding planning, venue selection, decor, guest hospitality and Indian wedding timelines.', 'textarea'),
            'wbc_service_area' => array('Service areas', 'Udaipur, Jaipur, Jodhpur, Ahmedabad, Surat, Goa, Rajasthan, Gujarat, India', 'textarea'),
            'wbc_price_range' => array('Price range', '₹₹₹', 'text'),
            'wbc_latitude' => array('Studio latitude', '24.5854', 'text'),
            'wbc_longitude' => array('Studio longitude', '73.7125', 'text'),
            'wbc_geo_region' => array('Geo region code', 'IN-RJ', 'text'),
            'wbc_founding_year' => array('Founding year', '2018', 'text'),
            'wbc_twitter_handle' => array('Twitter / X handle', '', 'text'),
            'wbc_google_site_verification' => array('Google Search Console code', '', 'text'),
            'wbc_bing_site_verification' => array('Bing Webmaster code', '', 'text'),
        ),
    );

    foreach ($fields as $section => $items) {
        foreach ($items as $id => $data) {
            $sanitize = $data[2] === 'url' ? 'esc_url_raw' : ($data[2] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field');
            $wp_customize->add_setting($id, array(
                'default' => $data[1],
                'sanitize_callback' => $sanitize,
                'transport' => 'refresh',
            ));
            $control = array(
                'label' => __($data[0], 'weddingsbychetanparihar'),
                'section' => $section,
                'type' => $data[2] === 'url' ? 'url' : $data[2],
            );
            if ($data[2] === 'radio' && !empty($data[3])) {
                $control['choices'] = $data[3];
            }
            $wp_customize->add_control($id, $control);
        }
    }

    foreach (array(
        'wbc_hero_image' => array('Hero photo (used if type is Photo, or as video poster)', 'wbc_media', 'hero'),
        'wbc_founder_image' => array('Founder photograph', 'wbc_founder', 'founder'),
        'wbc_editorial_image' => array('Editorial photo', 'wbc_media', 'editorial'),
        'wbc_about_image' => array('About page image', 'wbc_founder', 'about'),
        'wbc_cta_image' => array('Contact band photo', 'wbc_media', 'cta'),
        'wbc_process_image' => array('Process / planning band photo', 'wbc_media', 'process'),
        'wbc_kind_image' => array('Kind words band photo', 'wbc_media', 'kind'),
    ) as $id => $info) {
        $wp_customize->add_setting($id, array(
            'default' => wbc_default_image($info[2]),
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $id, array(
            'label' => __($info[0], 'weddingsbychetanparihar'),
            'section' => $info[1],
        )));
    }
}
add_action('customize_register', 'wbc_customize_register');

function wbc_handle_contact() {
    check_ajax_referer('wbc_contact', 'nonce');
    $honeypot = sanitize_text_field(wp_unslash($_POST['company'] ?? ''));
    $success = wbc_contact_setting('wbc_form_success', 'Thank you. Your enquiry has reached the studio.');
    if ($honeypot !== '') {
        wp_send_json_success(array('message' => $success));
    }

    $visible = wbc_visible_contact_fields();
    $values = array();
    foreach ($visible as $key => $field) {
        $raw = wp_unslash($_POST[$key] ?? '');
        $values[$key] = $field['type'] === 'textarea' ? sanitize_textarea_field($raw) : ($key === 'email' ? sanitize_email($raw) : sanitize_text_field($raw));
    }

    $name = $values['name'] ?? '';
    $email = $values['email'] ?? '';
    $phone = $values['phone'] ?? '';
    $has_email_field = isset($visible['email']);
    $has_phone_field = isset($visible['phone']);
    $needs_contact = ($has_email_field || $has_phone_field) && !$email && !$phone;
    if (!$name || $needs_contact) {
        wp_send_json_error(array('message' => wbc_contact_setting('wbc_form_error', 'Please share your name and either email or phone.')));
    }

    $message = $values['message'] ?? '';
    $lead_id = wp_insert_post(array(
        'post_type' => 'wbc_lead',
        'post_status' => 'private',
        'post_title' => $name . ' — ' . current_time('Y-m-d H:i'),
        'post_content' => $message,
    ));
    if ($lead_id && !is_wp_error($lead_id)) {
        update_post_meta($lead_id, 'name', $name);
        update_post_meta($lead_id, 'wbc_lead_status', 'new');
        foreach ($values as $key => $value) {
            if ($key !== 'message') {
                update_post_meta($lead_id, $key, $value);
            }
        }
    }

    $to = wbc_studio_email();
    $subject = str_replace('{name}', $name, wbc_contact_setting('wbc_form_subject', 'New wedding enquiry from {name}'));
    $lines = array();
    foreach ($visible as $key => $field) {
        $lines[] = $field['label'] . ': ' . ($values[$key] ?? '');
    }
    wp_mail($to, $subject, implode("\n", $lines), array('Content-Type: text/plain; charset=UTF-8'));

    wp_send_json_success(array('message' => $success));
}
add_action('wp_ajax_wbc_contact', 'wbc_handle_contact');
add_action('wp_ajax_nopriv_wbc_contact', 'wbc_handle_contact');

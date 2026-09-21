<?php
/**
 * Shared content and image helpers for the BTS-style theme.
 */

function wvn_media($file) {
    return 'https://weddingvowsbynikhil.com/wp-content/uploads/' . ltrim($file, '/');
}

function wvn_asset($path) {
    return get_theme_file_uri($path);
}

function wvn_home_id() {
    $id = (int) get_option('page_on_front');
    return $id ?: (int) get_the_ID();
}

function wvn_is_acf_layout_page($post_id = 0) {
    $post_id = (int) $post_id;
    if (!$post_id) {
        return false;
    }
    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'page') {
        return false;
    }
    $front = (int) get_option('page_on_front');
    $posts = (int) get_option('page_for_posts');
    $template = get_page_template_slug($post_id);
    $title = $post->post_title;
    return $post_id === $front
        || $post_id === $posts
        || $template === 'page-what-we-do.php'
        || $post->post_name === 'what-we-do'
        || $post->post_name === 'home'
        || $post->post_name === 'blog'
        || $title === 'Home'
        || strpos($title, 'Home') === 0;
}

function wvn_hide_acf_layout_editor() {
    $post_id = isset($_GET['post']) ? (int) $_GET['post'] : (isset($_POST['post_ID']) ? (int) $_POST['post_ID'] : 0);
    if ($post_id && wvn_is_acf_layout_page($post_id)) {
        remove_post_type_support('page', 'editor');
        // Strip Elementor builder mode every time this page is opened in wp-admin.
        delete_post_meta($post_id, '_elementor_edit_mode');
        delete_post_meta($post_id, '_elementor_template_type');
    }

    // If someone opens Elementor for an ACF page, send them to the field editor instead.
    if (!empty($_GET['action']) && $_GET['action'] === 'elementor' && $post_id && wvn_is_acf_layout_page($post_id)) {
        wp_safe_redirect(admin_url('post.php?post=' . $post_id . '&action=edit'));
        exit;
    }
}
add_action('admin_init', 'wvn_hide_acf_layout_editor');

function wvn_acf_missing_notice() {
    if (function_exists('acf_add_local_field_group')) {
        return;
    }
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen || $screen->base !== 'post') {
        return;
    }
    echo '<div class="notice notice-error"><p><strong>Advanced Custom Fields is not active.</strong> The homepage tabs (Hero, Intro, Collective…) need the ACF plugin. Activate <em>Advanced Custom Fields</em> or <em>ACF PRO</em> under Plugins.</p></div>';
}
add_action('admin_notices', 'wvn_acf_missing_notice');

function wvn_ensure_static_front_page() {
    if (get_option('_wvn_front_page_fixed_v1') === '1') {
        return;
    }
    $home = get_page_by_path('home');
    if (!$home) {
        $q = new WP_Query(array(
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'posts_per_page' => 20,
            'orderby'        => 'ID',
            'order'          => 'ASC',
        ));
        while ($q->have_posts()) {
            $q->the_post();
            if (get_the_title() === 'Home' || strpos(get_the_title(), 'Home') === 0) {
                $home = get_post(get_the_ID());
                break;
            }
        }
        wp_reset_postdata();
    }
    if ($home) {
        if (get_option('show_on_front') !== 'page') {
            update_option('show_on_front', 'page');
        }
        if ((int) get_option('page_on_front') !== (int) $home->ID) {
            update_option('page_on_front', (int) $home->ID);
        }
        delete_post_meta((int) $home->ID, '_elementor_edit_mode');
        delete_post_meta((int) $home->ID, '_elementor_template_type');
    }
    update_option('_wvn_front_page_fixed_v1', '1');
}
add_action('init', 'wvn_ensure_static_front_page', 35);

function wvn_acf_layout_admin_body_class($classes) {
    $post_id = isset($_GET['post']) ? (int) $_GET['post'] : 0;
    if ($post_id && wvn_is_acf_layout_page($post_id)) {
        $classes .= ' wvn-acf-layout';
    }
    return $classes;
}
add_filter('admin_body_class', 'wvn_acf_layout_admin_body_class');

function wvn_acf_layout_admin_assets() {
    $post_id = isset($_GET['post']) ? (int) $_GET['post'] : 0;
    if (!$post_id || !wvn_is_acf_layout_page($post_id)) {
        return;
    }
    echo '<style>
        body.wvn-acf-layout #postdivrich,
        body.wvn-acf-layout .block-editor,
        body.wvn-acf-layout #elementor-switch-mode,
        body.wvn-acf-layout .elementor-switch-mode,
        body.wvn-acf-layout #elementor-editor,
        body.wvn-acf-layout .elementor-editor-active #elementor-editor { display: none !important; }
    </style>';
}
add_action('admin_head', 'wvn_acf_layout_admin_assets');

function wvn_acf_layout_admin_notice() {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen || $screen->base !== 'post') {
        return;
    }
    $post_id = isset($_GET['post']) ? (int) $_GET['post'] : 0;
    if (!$post_id || !wvn_is_acf_layout_page($post_id)) {
        return;
    }
    echo '<div class="notice notice-info"><p><strong>Edit this page with the tabs below</strong> (Hero, Intro, Collective, etc.). Elementor is turned off here on purpose — the live homepage uses these fields, not the old Elementor layout.</p></div>';
}
add_action('admin_notices', 'wvn_acf_layout_admin_notice');

function wvn_elementor_can_edit_acf_page($can_edit, $post) {
    if ($post && wvn_is_acf_layout_page($post->ID)) {
        return false;
    }
    return $can_edit;
}
add_filter('elementor/editor/can_edit_post', 'wvn_elementor_can_edit_acf_page', 10, 2);

/**
 * Home still has old Elementor meta, which hides the normal "Edit Page" admin-bar
 * link and shows a dead "Edit with Elementor" state. Keep a real Edit link, and
 * clear the stale Elementor badge on ACF-driven pages.
 */
function wvn_admin_bar_edit_link($wp_admin_bar) {
    if (is_admin() || !is_singular()) {
        return;
    }
    $post_id = get_queried_object_id();
    if (!$post_id || !current_user_can('edit_post', $post_id)) {
        return;
    }
    $edit_url = get_edit_post_link($post_id);
    if (!$edit_url) {
        return;
    }
    $post_type = get_post_type_object(get_post_type($post_id));
    $title = ($post_type && !empty($post_type->labels->edit_item)) ? $post_type->labels->edit_item : __('Edit');

    if (wvn_is_acf_layout_page($post_id)) {
        $title = __('Edit page fields', 'woodmart');
    }

    $wp_admin_bar->add_node(array(
        'id'    => 'edit',
        'title' => $title,
        'href'  => $edit_url,
    ));
}
add_action('admin_bar_menu', 'wvn_admin_bar_edit_link', 81);

function wvn_clear_stale_elementor_on_acf_pages() {
    if (get_option('_wvn_clear_elementor_acf_v2') === '1') {
        return;
    }
    $ids = array_filter(array(
        (int) get_option('page_on_front'),
        (int) get_option('page_for_posts'),
    ));
    $services = get_page_by_path('what-we-do');
    if ($services) {
        $ids[] = (int) $services->ID;
    }
    $home = get_page_by_path('home');
    if ($home) {
        $ids[] = (int) $home->ID;
    }
    foreach (array_unique($ids) as $id) {
        if (!$id) {
            continue;
        }
        delete_post_meta($id, '_elementor_edit_mode');
        delete_post_meta($id, '_elementor_template_type');
    }
    update_option('_wvn_clear_elementor_acf_v2', '1');
}
add_action('init', 'wvn_clear_stale_elementor_on_acf_pages', 40);

function wvn_elementor_editing() {
    if (!class_exists('\Elementor\Plugin')) {
        return false;
    }
    $elementor = \Elementor\Plugin::$instance;
    if (!empty($elementor->editor) && method_exists($elementor->editor, 'is_edit_mode') && $elementor->editor->is_edit_mode()) {
        return true;
    }
    if (!empty($elementor->preview) && method_exists($elementor->preview, 'is_preview_mode') && $elementor->preview->is_preview_mode()) {
        return true;
    }
    return isset($_GET['elementor-preview']) || isset($_GET['elementor_library']);
}

function wvn_image_url($value, $default = '') {
    if (is_array($value)) {
        if (!empty($value['url'])) {
            return $value['url'];
        }
        if (!empty($value['ID'])) {
            $url = wp_get_attachment_image_url((int) $value['ID'], 'full');
            if ($url) {
                return $url;
            }
        }
    }
    if (is_numeric($value)) {
        $url = wp_get_attachment_image_url((int) $value, 'full');
        if ($url) {
            return $url;
        }
    }
    if (is_string($value) && $value !== '') {
        return $value;
    }
    return $default;
}

function wvn_home_text($name, $default = '') {
    if (!function_exists('get_field')) {
        return $default;
    }
    $value = get_field($name, wvn_home_id());
    if ($value === null || $value === false || $value === '') {
        return $default;
    }
    return is_string($value) ? $value : $default;
}

function wvn_home_html($name, $default = '') {
    $value = wvn_home_text($name, $default);
    return $value !== '' ? wp_kses_post($value) : '';
}

function wvn_home_intro_html() {
    $content = wvn_home_text('home_intro_content', '');
    if ($content !== '') {
        return wp_kses_post($content);
    }

    $kicker = trim(wp_strip_all_tags(wvn_home_text('home_intro_kicker', 'Destination wedding planner in Udaipur')));
    $heading = trim(wp_strip_all_tags(wvn_home_text('home_intro_heading', 'Destination weddings in Udaipur, planned with quiet luxury.')));
    $body = trim(wp_strip_all_tags(wvn_home_text('home_intro_text', 'Wedding Vows by Nikhil is an Udaipur-based destination wedding studio. We plan palace, lakeside and heritage weddings across Udaipur, Jaipur, Jodhpur and Goa — one team from the first venue walk to the last pheras.')));

    $html = '';
    if ($kicker !== '') {
        $html .= '<p class="wvn-kicker">' . esc_html($kicker) . '</p>';
    }
    if ($heading !== '') {
        $html .= '<h1>' . esc_html($heading) . '</h1>';
    }
    if ($body !== '') {
        $html .= '<p>' . esc_html($body) . '</p>';
    }
    return $html;
}

/**
 * Structured homepage intro — ivory editorial collage + crawlable SEO copy.
 */
function wvn_home_intro() {
    $gallery = function_exists('wvn_gallery_images') ? array_values(array_filter(wvn_gallery_images())) : array();
    $pick = function ($i, $fallback) use ($gallery) {
        return !empty($gallery[$i]) ? $gallery[$i] : wvn_media($fallback);
    };

    $img_left = wvn_home_image('home_intro_image_left', $pick(2, '2025/04/2J0A2532-533x800-1.jpg'));
    $img_right_top = wvn_home_image('home_intro_image_right_top', $pick(5, '2025/04/2J0A0986-534x800-1.jpg'));
    $img_right_bot = wvn_home_image('home_intro_image_right_bot', $pick(3, '2025/04/2J0A1820-1200x800-1.jpg'));
    $img_left_bot = wvn_home_image('home_intro_image_left_bot', $pick(4, '2025/04/2J0A1818.jpg'));
    $img_scape = wvn_home_image('home_intro_landscape', $pick(1, '2025/04/2J0A7886-1200x800-1.jpg'));
    // Single-image ACF fallback for older installs.
    $legacy = wvn_home_image('home_intro_image', '');
    if ($legacy) {
        $img_left = $img_left ?: $legacy;
    }

    $story_url = wvn_home_text('home_intro_story_url', '');
    if ($story_url === '') {
        $story_page = get_page_by_path('portfolio');
        $story_url = ($story_page && $story_page->post_status === 'publish')
            ? get_permalink($story_page)
            : (get_post_type_archive_link('portfolio') ?: home_url('/portfolio/'));
    }

    $founder = trim(wp_strip_all_tags(wvn_home_text('home_intro_founder', '')));
    if ($founder === '') {
        $sign = trim(wp_strip_all_tags(wvn_home_text('home_planner_sign', 'Nikhil Salvi — Founder')));
        $founder = preg_replace('/\s*[—\-–].*$/u', '', $sign) ?: 'Nikhil Salvi';
    }
    $role = trim(wp_strip_all_tags(wvn_home_text('home_intro_founder_role', 'Founder & Creative Director')));
    $secondary_cta_label = trim(wp_strip_all_tags(wvn_home_text('home_intro_secondary_cta_text', '')));
    $secondary_cta_url = wvn_home_text('home_intro_secondary_cta_url', '');
    $layout_variant = wvn_home_text('home_intro_layout_variant', 'editorial');
    $image_position = wvn_home_text('home_intro_image_position', 'center');
    $main_alt = trim(wp_strip_all_tags(wvn_home_text('home_intro_art_alt', 'Bride in traditional attire at a destination wedding in Udaipur')));

    $title_line = trim(wp_strip_all_tags(wvn_home_text('home_intro_title_line', 'Wedding Planner')));
    $title_em = trim(wp_strip_all_tags(wvn_home_text('home_intro_title_em', 'in')));
    $title_place = trim(wp_strip_all_tags(wvn_home_text('home_intro_title_place', 'Udaipur')));
    $heading = trim(implode(' ', array_filter(array($title_line, $title_em, $title_place))));
    if ($heading === '') {
        $heading = 'Wedding Planner in Udaipur';
    }

    return array(
        'eyebrow'        => trim(wp_strip_all_tags(wvn_home_text('home_intro_kicker', 'The Art of Celebration'))),
        'title_line'     => $title_line !== '' ? $title_line : 'Wedding Planner',
        'title_em'       => $title_em !== '' ? $title_em : 'in',
        'title_place'    => $title_place !== '' ? $title_place : 'Udaipur',
        'heading'        => $heading,
        'subhead'        => trim(wp_strip_all_tags(wvn_home_text('home_intro_subheading', 'Celebrations Beyond the Ordinary'))),
        'lead'           => trim(wp_strip_all_tags(wvn_home_text(
            'home_intro_lead',
            'At Wedding Vows by Nikhil, we create thoughtfully planned destination weddings in Udaipur, where royal heritage, breathtaking backdrops, and meaningful details come together to craft experiences that feel uniquely yours.'
        ))),
        'founder'        => $founder,
        'founder_role'   => $role,
        'cta_label'      => trim(wp_strip_all_tags(wvn_home_text('home_intro_cta_text', 'Plan your celebration'))),
        'cta_url'            => wvn_home_text('home_intro_cta_url', home_url('/contact-us/')),
        'secondary_cta_label' => $secondary_cta_label,
        'secondary_cta_url'   => $secondary_cta_url,
        'layout_variant'      => $layout_variant === 'minimal' ? 'minimal' : 'editorial',
        'image_position'      => $image_position,
        'story_label'    => trim(wp_strip_all_tags(wvn_home_text('home_intro_story_text', 'Our story'))),
        'story_url'      => $story_url,
        'index_label'    => trim(wp_strip_all_tags(wvn_home_text('home_intro_index', '01'))),
        'index_meta'     => trim(wp_strip_all_tags(wvn_home_text('home_intro_index_meta', 'People / Places / Precious Moments'))),
        'note_left'      => trim(wp_strip_all_tags(wvn_home_text('home_intro_note_left', 'A celebration shaped by place'))),
        'note_right'     => trim(wp_strip_all_tags(wvn_home_text('home_intro_note_right', 'Extraordinary Celebrations in Extraordinary Places'))),
        'note_detail'    => trim(wp_strip_all_tags(wvn_home_text('home_intro_note_detail', 'Beautiful Details / Meaningful Memories'))),
        'location'       => trim(wp_strip_all_tags(wvn_home_text('home_intro_location', 'Udaipur / India'))),
        'scroll_label'   => trim(wp_strip_all_tags(wvn_home_text('home_intro_scroll', 'Scroll to discover'))),
        'footer_mark'    => trim(wp_strip_all_tags(wvn_home_text('home_intro_footer_mark', 'Love lives here'))),
        'landscape'      => $img_scape,
        'landscape_alt'  => 'Udaipur lakeside palace setting for a destination wedding',
        'images'         => array(
            array(
                'url' => $img_left,
                'alt' => $main_alt,
                'slot'=> 'left',
            ),
            array(
                'url' => $img_right_top,
                'alt' => 'Palace wedding ceremony in Udaipur',
                'slot'=> 'right-top',
            ),
            array(
                'url' => $img_left_bot,
                'alt' => 'Wedding décor detail from an Udaipur celebration',
                'slot'=> 'left-bot',
            ),
            array(
                'url' => $img_right_bot,
                'alt' => 'Guests celebrating at a destination wedding in Udaipur',
                'slot'=> 'right-bot',
            ),
        ),
    );
}

/**
 * Contextual intro links — only published pages (or portfolio archive).
 */
function wvn_home_intro_links() {
    $candidates = array(
        array('slug' => 'weddings-in-udaipur', 'label' => 'Weddings in Udaipur guide'),
        array('slug' => 'wedding-venues-udaipur', 'label' => 'wedding venues in Udaipur'),
        array('slug' => 'udaipur-wedding-cost', 'label' => 'Udaipur wedding costs'),
        array('slug' => 'portfolio', 'label' => 'real wedding portfolio'),
        array('slug' => 'contact-us', 'label' => 'book a consultation'),
    );

    $links = array();
    $seen = array();
    foreach ($candidates as $item) {
        $slug = $item['slug'];
        $url = '';
        $page = get_page_by_path($slug);
        if ($page && $page->post_status === 'publish') {
            $url = get_permalink($page);
        } elseif ($slug === 'portfolio') {
            $archive = get_post_type_archive_link('portfolio');
            if ($archive) {
                $url = $archive;
            }
        }
        if (!$url || isset($seen[$url])) {
            continue;
        }
        $seen[$url] = true;
        $links[] = array(
            'url'   => $url,
            'label' => $item['label'],
        );
    }
    return $links;
}

/**
 * Intro image markup with dimensions / srcset when an attachment exists.
 */
function wvn_home_intro_image_html($url, $alt, $loading = 'lazy', $position = 'center') {
    $url = esc_url($url);
    if ($url === '') {
        return '';
    }
    $loading = ($loading === 'eager') ? 'eager' : 'lazy';
    $allowed_positions = array('center', 'top', 'center 35%', 'bottom');
    $position = in_array($position, $allowed_positions, true) ? $position : 'center';
    $attrs = array(
        'class'    => 'wvn-intro__img',
        'alt'      => $alt,
        'decoding' => 'async',
        'loading'  => $loading,
        'sizes'    => '(max-width: 900px) 70vw, 28vw',
        'style'    => 'object-position:' . esc_attr($position),
    );
    if ($loading === 'eager') {
        $attrs['fetchpriority'] = 'high';
    }
    $attachment_id = 0;
    if (function_exists('attachment_url_to_postid')) {
        $uploads = wp_upload_dir();
        if (!empty($uploads['baseurl']) && strpos($url, $uploads['baseurl']) === 0) {
            $attachment_id = (int) attachment_url_to_postid($url);
        }
    }
    if ($attachment_id) {
        return wp_get_attachment_image($attachment_id, 'large', false, $attrs);
    }
    $extra = $loading === 'eager' ? ' fetchpriority="high"' : '';
    return sprintf(
        '<img class="wvn-intro__img" src="%s" alt="%s" width="800" height="1000" decoding="async" loading="%s"%s sizes="(max-width: 900px) 70vw, 28vw" style="object-position:%s">',
        $url,
        esc_attr($alt),
        esc_attr($loading),
        $extra,
        esc_attr($position)
    );
}

function wvn_home_image($name, $default = '') {
    if (!function_exists('get_field')) {
        return $default;
    }
    return wvn_image_url(get_field($name, wvn_home_id()), $default);
}

function wvn_home_rows($name) {
    if (!function_exists('get_field')) {
        return array();
    }
    $rows = get_field($name, wvn_home_id());
    return (is_array($rows) && $rows) ? $rows : array();
}

function wvn_hero_image() {
    return wvn_home_image('home_hero_image', wvn_media('2025/04/NVP_JEHANAXKANISHK_WEDDING-1450.jpg'));
}

function wvn_hero_media_type() {
    $type = function_exists('get_field') ? (string) get_field('home_hero_media_type', wvn_home_id()) : 'image';
    return $type === 'video' ? 'video' : 'image';
}

function wvn_hero_video() {
    $file = function_exists('get_field') ? get_field('home_hero_video', wvn_home_id()) : null;
    return wvn_image_url($file, '');
}

function wvn_showreel_video() {
    $file = function_exists('get_field') ? get_field('home_showreel_video', wvn_home_id()) : null;
    $url = wvn_image_url($file, '');
    return $url ?: wvn_media('2026/08/Video-25994.mp4');
}

function wvn_founder_image() {
    return wvn_home_image('home_planner_image', wvn_media('2025/05/IMG_4902-scaled.png'));
}

function wvn_logo_src() {
    $theme_logo = get_theme_file_path('/images/logo-bg-dark.png');
    if (file_exists($theme_logo)) {
        return get_theme_file_uri('/images/logo-bg-dark.png');
    }
    return wvn_media('2025/05/nikhillogo-removebg-preview.png');
}

function wvn_weddings() {
    $items = array();
    $query = new WP_Query(array(
        'post_type'              => 'portfolio',
        'posts_per_page'         => 12,
        'post_status'            => 'publish',
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'ignore_sticky_posts'    => true,
        'no_found_rows'          => true,
        'update_post_meta_cache' => true,
        'update_post_term_cache' => false,
    ));
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $id = get_the_ID();
            $thumb = get_the_post_thumbnail_url($id, 'large');
            if (!$thumb) {
                $thumb = get_the_post_thumbnail_url($id, 'full');
            }
            $items[] = array(
                'title' => get_the_title($id),
                'venue' => get_the_excerpt($id) ?: 'Udaipur, Rajasthan',
                'url'   => get_permalink($id),
                'image' => $thumb ?: wvn_hero_image(),
            );
        }
        wp_reset_postdata();
    }
    return $items;
}

function wvn_services() {
    $rows = wvn_home_rows('home_services');
    if ($rows) {
        $items = array();
        foreach ($rows as $row) {
            $items[] = array(
                'title' => $row['title'] ?? '',
                'text'  => $row['text'] ?? '',
                'image' => wvn_image_url($row['image'] ?? '', wvn_hero_image()),
                'bg'    => wvn_image_url($row['bg'] ?? '', wvn_hero_image()),
            );
        }
        return $items;
    }
    return array(
        array(
            'title' => 'Venue Selection & Booking',
            'text'  => 'Hand-picked palaces, resorts, and beach venues across India and abroad.',
            'image' => wvn_media('2025/04/2J0A2532-533x800-1.jpg'),
            'bg'    => wvn_media('2025/04/NVP_JEHANAXKANISHK_WEDDING-1450.jpg'),
        ),
        array(
            'title' => 'Decor and Design',
            'text'  => 'Bespoke décor that transforms your vision into an unforgettable wedding experience.',
            'image' => wvn_media('2025/04/2J0A7886-1200x800-1.jpg'),
            'bg'    => wvn_media('2025/04/2J0A7886-1200x800-1.jpg'),
        ),
        array(
            'title' => 'Wedding Photography & Films',
            'text'  => 'Timeless photographs and cinematic films that preserve every emotion beautifully.',
            'image' => wvn_media('2025/04/2J0A1820-1200x800-1.jpg'),
            'bg'    => wvn_media('2025/04/2J0A1820-1200x800-1.jpg'),
        ),
        array(
            'title' => 'Hospitality & Logistics',
            'text'  => 'Flawless guest experiences and smooth coordination from arrival to farewell.',
            'image' => wvn_media('2025/04/2J0A0986-534x800-1.jpg'),
            'bg'    => wvn_media('2025/04/2J0A1818.jpg'),
        ),
        array(
            'title' => 'Vendor Selection',
            'text'  => 'Trusted wedding professionals, carefully selected and managed for exceptional results.',
            'image' => wvn_media('2025/04/2J0A0682.jpg'),
            'bg'    => wvn_media('2025/04/2J0A0682.jpg'),
        ),
    );
}

function wvn_faqs() {
    $rows = wvn_home_rows('home_faqs');
    if ($rows) {
        $items = array();
        foreach ($rows as $row) {
            $items[] = array(
                'q' => $row['q'] ?? '',
                'a' => $row['a'] ?? '',
            );
        }
        return $items;
    }
    return array(
        array(
            'q' => 'How much time is needed to plan a wedding?',
            'a' => 'Ideally, book your venue 8–9 months in advance. Artists usually need around 3 months and décor planning 1–2 months — we will handle the rest, step by step.',
        ),
        array(
            'q' => 'Why should I choose you as my wedding planner?',
            'a' => 'Wedding Vows by Nikhil is an Udaipur-based team that takes complete responsibility for planning, coordination, and on-ground execution — so you and your family can enjoy every moment.',
        ),
        array(
            'q' => 'What should I ask a planner before a destination wedding in Udaipur?',
            'a' => 'Ask about venue relationships, guest hospitality, artist timelines, décor lead times, and who will be on-site on the wedding days. We walk through all of this in the first consultation.',
        ),
        array(
            'q' => 'Can you plan my wedding if my venue is already booked?',
            'a' => 'Yes. We regularly step in after a venue is confirmed and take over design, vendors, hospitality, and day-of execution.',
        ),
        array(
            'q' => 'Do I need a planner for a small or intimate wedding?',
            'a' => 'Even intimate celebrations benefit from one dedicated team. We scale the plan to your guest count without losing the details that make it feel personal.',
        ),
        array(
            'q' => 'How early should I contact you for a wedding in Udaipur?',
            'a' => 'As soon as you have a season in mind. Peak palace dates in Udaipur fill early — eight to twelve months is ideal.',
        ),
        array(
            'q' => 'Do you work with the couple’s chosen vendors?',
            'a' => 'Yes. We happily collaborate with your preferred artists and vendors, and we also bring our trusted roster when you want us to curate the full team.',
        ),
        array(
            'q' => 'Do you help with wedding timelines and schedules?',
            'a' => 'Yes. We build minute-by-minute run of shows for every function, brief every vendor, and stay on the floor until the last farewell.',
        ),
    );
}

function wvn_testimonial_page_url($index = 0) {
    $page = get_page_by_path('testimonials');
    if ($page && $page->post_status === 'publish') {
        return add_query_arg('testimonial', max(0, (int) $index), get_permalink($page));
    }
    return home_url('/testimonials/');
}

function wvn_testimonial_excerpt($text, $words = 42) {
    $text = trim(wp_strip_all_tags((string) $text));
    if ($text === '') {
        return '';
    }
    return '“' . wp_trim_words($text, max(10, (int) $words), '…') . '”';
}

function wvn_testimonials_page_setup() {
    $page = get_page_by_path('testimonials');
    if (!$page) {
        $page_id = wp_insert_post(array(
            'post_title' => 'Testimonials',
            'post_name' => 'testimonials',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => '',
        ));
        if (!is_wp_error($page_id) && $page_id) {
            $page = get_post($page_id);
        }
    }
    if ($page && !is_wp_error($page)) {
        update_post_meta((int) $page->ID, '_wp_page_template', 'page-testimonials.php');
    }
}
add_action('init', 'wvn_testimonials_page_setup', 31);

function wvn_testimonials() {
    $rows = wvn_home_rows('home_quotes');
    if ($rows) {
        $items = array();
        foreach ($rows as $row) {
            $tags = $row['tags'] ?? array();
            if (is_string($tags)) {
                $tags = array_filter(array_map('trim', explode(',', $tags)));
            }
            $media = isset($row['media']) ? (string) $row['media'] : '';
            if ($media !== 'video' && $media !== 'photo') {
                $media = !empty($row['video']) ? 'video' : 'photo';
            }
            $items[] = array(
                'name'  => $row['name'] ?? '',
                'time'  => $row['time'] ?? '',
                'text'  => $row['text'] ?? '',
                'tags'  => $tags,
                'dark'  => !empty($row['dark']),
                'media' => $media,
                'image' => wvn_image_url($row['image'] ?? '', ''),
                'video' => wvn_image_url($row['video'] ?? '', ''),
            );
        }
        return $items;
    }
    return array(
        array(
            'name'  => 'Mansi & Aneel',
            'time'  => '4 months ago',
            'text'  => 'Every detail was handled before we even thought to ask. From the first venue visit to the final pheras, the team made a palace wedding feel completely stress-free.',
            'tags'  => array('On Time Service', 'Quality of Work', 'Highly Experienced'),
            'dark'  => true,
            'media' => 'photo',
            'image' => '',
            'video' => '',
        ),
        array(
            'name'  => 'Jehana & Kanishk',
            'time'  => '8 months ago',
            'text'  => 'Nikhil and the team understood our families, our rituals, and the kind of quiet luxury we wanted. Guests are still talking about the décor.',
            'tags'  => array('Unique Ideas', 'Quality of Work'),
            'dark'  => false,
            'media' => 'photo',
            'image' => '',
            'video' => '',
        ),
        array(
            'name'  => 'Vidushi Mishra',
            'time'  => '6 months ago',
            'text'  => 'Hospitality for outstation guests was flawless. Cars, rooms, welcome details — we never had to chase anyone.',
            'tags'  => array('On Time Service', 'Highly Experienced'),
            'dark'  => false,
            'media' => 'photo',
            'image' => '',
            'video' => '',
        ),
        array(
            'name'  => 'Aishwarya & Dishant',
            'time'  => '1 year ago',
            'text'  => 'We wanted maximal colour without chaos. They designed spaces that felt like us and then executed them perfectly on the ground.',
            'tags'  => array('Unique Ideas', 'Quality of Work'),
            'dark'  => true,
            'media' => 'photo',
            'image' => '',
            'video' => '',
        ),
    );
}

/**
 * Normalize cinematic media mode to video|photo.
 */
function wvn_cin_media_mode($name, $default = 'video') {
    $mode = strtolower(trim((string) wvn_home_text($name, $default)));
    return $mode === 'photo' ? 'photo' : 'video';
}

/**
 * Echo a cinematic backdrop as muted looping video or still photo.
 */
function wvn_cin_render_backdrop($mode, $video_url, $image_url) {
    $mode = $mode === 'photo' ? 'photo' : 'video';
    $image_url = (string) $image_url;
    $video_url = (string) $video_url;

    if ($mode === 'photo' || $video_url === '') {
        if ($image_url === '') {
            return;
        }
        printf(
            '<img src="%s" alt="" loading="eager" decoding="async">',
            esc_url($image_url)
        );
        return;
    }

    $type = 'video/mp4';
    $path = wp_parse_url($video_url, PHP_URL_PATH);
    $ext = strtolower(pathinfo((string) $path, PATHINFO_EXTENSION));
    if ($ext === 'webm') {
        $type = 'video/webm';
    } elseif ($ext === 'mov') {
        $type = 'video/quicktime';
    }

    printf(
        '<video class="wvn-cin-video" muted autoplay loop playsinline preload="auto"%s src="%s"><source src="%s" type="%s"></video>',
        $image_url !== '' ? ' poster="' . esc_url($image_url) . '"' : '',
        esc_url($video_url),
        esc_url($video_url),
        esc_attr($type)
    );
}

/**
 * Cinematic homepage story / VOWS media + copy (ACF with fallbacks).
 */
function wvn_cinematic_home() {
    $gallery = wvn_gallery_images();
    $defaults_tiles = array(
        wvn_media('2026/08/LKY06126-scaled.jpeg'),
        wvn_media('2026/08/IMG_5234.jpg'),
        wvn_media('2025/04/2J0A2532-533x800-1.jpg'),
        wvn_media('2026/08/IMG_5259-e1788187853846.jpg'),
        wvn_media('2026/08/IMG_5222.jpg'),
        wvn_media('2026/08/IMG_5231.jpg'),
    );

    $mosaic = array();
    if (function_exists('get_field')) {
        $raw = get_field('home_cin_mosaic', wvn_home_id());
        if (is_array($raw)) {
            foreach ($raw as $item) {
                $url = wvn_image_url($item, '');
                if ($url) {
                    $mosaic[] = $url;
                }
            }
        }
    }
    if (count($mosaic) < 6) {
        foreach ($defaults_tiles as $url) {
            if (count($mosaic) >= 6) {
                break;
            }
            if (!in_array($url, $mosaic, true)) {
                $mosaic[] = $url;
            }
        }
    }
    $mosaic = array_slice(array_values($mosaic), 0, 6);
    while (count($mosaic) < 6) {
        $mosaic[] = $gallery[count($mosaic) % max(1, count($gallery))] ?? $defaults_tiles[0];
    }

    $story_media = wvn_cin_media_mode('home_cin_story_media', 'video');
    $vows_media = wvn_cin_media_mode('home_cin_vows_media', 'video');
    $story_film = wvn_image_url(
        function_exists('get_field') ? get_field('home_cin_story_film', wvn_home_id()) : null,
        wvn_media('2026/08/Video-25994-1.mp4')
    );
    $story_poster = wvn_home_image('home_cin_story_poster', wvn_media('2026/08/2J0A1820-1200x800-1.jpg'));
    $vows_film = wvn_image_url(
        function_exists('get_field') ? get_field('home_cin_vows_film', wvn_home_id()) : null,
        wvn_media('2026/08/vidssave.com-Anirudh-Ishita-__Wedding-Trailer__-Radisson-Blu-Palace-Resort-Spa-Udaipur-720P.mp4')
    );
    $vows_poster = wvn_home_image('home_cin_vows_poster', $story_poster);
    $cta_url = wvn_home_text('home_cin_vows_cta_url', '');
    if ($cta_url === '') {
        $cta_url = wvn_home_text('home_cta_url', home_url('/contact-us/'));
    }

    return array(
        'story_media'      => $story_media,
        'story_film'       => $story_film,
        'story_poster'     => $story_poster,
        'vows_media'       => $vows_media,
        'vows_film'        => $vows_film,
        'vows_poster'      => $vows_poster,
        'mosaic'           => $mosaic,
        'start_eyebrow'    => wvn_home_text('home_cin_start_eyebrow', '▷ The Story We Create'),
        'start_heading'    => wvn_home_text('home_cin_start_heading', 'It begins with'),
        'start_heading_em' => wvn_home_text('home_cin_start_heading_em', 'a vision,'),
        'start_sub'        => wvn_home_text('home_cin_start_sub', 'a feeling, a dream waiting to be brought to life.'),
        'vows_word'        => wvn_home_text('home_cin_vows_word', 'Vows'),
        'vows_eyebrow'     => wvn_home_text('home_cin_vows_eyebrow', 'The Vows Standard'),
        'vows_headline'    => wvn_home_text('home_cin_vows_headline', 'Every Vow. Every Detail.'),
        'vows_headline_em' => wvn_home_text('home_cin_vows_headline_em', 'Beautifully Kept.'),
        'vows_cta'         => wvn_home_text('home_cin_vows_cta', 'Book a Consultation'),
        'vows_cta_url'     => $cta_url,
        'cites_eyebrow'    => wvn_home_text('home_cin_cites_eyebrow', 'Venues we love'),
        'cites_heading'    => wvn_home_text('home_cin_cites_heading', 'Palaces, lakes'),
        'cites_heading_em' => wvn_home_text('home_cin_cites_heading_em', '& lawns for your day.'),
        'cites_kicker'     => wvn_home_text('home_cin_cites_kicker', 'Venue'),
    );
}

function wvn_portfolio_images() {
    $items = array();
    $seen = array();
    $add = function ($url) use (&$items, &$seen) {
        if (!$url || isset($seen[$url])) {
            return;
        }
        $seen[$url] = true;
        $items[] = $url;
    };
    $query = new WP_Query(array(
        'post_type'      => 'portfolio',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ));
    while ($query->have_posts()) {
        $query->the_post();
        $id = get_the_ID();
        $add(get_the_post_thumbnail_url($id, 'full'));
        $rows = function_exists('get_field') ? get_field('gallery_images', $id) : null;
        if (is_array($rows)) {
            foreach ($rows as $row) {
                $add(wvn_image_url(is_array($row) ? ($row['image'] ?? $row) : $row, ''));
            }
        }
    }
    wp_reset_postdata();
    foreach (wvn_gallery_images() as $url) {
        $add($url);
    }
    return $items;
}

function wvn_gallery_category_taxonomy() {
    return 'wvn_gallery_category';
}

function wvn_attachment_id_from_media($value) {
    if (is_array($value)) {
        foreach (array('ID', 'id') as $key) {
            if (!empty($value[$key]) && is_numeric($value[$key])) {
                return (int) $value[$key];
            }
        }
    }
    if (is_numeric($value)) {
        return (int) $value;
    }
    if (is_string($value) && $value !== '' && function_exists('attachment_url_to_postid')) {
        return (int) attachment_url_to_postid($value);
    }
    return 0;
}

function wvn_gallery_media_terms($attachment_id) {
    $attachment_id = (int) $attachment_id;
    if (!$attachment_id || !taxonomy_exists(wvn_gallery_category_taxonomy())) {
        return array();
    }
    $terms = wp_get_object_terms($attachment_id, wvn_gallery_category_taxonomy(), array('fields' => 'all'));
    if (is_wp_error($terms) || !$terms) {
        return array();
    }
    $items = array();
    foreach ($terms as $term) {
        $items[] = array(
            'slug' => sanitize_title($term->slug),
            'name' => $term->name,
        );
    }
    return $items;
}

/**
 * Existing gallery ACF media, enriched with stable taxonomy identifiers.
 * The ACF gallery field remains untouched, so existing attachment references survive.
 */
function wvn_home_gallery_media() {
    $rows = wvn_home_rows('home_gallery');
    $items = array();
    foreach ($rows as $row) {
        $url = wvn_image_url($row, '');
        if (!$url) {
            continue;
        }
        $attachment_id = wvn_attachment_id_from_media($row);
        $items[] = array(
            'id' => $attachment_id,
            'url' => $url,
            'type' => 'photo',
            'categories' => wvn_gallery_media_terms($attachment_id),
        );
    }
    return $items;
}

function wvn_gallery_images() {
    $items = wvn_home_gallery_media();
    if ($items) {
        return array_values(array_filter(array_map(static function ($item) {
            return $item['url'] ?? '';
        }, $items)));
    }
    return array(
        wvn_media('2025/04/NVP_JEHANAXKANISHK_WEDDING-1450.jpg'),
        wvn_media('2025/04/2J0A7886-1200x800-1.jpg'),
        wvn_media('2025/04/2J0A2532-533x800-1.jpg'),
        wvn_media('2025/04/2J0A1820-1200x800-1.jpg'),
        wvn_media('2025/04/2J0A1818.jpg'),
        wvn_media('2025/04/2J0A0986-534x800-1.jpg'),
        wvn_media('2025/04/2J0A0682.jpg'),
        wvn_media('2025/05/IMG_4902-scaled.png'),
    );
}

function wvn_home_gallery_legacy_copy() {
    return array(
        'udaipur'    => 'Palace light, lakeside air',
        'palace'     => 'Where tradition finds its stage',
        'lakeside'   => 'Vows beside still water',
        'sangeet'    => 'Music, colour, celebration',
        'wedding'    => 'The ceremony, held with care',
        'receptions' => 'The final toast of the night',
        'intimate'   => 'Fewer guests, deeper moments',
    );
}

function wvn_home_gallery_categories_for_url($url) {
    $id = wvn_attachment_id_from_media($url);
    return wvn_gallery_media_terms($id);
}

/**
 * Homepage cinematic gallery collage — categories are explicitly assigned in wp-admin.
 * There is deliberately no filename/title keyword inference.
 */
function wvn_home_gallery_collage() {
    $media = wvn_home_gallery_media();
    $images = $media ? array_values(array_filter($media, static function ($item) {
        return !empty($item['url']);
    })) : array();
    $weddings = function_exists('wvn_weddings') ? wvn_weddings() : array();
    $legacy_titles = wvn_home_gallery_legacy_copy();
    $roles = array('feature', 'stack-a', 'stack-b', 'portrait', 'wide', 'support-a', 'support-b', 'support-c');
    $editor_items = wvn_home_rows('home_gallery_items');
    $editor_map = array();

    foreach ($editor_items as $row) {
        $row_img = wvn_image_url($row['image'] ?? '', '');
        if ($row_img) {
            $editor_map[$row_img] = $row;
            $id = wvn_attachment_id_from_media($row['image'] ?? '');
            if ($id) {
                $editor_map['id:' . $id] = $row;
            }
        }
    }

    $items = array();
    $count = max(count($images), 6);

    for ($i = 0; $i < $count && $i < 10; $i++) {
        $source = $images[$i % max(1, count($images))] ?? array(
            'url' => wvn_hero_image(),
            'categories' => array(),
            'id' => 0,
        );
        $img = $source['url'] ?? wvn_hero_image();
        $categories = $source['categories'] ?? array();
        $tags = array();

        foreach ($categories as $term) {
            if (!empty($term['slug'])) {
                $tags[] = sanitize_title($term['slug']);
            }
        }
        $tags = array_values(array_unique(array_filter($tags)));

        $editor = $editor_map[$img] ?? null;
        if (!$editor && !empty($source['id'])) {
            $editor = $editor_map['id:' . (int) $source['id']] ?? null;
        }

        $wedding = $weddings[$i % max(1, count($weddings))] ?? null;
        if ($wedding && !empty($wedding['image']) && $i < count($weddings) && $i > 0 && ($i % 3 === 0)) {
            $img = $wedding['image'];
            foreach (wvn_home_gallery_categories_for_url($img) as $term) {
                if (!empty($term['slug'])) {
                    $tags[] = sanitize_title($term['slug']);
                }
            }
            $tags = array_values(array_unique(array_filter($tags)));
        }

        $primary = $tags[0] ?? '';
        $label = 'Uncategorized';
        $title = $legacy_titles[$primary] ?? 'Destination wedding moment';

        if ($primary) {
            $term = get_term_by('slug', $primary, wvn_gallery_category_taxonomy());
            $label = ($term && !is_wp_error($term))
                ? $term->name
                : ucwords(str_replace('-', ' ', $primary));
        }

        $story = '';
        if ($wedding && !empty($wedding['title'])) {
            $title = $wedding['title'];
            $story = $wedding['url'] ?? '';
        }

        if (is_array($editor)) {
            if (!empty($editor['label'])) {
                $label = $editor['label'];
            }
            if (!empty($editor['title'])) {
                $title = $editor['title'];
            }
            if (!empty($editor['url'])) {
                $story = $editor['url'];
            }
        }

        $role = $roles[$i] ?? 'support-c';
        $items[] = array(
            'image' => $img,
            'alt' => (!empty($editor['alt']) ? $editor['alt'] : $title . ' — destination wedding by Wedding Vows by Nikhil'),
            'label' => $label,
            'title' => $title,
            'story_url' => $story,
            'tags' => $tags,
            'role' => $role,
            'type' => 'photo',
            'eager' => $role === 'feature',
        );
    }

    $film = function_exists('wvn_showreel_video') ? wvn_showreel_video() : '';
    $poster = wvn_home_image('home_showreel_image', $images[4]['url'] ?? ($images[0]['url'] ?? wvn_hero_image()));
    $film_field = function_exists('get_field') ? get_field('home_showreel_video', wvn_home_id()) : '';
    $film_id = wvn_attachment_id_from_media($film_field);
    $film_terms = wvn_gallery_media_terms($film_id);
    $film_tags = array();
    foreach ($film_terms as $term) {
        if (!empty($term['slug'])) {
            $film_tags[] = sanitize_title($term['slug']);
        }
    }

    if ($film || $poster) {
        $film_item = array(
            'image' => $poster,
            'alt' => 'Wedding film showreel — Wedding Vows by Nikhil',
            'label' => $film_terms ? implode(' · ', array_column($film_terms, 'name')) : 'The Film',
            'title' => wvn_home_text('home_showreel_caption', 'The Real Story Behind a Dream Wedding'),
            'story_url' => '',
            'tags' => array_values(array_unique($film_tags)),
            'role' => 'film',
            'type' => 'film',
            'eager' => false,
            'video' => $film,
        );
        array_splice($items, 4, 0, array($film_item));
        $ri = 0;
        foreach ($items as &$item) {
            if (($item['type'] ?? '') === 'film') {
                $item['role'] = 'film';
                continue;
            }
            $item['role'] = $roles[$ri] ?? 'support-c';
            $item['eager'] = $item['role'] === 'feature';
            $ri++;
        }
        unset($item);
    }

    $filters = array('all' => 'All');
    foreach ($items as $item) {
        foreach (($item['tags'] ?? array()) as $slug) {
            $term = get_term_by('slug', $slug, wvn_gallery_category_taxonomy());
            if ($term && !is_wp_error($term)) {
                $filters[$term->slug] = $term->name;
            }
        }
    }
    foreach ($items as $item) {
        if (empty($item['tags'])) {
            $filters['uncategorized'] = 'Uncategorized';
            break;
        }
    }

    $kicker = wvn_home_text('home_gallery_kicker', 'Gallery');
    $heading = wvn_home_text('home_gallery_heading', 'Moments, captured beyond time');
    $lede = wvn_home_text('home_gallery_lede', 'A glimpse into the celebrations we have quietly orchestrated—from first looks to the last dance.');
    if ($heading === 'Moments, captured behind the scenes') {
        $heading = 'Moments, captured beyond time';
    }
    if ($lede === 'A glimpse into the celebrations we have quietly orchestrated — from first looks to the last dance.') {
        $lede = 'A glimpse into the celebrations we have quietly orchestrated—from first looks to the last dance.';
    }

    return array(
        'kicker' => $kicker,
        'heading' => $heading,
        'lede' => $lede,
        'cta_url' => wvn_home_text('home_gallery_cta_url', home_url('/portfolio/')),
        'cta' => wvn_home_text('home_gallery_cta', 'View full gallery'),
        'filters' => $filters,
        'items' => $items,
    );
}
function wvn_stories() {
    $gallery = wvn_gallery_images();
    $defaults = array(
        array('title' => 'A Wedding Well Planned', 'caption' => 'In Their Words', 'image' => $gallery[0] ?? wvn_hero_image(), 'video' => ''),
        array('title' => 'Every Detail, Handled', 'caption' => 'In Their Words', 'image' => $gallery[1] ?? wvn_hero_image(), 'video' => ''),
        array('title' => 'Our Dream Celebration', 'caption' => 'In Their Words', 'image' => $gallery[3] ?? wvn_hero_image(), 'video' => ''),
    );
    $rows = wvn_home_rows('home_stories');
    if (!$rows) {
        return $defaults;
    }
    $items = array();
    foreach ($rows as $row) {
        $items[] = array(
            'title'   => $row['title'] ?? '',
            'caption' => $row['caption'] ?? 'In Their Words',
            'image'   => wvn_image_url($row['image'] ?? '', wvn_hero_image()),
            'video'   => wvn_image_url($row['video'] ?? '', ''),
        );
    }
    return $items ?: $defaults;
}

function wvn_press_pages() {
    $defaults = array(
        array(
            'brand' => 'WeddingSutra',
            'title' => 'Nikhil Salvi: The quiet luxury of Udaipur destination weddings',
            'image' => wvn_founder_image(),
            'text'  => '',
        ),
        array(
            'brand' => '',
            'title' => '',
            'image' => '',
            'text'  => "Wedding Vows by Nikhil has become a trusted name for families who want a palace or lakeside celebration without the noise of a large production company. The work is personal, exacting, and quietly luxurious.\n\nFrom the first venue walk-through to the last farewell, one team stays with the couple — designing spaces, coordinating vendors, and hosting guests as if they were family.\n\nFeatured for destination wedding planning in Udaipur, Jaipur, Jodhpur and Goa.",
        ),
        array(
            'brand' => 'Bridestory',
            'title' => 'The growing influence of India’s wedding industry on global tourism',
            'image' => wvn_media('2025/04/2J0A7886-1200x800-1.jpg'),
            'text'  => 'Couples now travel across continents for a wedding that feels rooted — in craft, ritual, and place. Udaipur has become one of those rare cities where heritage and hospitality meet.',
        ),
        array(
            'brand' => '',
            'title' => '',
            'image' => '',
            'text'  => "Event planners who understand both the architecture of a palace and the pace of a family gathering are shaping how the world sees Indian destination weddings.\n\nWedding Vows by Nikhil works with local artisans and first-in-class vendors so every celebration feels specific to the couple — never copied, never rushed.\n\nAwards — Destination wedding planning · Udaipur",
        ),
        array(
            'brand' => 'WedMeGood',
            'title' => 'How to plan an unforgettable destination wedding in India',
            'image' => wvn_media('2025/04/NVP_JEHANAXKANISHK_WEDDING-1450.jpg'),
            'text'  => 'Start with the venue, then the guest journey. The rest — décor, rituals, timing — follows when one team holds the whole picture.',
        ),
        array(
            'brand' => 'WeddingWire',
            'title' => 'The art of wedding planning: a conversation with Nikhil Salvi',
            'image' => wvn_media('2025/04/2J0A1820-1200x800-1.jpg'),
            'text'  => '“Weddings aren’t planned by companies, they’re planned by people.” That idea sits at the centre of every celebration the studio creates.',
        ),
    );
    $rows = wvn_home_rows('home_press_pages');
    if (!$rows) {
        return $defaults;
    }
    $items = array();
    foreach ($rows as $row) {
        $items[] = array(
            'brand' => $row['brand'] ?? '',
            'title' => $row['title'] ?? '',
            'image' => wvn_image_url($row['image'] ?? '', ''),
            'text'  => $row['text'] ?? '',
        );
    }
    return $items ?: $defaults;
}

function wvn_press_logos() {
    $rows = wvn_home_rows('home_press_logos');
    if ($rows) {
        $items = array();
        foreach ($rows as $row) {
            if (!empty($row['label'])) {
                $items[] = $row['label'];
            }
        }
        if ($items) {
            return $items;
        }
    }
    return array('bridestory', 'WedMeGood', 'Zankyou', 'WeddingSutra');
}

function wvn_pressbook_sheets() {
    $gallery = array_values(array_filter(function_exists('wvn_gallery_images') ? wvn_gallery_images() : array()));
    $quotes = array_values(array_filter(wvn_testimonials(), function ($q) {
        return !empty($q['text']) && !empty($q['name']);
    }));

    $pages = array();
    foreach ($quotes as $i => $q) {
        $img = !empty($q['image']) ? $q['image'] : '';
        if (!$img && $gallery) {
            $img = $gallery[$i % count($gallery)];
        }
        if (!$img) {
            $img = function_exists('wvn_hero_image') ? wvn_hero_image() : '';
        }
        $meta = trim((string) ($q['time'] ?? ''));
        if ($meta === '' && !empty($q['tags']) && is_array($q['tags'])) {
            $meta = implode(' · ', array_slice($q['tags'], 0, 2));
        }
        $pages[] = array(
            'brand' => $meta !== '' ? $meta : 'Couple story',
            'title' => $q['name'],
            'image' => $img,
            'text'  => wvn_testimonial_excerpt($q['text'], 42),
            'quote' => true,
            'read_more_url' => wvn_testimonial_page_url($i),
            'read_more_label' => 'Read more',
        );
    }

    $end = array(
        'brand' => wvn_home_text('home_press_end_brand', 'Wedding Vows by Nikhil'),
        'title' => wvn_home_text('home_press_end_title', 'Your celebration, in their words'),
        'image' => '',
        'text'  => wvn_home_text('home_press_end_text', 'These are the moments families remember — the calm before pheras, the guests who felt looked after, and the details that made the day feel entirely theirs.'),
        'small' => 'Tap the arrows or the page to close',
        'end'   => true,
    );

    $cover_fallback = $gallery ? $gallery[0] : (function_exists('wvn_hero_image') ? wvn_hero_image() : '');
    $cover_image = wvn_home_image('home_press_cover', $cover_fallback);
    $founder = function_exists('wvn_founder_image') ? wvn_founder_image() : '';
    // Keep the book on wedding imagery, not the founder portrait.
    if ($founder && $cover_image && $cover_image === $founder && $cover_fallback) {
        $cover_image = $cover_fallback;
    }
    $cover = array(
        'image' => $cover_image ?: $cover_fallback,
        'title' => wvn_home_text('home_press_cover_title', 'Testimonials'),
        'note'  => wvn_home_text('home_press_cover_note', 'Tap to open'),
    );

    if (!$pages) {
        $pages[] = $end;
    }

    $sheets = array();
    $first = array_shift($pages);
    $sheets[] = array(
        'cover' => true,
        'front' => $cover,
        'back'  => $first ?: $end,
    );
    while ($pages) {
        $front = array_shift($pages);
        $back = $pages ? array_shift($pages) : $end;
        $sheets[] = array(
            'cover' => false,
            'front' => $front,
            'back'  => $back,
        );
    }
    return $sheets;
}

function wvn_press_leaf($leaf) {
    if (!$leaf) {
        return;
    }
    $end = !empty($leaf['end']);
    $quote = !empty($leaf['quote']);
    $alt = $leaf['title'] ?? ($leaf['brand'] ?? '');
    ?>
    <div class="wvn-pressbook-leaf<?php echo $end ? ' wvn-pressbook-end' : ''; ?><?php echo $quote ? ' wvn-pressbook-leaf--quote' : ''; ?>">
      <?php if ($quote) : ?>
        <?php if (!empty($leaf['image'])) : ?><img src="<?php echo esc_url($leaf['image']); ?>" alt="<?php echo esc_attr($alt); ?>"><?php endif; ?>
        <?php if (!empty($leaf['title'])) : ?><h3><?php echo esc_html($leaf['title']); ?></h3><?php endif; ?>
        <?php if (!empty($leaf['brand'])) : ?><p class="wvn-pressbook-brand"><?php echo esc_html($leaf['brand']); ?></p><?php endif; ?>
        <?php if (!empty($leaf['text'])) : ?>
          <p class="wvn-pressbook-quote-text"><?php echo esc_html($leaf['text']); ?></p>
        <?php endif; ?>
        <?php if (!empty($leaf['read_more_url'])) : ?>
          <a class="wvn-pressbook-read-more" href="<?php echo esc_url($leaf['read_more_url']); ?>">
            <?php echo esc_html($leaf['read_more_label'] ?? 'Read more'); ?> <span aria-hidden="true">↗</span>
          </a>
        <?php endif; ?>
      <?php else : ?>
        <?php if (!empty($leaf['brand'])) : ?><p class="wvn-pressbook-brand"><?php echo esc_html($leaf['brand']); ?></p><?php endif; ?>
        <?php if (!empty($leaf['title'])) : ?><h3><?php echo esc_html($leaf['title']); ?></h3><?php endif; ?>
        <?php if (!empty($leaf['image'])) : ?><img src="<?php echo esc_url($leaf['image']); ?>" alt="<?php echo esc_attr($alt); ?>"><?php endif; ?>
        <?php if (!empty($leaf['text'])) : ?>
          <?php foreach (preg_split('/\n\s*\n/', trim($leaf['text'])) as $para) : ?>
            <p><?php echo nl2br(esc_html(trim($para))); ?></p>
          <?php endforeach; ?>
        <?php endif; ?>
      <?php endif; ?>
      <?php if (!empty($leaf['small'])) : ?><small><?php echo esc_html($leaf['small']); ?></small><?php endif; ?>
    </div>
    <?php
}

function wvn_nav_items() {
    return array(
        array('label' => 'Home', 'url' => home_url('/'), 'icon' => 'home'),
        array('label' => 'Services', 'url' => home_url('/what-we-do/'), 'icon' => 'grid'),
        array('label' => 'Blog', 'url' => get_option('page_for_posts') ? get_permalink((int) get_option('page_for_posts')) : home_url('/blog/'), 'icon' => 'blog'),
        array('label' => 'Weddings', 'url' => home_url('/portfolio/'), 'icon' => 'image'),
        array('label' => 'Contact', 'url' => home_url('/contact-us/'), 'icon' => 'doc'),
    );
}

function wvn_setup_blog() {
    $approach = get_page_by_path('how-we-do-it');
    if ($approach) {
        wp_delete_post($approach->ID, true);
    }

    $blog = get_page_by_path('blog');
    if (!$blog) {
        $id = wp_insert_post(array(
            'post_title'   => 'Blog',
            'post_name'    => 'blog',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ));
        $blog = $id && !is_wp_error($id) ? get_post($id) : null;
    }
    if ($blog && (int) get_option('page_for_posts') !== (int) $blog->ID) {
        update_option('page_for_posts', (int) $blog->ID);
        if (!get_option('page_on_front')) {
            update_option('show_on_front', 'page');
        }
    }
    if (get_option('_wvn_blog_seeded')) {
        return;
    }
    $samples = array(
        array(
            'title'   => 'How to choose a palace venue in Udaipur',
            'excerpt' => 'What to look for when the guest list, season, and rituals all have to fit one courtyard.',
            'image'   => wvn_media('2025/04/NVP_JEHANAXKANISHK_WEDDING-1450.jpg'),
            'content' => '<p>Udaipur’s palaces are not interchangeable. Guest count, arrival flow, and where the pheras sit at sunset should decide the venue — not the photograph you fell in love with first.</p><p>Walk the property at the hour you will marry. Check how guests move from welcome drinks to the mandap, and whether the rooms you need are on the same campus. We hold those relationships so the date, the rooms, and the ceremony lawn are confirmed together.</p>',
        ),
        array(
            'title'   => 'What a full-service wedding studio actually handles',
            'excerpt' => 'Venue, décor, hospitality, and the day itself — why one brief is easier than a dozen vendors.',
            'image'   => wvn_media('2025/04/2J0A7886-1200x800-1.jpg'),
            'content' => '<p>Most destination weddings fail in the gaps between vendors. The florist has not spoken to lighting. The hotel does not know when the baraat arrives. A full-service studio keeps one plan, one timeline, and one person accountable.</p><p>At Wedding Vows by Nikhil that means design, vendors, guest care, and on-ground coordination stay in the same conversation from the first call to the last farewell.</p>',
        ),
        array(
            'title'   => 'Planning a destination wedding timeline in India',
            'excerpt' => 'When to book the venue, the artists, and the décor — and what can wait.',
            'image'   => wvn_media('2025/04/2J0A1820-1200x800-1.jpg'),
            'content' => '<p>Peak palace dates in Udaipur fill eight to twelve months ahead. Artists usually need around three months; décor detailing can sit closer, once the venue and guest count are locked.</p><p>Start with the season and the guest journey. The rest — rituals, menus, and the run of show — follows when one team holds the whole picture.</p>',
        ),
    );
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    foreach ($samples as $sample) {
        $post_id = wp_insert_post(array(
            'post_title'   => $sample['title'],
            'post_excerpt' => $sample['excerpt'],
            'post_content' => $sample['content'],
            'post_status'  => 'publish',
            'post_type'    => 'post',
        ));
        if (!$post_id || is_wp_error($post_id)) {
            continue;
        }
        $image_id = media_sideload_image($sample['image'], $post_id, $sample['title'], 'id');
        if (!is_wp_error($image_id) && $image_id) {
            set_post_thumbnail($post_id, (int) $image_id);
        }
    }
    update_option('_wvn_blog_seeded', '1');
}
add_action('init', 'wvn_setup_blog', 30);

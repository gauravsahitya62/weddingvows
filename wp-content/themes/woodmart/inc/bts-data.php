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
    return $post_id === $front
        || $post_id === $posts
        || $template === 'page-what-we-do.php'
        || $post->post_name === 'what-we-do'
        || $post->post_name === 'home'
        || $post->post_name === 'blog';
}

function wvn_hide_acf_layout_editor() {
    $post_id = isset($_GET['post']) ? (int) $_GET['post'] : (isset($_POST['post_ID']) ? (int) $_POST['post_ID'] : 0);
    if ($post_id && wvn_is_acf_layout_page($post_id)) {
        remove_post_type_support('page', 'editor');
    }
}
add_action('admin_init', 'wvn_hide_acf_layout_editor');

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
    echo '<div class="notice notice-info"><p><strong>This page is edited from the fields below</strong> — not the old WordPress or Elementor editor. What you save here is what appears on the live page.</p></div>';
}
add_action('admin_notices', 'wvn_acf_layout_admin_notice');

function wvn_elementor_can_edit_acf_page($can_edit, $post) {
    if ($post && wvn_is_acf_layout_page($post->ID)) {
        return false;
    }
    return $can_edit;
}
add_filter('elementor/editor/can_edit_post', 'wvn_elementor_can_edit_acf_page', 10, 2);

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
        'post_type'      => 'portfolio',
        'posts_per_page' => 8,
        'post_status'    => 'publish',
    ));
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $items[] = array(
                'title'    => get_the_title(),
                'venue'    => get_the_excerpt() ?: 'Udaipur, Rajasthan',
                'url'      => get_permalink(),
                'image'    => $thumb ?: wvn_hero_image(),
            );
        }
        wp_reset_postdata();
    }
    if (count($items) < 3) {
        $items = array(
            array(
                'title' => 'Jehana & Kanishk',
                'venue' => 'Udaipur, Rajasthan',
                'url'   => home_url('/portfolio/'),
                'image' => wvn_media('2025/04/NVP_JEHANAXKANISHK_WEDDING-1450.jpg'),
            ),
            array(
                'title' => 'A Royal Evening',
                'venue' => 'Palace Courtyard, Udaipur',
                'url'   => home_url('/portfolio/'),
                'image' => wvn_media('2025/04/2J0A7886-1200x800-1.jpg'),
            ),
            array(
                'title' => 'Candlelit Vows',
                'venue' => 'Heritage Venue, Udaipur',
                'url'   => home_url('/portfolio/'),
                'image' => wvn_media('2025/04/2J0A1820-1200x800-1.jpg'),
            ),
            array(
                'title' => 'Marigold Procession',
                'venue' => 'Udaipur, Rajasthan',
                'url'   => home_url('/portfolio/'),
                'image' => wvn_media('2025/04/2J0A1818.jpg'),
            ),
            array(
                'title' => 'The First Look',
                'venue' => 'Udaipur, Rajasthan',
                'url'   => home_url('/portfolio/'),
                'image' => wvn_media('2025/04/2J0A0682.jpg'),
            ),
            array(
                'title' => 'Guest Welcome',
                'venue' => 'Udaipur, Rajasthan',
                'url'   => home_url('/portfolio/'),
                'image' => wvn_media('2025/04/2J0A0986-534x800-1.jpg'),
            ),
            array(
                'title' => 'Palace Vows',
                'venue' => 'Udaipur, Rajasthan',
                'url'   => home_url('/portfolio/'),
                'image' => wvn_media('2025/04/2J0A2532-533x800-1.jpg'),
            ),
        );
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

function wvn_testimonials() {
    $rows = wvn_home_rows('home_quotes');
    if ($rows) {
        $items = array();
        foreach ($rows as $row) {
            $tags = $row['tags'] ?? array();
            if (is_string($tags)) {
                $tags = array_filter(array_map('trim', explode(',', $tags)));
            }
            $items[] = array(
                'name' => $row['name'] ?? '',
                'time' => $row['time'] ?? '',
                'text' => $row['text'] ?? '',
                'tags' => $tags,
                'dark' => !empty($row['dark']),
            );
        }
        return $items;
    }
    return array(
        array(
            'name' => 'Mansi & Aneel',
            'time' => '4 months ago',
            'text' => 'Every detail was handled before we even thought to ask. From the first venue visit to the final pheras, the team made a palace wedding feel completely stress-free.',
            'tags' => array('On Time Service', 'Quality of Work', 'Highly Experienced'),
            'dark' => true,
        ),
        array(
            'name' => 'Jehana & Kanishk',
            'time' => '8 months ago',
            'text' => 'Nikhil and the team understood our families, our rituals, and the kind of quiet luxury we wanted. Guests are still talking about the décor.',
            'tags' => array('Unique Ideas', 'Quality of Work'),
            'dark' => false,
        ),
        array(
            'name' => 'Vidushi Mishra',
            'time' => '6 months ago',
            'text' => 'Hospitality for outstation guests was flawless. Cars, rooms, welcome details — we never had to chase anyone.',
            'tags' => array('On Time Service', 'Highly Experienced'),
            'dark' => false,
        ),
        array(
            'name' => 'Aishwarya & Dishant',
            'time' => '1 year ago',
            'text' => 'We wanted maximal colour without chaos. They designed spaces that felt like us and then executed them perfectly on the ground.',
            'tags' => array('Unique Ideas', 'Quality of Work'),
            'dark' => true,
        ),
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

function wvn_gallery_images() {
    $rows = wvn_home_rows('home_gallery');
    if ($rows) {
        $items = array();
        foreach ($rows as $row) {
            $url = wvn_image_url($row, '');
            if ($url) {
                $items[] = $url;
            }
        }
        if ($items) {
            return $items;
        }
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
    $pages = wvn_press_pages();
    $end = array(
        'brand' => wvn_home_text('home_press_end_brand', 'Wedding Vows by Nikhil'),
        'title' => wvn_home_text('home_press_end_title', 'The story continues in person'),
        'image' => '',
        'text'  => wvn_home_text('home_press_end_text', 'Press coverage is only a glimpse. The work is in the rooms, the timing, and the people who stay with you until the last farewell.'),
        'small' => 'Tap the arrows or the page to close',
        'end'   => true,
    );
    $cover = array(
        'image' => wvn_home_image('home_press_cover', wvn_founder_image()),
        'title' => wvn_home_text('home_press_cover_title', 'Featured in'),
        'note'  => wvn_home_text('home_press_cover_note', 'Tap to open'),
    );
    $sheets = array();
    $first = $pages ? array_shift($pages) : $end;
    $sheets[] = array(
        'cover' => true,
        'front' => $cover,
        'back'  => $first,
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
    ?>
    <div class="wvn-pressbook-leaf<?php echo $end ? ' wvn-pressbook-end' : ''; ?>">
      <?php if (!empty($leaf['brand'])) : ?><p class="wvn-pressbook-brand"><?php echo esc_html($leaf['brand']); ?></p><?php endif; ?>
      <?php if (!empty($leaf['title'])) : ?><h3><?php echo esc_html($leaf['title']); ?></h3><?php endif; ?>
      <?php if (!empty($leaf['image'])) : ?><img src="<?php echo esc_url($leaf['image']); ?>" alt="<?php echo esc_attr($leaf['title'] ?: $leaf['brand']); ?>"><?php endif; ?>
      <?php if (!empty($leaf['text'])) : ?>
        <?php foreach (preg_split('/\n\s*\n/', trim($leaf['text'])) as $para) : ?>
          <p><?php echo nl2br(esc_html(trim($para))); ?></p>
        <?php endforeach; ?>
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

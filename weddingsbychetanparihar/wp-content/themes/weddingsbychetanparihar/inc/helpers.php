<?php
/**
 * Shared helpers, URLs, and first-run content.
 */

if (!defined('ABSPATH')) {
    exit;
}

function wbc_unsplash($photo_id, $width = 1600) {
    return 'https://images.unsplash.com/photo-' . $photo_id . '?auto=format&fit=crop&w=' . (int) $width . '&q=80';
}

function wbc_default_image($key = 'hero') {
    $images = array(
        'hero'       => wbc_unsplash('1587271407850-8d438ca9fdf2', 2000),
        'cta'        => wbc_unsplash('1727430256509-0f897d6f4765', 2000),
        'process'    => wbc_unsplash('1587271636175-90d58cdad458', 2000),
        'editorial'  => wbc_unsplash('1733937140732-2cc70a1d7017', 1600),
        'kind'       => wbc_unsplash('1774024051976-7b5a15542a05', 2000),
        'founder'    => wbc_unsplash('1665960213533-52fc5b41daff', 900),
        'about'      => wbc_unsplash('1733937111165-36efb3ded769', 1600),
        'wedding-1'  => wbc_unsplash('1733759414886-6b3a5423ceb3', 1400),
        'wedding-2'  => wbc_unsplash('1647949940712-bfcf82015d9b', 1400),
        'wedding-3'  => wbc_unsplash('1661877574666-c6574f69fa9d', 1400),
        'wedding-4'  => wbc_unsplash('1762201698238-bf412e297016', 1400),
        'couple'     => wbc_unsplash('1716604435424-b24fb7b891c3', 1400),
        'ceremony'   => wbc_unsplash('1774024051461-433f8f16faac', 1600),
        'decor'      => wbc_unsplash('1744805624890-9931ebb50428', 1600),
        'palace'     => wbc_unsplash('1578662996442-48f60103fc96', 1600),
        'reception'  => wbc_unsplash('1666916991821-d594c8fceaff', 1600),
        'udaipur'    => wbc_unsplash('1759387759149-2109e4fa3198', 1600),
        'jaipur'     => wbc_unsplash('1477587458883-47145ed94245', 1600),
        'jodhpur'    => wbc_unsplash('1676094259695-ae66ba12ab8a', 1600),
        'goa'        => wbc_unsplash('1512343879784-a960bf40e7f2', 1600),
        'ahmedabad'  => wbc_unsplash('1582510003544-4d00b7f74220', 1600),
        'strip-1'    => wbc_unsplash('1505932794465-147d1f1b2c97', 900),
        'strip-2'    => wbc_unsplash('1554787388-9194e4eb57a3', 900),
        'strip-3'    => wbc_unsplash('1641755322620-b99e9132fceb', 900),
        'strip-4'    => wbc_unsplash('1661885411165-a08c34f40488', 900),
        'strip-5'    => wbc_unsplash('1654156577076-e0350ba86cc1', 900),
        'service-1'  => wbc_unsplash('1774024052568-3c2701e21fa7', 1600),
        'service-2'  => wbc_unsplash('1744804298612-fa9f2ef0e125', 1600),
        'service-3'  => wbc_unsplash('1774020040126-83543f6de513', 1600),
        'service-4'  => wbc_unsplash('1774020040429-50604124854a', 1600),
        'service-5'  => wbc_unsplash('1666916990615-51537445e50b', 1600),
        'service-6'  => wbc_unsplash('1774024872805-5a73cc24a721', 1600),
        'faq'        => WBC_THEME_URI . '/assets/img/faq.jpg',
        'journal-1'  => wbc_unsplash('1599661046289-e31897846e41', 1600),
        'journal-2'  => wbc_unsplash('1548013146-72479768bada', 1600),
        'extra-1'    => wbc_unsplash('1727430334014-3f3c90400455', 1400),
        'extra-2'    => wbc_unsplash('1727430334033-d2ffe559bdce', 1400),
        'extra-3'    => wbc_unsplash('1727430334140-c21dc3d415f1', 1400),
        'extra-4'    => wbc_unsplash('1727430228383-aa1fb59db8bf', 1400),
        'extra-5'    => wbc_unsplash('1665960213530-3fb10da1f25e', 1400),
        'extra-6'    => wbc_unsplash('1665960211002-0ecf92bed0ac', 1400),
        'extra-7'    => 'https://assets.mixkit.co/videos/50785/50785-thumb-720-0.jpg',
        'extra-8'    => wbc_unsplash('1727430201245-fb796167e302', 1400),
        'extra-9'    => wbc_unsplash('1665960213508-48f07086d49c', 1400),
        'extra-10'   => wbc_unsplash('1635919252654-64529dd4584b', 1400),
        'extra-11'   => wbc_unsplash('1635919252717-de7c8b9bde19', 1400),
        'extra-12'   => 'https://assets.mixkit.co/videos/50786/50786-thumb-720-0.jpg',
        'extra-13'   => wbc_unsplash('1774024050561-4ee0148c8526', 1400),
        'extra-14'   => wbc_unsplash('1727430347136-3965eb462e04', 1400),
        'extra-15'   => wbc_unsplash('1774020039643-0fd333d5983a', 1400),
        'extra-16'   => wbc_unsplash('1774020039644-95b548cd2053', 1400),
    );
    return $images[$key] ?? $images['hero'];
}

function wbc_default_video($slot = 'hero') {
    $videos = array(
        'hero'      => 'https://assets.mixkit.co/videos/50781/50781-720.mp4',
        'cta'       => 'https://assets.mixkit.co/videos/50790/50790-720.mp4',
        'process'   => 'https://assets.mixkit.co/videos/50780/50780-720.mp4',
        'editorial' => 'https://assets.mixkit.co/videos/50787/50787-720.mp4',
    );
    return $videos[$slot] ?? $videos['hero'];
}

function wbc_image_key_for_post($post_id, $fallback = 'hero') {
    $title = $post_id ? trim(wp_strip_all_tags(html_entity_decode(get_the_title($post_id), ENT_QUOTES, 'UTF-8'))) : '';
    $map = array(
        'A Palace Evening' => 'wedding-1',
        'Marigold Courtyard' => 'wedding-2',
        'Moonlit Vows' => 'wedding-3',
        'Blue City Gathering' => 'wedding-4',
        'Udaipur' => 'udaipur',
        'Jaipur' => 'jaipur',
        'Jodhpur' => 'jodhpur',
        'Goa' => 'goa',
        'Ahmedabad & Surat' => 'ahmedabad',
        'Venue Curation' => 'service-1',
        'Decor & Design' => 'service-2',
        'Planning & Production' => 'service-3',
        'Hospitality & Logistics' => 'service-4',
        'Budget & Vendor Direction' => 'service-5',
        'Entertainment & Moments' => 'service-6',
        'How to plan an elegant destination wedding in Udaipur' => 'journal-1',
        'Jaipur or Udaipur: choosing a Rajasthan wedding city' => 'journal-2',
        'Hello world!' => 'extra-8',
    );
    if ($title && isset($map[$title])) {
        return $map[$title];
    }

    $type = $post_id ? get_post_type($post_id) : '';
    $pools = array(
        'wbc_wedding'     => array('wedding-1', 'wedding-2', 'wedding-3', 'wedding-4', 'extra-6', 'extra-7'),
        'wbc_destination' => array('udaipur', 'jaipur', 'jodhpur', 'goa', 'ahmedabad', 'extra-14'),
        'wbc_service'     => array('service-1', 'service-2', 'service-3', 'service-4', 'service-5', 'service-6'),
        'post'            => array('journal-1', 'journal-2', 'extra-8', 'extra-9'),
    );
    if (isset($pools[$type])) {
        $pool = $pools[$type];
        return $pool[(int) $post_id % count($pool)];
    }

    return $fallback;
}

function wbc_mod($name, $default = '') {
    $value = get_theme_mod($name, $default);
    return $value === '' || $value === false || $value === null ? $default : $value;
}

function wbc_default_stats() {
    return array(
        1 => array('value' => '1', 'label' => 'Team, end to end'),
        2 => array('value' => '8+', 'label' => 'Cities planned'),
        3 => array('value' => 'Pin to plane', 'label' => 'Planning depth'),
        4 => array('value' => 'Udaipur', 'label' => 'Home studio'),
    );
}

function wbc_default_pillars() {
    return array(
        1 => array(
            'label' => '01',
            'title' => 'One studio',
            'text'  => 'Design, logistics and guest care held as a single conversation — never twelve vendors stitched together.',
        ),
        2 => array(
            'label' => '02',
            'title' => 'Design first',
            'text'  => 'Rooms, rituals and light are shaped before production. The weekend should feel like the couple, not a catalogue.',
        ),
        3 => array(
            'label' => '03',
            'title' => 'On the ground',
            'text'  => 'The same team stays until the last farewell. Families move; we hold the cues, hospitality and calm.',
        ),
        4 => array(
            'label' => '04',
            'title' => 'Udaipur home',
            'text'  => 'A studio rooted in Rajasthan, with a map that reaches Jaipur, Jodhpur, Goa and beyond.',
        ),
    );
}

function wbc_listing_defaults($slot) {
    $map = array(
        'services' => array(
            'kicker' => 'Planning & design',
            'title'  => 'Wedding planning, design and guest care — one studio.',
            'text'   => 'Venue, decor, production, hospitality and vendors are held as a single conversation so families are never stitching twelve teams together.',
            'cta'    => 'Start an enquiry',
            'image'  => wbc_default_image('service-1'),
        ),
        'weddings' => array(
            'kicker' => 'Portfolio',
            'title'  => 'Real weddings by ' . wbc_brand_name(),
            'text'   => 'Palace, heritage, lakeside and destination celebrations — each story told through rooms, rituals and light.',
            'cta'    => 'Plan a weekend',
            'image'  => wbc_default_image('wedding-1'),
        ),
        'journal' => array(
            'kicker' => 'Journal',
            'title'  => 'Wedding planning notes for thoughtful celebrations.',
            'text'   => 'Destination guides, design notes, venue thinking and practical timelines from ' . wbc_brand_name() . '.',
            'cta'    => 'Read the latest note',
            'image'  => wbc_default_image('journal-1'),
        ),
    );
    return isset($map[$slot]) ? $map[$slot] : array();
}

function wbc_listing_key($slot, $field) {
    if ($slot === 'journal') {
        return 'wbc_journal_' . $field;
    }
    return 'wbc_' . $slot . '_page_' . $field;
}

function wbc_listing_mod($slot, $field) {
    $defaults = wbc_listing_defaults($slot);
    $default = isset($defaults[$field]) ? $defaults[$field] : '';
    return wbc_mod(wbc_listing_key($slot, $field), $default);
}

function wbc_brand_name() {
    return wbc_mod('wbc_brand_name', 'Chetan Parihar Weddings');
}

function wbc_brand_parts() {
    $name = trim(wbc_brand_name());
    $words = preg_split('/\s+/', $name);
    if (count($words) < 2) {
        return array($name, '');
    }
    $last = array_pop($words);
    return array(implode(' ', $words), $last);
}

function wbc_youtube_id($url) {
    if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([A-Za-z0-9_-]{11})~', (string) $url, $match)) {
        return $match[1];
    }
    return '';
}

function wbc_vimeo_id($url) {
    if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', (string) $url, $match)) {
        return $match[1];
    }
    return '';
}

function wbc_slot_setting($slot, $kind, $default = '') {
    $key = 'wbc_' . $slot . '_' . $kind;
    $value = wbc_mod($key, '');
    if ($value === '') {
        $front_id = (int) get_option('page_on_front');
        if ($front_id) {
            $value = wbc_meta($front_id, $key, '');
        }
    }
    return $value !== '' ? $value : $default;
}

function wbc_slot_image($slot, $fallback = 'hero') {
    return wbc_slot_setting($slot, 'image', wbc_default_image($fallback));
}

function wbc_slot_video($slot) {
    return wbc_slot_setting($slot, 'video', wbc_default_video($slot));
}

function wbc_slot_uses_video($slot) {
    $type = wbc_slot_setting($slot, 'media_type', 'photo');
    return $type === 'video' && wbc_slot_video($slot);
}

function wbc_render_band_media($slot, $args = array()) {
    $args = wp_parse_args($args, array(
        'alt'      => wbc_brand_name(),
        'fallback' => 'hero',
        'eager'    => false,
    ));
    $image = wbc_slot_image($slot, $args['fallback']);
    $video = wbc_slot_video($slot);
    $youtube = wbc_youtube_id($video);
    $vimeo = wbc_vimeo_id($video);

    if (wbc_slot_uses_video($slot)) {
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

function wbc_has_band() {
    if (is_front_page() || is_page('contact')) {
        return false;
    }
    return is_page('about')
        || is_home()
        || is_singular(array('post', 'wbc_wedding', 'wbc_service'))
        || is_post_type_archive(array('wbc_wedding', 'wbc_service'));
}

function wbc_render_page_band($args = array()) {
    $args = wp_parse_args($args, array(
        'kicker'   => '',
        'title'    => '',
        'lead'     => '',
        'cta'      => '',
        'cta_url'  => '',
        'image'    => '',
        'alt'      => '',
        'fallback' => 'hero',
        'eager'    => true,
    ));
    $image = $args['image'] ?: wbc_default_image($args['fallback']);
    $alt = $args['alt'] ?: wp_strip_all_tags($args['title']);
    $eager = $args['eager'] ? ' fetchpriority="high"' : ' loading="lazy"';
    ?>
    <section class="wbc-band">
        <div class="wbc-band-media" data-parallax>
            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($alt); ?>"<?php echo $eager; ?> decoding="async">
        </div>
        <div class="wbc-band-copy">
            <?php if ($args['kicker']) : ?>
                <p class="wbc-kicker is-light"><?php echo esc_html($args['kicker']); ?></p>
            <?php endif; ?>
            <h1 class="wbc-hero-title"><?php echo esc_html($args['title']); ?></h1>
            <?php if ($args['lead']) : ?>
                <p class="wbc-hero-lead"><?php echo esc_html($args['lead']); ?></p>
            <?php endif; ?>
            <?php if ($args['cta'] && $args['cta_url']) : ?>
                <a class="wbc-textlink is-light" href="<?php echo esc_url($args['cta_url']); ?>"><?php echo esc_html($args['cta']); ?></a>
            <?php endif; ?>
        </div>
    </section>
    <?php
}

function wbc_render_story_card($post, $args = array()) {
    $args = wp_parse_args($args, array(
        'meta'     => '',
        'city'     => '',
        'fallback' => 'couple',
        'eager'    => false,
    ));
    $city_attr = $args['city'] !== '' ? ' data-city="' . esc_attr($args['city']) . '"' : '';
    $loading = $args['eager'] ? 'eager' : 'lazy';
    ?>
    <article class="wbc-story-card"<?php echo $city_attr; ?>>
        <a href="<?php echo esc_url(get_permalink($post)); ?>">
            <figure>
                <img src="<?php echo esc_url(wbc_image_url($post->ID, $args['fallback'])); ?>" alt="<?php echo esc_attr(get_the_title($post)); ?>" loading="<?php echo esc_attr($loading); ?>" decoding="async">
            </figure>
            <?php if ($args['meta']) : ?>
                <span><?php echo esc_html($args['meta']); ?></span>
            <?php endif; ?>
            <h3><?php echo esc_html(get_the_title($post)); ?></h3>
        </a>
    </article>
    <?php
}

function wbc_related_posts($post_id, $type = '', $limit = 4) {
    $type = $type ?: get_post_type($post_id);
    return get_posts(array(
        'post_type'      => $type,
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'post__not_in'   => array((int) $post_id),
        'orderby'        => array('menu_order' => 'ASC', 'date' => 'DESC'),
    ));
}

function wbc_render_related_film($posts, $args = array()) {
    $args = wp_parse_args($args, array(
        'kicker'   => 'Continue',
        'title'    => 'More from the studio.',
        'link'     => '',
        'label'    => '',
        'meta_key' => '',
        'fallback' => 'couple',
    ));
    if (!$posts) {
        return;
    }
    ?>
    <section class="wbc-section wbc-latest">
        <div class="wbc-section-head is-center">
            <p class="wbc-kicker"><?php echo esc_html($args['kicker']); ?></p>
            <h2><?php echo esc_html($args['title']); ?></h2>
        </div>
        <div class="wbc-film" data-film>
            <div class="wbc-film-track">
                <?php foreach ($posts as $i => $item) : ?>
                    <a class="wbc-film-card" href="<?php echo esc_url(get_permalink($item)); ?>">
                        <figure>
                            <img src="<?php echo esc_url(wbc_image_url($item->ID, $args['fallback'])); ?>" alt="<?php echo esc_attr(get_the_title($item)); ?>" loading="<?php echo $i < 2 ? 'eager' : 'lazy'; ?>" decoding="async">
                        </figure>
                        <?php if ($args['meta_key']) : ?>
                            <span><?php echo esc_html(wbc_meta($item->ID, $args['meta_key'], get_the_date('', $item))); ?></span>
                        <?php else : ?>
                            <span><?php echo esc_html(get_the_date('', $item)); ?></span>
                        <?php endif; ?>
                        <h3><?php echo esc_html(get_the_title($item)); ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php if ($args['link'] && $args['label']) : ?>
            <div class="wbc-center-link">
                <a class="wbc-textlink" href="<?php echo esc_url($args['link']); ?>"><?php echo esc_html($args['label']); ?></a>
            </div>
        <?php endif; ?>
    </section>
    <?php
}

function wbc_logo_url() {
    $logo_id = get_theme_mod('custom_logo');
    if ($logo_id) {
        $logo = wp_get_attachment_image_url((int) $logo_id, 'full');
        if ($logo) {
            return $logo;
        }
    }
    return '';
}

function wbc_image_url($post_id = 0, $fallback = 'hero') {
    $post_id = $post_id ?: get_the_ID();
    $url = $post_id ? get_the_post_thumbnail_url($post_id, 'full') : '';
    if ($url) {
        return $url;
    }
    return wbc_default_image(wbc_image_key_for_post($post_id, $fallback));
}

function wbc_refresh_media_pack() {
    if (get_option('wbc_media_pack') === '2026-08-31-c') {
        return;
    }
    $mods = array(
        'wbc_hero_image'          => wbc_default_image('hero'),
        'wbc_hero_media_type'     => 'video',
        'wbc_hero_video'          => wbc_default_video('hero'),
        'wbc_cta_image'           => wbc_default_image('cta'),
        'wbc_cta_media_type'      => 'video',
        'wbc_cta_video'           => wbc_default_video('cta'),
        'wbc_editorial_image'     => wbc_default_image('editorial'),
        'wbc_editorial_media_type'=> 'video',
        'wbc_editorial_video'     => wbc_default_video('editorial'),
        'wbc_process_image'       => wbc_default_image('process'),
        'wbc_process_media_type'  => 'video',
        'wbc_process_video'       => wbc_default_video('process'),
        'wbc_kind_image'          => wbc_default_image('kind'),
        'wbc_kind_media_type'     => 'photo',
        'wbc_founder_image'       => wbc_default_image('founder'),
        'wbc_about_image'         => wbc_default_image('about'),
    );
    foreach ($mods as $name => $value) {
        set_theme_mod($name, $value);
    }
    update_option('wbc_media_pack', '2026-08-31-c');
}

function wbc_get_ordered_posts($type, $limit = -1) {
    return get_posts(array(
        'post_type'      => $type,
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'orderby'        => array('menu_order' => 'ASC', 'date' => 'DESC'),
    ));
}

function wbc_meta($post_id, $key, $default = '') {
    $value = get_post_meta((int) $post_id, $key, true);
    return $value === '' ? $default : $value;
}

function wbc_excerpt($post_id, $words = 26) {
    $excerpt = get_the_excerpt($post_id);
    if (!$excerpt) {
        $excerpt = wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $post_id)), $words);
    }
    return $excerpt;
}

function wbc_page_url($slug, $fallback = '') {
    $page = get_page_by_path($slug);
    return $page ? get_permalink($page) : ($fallback ?: home_url('/' . trim($slug, '/') . '/'));
}

function wbc_faq_image() {
    $image = (string) get_theme_mod('wbc_faq_image', '');
    if ($image === '' || $image === 'none') {
        return '';
    }
    // Drop the old Unsplash placeholder so cleared / migrated sites can use parchment.
    if (strpos($image, 'photo-1661877574666') !== false) {
        return '';
    }
    return $image;
}

function wbc_footer_strip() {
    $linked = array_slice(array_merge(
        wbc_get_ordered_posts('wbc_wedding', 4),
        wbc_get_ordered_posts('wbc_destination', 3)
    ), 0, 5);
    $items = array();
    for ($i = 1; $i <= 5; $i++) {
        $item = $linked[$i - 1] ?? null;
        $items[] = array(
            'url'   => $item ? get_permalink($item) : '',
            'alt'   => $item ? get_the_title($item) : wbc_brand_name(),
            'image' => wbc_mod('wbc_footer_image_' . $i, wbc_default_image('strip-' . $i)),
        );
    }
    return $items;
}

function wbc_contact_url() {
    return wbc_page_url('contact');
}

function wbc_contact_page_id() {
    $page = get_page_by_path('contact');
    return $page ? (int) $page->ID : 0;
}

function wbc_contact_setting($key, $default = '') {
    return wbc_editor_value(wbc_contact_page_id(), $key) ?: $default;
}

function wbc_studio_email() {
    $email = sanitize_email(wbc_contact_setting('wbc_email', 'hello@chetanpariharweddings.com'));
    return $email ?: get_option('admin_email');
}

function wbc_contact_form_fields() {
    return array(
        'name'    => array('label' => 'Name', 'type' => 'text', 'autocomplete' => 'name', 'required' => true, 'locked' => true),
        'email'   => array('label' => 'Email', 'type' => 'email', 'autocomplete' => 'email'),
        'phone'   => array('label' => 'Phone', 'type' => 'tel', 'autocomplete' => 'tel'),
        'date'    => array('label' => 'Wedding date', 'type' => 'date'),
        'city'    => array('label' => 'City / destination', 'type' => 'text', 'placeholder' => 'Udaipur, Jaipur, Goa…'),
        'guests'  => array('label' => 'Guest count', 'type' => 'text', 'placeholder' => '180'),
        'budget'  => array('label' => 'Approximate budget', 'type' => 'text', 'placeholder' => 'Planning + decor range'),
        'message' => array('label' => 'Message', 'type' => 'textarea', 'placeholder' => 'Rituals, venues you love, guest cities…', 'wide' => true),
    );
}

function wbc_contact_field($key) {
    $fields = wbc_contact_form_fields();
    if (!isset($fields[$key])) {
        return null;
    }
    $field = $fields[$key];
    $field['key'] = $key;
    $field['label'] = wbc_contact_setting('wbc_form_' . $key . '_label', $field['label']);
    $field['placeholder'] = wbc_contact_setting('wbc_form_' . $key . '_placeholder', $field['placeholder'] ?? '');
    $show = !empty($field['locked']) ? 'yes' : wbc_contact_setting('wbc_form_' . $key . '_show', 'yes');
    $field['show'] = $show !== 'no';
    return $field;
}

function wbc_visible_contact_fields() {
    $visible = array();
    foreach (array_keys(wbc_contact_form_fields()) as $key) {
        $field = wbc_contact_field($key);
        if ($field && $field['show']) {
            $visible[$key] = $field;
        }
    }
    return $visible;
}

function wbc_about_url() {
    return wbc_page_url('about');
}

function wbc_weddings_url() {
    return get_post_type_archive_link('wbc_wedding') ?: home_url('/weddings/');
}

function wbc_services_url() {
    return get_post_type_archive_link('wbc_service') ?: home_url('/services/');
}

function wbc_destinations_url() {
    return get_post_type_archive_link('wbc_destination') ?: home_url('/destinations/');
}

function wbc_journal_url() {
    $id = (int) get_option('page_for_posts');
    return $id ? get_permalink($id) : home_url('/journal/');
}

function wbc_phone_plain() {
    return preg_replace('/[^0-9+]/', '', wbc_mod('wbc_phone', '+91 76667 78899'));
}

function wbc_whatsapp_url() {
    $custom = wbc_mod('wbc_whatsapp_url', '');
    if ($custom) {
        return $custom;
    }
    $phone = preg_replace('/[^0-9]/', '', wbc_phone_plain());
    return $phone ? 'https://wa.me/' . $phone : '#';
}

function wbc_full_address() {
    $parts = array_filter(array(
        wbc_mod('wbc_street', '31, New Polo Ground, Saheli Nagar'),
        wbc_mod('wbc_city', 'Udaipur'),
        wbc_mod('wbc_state', 'Rajasthan'),
        wbc_mod('wbc_postcode', '313001'),
        wbc_mod('wbc_country', 'India'),
    ));
    return implode(', ', $parts);
}

function wbc_nav_items() {
    return array(
        array('label' => 'Home', 'url' => home_url('/'), 'icon' => 'home', 'match' => 'home'),
        array('label' => 'Services', 'url' => wbc_services_url(), 'icon' => 'grid', 'match' => 'services'),
        array('label' => 'Weddings', 'url' => wbc_weddings_url(), 'icon' => 'image', 'match' => 'weddings'),
        array('label' => 'Destinations', 'url' => wbc_destinations_url(), 'icon' => 'pin', 'match' => 'destinations'),
        array('label' => 'Journal', 'url' => wbc_journal_url(), 'icon' => 'note', 'match' => 'journal'),
        array('label' => 'Contact', 'url' => wbc_contact_url(), 'icon' => 'mail', 'match' => 'contact'),
    );
}

function wbc_header_nav_items() {
    return array(
        array('label' => 'About', 'url' => wbc_about_url(), 'match' => 'about'),
        array('label' => 'Services', 'url' => wbc_services_url(), 'match' => 'services'),
        array('label' => 'Real Weddings', 'url' => wbc_weddings_url(), 'match' => 'weddings'),
        array('label' => 'Blog', 'url' => wbc_journal_url(), 'match' => 'journal'),
        array('label' => 'contact', 'url' => wbc_contact_url(), 'match' => 'contact', 'script' => true),
    );
}

function wbc_nav_is_active($item) {
    $match = $item['match'] ?? '';
    if ($match === 'home') {
        return is_front_page();
    }
    if ($match === 'services') {
        return is_post_type_archive('wbc_service') || is_singular('wbc_service');
    }
    if ($match === 'weddings') {
        return is_post_type_archive('wbc_wedding') || is_singular('wbc_wedding');
    }
    if ($match === 'destinations') {
        return is_post_type_archive('wbc_destination') || is_singular('wbc_destination');
    }
    if ($match === 'journal') {
        return is_home() || is_singular('post') || is_category() || is_tag();
    }
    if ($match === 'about') {
        return is_page('about');
    }
    if ($match === 'contact') {
        return is_page('contact');
    }
    return untrailingslashit($item['url']) === untrailingslashit(wbc_canonical_url());
}

function wbc_svg_icon($name) {
    $icons = array(
        'home'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 11.5 12 4l8 7.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1v-8.5z"/></svg>',
        'grid'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="4" y="4" width="7" height="7" rx="1.5"/><rect x="13" y="4" width="7" height="7" rx="1.5"/><rect x="4" y="13" width="7" height="7" rx="1.5"/><rect x="13" y="13" width="7" height="7" rx="1.5"/></svg>',
        'image' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10" r="1.5"/><path d="m21 16-5-5-9 8"/></svg>',
        'note'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M5 5h14M5 10h14M5 15h8M5 20h6"/></svg>',
        'mail'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="4" y="5" width="16" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>',
        'pin'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.2"/></svg>',
        'arrow' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M7 17 17 7M8 7h9v9"/></svg>',
        'search' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="11" cy="11" r="6.5"/><path d="m16 16 5 5"/></svg>',
        'instagram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="4" y="4" width="16" height="16" rx="5"/><circle cx="12" cy="12" r="3.4"/><circle cx="17.2" cy="6.8" r="0.8" fill="currentColor"/></svg>',
        'facebook' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M14.2 21v-7.2h2.4l.4-2.8h-2.8V9.2c0-.8.2-1.4 1.4-1.4h1.5V5.3c-.3 0-1.2-.1-2.2-.1-2.2 0-3.7 1.3-3.7 3.8v2h-2.5v2.8H11v7.2h3.2z"/></svg>',
        'youtube' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M21.6 7.2a2.7 2.7 0 0 0-1.9-1.9C18 5 12 5 12 5s-6 0-7.7.3A2.7 2.7 0 0 0 2.4 7.2 28 28 0 0 0 2 12a28 28 0 0 0 .4 4.8 2.7 2.7 0 0 0 1.9 1.9C6 19 12 19 12 19s6 0 7.7-.3a2.7 2.7 0 0 0 1.9-1.9A28 28 0 0 0 22 12a28 28 0 0 0-.4-4.8ZM10 15.2V8.8L15.2 12 10 15.2Z"/></svg>',
        'pinterest' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 3.2A8.8 8.8 0 0 0 8.4 20c.1-.7.4-1.8.7-2.6l1.3-5c-.3-.5-.4-1.2-.4-1.9 0-1.7 1-3 2.3-3 1 0 1.6.8 1.6 1.8 0 1.1-.7 2.8-1.1 4.3-.3 1.3.6 2.4 1.9 2.4 2.3 0 3.8-2.9 3.8-6.4 0-2.6-1.8-4.6-5-4.6-3.6 0-5.8 2.7-5.8 5.7 0 1 .3 1.8.9 2.4.1.1.1.2.1.3l-.3 1.3c0 .2-.2.3-.4.2-1.6-.7-2.3-2.6-2.3-4.7 0-3.5 3-7.7 8.9-7.7 4.7 0 7.8 3.4 7.8 7.1 0 4.8-2.7 8.4-6.6 8.4-1.3 0-2.6-.7-3-.1l-.8 3.2A8.8 8.8 0 1 0 12 3.2Z"/></svg>',
        'tiktok' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M14.8 3c.4 2.4 1.8 4 4.2 4.2v2.4c-1.4 0-2.7-.4-4-1.1v6.3c0 3.2-2.5 5.6-5.8 5.2A5.2 5.2 0 0 1 8.4 10c.8 0 1.5.2 2.2.6v2.6a2.6 2.6 0 1 0 1.8 2.5V3h2.4Z"/></svg>',
        'wedmegood' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 20s-6.2-4.4-6.2-9.1A3.7 3.7 0 0 1 12 8.2a3.7 3.7 0 0 1 6.2 2.7C18.2 15.6 12 20 12 20z"/></svg>',
    );
    return $icons[$name] ?? $icons['arrow'];
}

function wbc_gallery_ids($post_id) {
    $raw = wbc_meta($post_id, 'wbc_gallery_ids');
    return array_values(array_filter(array_map('absint', explode(',', (string) $raw))));
}

function wbc_updated_label($post_id = 0) {
    $post_id = $post_id ?: get_the_ID();
    return get_the_modified_date('F Y', $post_id);
}

function wbc_social_links() {
    $links = array(
        'instagram' => wbc_mod('wbc_instagram', ''),
        'facebook'  => wbc_mod('wbc_facebook', ''),
        'pinterest' => wbc_mod('wbc_pinterest', ''),
        'youtube'   => wbc_mod('wbc_youtube', ''),
        'tiktok'    => wbc_mod('wbc_tiktok', ''),
        'wedmegood' => wbc_mod('wbc_wedmegood', 'https://www.wedmegood.com/profile/Chetan-Parihar-Weddings-106898'),
    );
    return array_filter($links);
}

function wbc_footer_socials() {
    $order = array('pinterest', 'facebook', 'instagram', 'tiktok');
    $items = array();
    foreach ($order as $name) {
        $url = esc_url_raw(wbc_mod('wbc_' . $name, ''));
        $items[] = array(
            'name' => $name,
            'url'  => $url,
        );
    }
    return $items;
}

function wbc_footer_mark() {
    $mark = wbc_mod('wbc_footer_mark', '');
    if ($mark === '') {
        $mark = strtoupper(substr(wbc_brand_name(), 0, 1));
    }
    return $mark;
}

function wbc_footer_logo() {
    return wbc_mod('wbc_footer_logo', '');
}

function wbc_intro_defaults() {
    return array(
        'kicker' => 'Our Services',
        'title'  => 'The Art of the Celebration',
        'text'   => 'Full-service wedding planning and design for extraordinary people and unforgettable moments.',
        'cta'    => 'Explore Services',
        'alt'    => 'A twilight celebration pavilion planned by Chetan Parihar Weddings',
    );
}

function wbc_intro_legacy($key) {
    $legacy = array(
        'kicker' => array('Destination wedding planner in Udaipur, India'),
        'title'  => array(
            'You want a wedding that feels elegant, effortless, and completely your own.',
            'For couples and families who want a wedding that feels extraordinary — and completely calm.',
        ),
        'text'   => array(
            'Chetan Parihar Weddings plans destination celebrations from Udaipur across Rajasthan, Gujarat, Goa and beyond. One team designs the rooms, holds the vendors, and stays on the ground until the last farewell.',
        ),
    );
    return isset($legacy[$key]) ? $legacy[$key] : array();
}

function wbc_intro_value($key, $mod_key) {
    $defaults = wbc_intro_defaults();
    $fallback = isset($defaults[$key]) ? $defaults[$key] : '';
    $value = wbc_mod($mod_key, '');
    if ($value === '' || in_array($value, wbc_intro_legacy($key), true)) {
        return $fallback;
    }
    return $value;
}

function wbc_intro_image() {
    $image = wbc_mod('wbc_intro_image', '');
    return $image !== '' ? $image : wbc_default_image('ceremony');
}

function wbc_intro_cta_url() {
    $url = wbc_mod('wbc_intro_cta_url', '');
    return $url !== '' ? $url : wbc_services_url();
}

function wbc_default_intro_icons() {
    $kinds = array(
        'planning'      => 'Planning',
        'design'        => 'Design & Decor',
        'destination'   => 'Destination',
        'hospitality'   => 'Hospitality',
        'entertainment' => 'Entertainment',
        'photography'   => 'Photography',
    );
    $items = array();
    foreach ($kinds as $kind => $label) {
        $items[] = array(
            'kind'  => $kind,
            'label' => $label,
            'url'   => '',
            'icon'  => WBC_THEME_URI . '/assets/img/icons/' . $kind . '.svg',
        );
    }
    return $items;
}

function wbc_intro_icons() {
    $raw = get_theme_mod('wbc_intro_icons', array());
    if (empty($raw)) {
        $front_id = (int) get_option('page_on_front');
        if ($front_id) {
            $meta = get_post_meta($front_id, 'wbc_intro_icons', true);
            if ($meta !== '' && $meta !== false) {
                $raw = $meta;
            }
        }
    }
    if (is_string($raw)) {
        $decoded = json_decode($raw, true);
        $raw = is_array($decoded) ? $decoded : array();
    }
    if (!is_array($raw) || !$raw) {
        return wbc_default_intro_icons();
    }
    $items = array();
    foreach ($raw as $item) {
        if (!is_array($item)) {
            continue;
        }
        $icon = isset($item['icon']) ? esc_url_raw($item['icon']) : '';
        $url = isset($item['url']) ? esc_url_raw($item['url']) : '';
        $label = isset($item['label']) ? sanitize_text_field($item['label']) : '';
        $kind = isset($item['kind']) ? sanitize_key($item['kind']) : '';
        if ($icon === '' && $kind !== '') {
            $icon = WBC_THEME_URI . '/assets/img/icons/' . $kind . '.svg';
        }
        if ($icon === '' && $label === '') {
            continue;
        }
        $items[] = array(
            'kind'  => $kind,
            'icon'  => $icon,
            'url'   => $url,
            'label' => $label,
        );
    }
    return $items ? $items : wbc_default_intro_icons();
}

function wbc_footer_links() {
    $raw = get_theme_mod('wbc_footer_links', array());
    if (empty($raw)) {
        $front_id = (int) get_option('page_on_front');
        if ($front_id) {
            $meta = get_post_meta($front_id, 'wbc_footer_links', true);
            if ($meta !== '' && $meta !== false) {
                $raw = $meta;
            }
        }
    }
    if (is_string($raw)) {
        $decoded = json_decode($raw, true);
        $raw = is_array($decoded) ? $decoded : array();
    }
    if (!is_array($raw)) {
        return array();
    }
    $items = array();
    foreach ($raw as $item) {
        if (!is_array($item)) {
            continue;
        }
        $icon = isset($item['icon']) ? esc_url_raw($item['icon']) : '';
        $url = isset($item['url']) ? esc_url_raw($item['url']) : '';
        $label = isset($item['label']) ? sanitize_text_field($item['label']) : '';
        if ($icon === '' && $url === '') {
            continue;
        }
        $items[] = array(
            'icon'  => $icon,
            'url'   => $url,
            'label' => $label,
        );
    }
    return $items;
}

function wbc_cta_image() {
    return wbc_slot_image('cta', 'cta');
}

function wbc_render_cta($as_page = false) {
    $image = wbc_cta_image();
    $label = wbc_mod('wbc_cta_kicker', 'Contact us');
    if (strcasecmp($label, 'Begin the conversation') === 0) {
        $label = 'Contact us';
    }
    $video = wbc_slot_uses_video('cta');
    $classes = 'wbc-cta' . ($as_page ? ' is-page' : '') . ($video ? ' has-video' : '');
    ?>
    <section class="<?php echo esc_attr($classes); ?>" data-cta style="--cta-image: url('<?php echo esc_url($image); ?>')">
        <div class="wbc-cta-media<?php echo $video ? ' is-embed' : ''; ?>" data-parallax>
            <?php wbc_render_band_media('cta', array('alt' => $label, 'fallback' => 'cta')); ?>
        </div>
        <?php if ($as_page) : ?>
            <h1 class="wbc-cta-mark"><?php echo esc_html($label); ?></h1>
        <?php else : ?>
            <a class="wbc-cta-mark" href="<?php echo esc_url(wbc_contact_url()); ?>"><?php echo esc_html($label); ?></a>
        <?php endif; ?>
    </section>
    <?php
}

function wbc_ensure_page($slug, $title, $template = '', $content = '') {
    $page = get_page_by_path($slug);
    if ($page) {
        if ($template) {
            update_post_meta((int) $page->ID, '_wp_page_template', $template);
        }
        return $page;
    }
    $id = wp_insert_post(array(
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => $content,
    ));
    if (!$id || is_wp_error($id)) {
        return null;
    }
    if ($template) {
        update_post_meta($id, '_wp_page_template', $template);
    }
    return get_post($id);
}

function wbc_seed_pages() {
    $home = wbc_ensure_page('home', 'Home');
    if ($home) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', (int) $home->ID);
    }

    wbc_ensure_page(
        'about',
        'About',
        'page-about.php',
        '<p>Chetan Parihar Weddings is a Udaipur-based destination wedding planning and event styling studio. The work is personal: one team holds venue, design, hospitality, vendors, and the weekend itself.</p>'
    );
    wbc_ensure_page('contact', 'Contact', 'page-contact.php');
    $journal = wbc_ensure_page('journal', 'Journal');
    if ($journal) {
        update_option('page_for_posts', (int) $journal->ID);
    }
    wbc_ensure_page(
        'privacy',
        'Privacy',
        '',
        '<p>Enquiries submitted through this website are stored as private Contact Leads in WordPress and emailed to the studio. We use your details only to respond to wedding planning conversations. Update this page from Pages in wp-admin.</p>'
    );
}

function wbc_insert_if_missing($type, $title, $args = array(), $meta = array()) {
    $found = get_posts(array(
        'post_type'      => $type,
        'title'          => $title,
        'post_status'    => 'any',
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ));
    if ($found) {
        return (int) $found[0];
    }
    $id = wp_insert_post(array_merge(array(
        'post_type'   => $type,
        'post_status' => 'publish',
        'post_title'  => $title,
    ), $args));
    if (!$id || is_wp_error($id)) {
        return 0;
    }
    foreach ($meta as $key => $value) {
        update_post_meta($id, $key, $value);
    }
    return (int) $id;
}

function wbc_seed_content() {
    $services = array(
        array('Venue Curation', 'Palaces, lakeside resorts, heritage havelis and private estates chosen around guest flow, rooms, rituals and light.', 'Pin to plane'),
        array('Decor & Design', 'Floral direction, mandap language, tablescapes, lighting and handmade details shaped around the couple rather than a borrowed trend.', 'Studio signature'),
        array('Planning & Production', 'Vendor calls, permissions, technical run sheets, ceremony cues and function-by-function execution with one accountable team.', 'End to end'),
        array('Hospitality & Logistics', 'Airport pickups, welcome desks, rooming lists, movement plans and the invisible calm families remember after the music fades.', 'Guest care'),
        array('Budget & Vendor Direction', 'Clear cost architecture, trusted specialists, and decisions that protect both the mood of the wedding and the family’s peace of mind.', 'Stewardship'),
        array('Entertainment & Moments', 'Music, rituals, welcome dinners and the small staged surprises that make a multi-day celebration feel alive.', 'Atmosphere'),
    );
    foreach ($services as $i => $service) {
        wbc_insert_if_missing('wbc_service', $service[0], array(
            'post_content' => $service[1],
            'post_excerpt' => $service[1],
            'menu_order'   => $i,
        ), array('wbc_service_kicker' => $service[2]));
    }

    $weddings = array(
        array('A Palace Evening', 'City Palace, Udaipur', 'Udaipur, Rajasthan', 'Winter', '220 guests', 'A soft-lit sangeet and lakeside pheras across two unhurried days in Udaipur.'),
        array('Marigold Courtyard', 'Heritage Haveli', 'Jaipur, Rajasthan', 'Spring', '180 guests', 'A colour-rich celebration designed around family rituals and handmade courtyard details.'),
        array('Moonlit Vows', 'Private Lakeside Resort', 'Goa', 'December', '140 guests', 'A coastal wedding with intimate ceremonies, warm tables and cinematic nights.'),
        array('Blue City Gathering', 'Fort Lawn', 'Jodhpur, Rajasthan', 'November', '260 guests', 'A desert-light wedding weekend with processions, open sky and a long farewell brunch.'),
    );
    foreach ($weddings as $i => $wedding) {
        wbc_insert_if_missing('wbc_wedding', $wedding[0], array(
            'post_excerpt' => $wedding[5],
            'post_content' => '<p>' . esc_html($wedding[5]) . '</p><p>Use this page in wp-admin to add the full story, couple names, gallery, film link and planning notes. Featured image becomes the portfolio cover.</p>',
            'menu_order'   => $i,
        ), array(
            'wbc_venue' => $wedding[1],
            'wbc_location' => $wedding[2],
            'wbc_season' => $wedding[3],
            'wbc_guest_count' => $wedding[4],
            'wbc_style' => $i % 2 ? 'Heritage' : 'Palace',
        ));
    }

    $destinations = array(
        array('Udaipur', 'Rajasthan, India', '24.5854', '73.7125', 'October to March', 'Palaces, lake palaces, heritage hotels', 'Udaipur is the studio’s home city — lakes, marble courtyards and palace weekends planned with local knowledge of rooms, permissions and guest movement.'),
        array('Jaipur', 'Rajasthan, India', '26.9124', '75.7873', 'November to February', 'Havelis, forts, palace lawns', 'Jaipur weddings ask for colour, craft and courtyard scale. The studio designs around the city’s light and the family’s ritual calendar.'),
        array('Jodhpur', 'Rajasthan, India', '26.2389', '73.0243', 'October to March', 'Forts, desert resorts, city palaces', 'Jodhpur offers open sky, fort architecture and a quieter luxury. Ideal for families who want grandeur without a crowded calendar.'),
        array('Goa', 'India', '15.2993', '74.1240', 'November to February', 'Coastal resorts, villas, heritage homes', 'Coastal celebrations with intimate ceremonies, warm tables and guest stays that feel like a shared holiday rather than a production.'),
        array('Ahmedabad & Surat', 'Gujarat, India', '23.0225', '72.5714', 'November to February', 'Heritage homes, lawns, city hotels', 'Family-led Gujarati celebrations planned with hospitality, vendor clarity and a calm weekend structure.'),
    );
    foreach ($destinations as $i => $place) {
        wbc_insert_if_missing('wbc_destination', $place[0], array(
            'post_content' => $place[6],
            'post_excerpt' => $place[6],
            'menu_order'   => $i,
        ), array(
            'wbc_region' => $place[1],
            'wbc_latitude' => $place[2],
            'wbc_longitude' => $place[3],
            'wbc_best_season' => $place[4],
            'wbc_venue_types' => $place[5],
        ));
    }

    $steps = array(
        array('Tell us your story', 'ONE', 'Share the date, guest count, cities you are considering, and the feeling you want the weekend to hold. The first conversation is about people, not packages.'),
        array('We shape a firm plan', 'TWO', 'Venues, rooms, design language and a cost architecture are built around your rituals. You see clear options, not an endless moodboard.'),
        array('Details become a run sheet', 'THREE', 'Vendors, hospitality, timelines, permissions and ceremony cues are locked so the wedding can run without the couple managing it.'),
        array('You live the wedding', 'FOUR', 'The studio holds the ground. Families move through welcome dinners, pheras and farewells while one team keeps the weekend calm.'),
    );
    foreach ($steps as $i => $step) {
        wbc_insert_if_missing('wbc_process', $step[0], array(
            'post_content' => $step[2],
            'menu_order'   => $i,
        ), array('wbc_step_label' => $step[1]));
    }

    $press = array(
        array('WedMeGood', 'Destination wedding planning from Udaipur', 'Featured planner profile for palace and destination celebrations across Rajasthan and Goa.'),
        array('Dream Wedding Hub', 'Decor-led destination studio', 'Noted for pin-to-plane planning and a design-first approach to Indian destination weddings.'),
    );
    foreach ($press as $i => $item) {
        wbc_insert_if_missing('wbc_press', $item[1], array(
            'post_content' => $item[2],
            'menu_order'   => $i,
        ), array('wbc_publication' => $item[0], 'wbc_year' => '2025'));
    }

    $testimonials = array(
        array('Rhea & Arjun', 'The team made a complex destination wedding feel beautifully simple. Every room, cue and guest moment felt considered.', 'Udaipur palace wedding'),
        array('Ananya & Dev', 'Chetan understood the emotion of the wedding, not just the production. Our weekend still feels like us.', 'Jaipur haveli celebration'),
        array('Family of the Bride', 'The calmest team on the busiest weekend. They handled hospitality, vendors and timelines with complete grace.', 'Jodhpur fort wedding'),
    );
    foreach ($testimonials as $i => $quote) {
        wbc_insert_if_missing('wbc_testimonial', $quote[0], array(
            'post_content' => $quote[1],
            'menu_order'   => $i,
        ), array('wbc_rating' => '5', 'wbc_event' => $quote[2]));
    }

    $faqs = array(
        array('What does Chetan Parihar Weddings manage?', 'The studio can manage venue shortlisting, decor direction, planning, hospitality, logistics, vendor coordination, entertainment and on-ground wedding execution for destination and city celebrations.'),
        array('Where do you plan weddings?', 'The studio is based in Udaipur and regularly plans destination weddings in Jaipur, Jodhpur, Ahmedabad, Surat, Goa and other Indian wedding cities.'),
        array('How early should we enquire?', 'For peak-season palace and destination weddings, enquire eight to twelve months ahead when possible. Intimate weekends can sometimes be planned on shorter timelines.'),
        array('Is everything on this website editable?', 'Yes. Weddings, services, destinations, process steps, press, testimonials, FAQs, journal articles, contact leads and brand settings are all managed from WordPress admin — no code required.'),
        array('Do you only plan luxury palace weddings?', 'Palace and heritage weddings are a strength, but the studio also plans intimate destination weekends and family-led city celebrations. The approach stays the same: one team, clear decisions, calm ground.'),
    );
    foreach ($faqs as $i => $faq) {
        wbc_insert_if_missing('wbc_faq', $faq[0], array(
            'post_content' => $faq[1],
            'menu_order'   => $i,
        ));
    }

    wbc_insert_if_missing('post', 'How to plan an elegant destination wedding in Udaipur', array(
        'post_excerpt' => 'A practical note for couples comparing venues, guest flow, decor and timelines for an Udaipur destination wedding.',
        'post_content' => '<p>Start with guest count, season and the room block before choosing the photograph you love most. The right venue is the one that holds your rituals, your families and your movement plan.</p><p>Then define the mood of each function: welcome dinner, mehendi, sangeet, pheras, reception and farewell. A calm wedding weekend is designed backwards from the guest experience.</p><p>Chetan Parihar Weddings is based in Udaipur and can walk venues with you, then hold design, vendors and hospitality as one conversation.</p>',
    ));
    wbc_insert_if_missing('post', 'Jaipur or Udaipur: choosing a Rajasthan wedding city', array(
        'post_excerpt' => 'A short comparison of light, venues, guest travel and ritual fit for two of India’s most requested destination wedding cities.',
        'post_content' => '<p>Udaipur offers lakes, palace courtyards and a concentrated luxury hotel map. Jaipur offers colour, haveli intimacy and easier flight connections for many families.</p><p>Choose the city for the guest journey first, then the photograph. Both can be extraordinary when one team holds rooms, design and timing.</p>',
    ));

    update_option('wbc_seed_content_v1', '1');
    update_option('wbc_seed_content_v2', '1');
    update_option('blogdescription', 'Destination wedding planning and celebration design from Udaipur.');
}

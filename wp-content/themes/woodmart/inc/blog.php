<?php
/**
 * Blog listing helpers, categories, and header fields.
 */

function wvn_blog_category_map() {
    return array(
        'real-weddings'  => 'Real Weddings',
        'planning-tips'  => 'Planning Tips',
        'destinations'   => 'Destinations',
        'decor-design'   => 'Decor & Design',
        'bridal-style'   => 'Bridal Style',
    );
}

function wvn_blog_ensure_categories() {
    foreach (wvn_blog_category_map() as $slug => $name) {
        if (!term_exists($slug, 'category')) {
            wp_insert_term($name, 'category', array('slug' => $slug));
        }
    }
}

function wvn_reading_time($post_id = 0) {
    $post_id = $post_id ?: get_the_ID();
    $words = str_word_count(wp_strip_all_tags(get_post_field('post_content', $post_id)));
    return max(1, (int) ceil($words / 180));
}

function wvn_post_category($post_id = 0) {
    $cats = get_the_category($post_id ?: get_the_ID());
    foreach ($cats as $cat) {
        if ($cat->slug !== 'uncategorized') {
            return $cat;
        }
    }
    return $cats ? $cats[0] : null;
}

function wvn_blog_image($post_id = 0, $size = 'large') {
    $post_id = $post_id ?: get_the_ID();
    return get_the_post_thumbnail_url($post_id, $size) ?: wvn_hero_image();
}

function wvn_next_blog_post($post_id = 0) {
    $post_id = $post_id ?: get_the_ID();
    $next = get_next_post();
    if ($next) {
        return $next;
    }
    $prev = get_previous_post();
    if ($prev) {
        return $prev;
    }
    $others = get_posts(array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 1,
        'post__not_in'        => array((int) $post_id),
        'orderby'             => 'date',
        'order'               => 'DESC',
        'ignore_sticky_posts' => true,
    ));
    return $others ? $others[0] : null;
}

function wvn_blog_header() {
    $id = (int) get_option('page_for_posts');
    $defaults = array(
        'kicker'  => 'The journal',
        'heading' => 'Destination wedding notes from Udaipur',
        'lede'    => 'Real weddings, planning wisdom and destination guides — from an Udaipur studio that plans palace and lakeside celebrations across India.',
    );
    if (is_category()) {
        $term = get_queried_object();
        if ($term && !is_wp_error($term)) {
            return array(
                'kicker'  => 'The journal',
                'heading' => $term->name,
                'lede'    => $term->description ?: $defaults['lede'],
            );
        }
    }
    if (!$id || !function_exists('get_field')) {
        return $defaults;
    }
    return array(
        'kicker'  => get_field('blog_kicker', $id) ?: $defaults['kicker'],
        'heading' => get_field('blog_heading', $id) ?: $defaults['heading'],
        'lede'    => get_field('blog_lede', $id) ?: $defaults['lede'],
    );
}

function wvn_blog_hero_image() {
    $id = (int) get_option('page_for_posts');
    if ($id) {
        $thumb = get_the_post_thumbnail_url($id, 'full');
        if ($thumb) {
            return $thumb;
        }
    }
    return function_exists('wvn_hero_image') ? wvn_hero_image() : '';
}

function wvn_register_blog_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }
    $locations = array(
        array(
            array(
                'param' => 'page_type',
                'operator' => '==',
                'value' => 'posts_page',
            ),
        ),
    );
    $page = get_page_by_path('blog');
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
        'key' => 'group_wvn_blog',
        'title' => 'Blog listing header',
        'position' => 'acf_after_title',
        'hide_on_screen' => array('the_content', 'excerpt', 'discussion', 'comments'),
        'location' => $locations,
        'fields' => array(
            array('key' => 'field_wvn_blog_kicker', 'label' => 'Kicker', 'name' => 'blog_kicker', 'type' => 'text'),
            array('key' => 'field_wvn_blog_heading', 'label' => 'Heading', 'name' => 'blog_heading', 'type' => 'text'),
            array('key' => 'field_wvn_blog_lede', 'label' => 'Intro', 'name' => 'blog_lede', 'type' => 'textarea', 'rows' => 3),
        ),
    ));

    acf_add_local_field_group(array(
        'key' => 'group_wvn_post',
        'title' => 'Article extras',
        'position' => 'acf_after_title',
        'location' => array(
            array(
                array('param' => 'post_type', 'operator' => '==', 'value' => 'post'),
            ),
        ),
        'fields' => array(
            array('key' => 'field_wvn_post_overlay', 'label' => 'Hero overlay title', 'name' => 'post_overlay_title', 'type' => 'text'),
            array('key' => 'field_wvn_post_overlay_sub', 'label' => 'Hero overlay subtitle', 'name' => 'post_overlay_sub', 'type' => 'text'),
            array(
                'key' => 'field_wvn_post_gallery',
                'label' => 'In-article gallery',
                'name' => 'post_gallery',
                'type' => 'gallery',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_wvn_post_faqs',
                'label' => 'FAQs',
                'name' => 'post_faqs',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add question',
                'sub_fields' => array(
                    array('key' => 'field_wvn_post_faq_q', 'label' => 'Question', 'name' => 'q', 'type' => 'text'),
                    array('key' => 'field_wvn_post_faq_a', 'label' => 'Answer', 'name' => 'a', 'type' => 'textarea', 'rows' => 3),
                ),
            ),
            array('key' => 'field_wvn_post_faq_heading', 'label' => 'FAQ heading', 'name' => 'post_faq_heading', 'type' => 'text'),
            array('key' => 'field_wvn_post_cta_heading', 'label' => 'Bottom CTA heading', 'name' => 'post_cta_heading', 'type' => 'text'),
            array('key' => 'field_wvn_post_cta_text', 'label' => 'Bottom CTA text', 'name' => 'post_cta_text', 'type' => 'text'),
            array('key' => 'field_wvn_post_cta_button', 'label' => 'Bottom CTA button', 'name' => 'post_cta_button', 'type' => 'text'),
            array('key' => 'field_wvn_post_venue_name', 'label' => 'Tagged venue name', 'name' => 'post_venue_name', 'type' => 'text'),
            array('key' => 'field_wvn_post_venue_meta', 'label' => 'Tagged venue meta', 'name' => 'post_venue_meta', 'type' => 'text'),
            array('key' => 'field_wvn_post_venue_url', 'label' => 'Tagged venue URL', 'name' => 'post_venue_url', 'type' => 'url'),
            array('key' => 'field_wvn_post_venue_image', 'label' => 'Tagged venue image', 'name' => 'post_venue_image', 'type' => 'image', 'return_format' => 'array'),
        ),
    ));
}
add_action('acf/init', 'wvn_register_blog_fields');

function wvn_post_meta($post_id = 0) {
    $post_id = $post_id ?: get_the_ID();
    $overlay = '';
    $sub = '';
    $faqs = array();
    $gallery = array();
    $faq_heading = '';
    $cta_heading = '';
    $cta_text = '';
    $cta_button = '';
    $venue = array('name' => '', 'meta' => '', 'url' => '', 'image' => '');
    if (function_exists('get_field')) {
        $overlay = (string) get_field('post_overlay_title', $post_id);
        $sub = (string) get_field('post_overlay_sub', $post_id);
        $faq_heading = (string) get_field('post_faq_heading', $post_id);
        $cta_heading = (string) get_field('post_cta_heading', $post_id);
        $cta_text = (string) get_field('post_cta_text', $post_id);
        $cta_button = (string) get_field('post_cta_button', $post_id);
        $rows = get_field('post_faqs', $post_id);
        if (is_array($rows)) {
            foreach ($rows as $row) {
                if (!empty($row['q'])) {
                    $faqs[] = array('q' => $row['q'], 'a' => $row['a'] ?? '');
                }
            }
        }
        $images = get_field('post_gallery', $post_id);
        if (is_array($images)) {
            foreach ($images as $image) {
                $url = wvn_image_url($image, '');
                if ($url) {
                    $gallery[] = $url;
                }
            }
        }
        $venue = array(
            'name'  => (string) get_field('post_venue_name', $post_id),
            'meta'  => (string) get_field('post_venue_meta', $post_id),
            'url'   => (string) get_field('post_venue_url', $post_id),
            'image' => wvn_image_url(get_field('post_venue_image', $post_id), ''),
        );
    }
    return array(
        'overlay'     => $overlay,
        'sub'         => $sub,
        'faqs'        => $faqs,
        'gallery'     => $gallery,
        'faq_heading' => $faq_heading ?: 'Questions, answered',
        'cta_heading' => $cta_heading ?: 'Let us help you plan your wedding',
        'cta_text'    => $cta_text ?: 'Fill out this form to get in touch with us',
        'cta_button'  => $cta_button ?: 'Plan my wedding ↗',
        'venue'       => $venue,
    );
}

function wvn_blog_filters() {
    $blog_url = get_permalink((int) get_option('page_for_posts')) ?: home_url('/blog/');
    $current = is_category() ? get_queried_object()->slug : '';
    ?>
    <nav class="wvn-blog-filters" aria-label="Journal categories">
      <a class="<?php echo $current === '' ? 'is-active' : ''; ?>" href="<?php echo esc_url($blog_url); ?>">All</a>
      <?php foreach (wvn_blog_category_map() as $slug => $name) :
          $term = get_term_by('slug', $slug, 'category');
          if (!$term || is_wp_error($term)) {
              continue;
          }
          ?>
        <a class="<?php echo $current === $slug ? 'is-active' : ''; ?>" href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($name); ?></a>
      <?php endforeach; ?>
    </nav>
    <?php
}

function wvn_blog_card($featured = false) {
    $cat = wvn_post_category();
    $image = wvn_blog_image(0, $featured ? 'full' : 'large');
    $mins = wvn_reading_time();
    ?>
    <article class="wvn-blog-card<?php echo $featured ? ' is-featured' : ''; ?>">
      <a href="<?php the_permalink(); ?>">
        <figure><img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"></figure>
        <div class="wvn-blog-card-copy">
          <p class="wvn-blog-cat">
            <?php echo $cat ? esc_html($cat->name) : 'Journal'; ?>
            <?php if ($featured) : ?> · <?php echo (int) $mins; ?> min read<?php endif; ?>
          </p>
          <h2><?php the_title(); ?></h2>
          <p><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), $featured ? 36 : 22)); ?></p>
          <p class="wvn-blog-meta">Wedding Vows by Nikhil — <?php echo esc_html(get_the_date('M j, Y')); ?></p>
          <?php if ($featured) : ?><span class="wvn-blog-more">Read the story →</span><?php endif; ?>
        </div>
      </a>
    </article>
    <?php
}

function wvn_render_journal() {
    $header = wvn_blog_header();
    $empty = is_category() ? 'No stories in this category yet.' : 'No stories in this journal yet.';
    $has_posts = have_posts();
    $show_featured = $has_posts && !is_paged() && !is_category();
    $hero = wvn_blog_hero_image();
    ?>
<main id="content" class="wvn-blog">
  <header class="wvn-page-hero">
    <div class="wvn-page-hero__media" style="background-image:url('<?php echo esc_url($hero); ?>')" aria-hidden="true"></div>
    <div class="wvn-page-hero__veil" aria-hidden="true"></div>
    <div class="wvn-page-hero__grain" aria-hidden="true"></div>
    <div class="wvn-page-hero__inner">
      <p class="wvn-page-hero__eyebrow"><?php echo esc_html($header['kicker']); ?></p>
      <h1 class="wvn-display"><?php echo esc_html($header['heading']); ?></h1>
      <p class="wvn-page-hero__lede"><?php echo esc_html($header['lede']); ?></p>
    </div>
  </header>
  <div class="wvn-blog-shell">
    <div class="wvn-blog-top">
      <?php wvn_blog_filters(); ?>
      <?php if ($show_featured) : the_post(); ?>
        <section class="wvn-blog-featured">
          <?php wvn_blog_card(true); ?>
        </section>
      <?php endif; ?>
    </div>
    <?php if (have_posts()) : ?>
      <div class="wvn-blog-grid">
        <?php while (have_posts()) : the_post(); ?>
          <?php wvn_blog_card(false); ?>
        <?php endwhile; ?>
      </div>
      <div class="wvn-blog-nav"><?php the_posts_pagination(array('prev_text' => 'Previous', 'next_text' => 'Next')); ?></div>
    <?php elseif (!$has_posts) : ?>
      <p class="wvn-lede"><?php echo esc_html($empty); ?></p>
    <?php endif; ?>
  </div>
</main>
    <?php
}

function wvn_blog_query_size($query) {
    if (!is_admin() && $query->is_main_query() && ($query->is_home() || $query->is_category())) {
        $query->set('posts_per_page', 10);
    }
}
add_action('pre_get_posts', 'wvn_blog_query_size');

function wvn_setup_blog_taxonomy() {
    wvn_blog_ensure_categories();
    if (get_option('_wvn_blog_layout_v2')) {
        return;
    }
    $assign = array(
        'how-to-choose-a-palace-venue-in-udaipur' => 'destinations',
        'what-a-full-service-wedding-studio-actually-handles' => 'planning-tips',
        'planning-a-destination-wedding-timeline-in-india' => 'planning-tips',
    );
    foreach ($assign as $slug => $cat) {
        $post = get_page_by_path($slug, OBJECT, 'post');
        if ($post) {
            wp_set_object_terms($post->ID, $cat, 'category');
        }
    }
    $extra = array(
        array(
            'title'    => 'Know the cost of a destination wedding at The Leela Palace, Udaipur',
            'slug'     => 'leela-palace-udaipur-wedding-cost',
            'cat'      => 'destinations',
            'excerpt'  => 'What a Leela Palace wedding typically includes — rooms, ceremonies, and the costs couples should plan for.',
            'image'    => wvn_media('2025/04/NVP_JEHANAXKANISHK_WEDDING-1450.jpg'),
            'content'  => '<p>The Leela Palace sits on Lake Pichola with the kind of arrival that photographs itself. The real work is matching guest count to the courtyards you can actually hold, and understanding what the hotel package covers versus what your planner still has to build.</p><p>We walk couples through ceremony lawns, guest rooms, and the quiet extras — lighting, mandap, and hospitality — so the number you approve is the number you host.</p>',
        ),
        array(
            'title'    => 'A palace wedding in Udaipur, designed end to end',
            'slug'     => 'palace-wedding-udaipur-real-story',
            'cat'      => 'real-weddings',
            'excerpt'  => 'From the first venue walk to the last pheras — how one Udaipur celebration came together.',
            'image'    => wvn_media('2025/04/2J0A1818.jpg'),
            'content'  => '<p>This family wanted a palace that felt like home for four days, not a hotel they visited for an evening. We held the venue, the guest list, and every function on one timeline.</p><p>Décor, hospitality, and the baraat route were briefed together, so nothing arrived as a surprise on the day.</p>',
        ),
        array(
            'title'    => 'Mandap, florals, and the lighting that holds the night',
            'slug'     => 'mandap-florals-lighting-wedding-decor',
            'cat'      => 'decor-design',
            'excerpt'  => 'How we design a ceremony set that still feels like the couple — not a catalogue mandap.',
            'image'    => wvn_media('2025/04/2J0A7886-1200x800-1.jpg'),
            'content'  => '<p>Décor is not a backdrop. It is how guests understand the evening before a word is spoken. We start with the architecture, then florals, then light — so the mandap belongs to the palace, not the other way around.</p>',
        ),
        array(
            'title'    => 'Bridal beauty that lasts from mehendi to pheras',
            'slug'     => 'bridal-beauty-mehendi-to-pheras',
            'cat'      => 'bridal-style',
            'excerpt'  => 'Artists, trials, and the timeline that keeps makeup and mehendi calm on a long wedding day.',
            'image'    => wvn_media('2025/04/2J0A2532-533x800-1.jpg'),
            'content'  => '<p>A destination wedding is a long day under Udaipur light. We book artists who have worked these hours before, run a trial, and build a beauty schedule that does not collide with the baraat.</p>',
        ),
    );
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    foreach ($extra as $sample) {
        if (get_page_by_path($sample['slug'], OBJECT, 'post')) {
            continue;
        }
        $post_id = wp_insert_post(array(
            'post_title'   => $sample['title'],
            'post_name'    => $sample['slug'],
            'post_excerpt' => $sample['excerpt'],
            'post_content' => $sample['content'],
            'post_status'  => 'publish',
            'post_type'    => 'post',
        ));
        if (!$post_id || is_wp_error($post_id)) {
            continue;
        }
        wp_set_object_terms($post_id, $sample['cat'], 'category');
        $image_id = media_sideload_image($sample['image'], $post_id, $sample['title'], 'id');
        if (!is_wp_error($image_id) && $image_id) {
            set_post_thumbnail($post_id, (int) $image_id);
        }
    }
    update_option('_wvn_blog_layout_v2', '1');
}
add_action('init', 'wvn_setup_blog_taxonomy', 40);

function wvn_seed_article_layout() {
    if (get_option('_wvn_article_seeded') || !function_exists('update_field')) {
        return;
    }
    $post = get_page_by_path('leela-palace-udaipur-wedding-cost', OBJECT, 'post');
    if (!$post) {
        return;
    }
    $id = (int) $post->ID;
    $thumb = get_the_post_thumbnail_url($id, 'large') ?: wvn_hero_image();
    $body = '<p>The Leela Palace Udaipur is one of the city’s most requested palace hotels for a destination wedding — a lakeside arrival, guest rooms on campus, and ceremony lawns that can hold an intimate pheras or a larger baraat.</p>
<p>Costs vary with season, room block, and how many functions you host on property. The figures below are planning ranges we walk couples through before a date is locked.</p>
<h2>Accommodation</h2>
<img src="' . esc_url($thumb) . '" alt="The Leela Palace Udaipur">
<table><thead><tr><th>No. of rooms</th><th>Price per room / night</th></tr></thead><tbody>
<tr><td>30 – 50</td><td>₹45,000 + taxes</td></tr>
<tr><td>50 – 80</td><td>₹40,000 + taxes</td></tr>
<tr><td>80+</td><td>On request</td></tr>
</tbody></table>
<h2>Food expenses</h2>
<p>Menus are typically priced per person, with lunch, high tea, and dinner as separate events. Taxes and service apply on top.</p>
<table><thead><tr><th>Meal type</th><th>Price for a wedding</th></tr></thead><tbody>
<tr><td>Lunch</td><td>₹6,500 + 18% taxes</td></tr>
<tr><td>High tea</td><td>₹3,500 + 18% taxes</td></tr>
<tr><td>Dinner</td><td>₹7,500 + 18% taxes</td></tr>
</tbody></table>
<h2>Venue charges</h2>
<p>Ceremony and reception spaces are assigned by guest count. We confirm lawns and indoor halls together with the room block.</p>
<table><thead><tr><th>Venue</th><th>Maximum capacity</th></tr></thead><tbody>
<tr><td>Front lawn</td><td>250</td></tr>
<tr><td>Lake-view terrace</td><td>180</td></tr>
<tr><td>Ballroom</td><td>120</td></tr>
</tbody></table>';
    wp_update_post(array('ID' => $id, 'post_content' => $body));
    update_field('post_overlay_title', 'The Leela Palace', $id);
    update_field('post_overlay_sub', 'Wedding cost and other details', $id);
    update_field('post_faq_heading', 'FAQ about wedding planning at The Leela Palace Udaipur', $id);
    update_field('post_faqs', array(
        array('q' => 'What is the room price for a wedding at The Leela Palace?', 'a' => 'Room blocks are quoted by season and length of stay. Couples typically plan ₹40,000–₹45,000 per room per night, plus taxes, with a minimum night stay in peak months.'),
        array('q' => 'How much does a Leela Palace wedding cost for 3 days?', 'a' => 'A three-day celebration with rooms, meals, and lawns usually sits in a wide band depending on guest count. We build a single estimate that includes hotel, décor, and hospitality so there are no parallel quotes.'),
        array('q' => 'What is included in the hotel package?', 'a' => 'Rooms, designated ceremony spaces, and in-house catering are the base. Mandap, lighting, entertainment, and guest concierge sit with the planning studio.'),
        array('q' => 'Can we host mehendi and sangeet on property?', 'a' => 'Yes. We sequence functions across lawns and indoor halls so sound, guest flow, and changeovers stay on one timeline.'),
        array('q' => 'Do you coordinate the hotel and vendors together?', 'a' => 'Yes. Wedding Vows by Nikhil holds the hotel relationship and the vendor brief, so you have one point of contact from the first walk-through to the last farewell.'),
    ), $id);
    update_field('post_cta_heading', 'Let us help you plan your wedding at The Leela Palace Udaipur', $id);
    update_field('post_cta_text', 'Fill out this form to get in touch with us', $id);
    update_field('post_cta_button', 'Plan my wedding ↗', $id);
    update_field('post_venue_name', 'The Leela Palace Udaipur', $id);
    update_field('post_venue_meta', 'Palace hotel · Lakefront', $id);
    update_field('post_venue_url', home_url('/contact-us/'), $id);
    $gallery = get_posts(array(
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'posts_per_page' => 5,
        'fields'         => 'ids',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));
    if ($gallery) {
        update_field('post_gallery', $gallery, $id);
    }
    $thumb_id = get_post_thumbnail_id($id);
    if ($thumb_id) {
        update_field('post_venue_image', (int) $thumb_id, $id);
    }
    update_option('_wvn_article_seeded', '1');
}
add_action('acf/init', 'wvn_seed_article_layout', 50);

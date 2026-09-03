<?php
get_header();
while (have_posts()) :
    the_post();
    if (wvn_elementor_editing()) :
        ?>
<main id="content" class="wvn-page">
  <?php the_content(); ?>
</main>
        <?php
        get_footer();
        return;
    endif;

    $id = get_the_ID();
    $title = get_the_title();
    $excerpt = trim(get_the_excerpt());
    $thumb = get_the_post_thumbnail_url($id, 'full');

    // ACF Fields
    $hero_img = function_exists('get_field') ? get_field('portfolio_hero_image', $id) : null;
    $hero_url = wvn_image_url($hero_img, $thumb);

    $subtitle = function_exists('get_field') ? get_field('portfolio_subtitle', $id) : '';
    if (!$subtitle && $excerpt) {
        $subtitle = $excerpt;
    }

    $pills_str = function_exists('get_field') ? get_field('portfolio_pills', $id) : '';
    $pills = array();
    if ($pills_str) {
        $pills = array_filter(array_map('trim', preg_split('/[•,]/', $pills_str)));
    }

    $story_heading = function_exists('get_field') ? get_field('portfolio_story_heading', $id) : '';
    $story_intro   = function_exists('get_field') ? get_field('portfolio_story_intro', $id) : '';
    $raw_content   = trim(wp_strip_all_tags(get_the_content()));

    $events = function_exists('get_field') ? get_field('portfolio_events', $id) : null;

    // Credits
    $venue       = function_exists('get_field') ? get_field('portfolio_venue', $id) : '';
    $date        = function_exists('get_field') ? get_field('portfolio_date', $id) : '';
    $planner     = function_exists('get_field') ? get_field('portfolio_planner', $id) : 'Wedding Vows by Nikhil';
    $decor       = function_exists('get_field') ? get_field('portfolio_decor', $id) : '';
    $photography = function_exists('get_field') ? get_field('portfolio_photography', $id) : '';
    $makeup      = function_exists('get_field') ? get_field('portfolio_makeup', $id) : '';
    $custom_creds= function_exists('get_field') ? get_field('portfolio_custom_credits', $id) : null;

    // Gallery / Mosaic
    $gallery_title = function_exists('get_field') ? get_field('portfolio_gallery_title', $id) : 'Moments From The Celebration';
    $gallery_rows  = function_exists('get_field') ? get_field('gallery_images', $id) : null;
    $gallery_images = array();
    if (is_array($gallery_rows)) {
        foreach ($gallery_rows as $grow) {
            $gurl = wvn_image_url(is_array($grow) ? ($grow['image'] ?? $grow) : $grow, '');
            if ($gurl) {
                $gallery_images[] = array(
                    'url' => $gurl,
                    'caption' => is_array($grow) && !empty($grow['caption']) ? $grow['caption'] : '',
                );
            }
        }
    }

    // Related Weddings
    $related_q = new WP_Query(array(
        'post_type'      => 'portfolio',
        'post_status'    => 'publish',
        'posts_per_page' => 3,
        'post__not_in'   => array($id),
        'orderby'        => 'rand',
    ));
    ?>
<main id="content" class="wvn-wedding-single">

  <!-- HERO BANNER -->
  <section class="wvn-wedding-hero" style="<?php echo $hero_url ? 'background-image:url(\'' . esc_url($hero_url) . '\');' : ''; ?>">
    <div class="wvn-wedding-hero-overlay"></div>
    <div class="wvn-wedding-hero-inner">
      <nav class="wvn-wedding-breadcrumbs" aria-label="Breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <span aria-hidden="true">/</span>
        <a href="<?php echo esc_url(home_url('/portfolio/')); ?>">Real Weddings</a>
        <span aria-hidden="true">/</span>
        <span><?php echo esc_html($title); ?></span>
      </nav>
      <h1 class="wvn-wedding-title"><?php echo esc_html($title); ?></h1>
      <?php if ($subtitle) : ?>
        <p class="wvn-wedding-subtitle"><?php echo esc_html($subtitle); ?></p>
      <?php endif; ?>
      <?php if ($pills) : ?>
        <div class="wvn-wedding-pills">
          <?php foreach ($pills as $pill) : ?>
            <span class="wvn-wedding-pill"><?php echo esc_html($pill); ?></span>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- STORY / OVERVIEW -->
  <?php if ($story_intro || $story_heading || $raw_content) : ?>
  <section class="wvn-wedding-overview">
    <div class="wvn-wedding-overview-inner">
      <p class="wvn-kicker">The Story</p>
      <h2 class="wvn-display"><?php echo esc_html($story_heading ?: 'A Royal Affair In The City Of Lakes'); ?></h2>
      <div class="wvn-wedding-story-body">
        <?php if ($story_intro) : ?>
          <?php foreach (preg_split('/\n\s*\n/', trim($story_intro)) as $para) : ?>
            <p><?php echo nl2br(esc_html(trim($para))); ?></p>
          <?php endforeach; ?>
        <?php elseif ($raw_content) : ?>
          <?php the_content(); ?>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 3-PHOTO REPETITIVE EVENT SECTIONS -->
  <?php if (!empty($events) && is_array($events)) : ?>
    <div class="wvn-wedding-events">
      <?php foreach ($events as $idx => $evt) :
          $evt_tag   = $evt['event_tag'] ?? '';
          $evt_title = $evt['event_title'] ?? '';
          $evt_desc  = $evt['event_description'] ?? '';
          $evt_theme = $evt['event_theme'] ?? '';
          $img1_url  = wvn_image_url($evt['photo_1'] ?? '', '');
          $img2_url  = wvn_image_url($evt['photo_2'] ?? '', '');
          $img3_url  = wvn_image_url($evt['photo_3'] ?? '', '');
          $align     = $evt['layout_alignment'] ?? ($idx % 2 === 1 ? 'photo_right' : 'photo_left');
          $has_photos = $img1_url || $img2_url || $img3_url;
          ?>
        <section class="wvn-wedding-event-section<?php echo $align === 'photo_right' ? ' is-reversed' : ''; ?>">
          <div class="wvn-wedding-event-row">
            
            <?php if ($has_photos) : ?>
            <div class="wvn-wedding-collage">
              <?php if ($img1_url) : ?>
                <a class="wvn-collage-item is-main" href="<?php echo esc_url($img1_url); ?>" data-wvn-lightbox>
                  <img src="<?php echo esc_url($img1_url); ?>" alt="<?php echo esc_attr($evt_title ?: $title); ?>" loading="lazy">
                </a>
              <?php endif; ?>
              <div class="wvn-collage-stack">
                <?php if ($img2_url) : ?>
                  <a class="wvn-collage-item is-sub" href="<?php echo esc_url($img2_url); ?>" data-wvn-lightbox>
                    <img src="<?php echo esc_url($img2_url); ?>" alt="<?php echo esc_attr($evt_title ?: $title); ?>" loading="lazy">
                  </a>
                <?php endif; ?>
                <?php if ($img3_url) : ?>
                  <a class="wvn-collage-item is-sub" href="<?php echo esc_url($img3_url); ?>" data-wvn-lightbox>
                    <img src="<?php echo esc_url($img3_url); ?>" alt="<?php echo esc_attr($evt_title ?: $title); ?>" loading="lazy">
                  </a>
                <?php endif; ?>
              </div>
            </div>
            <?php endif; ?>

            <div class="wvn-wedding-event-copy">
              <?php if ($evt_tag) : ?>
                <p class="wvn-kicker"><?php echo esc_html($evt_tag); ?></p>
              <?php endif; ?>
              <?php if ($evt_title) : ?>
                <h3 class="wvn-display"><?php echo esc_html($evt_title); ?></h3>
              <?php endif; ?>
              <?php if ($evt_theme) : ?>
                <p class="wvn-wedding-event-theme"><?php echo esc_html($evt_theme); ?></p>
              <?php endif; ?>
              <?php if ($evt_desc) : ?>
                <div class="wvn-wedding-event-text">
                  <?php foreach (preg_split('/\n\s*\n/', trim($evt_desc)) as $para) : ?>
                    <p><?php echo nl2br(esc_html(trim($para))); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>

          </div>
        </section>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- MOMENTS GALLERY -->
  <?php if (!empty($gallery_images)) : ?>
  <section class="wvn-wedding-gallery-section">
    <div class="wvn-wedding-gallery-header">
      <p class="wvn-kicker">The Details</p>
      <h2 class="wvn-display"><?php echo esc_html($gallery_title); ?></h2>
    </div>
    <div class="wvn-mosaic wvn-wedding-mosaic">
      <?php foreach ($gallery_images as $gitem) : ?>
        <a href="<?php echo esc_url($gitem['url']); ?>" data-wvn-lightbox data-caption="<?php echo esc_attr($gitem['caption']); ?>">
          <img src="<?php echo esc_url($gitem['url']); ?>" alt="<?php echo esc_attr($gitem['caption'] ?: $title); ?>" loading="lazy">
          <?php if (!empty($gitem['caption'])) : ?>
            <span class="wvn-mosaic-caption"><?php echo esc_html($gitem['caption']); ?></span>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <!-- WEDDING DETAILS & CREDITS -->
  <?php
  $has_credits = $venue || $date || $planner || $decor || $photography || $makeup || !empty($custom_creds);
  if ($has_credits) : ?>
  <section class="wvn-wedding-credits-section">
    <div class="wvn-wedding-credits-card">
      <p class="wvn-kicker wvn-center">Key Details</p>
      <h2 class="wvn-display wvn-center">The Wedding Credits</h2>
      <div class="wvn-wedding-credits-table">
        <?php if ($venue) : ?>
          <div class="wvn-credit-row">
            <span class="wvn-credit-label">Venue / Location</span>
            <span class="wvn-credit-value"><?php echo esc_html($venue); ?></span>
          </div>
        <?php endif; ?>
        <?php if ($date) : ?>
          <div class="wvn-credit-row">
            <span class="wvn-credit-label">Wedding Date</span>
            <span class="wvn-credit-value"><?php echo esc_html($date); ?></span>
          </div>
        <?php endif; ?>
        <?php if ($planner) : ?>
          <div class="wvn-credit-row">
            <span class="wvn-credit-label">Planned & Managed By</span>
            <span class="wvn-credit-value"><strong><?php echo esc_html($planner); ?></strong></span>
          </div>
        <?php endif; ?>
        <?php if ($decor) : ?>
          <div class="wvn-credit-row">
            <span class="wvn-credit-label">Décor & Production</span>
            <span class="wvn-credit-value"><?php echo esc_html($decor); ?></span>
          </div>
        <?php endif; ?>
        <?php if ($photography) : ?>
          <div class="wvn-credit-row">
            <span class="wvn-credit-label">Photography & Cinematography</span>
            <span class="wvn-credit-value"><?php echo esc_html($photography); ?></span>
          </div>
        <?php endif; ?>
        <?php if ($makeup) : ?>
          <div class="wvn-credit-row">
            <span class="wvn-credit-label">Bridal Styling & Makeup</span>
            <span class="wvn-credit-value"><?php echo esc_html($makeup); ?></span>
          </div>
        <?php endif; ?>
        <?php if (!empty($custom_creds) && is_array($custom_creds)) : ?>
          <?php foreach ($custom_creds as $cc) :
              if (empty($cc['label']) || empty($cc['value'])) continue; ?>
            <div class="wvn-credit-row">
              <span class="wvn-credit-label"><?php echo esc_html($cc['label']); ?></span>
              <span class="wvn-credit-value"><?php echo esc_html($cc['value']); ?></span>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- RELATED REAL WEDDINGS -->
  <?php if ($related_q->have_posts()) : ?>
  <section class="wvn-wedding-related-section">
    <div class="wvn-wedding-related-header">
      <p class="wvn-kicker">Explore More</p>
      <h2 class="wvn-display">Other Real Weddings</h2>
    </div>
    <div class="wvn-wedding-related-grid">
      <?php while ($related_q->have_posts()) : $related_q->the_post();
          $rel_thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
          $rel_excerpt = get_the_excerpt();
          ?>
        <a class="wvn-wedding-related-card" href="<?php the_permalink(); ?>">
          <div class="wvn-wedding-related-thumb">
            <?php if ($rel_thumb) : ?>
              <img src="<?php echo esc_url($rel_thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
            <?php else : ?>
              <div class="wvn-related-placeholder"></div>
            <?php endif; ?>
          </div>
          <div class="wvn-wedding-related-meta">
            <h3><?php the_title(); ?></h3>
            <?php if ($rel_excerpt) : ?>
              <p><?php echo esc_html($rel_excerpt); ?></p>
            <?php endif; ?>
          </div>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </section>
  <?php endif; ?>

  <!-- CTA BANNER -->
  <section class="wvn-wedding-cta-section">
    <div class="wvn-wedding-cta-box">
      <h2 class="wvn-display">Start Planning Your Dream Celebration With Us</h2>
      <p class="wvn-lede">From royal palace courtyards to sunset lakefront ceremonies, we design weddings that reflect you in every single detail.</p>
      <a class="wvn-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Plan Your Wedding ↗</a>
    </div>
  </section>

</main>
<?php
endwhile;
get_footer();

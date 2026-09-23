<?php
get_header();
if (wvn_elementor_editing()) :
    while (have_posts()) :
        the_post();
        ?>
<main id="content" class="wvn-page">
  <?php the_content(); ?>
</main>
        <?php
    endwhile;
    get_footer();
    return;
endif;
$weddings = wvn_weddings();
$services = wvn_services();
$faqs = wvn_faqs();

/* Search-demand FAQ layer: answer the cost, venue and destination-planning
 * questions already appearing in Search Console without stuffing the page.
 */
$homepage_search_faqs = array(
    array(
        'q' => 'How much does a destination wedding in Udaipur cost?',
        'a' => 'The budget depends on guest count, venue, room block, number of functions, catering, décor and production. Our Udaipur wedding cost guide explains the main cost components and typical planning ranges before you shortlist a venue.',
    ),
    array(
        'q' => 'What are the best wedding venues in Udaipur for a destination wedding?',
        'a' => 'Udaipur offers lake palaces, heritage properties and luxury resorts. The right venue depends on your guest count, room requirements, ceremony spaces, number of functions and whether you want a palace, lakeside or resort setting.',
    ),
    array(
        'q' => 'What does a wedding planner in Udaipur handle?',
        'a' => 'A full-service Udaipur wedding planner can coordinate venue sourcing, vendor selection, décor and design, guest hospitality, transport, entertainment, production, timelines and on-ground execution across the wedding weekend.',
    ),
    array(
        'q' => 'How early should I book a destination wedding planner in Udaipur?',
        'a' => 'For popular palace and luxury resort dates, it is sensible to begin planning well ahead of the wedding season. Earlier planning gives you more choice of venue dates, room blocks, artists, décor teams and guest logistics.',
    ),
);
$existing_faq_questions = array_map(function ($faq) {
    return strtolower(trim((string) ($faq['q'] ?? '')));
}, is_array($faqs) ? $faqs : array());
foreach ($homepage_search_faqs as $search_faq) {
    if (!in_array(strtolower($search_faq['q']), $existing_faq_questions, true)) {
        $faqs[] = $search_faq;
        $existing_faq_questions[] = strtolower($search_faq['q']);
    }
}

$quotes = wvn_testimonials();
$venues_home = function_exists('wvn_venues_for_home') ? wvn_venues_for_home(8) : array();
$gallery = wvn_gallery_images();
$stories = wvn_stories();
$press_sheets = array_reverse(wvn_pressbook_sheets());
$service_count = count($services);
?>

<main id="content">
  <section class="wvn-opening" data-pin="opening">
    <div class="wvn-hero">
      <div class="wvn-hero-frame">
        <?php
        $hero_poster = wvn_hero_image();
        $hero_video = function_exists('wvn_hero_video') ? wvn_hero_video() : '';
        $hero_is_video = function_exists('wvn_hero_media_type') && wvn_hero_media_type() === 'video' && $hero_video;
        if ($hero_is_video) :
            ?>
          <video
            class="wvn-hero-video"
            autoplay
            muted
            loop
            playsinline
            preload="metadata"
            poster="<?php echo esc_url($hero_poster); ?>"
            aria-label="Wedding Vows by Nikhil hero film"
          >
            <source src="<?php echo esc_url($hero_video); ?>" type="video/mp4">
          </video>
        <?php else : ?>
          <img src="<?php echo esc_url($hero_poster); ?>" alt="Destination wedding in Udaipur planned by Wedding Vows by Nikhil" fetchpriority="high" decoding="async">
        <?php endif; ?>
      </div>
      <div class="wvn-hero-copy"><?php echo esc_html(wvn_home_text('home_hero_copy', 'We work behind the scenes, because your wedding deserves to be planned beautifully.')); ?></div>
    </div>
    <div class="wvn-hero-travel" aria-hidden="true"></div>
    <?php
    $intro = function_exists('wvn_home_intro') ? wvn_home_intro() : array();
    $intro_images = !empty($intro['images']) && is_array($intro['images']) ? $intro['images'] : array();
    $intro_by_slot = array();
    foreach ($intro_images as $img) {
        if (!empty($img['slot'])) {
            $intro_by_slot[$img['slot']] = $img;
        }
    }
    $intro_title_line = $intro['title_line'] ?? 'Wedding Planner';
    $intro_title_em = $intro['title_em'] ?? 'in';
    $intro_title_place = $intro['title_place'] ?? 'Udaipur';
    ?>
    <section class="wvn-intro<?php echo ($intro['layout_variant'] ?? 'editorial') === 'minimal' ? ' is-minimal-notes' : ''; ?>" aria-labelledby="wvn-intro-heading" data-wvn-intro>
      <?php if (!empty($intro['landscape'])) : ?>
        <div class="wvn-intro__scape" data-wvn-intro-scape aria-hidden="true">
          <img src="<?php echo esc_url($intro['landscape']); ?>" alt="" decoding="async" loading="lazy">
        </div>
      <?php endif; ?>
      <div class="wvn-intro__veil" aria-hidden="true"></div>

      <div class="wvn-intro__stage">
        <aside class="wvn-intro__rail wvn-intro__rail--left">
          <?php if (($intro['layout_variant'] ?? 'editorial') !== 'minimal' && (!empty($intro['index_label']) || !empty($intro['index_meta']))) : ?>
            <p class="wvn-intro__index">
              <?php if (!empty($intro['index_label'])) : ?><span><?php echo esc_html($intro['index_label']); ?></span><?php endif; ?>
              <?php if (!empty($intro['index_meta'])) : ?><small><?php echo esc_html($intro['index_meta']); ?></small><?php endif; ?>
            </p>
          <?php endif; ?>
          <?php if (!empty($intro_by_slot['left']['url'])) : ?>
            <figure class="wvn-intro__shot wvn-intro__shot--arch" data-wvn-intro-shot>
              <?php echo wvn_home_intro_image_html($intro_by_slot['left']['url'], $intro_by_slot['left']['alt'] ?? '', 'eager', $intro['image_position'] ?? 'center'); ?>
            </figure>
          <?php endif; ?>
          <?php if (!empty($intro_by_slot['left-bot']['url'])) : ?>
            <figure class="wvn-intro__shot wvn-intro__shot--overlap" data-wvn-intro-shot>
              <?php echo wvn_home_intro_image_html($intro_by_slot['left-bot']['url'], $intro_by_slot['left-bot']['alt'] ?? '', 'lazy'); ?>
            </figure>
          <?php endif; ?>
          <?php if (($intro['layout_variant'] ?? 'editorial') !== 'minimal' && !empty($intro['note_left'])) : ?>
            <p class="wvn-intro__note wvn-intro__note--left"><?php echo esc_html($intro['note_left']); ?></p>
          <?php endif; ?>
        </aside>

        <div class="wvn-intro__copy" data-wvn-intro-copy>
          <div class="wvn-intro__bloom" aria-hidden="true">
            <svg viewBox="0 0 48 48" width="36" height="36" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M24 6c1.8 6.2 5.8 10.2 12 12-6.2 1.8-10.2 5.8-12 12-1.8-6.2-5.8-10.2-12-12 6.2-1.8 10.2-5.8 12-12Z" stroke="currentColor" stroke-width="1.2"/>
              <circle cx="24" cy="24" r="2.2" fill="currentColor"/>
            </svg>
          </div>
          <?php if (!empty($intro['eyebrow'])) : ?>
            <p class="wvn-intro__eyebrow"><?php echo esc_html($intro['eyebrow']); ?></p>
          <?php endif; ?>
          <h1 id="wvn-intro-heading" class="wvn-intro__title">
            <span class="wvn-intro__title-line"><?php echo esc_html($intro_title_line); ?></span>
            <span class="wvn-intro__title-line">
              <em class="wvn-intro__accent"><?php echo esc_html($intro_title_em); ?></em>
              <?php echo esc_html(' ' . $intro_title_place); ?>
            </span>
          </h1>
          <?php if (!empty($intro['subhead'])) : ?>
            <p class="wvn-intro__sub"><?php echo esc_html($intro['subhead']); ?></p>
          <?php endif; ?>
          <?php if (!empty($intro['lead'])) : ?>
            <p class="wvn-intro__lead"><?php echo esc_html($intro['lead']); ?></p>
          <?php endif; ?>
          <?php if (!empty($intro['founder'])) : ?>
            <p class="wvn-intro__founder">
              <strong><?php echo esc_html($intro['founder']); ?></strong>
              <?php if (!empty($intro['founder_role'])) : ?>
                <span><?php echo esc_html($intro['founder_role']); ?></span>
              <?php endif; ?>
            </p>
          <?php endif; ?>
          <div class="wvn-intro__actions">
            <?php if (!empty($intro['cta_url']) && !empty($intro['cta_label'])) : ?>
              <a class="wvn-intro__cta" href="<?php echo esc_url($intro['cta_url']); ?>">
                <span class="wvn-intro__cta-label"><?php echo esc_html($intro['cta_label']); ?></span>
                <span class="wvn-intro__cta-arrow" aria-hidden="true">→</span>
              </a>
            <?php endif; ?>
            <?php if (!empty($intro['story_url']) && !empty($intro['story_label'])) : ?>
              <a class="wvn-intro__story" href="<?php echo esc_url($intro['story_url']); ?>"><?php echo esc_html($intro['story_label']); ?> ↗</a>
            <?php endif; ?>
            <?php if (!empty($intro['secondary_cta_url']) && !empty($intro['secondary_cta_label'])) : ?>
              <a class="wvn-intro__story" href="<?php echo esc_url($intro['secondary_cta_url']); ?>"><?php echo esc_html($intro['secondary_cta_label']); ?> ↗</a>
            <?php endif; ?>
          </div>
        </div>

        <aside class="wvn-intro__rail wvn-intro__rail--right">
          <div class="wvn-intro__paper" aria-hidden="true"></div>
          <?php if (!empty($intro_by_slot['right-top']['url'])) : ?>
            <figure class="wvn-intro__shot wvn-intro__shot--tilt" data-wvn-intro-shot>
              <?php echo wvn_home_intro_image_html($intro_by_slot['right-top']['url'], $intro_by_slot['right-top']['alt'] ?? '', 'lazy'); ?>
            </figure>
          <?php endif; ?>
          <?php if (($intro['layout_variant'] ?? 'editorial') !== 'minimal' && !empty($intro['note_right'])) : ?>
            <p class="wvn-intro__note wvn-intro__note--right"><?php echo esc_html($intro['note_right']); ?></p>
          <?php endif; ?>
          <?php if (!empty($intro_by_slot['right-bot']['url'])) : ?>
            <figure class="wvn-intro__shot wvn-intro__shot--wide" data-wvn-intro-shot>
              <?php echo wvn_home_intro_image_html($intro_by_slot['right-bot']['url'], $intro_by_slot['right-bot']['alt'] ?? '', 'lazy'); ?>
            </figure>
          <?php endif; ?>
          <?php if (($intro['layout_variant'] ?? 'editorial') !== 'minimal' && !empty($intro['note_detail'])) : ?>
            <p class="wvn-intro__meta"><?php echo esc_html($intro['note_detail']); ?></p>
          <?php endif; ?>
        </aside>
      </div>

      <div class="wvn-intro__ground">
        <?php if (($intro['layout_variant'] ?? 'editorial') !== 'minimal' && !empty($intro['location'])) : ?>
          <p class="wvn-intro__place"><?php echo esc_html($intro['location']); ?></p>
        <?php endif; ?>
        <?php if (($intro['layout_variant'] ?? 'editorial') !== 'minimal' && !empty($intro['scroll_label'])) : ?>
          <p class="wvn-intro__scroll">
            <span class="wvn-intro__scroll-line" aria-hidden="true"></span>
            <?php echo esc_html($intro['scroll_label']); ?>
          </p>
        <?php endif; ?>
        <?php if (($intro['layout_variant'] ?? 'editorial') !== 'minimal' && !empty($intro['footer_mark'])) : ?>
          <p class="wvn-intro__mark">
            <span class="wvn-intro__mark-line" aria-hidden="true"></span>
            <?php echo esc_html($intro['footer_mark']); ?>
          </p>
        <?php endif; ?>
      </div>
    </section>
  </section>

  <section class="wvn-collective">
    <p class="wvn-kicker wvn-center wvn-reveal"><?php echo esc_html(wvn_home_text('home_collective_kicker', 'WVN Wedding Collective')); ?></p>
    <h2 class="wvn-display wvn-reveal"><?php echo esc_html(wvn_home_text('home_collective_heading', 'Before we tell you our story, let our weddings speak for us.')); ?></h2>
    <?php if ($weddings) : ?>
    <div class="wvn-coverflow" data-hscroll>
      <div class="wvn-coverflow-track">
        <?php foreach ($weddings as $wedding) : ?>
          <a class="wvn-card" href="<?php echo esc_url($wedding['url']); ?>">
            <figure><img src="<?php echo esc_url($wedding['image']); ?>" alt="<?php echo esc_attr($wedding['title'] . ' — destination wedding in Udaipur'); ?>" loading="lazy" decoding="async"></figure>
            <h3><?php echo esc_html($wedding['title']); ?></h3>
            <p><?php echo esc_html($wedding['venue']); ?></p>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php else : ?>
    <p class="wvn-lede wvn-center" style="margin-top:28px;">Add weddings under <strong>Portfolio</strong> in wp-admin — each one appears here and links to its detail page.</p>
    <?php endif; ?>
  </section>

  <section class="wvn-planners">
    <div class="wvn-planners-card">
      <div class="wvn-planners-photo">
        <img src="<?php echo esc_url(wvn_founder_image()); ?>" alt="Nikhil Salvi, destination wedding planner in Udaipur">
      </div>
      <div class="wvn-planners-copy">
        <h2 class="wvn-display"><?php echo esc_html(wvn_home_text('home_planner_heading', 'Meet the planner')); ?></h2>
        <p class="wvn-kicker"><?php echo esc_html(wvn_home_text('home_planner_kicker', 'Weddings aren’t planned by companies, they’re planned by people.')); ?></p>
        <p><?php echo esc_html(wvn_home_text('home_planner_text', 'Nikhil Salvi leads Wedding Vows by Nikhil and personally oversees every celebration we create. From the first conversation to the last farewell, one team stays with you — designing, coordinating, and executing on the ground in Udaipur and beyond.')); ?></p>
        <p class="wvn-sign"><?php echo esc_html(wvn_home_text('home_planner_sign', 'Nikhil Salvi — Founder')); ?></p>
        <a class="wvn-textlink" href="<?php echo esc_url(wvn_home_text('home_planner_link_url', home_url('/contact-us/'))); ?>"><?php echo esc_html(wvn_home_text('home_planner_link_text', 'Book a consultation ↗')); ?></a>
      </div>
    </div>
  </section>

  <section class="wvn-achieve" aria-label="Testimonials">
    <h2 class="wvn-display"><?php echo esc_html(wvn_home_text('home_achieve_heading', 'In Their Words')); ?></h2>
    <p class="wvn-lede"><?php echo esc_html(wvn_home_text('home_achieve_lede', 'Real stories from the couples and families we’ve celebrated with — open the book to read more.')); ?></p>
    <div class="wvn-pressbook wvn-pressbook--testimonials" data-book>
      <div class="wvn-pressbook-frame">
        <div class="wvn-pressbook-3d">
          <div class="wvn-pressbook-base" aria-hidden="true"></div>
          <?php foreach ($press_sheets as $index => $sheet) :
              $sheet_i = count($press_sheets) - 1 - $index;
              ?>
            <div class="wvn-pressbook-sheet<?php echo !empty($sheet['cover']) ? ' is-cover' : ''; ?>" data-sheet="<?php echo (int) $sheet_i; ?>">
              <?php if (!empty($sheet['cover'])) : ?>
                <button class="wvn-pressbook-face is-front" type="button" data-book-toggle>
                  <img src="<?php echo esc_url($sheet['front']['image']); ?>" alt="<?php echo esc_attr($sheet['front']['title']); ?>">
                  <span><?php echo esc_html($sheet['front']['title']); ?></span>
                  <small><?php echo esc_html($sheet['front']['note']); ?></small>
                </button>
              <?php else : ?>
                <div class="wvn-pressbook-face is-front"><?php wvn_press_leaf($sheet['front']); ?></div>
              <?php endif; ?>
              <div class="wvn-pressbook-face is-back"><?php wvn_press_leaf($sheet['back']); ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="wvn-pressbook-controls">
        <button type="button" data-book-prev aria-label="Previous testimonial">‹</button>
        <button type="button" data-book-next aria-label="Next testimonial">›</button>
      </div>
    </div>
  </section>

  <section class="wvn-services wvn-pin" data-pin="services">
    <div class="wvn-pin-sticky wvn-services-sticky">
      <div class="wvn-services-bgs" aria-hidden="true">
        <?php foreach ($services as $item) : ?>
          <div class="wvn-services-bg" data-service-bg style="background-image:url('<?php echo esc_url($item['bg']); ?>')"></div>
        <?php endforeach; ?>
      </div>
      <div class="wvn-services-head">
        <p class="wvn-kicker"><?php echo esc_html(wvn_home_text('home_services_kicker', 'What we do')); ?></p>
        <h2 class="wvn-display"><?php echo esc_html(wvn_home_text('home_services_heading', 'End-to-end, one team')); ?></h2>
        <p class="wvn-lede"><?php echo esc_html(wvn_home_text('home_services_lede', 'We offer complete destination wedding planning, so you only ever deal with one team — from the first venue visit to the final farewell.')); ?></p>
      </div>
      <div class="wvn-services-viewport">
        <?php foreach ($services as $item) : ?>
          <article class="wvn-service-card" data-service-card>
            <p class="wvn-kicker">Services</p>
            <h3 class="wvn-display"><?php echo esc_html($item['title']); ?></h3>
            <figure><img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>"></figure>
            <p><?php echo esc_html($item['text']); ?></p>
          </article>
        <?php endforeach; ?>
      </div>
      <div class="wvn-service-nav">
        <button type="button" data-prev aria-label="Previous service">←</button>
        <span data-service-count><?php echo esc_html(str_pad('1', 2, '0', STR_PAD_LEFT) . ' / ' . str_pad((string) max(1, $service_count), 2, '0', STR_PAD_LEFT)); ?></span>
        <button type="button" data-next aria-label="Next service">→</button>
      </div>
    </div>
  </section>

  <section class="wvn-showreel">
    <div class="wvn-showreel-row">
      <b>©<?php echo esc_html(date('Y')); ?></b>
      <button class="wvn-showreel-frame" type="button" data-open-showreel>
        <img src="<?php echo esc_url(wvn_home_image('home_showreel_image', $gallery[4] ?? wvn_hero_image())); ?>" alt="Showreel">
        <em><?php echo esc_html(wvn_home_text('home_showreel_caption', 'The Real Story Behind a Dream Wedding')); ?></em>
      </button>
      <b>Showreel</b>
    </div>
    <?php
    $showreel_url = wvn_home_text('home_showreel_button_url', '');
    $showreel_txt = wvn_home_text('home_showreel_button_text', 'See more');
    if (!empty($showreel_url)) : ?>
      <div class="wvn-showreel-action">
        <a class="wvn-showreel-btn" href="<?php echo esc_url($showreel_url); ?>" target="_blank" rel="noopener">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
          <span><?php echo esc_html($showreel_txt); ?></span>
          <span aria-hidden="true">↗</span>
        </a>
      </div>
    <?php endif; ?>
  </section>

  <?php
  $cin = wvn_cinematic_home();
  $cin_tiles = $cin['mosaic'];
  ?>
  <section class="wvn-cin-story" id="the-story-we-create" data-wvn-cin-story aria-label="<?php echo esc_attr($cin['start_eyebrow']); ?>">
    <div class="wvn-cin-story__sticky">
      <div class="wvn-cin-story__film" data-wvn-cin-story-film>
        <?php wvn_cin_render_backdrop($cin['story_media'], $cin['story_film'], $cin['story_poster']); ?>
        <div class="wvn-cin-story__film-tint" aria-hidden="true"></div>
      </div>

      <div class="wvn-cin-story__curtain" data-wvn-cin-story-curtain aria-hidden="true"></div>

      <div class="wvn-cin-story__vows-film" data-wvn-cin-vows-film>
        <?php wvn_cin_render_backdrop($cin['vows_media'], $cin['vows_film'], $cin['vows_poster']); ?>
      </div>
      <div class="wvn-cin-story__vows-shade" aria-hidden="true"></div>
      <div class="wvn-cin-story__vows-mask" data-wvn-cin-vows-mask aria-hidden="true">
        <p class="wvn-cin-story__vows-word"><?php echo esc_html($cin['vows_word']); ?></p>
      </div>

      <div class="wvn-cin-story__tiles" data-wvn-cin-story-tiles aria-hidden="true">
        <?php foreach ($cin_tiles as $ti => $tile_src) : ?>
          <div class="wvn-cin-story__tile" data-row="<?php echo $ti < 3 ? 'top' : 'bottom'; ?>">
            <img src="<?php echo esc_url($tile_src); ?>" alt="" loading="lazy" decoding="async">
          </div>
        <?php endforeach; ?>
      </div>

      <div class="wvn-cin-story__start" data-wvn-cin-story-start>
        <div class="wvn-cin-story__card">
          <p class="wvn-cin-story__start-eyebrow"><?php echo esc_html($cin['start_eyebrow']); ?></p>
          <h2 class="wvn-cin-story__start-heading">
            <?php echo esc_html($cin['start_heading']); ?>
            <?php if ($cin['start_heading_em'] !== '') : ?>
              <em><?php echo esc_html($cin['start_heading_em']); ?></em>
            <?php endif; ?>
          </h2>
          <p class="wvn-cin-story__start-sub"><?php echo esc_html($cin['start_sub']); ?></p>
        </div>
      </div>

      <div class="wvn-cin-story__vows-caption" data-wvn-cin-vows-caption>
        <div class="wvn-cin-story__vows-panel">
          <p class="wvn-cin-story__vows-eyebrow"><?php echo esc_html($cin['vows_eyebrow']); ?></p>
          <h2 class="wvn-cin-story__vows-headline">
            <?php echo esc_html($cin['vows_headline']); ?>
            <?php if ($cin['vows_headline_em'] !== '') : ?>
              <span><?php echo esc_html($cin['vows_headline_em']); ?></span>
            <?php endif; ?>
          </h2>
          <a class="wvn-cin-story__vows-cta" href="<?php echo esc_url($cin['vows_cta_url']); ?>">
            <?php echo esc_html($cin['vows_cta']); ?>
            <span class="wvn-cin-story__vows-cta-arrow" aria-hidden="true">↗</span>
          </a>
        </div>
      </div>

      <div class="wvn-cin-story__vignette" data-wvn-cin-story-vignette aria-hidden="true"></div>
      <div class="wvn-cin-story__grain" aria-hidden="true"></div>
      <div class="wvn-cin-story__cue" data-wvn-cin-story-cue aria-hidden="true">
        <span>Scroll</span>
        <i></i>
      </div>
    </div>
  </section>

  <?php
  $cin_venues = array_values(array_filter($venues_home, function ($q) {
      return !empty($q['name']) && !empty($q['image']);
  }));
  if (!$cin_venues) {
      // Fallback: keep slider populated until venues are published in admin.
      $cin_quotes = array_values(array_filter($quotes, function ($q) {
          return !empty($q['text']) && !empty($q['name']);
      }));
      $cin_quotes = array_slice($cin_quotes, 0, 6);
      $cin_gallery = array_values(array_filter($gallery));
      if (!$cin_gallery) {
          $cin_gallery = $cin['mosaic'];
      }
      foreach ($cin_quotes as $i => $quote) {
          $meta = trim($quote['time'] ?? '');
          if (!$meta && !empty($quote['tags']) && is_array($quote['tags'])) {
              $meta = implode(' · ', array_slice($quote['tags'], 0, 2));
          }
          $img = !empty($quote['image']) ? $quote['image'] : ($cin_gallery[$i % max(1, count($cin_gallery))] ?? '');
          $cin_venues[] = array(
              'name'  => $quote['name'],
              'text'  => $quote['text'],
              'meta'  => $meta,
              'image' => $img,
              'url'   => '',
              'kicker'=> $cin['cites_kicker'],
          );
      }
  }
  $cin_venues = array_slice($cin_venues, 0, 8);
  ?>
  <section class="wvn-cin-cites" id="venues" data-wvn-cin-cites aria-label="Venues">
    <div class="wvn-cin-cites__atmosphere" aria-hidden="true">
      <div class="wvn-cin-cites__glow"></div>
      <div class="wvn-cin-cites__grain"></div>
    </div>

    <div class="wvn-cin-cites__inner">
      <header class="wvn-cin-cites__head">
        <p class="wvn-cin-cites__eyebrow"><?php echo esc_html($cin['cites_eyebrow']); ?></p>
        <h2 class="wvn-cin-cites__title">
          <?php echo esc_html($cin['cites_heading']); ?>
          <?php if ($cin['cites_heading_em'] !== '') : ?>
            <em><?php echo esc_html($cin['cites_heading_em']); ?></em>
          <?php endif; ?>
        </h2>
      </header>

      <div class="wvn-cin-cites__deck" data-wvn-cin-cites-deck>
        <div class="wvn-cin-cites__rail" aria-hidden="true"></div>
        <div class="wvn-cin-cites__stage" data-wvn-cin-cites-stage>
          <?php foreach ($cin_venues as $i => $venue) :
              $meta = trim($venue['meta'] ?? '');
              $img = $venue['image'] ?? '';
              $url = $venue['url'] ?? '';
              $kicker = !empty($venue['kicker']) ? $venue['kicker'] : $cin['cites_kicker'];
              $blurb = $venue['text'] ?? '';
              ?>
            <article
              class="wvn-cin-cites__card<?php echo $i === 0 ? ' is-active' : ''; ?>"
              data-wvn-cin-cites-card
              data-index="<?php echo (int) $i; ?>"
              data-quote="<?php echo esc_attr($blurb); ?>"
              data-name="<?php echo esc_attr($venue['name']); ?>"
              data-meta="<?php echo esc_attr($meta); ?>"
              data-image="<?php echo esc_url($img); ?>"
              <?php if ($url) : ?>data-url="<?php echo esc_url($url); ?>"<?php endif; ?>
              style="--o: <?php echo (int) $i; ?>"
              role="button"
              tabindex="0"
              aria-roledescription="slide"
              aria-label="<?php echo esc_attr('View venue: ' . $venue['name']); ?>"
              <?php echo $i === 0 ? '' : ' aria-hidden="true"'; ?>
            >
              <div class="wvn-cin-cites__card-media">
                <?php if ($img) : ?>
                  <img src="<?php echo esc_url($img); ?>" alt="" loading="lazy" decoding="async">
                <?php endif; ?>
              </div>
              <div class="wvn-cin-cites__card-body">
                <p class="wvn-cin-cites__kicker"><?php echo esc_html($kicker); ?></p>
                <p class="wvn-cin-cites__venue-title"><?php echo esc_html($venue['name']); ?></p>
                <?php if ($blurb !== '') : ?>
                  <blockquote class="wvn-cin-cites__quote"><?php echo esc_html($blurb); ?></blockquote>
                <?php endif; ?>
                <?php if ($url) : ?>
                  <span class="wvn-cin-cites__cta" aria-hidden="true">View venue</span>
                <?php endif; ?>
                <?php if ($meta) : ?>
                  <div class="wvn-cin-cites__credit">
                    <span class="wvn-cin-cites__meta"><?php echo esc_html($meta); ?></span>
                  </div>
                <?php endif; ?>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="wvn-cin-cites__nav">
        <button type="button" class="wvn-cin-cites__btn" data-wvn-cin-cites-prev aria-label="Previous venue">←</button>
        <div class="wvn-cin-cites__dots" data-wvn-cin-cites-dots role="tablist" aria-label="Choose a venue">
          <?php foreach ($cin_venues as $i => $venue) : ?>
            <button
              type="button"
              class="wvn-cin-cites__dot<?php echo $i === 0 ? ' is-active' : ''; ?>"
              data-wvn-cin-cites-dot
              data-index="<?php echo (int) $i; ?>"
              aria-label="Go to venue <?php echo (int) ($i + 1); ?>"
              <?php echo $i === 0 ? ' aria-current="true"' : ''; ?>
            ></button>
          <?php endforeach; ?>
        </div>
        <button type="button" class="wvn-cin-cites__btn" data-wvn-cin-cites-next aria-label="Next venue">→</button>
      </div>
    </div>
  </section>

  <section class="wvn-cta">
    <div class="wvn-cta-box">
      <h2 class="wvn-display"><?php echo esc_html(wvn_home_text('home_cta_heading', 'Let’s plan your wedding with confidence')); ?></h2>
      <p class="wvn-lede"><?php echo esc_html(wvn_home_text('home_cta_text', 'Connect with our expert wedding planner to discuss your ideas, timelines, and requirements. Let us handle the planning, while you enjoy the celebration.')); ?></p>
      <a class="wvn-btn" href="<?php echo esc_url(wvn_home_text('home_cta_url', home_url('/contact-us/'))); ?>"><?php echo esc_html(wvn_home_text('home_cta_button', 'Book a Consultation ↗')); ?></a>
    </div>
  </section>

  <section class="wvn-stories">
    <p class="wvn-kicker wvn-center"><?php echo esc_html(wvn_home_text('home_stories_kicker', 'Couple stories')); ?></p>
    <h2 class="wvn-display wvn-center"><?php echo esc_html(wvn_home_text('home_stories_heading', 'Hear it straight from our couples')); ?></h2>
    <div class="wvn-stories-grid">
      <?php foreach (array_slice($stories, 0, 3) as $story) :
          $has_video = !empty($story['video']);
          ?>
        <figure class="wvn-story<?php echo $has_video ? ' has-video' : ''; ?>">
          <?php if (!empty($story['image'])) : ?>
            <img src="<?php echo esc_url($story['image']); ?>" alt="<?php echo esc_attr($story['title']); ?>" loading="lazy">
          <?php endif; ?>
          <?php if ($has_video) : ?>
            <video playsinline autoplay muted loop preload="auto" src="<?php echo esc_url($story['video']); ?>"></video>
            <div class="wvn-story-overlay" aria-hidden="true"></div>
            <button class="wvn-story-play" type="button" data-story-play aria-label="Toggle sound and play">
              <span class="wvn-story-play-icon"></span>
            </button>
          <?php endif; ?>
          <figcaption>
            <strong><?php echo esc_html($story['title']); ?></strong><br>
            <small><?php echo esc_html($story['caption'] ?? 'In Their Words'); ?></small>
          </figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  </section>

  <?php
  $hg = wvn_home_gallery_collage();
  $hg_items = $hg['items'];
  ?>
  <section class="wvn-gallery wvn-hg" id="gallery" aria-label="<?php echo esc_attr($hg['kicker']); ?>">
    <div class="wvn-hg__inner">
      <header class="wvn-hg__head">
        <p class="wvn-hg__eyebrow"><?php echo esc_html($hg['kicker']); ?></p>
        <h2 class="wvn-hg__heading"><?php echo esc_html($hg['heading']); ?></h2>
        <p class="wvn-hg__lede"><?php echo esc_html($hg['lede']); ?></p>
      </header>

      <?php if (count($hg['filters']) > 1) : ?>
        <div class="wvn-hg__filters" role="tablist" aria-label="Filter gallery">
          <?php foreach ($hg['filters'] as $fkey => $flabel) : ?>
            <button
              type="button"
              class="wvn-hg__filter<?php echo $fkey === 'all' ? ' is-active' : ''; ?>"
              role="tab"
              aria-selected="<?php echo $fkey === 'all' ? 'true' : 'false'; ?>"
              data-hg-filter="<?php echo esc_attr($fkey); ?>"
            ><?php echo esc_html($flabel); ?></button>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <p class="wvn-hg__rail-hint" aria-hidden="true">
        <span>Swipe stories</span>
        <span data-hg-progress>01 / <?php echo esc_html(str_pad((string) max(1, count($hg_items)), 2, '0', STR_PAD_LEFT)); ?></span>
      </p>

      <div class="wvn-hg__collage wvn-mosaic" data-hg-collage>
        <?php foreach ($hg_items as $gi => $card) :
            $tag_str = implode(' ', $card['tags']);
            $role = $card['role'];
            $is_film = ($card['type'] ?? '') === 'film';
            $is_video = ($card['type'] ?? '') === 'video';
            ?>
          <article
            class="wvn-hg-card wvn-hg-card--<?php echo esc_attr($role); ?><?php echo $is_film ? ' is-film' : ''; ?>"
            data-hg-card
            data-hg-tags="<?php echo esc_attr($tag_str); ?>"
            style="--hg-i: <?php echo (int) $gi; ?>"
          >
            <?php if ($is_film) : ?>
              <button type="button" class="wvn-hg-card__media" data-open-showreel aria-label="Play wedding film">
                <img
                  src="<?php echo esc_url($card['image']); ?>"
                  alt="<?php echo esc_attr($card['alt']); ?>"
                  loading="lazy"
                  decoding="async"
                >
                <span class="wvn-hg-card__veil" aria-hidden="true"></span>
                <span class="wvn-hg-card__play" aria-hidden="true">▶</span>
              </button>
            <?php elseif ($is_video) : ?>
              <div class="wvn-hg-card__media wvn-hg-card__media--video">
                <video
                  src="<?php echo esc_url($card['video']); ?>"
                  <?php echo !empty($card['image']) ? 'poster="' . esc_url($card['image']) . '"' : ''; ?>
                  muted
                  autoplay
                  loop
                  playsinline
                  preload="metadata"
                  aria-label="<?php echo esc_attr($card['alt']); ?>"
                ></video>
                <span class="wvn-hg-card__veil" aria-hidden="true"></span>
              </div>
            <?php else : ?>
              <a
                class="wvn-hg-card__media"
                href="<?php echo esc_url($card['image']); ?>"
                data-wvn-lightbox
                data-caption="<?php echo esc_attr($card['title']); ?>"
              >
                <img
                  src="<?php echo esc_url($card['image']); ?>"
                  alt="<?php echo esc_attr($card['alt']); ?>"
                  <?php echo !empty($card['eager']) ? 'fetchpriority="high" decoding="async"' : 'loading="lazy" decoding="async"'; ?>
                >
                <span class="wvn-hg-card__veil" aria-hidden="true"></span>
              </a>
            <?php endif; ?>

            <div class="wvn-hg-card__meta">
              <p class="wvn-hg-card__label"><?php echo esc_html($card['label']); ?></p>
              <h3 class="wvn-hg-card__title"><?php echo esc_html($card['title']); ?></h3>
              <?php if (!empty($card['story_url'])) : ?>
                <a class="wvn-hg-card__story" href="<?php echo esc_url($card['story_url']); ?>">View story <span aria-hidden="true">→</span></a>
              <?php elseif ($is_film) : ?>
                <button type="button" class="wvn-hg-card__story" data-open-showreel>Watch film <span aria-hidden="true">→</span></button>
              <?php elseif ($is_video) : ?>
                <span class="wvn-hg-card__story">Watch film <span aria-hidden="true">→</span></span>
              <?php else : ?>
                <button type="button" class="wvn-hg-card__story" data-hg-open-lb>View moment <span aria-hidden="true">→</span></button>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <div class="wvn-hg__dots" data-hg-dots role="tablist" aria-label="Gallery stories"></div>

      <div class="wvn-hg__cta">
        <a class="wvn-hg__cta-link" href="<?php echo esc_url($hg['cta_url']); ?>">
          <?php echo esc_html($hg['cta']); ?>
          <span class="wvn-hg__cta-arrow" aria-hidden="true">→</span>
        </a>
      </div>
    </div>
  </section>

  <section class="wvn-faq">
    <p class="wvn-kicker wvn-center"><?php echo esc_html(wvn_home_text('home_faq_kicker', 'FAQs')); ?></p>
    <h2 class="wvn-display wvn-center"><?php echo esc_html(wvn_home_text('home_faq_heading', 'Questions, answered in advance')); ?></h2>
    <p class="wvn-lede"><?php echo esc_html(wvn_home_text('home_faq_lede', 'Let your wedding planner answer the things couples ask us most — before you even have to ask.')); ?></p>
    <div class="wvn-acc">
      <?php foreach ($faqs as $i => $faq) : ?>
        <details name="wvn-faq"<?php echo $i === 0 ? ' open' : ''; ?>>
          <summary><?php echo esc_html($faq['q']); ?></summary>
          <p><?php echo esc_html($faq['a']); ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </section>
  <?php
  $seo_eyebrow = wvn_home_text('home_seo_eyebrow', 'Wedding planning in Udaipur');
  $seo_title = wvn_home_text('home_seo_title', 'Wedding & Event Planner');
  $seo_title_em = wvn_home_text('home_seo_title_em', 'in Udaipur');
  $seo_lede = wvn_home_text('home_seo_lede', 'Wedding Vows by Nikhil plans destination weddings and events in Udaipur, from palace celebrations and lakeside ceremonies to intimate and large multi-day weddings. Our team coordinates venue sourcing, wedding décor and design, guest hospitality, production and on-ground execution.');
  $seo_prompt = wvn_home_text('home_seo_prompt', 'Planning a destination wedding in Udaipur?');
  $seo_links = array(
      array('label' => wvn_home_text('home_seo_link1_label', 'Udaipur wedding planning guide'), 'url' => wvn_home_text('home_seo_link1_url', home_url('/weddings-in-udaipur/'))),
      array('label' => wvn_home_text('home_seo_link2_label', 'Wedding venues in Udaipur'), 'url' => wvn_home_text('home_seo_link2_url', home_url('/wedding-venues-udaipur/'))),
      array('label' => wvn_home_text('home_seo_link3_label', 'Udaipur wedding costs'), 'url' => wvn_home_text('home_seo_link3_url', home_url('/udaipur-wedding-cost/'))),
      array('label' => wvn_home_text('home_seo_link4_label', 'Real wedding portfolio'), 'url' => wvn_home_text('home_seo_link4_url', home_url('/portfolio/'))),
  );
  ?>
  <section class="wvn-home-seo-copy" aria-labelledby="wvn-home-seo-heading">
    <div class="wvn-home-seo-copy__inner">
      <p class="wvn-home-seo-copy__eyebrow">Destination wedding planning in Udaipur</p>

      <h2 id="wvn-home-seo-heading">
        Destination Wedding Planner
        <em>in Udaipur</em>
      </h2>

      <p class="wvn-home-seo-copy__lede">
        Wedding Vows by Nikhil is a Udaipur-based destination wedding planner and event planning studio for couples celebrating in Rajasthan. From palace and lakeside weddings to luxury resort celebrations, we handle venue sourcing, wedding décor and design, guest hospitality, entertainment, production, transport, timelines and complete on-ground coordination.
      </p>

      <div class="wvn-home-seo-copy__topics">
        <article>
          <h3>Wedding &amp; Event Planner in Udaipur</h3>
          <p>Plan mehendi, haldi, sangeet, wedding ceremonies and receptions with one local team managing vendors, design, production and the wedding-day schedule.</p>
          <a href="<?php echo esc_url(home_url('/wedding-planner-udaipur/')); ?>">Wedding planning services <span aria-hidden="true">→</span></a>
        </article>

        <article>
          <h3>Luxury &amp; Palace Weddings in Udaipur</h3>
          <p>Compare palace, heritage and luxury resort settings around Lake Pichola and Udaipur based on guest count, room blocks, functions and celebration style.</p>
          <a href="<?php echo esc_url(home_url('/wedding-venues-udaipur/')); ?>">Explore wedding venues <span aria-hidden="true">→</span></a>
        </article>

        <article>
          <h3>Udaipur Destination Wedding Cost</h3>
          <p>Understand the main budget drivers — venue and rooms, catering, décor, production, photography and planning — before you shortlist your venue and wedding season.</p>
          <a href="<?php echo esc_url(home_url('/udaipur-wedding-cost/')); ?>">See the cost guide <span aria-hidden="true">→</span></a>
        </article>

        <article>
          <h3>Real Udaipur Wedding Stories</h3>
          <p>Explore real celebrations, venues and couple stories to see how a destination wedding comes together from the first planning conversation to the final farewell.</p>
          <a href="<?php echo esc_url(home_url('/portfolio/')); ?>">View real weddings <span aria-hidden="true">→</span></a>
        </article>
      </div>

      <nav class="wvn-home-seo-copy__links" aria-label="Udaipur wedding planning resources">
        <a href="<?php echo esc_url(home_url('/destination-wedding-planner-udaipur/')); ?>">Destination wedding planner in Udaipur</a>
        <a href="<?php echo esc_url(home_url('/event-planner-udaipur/')); ?>">Event planner in Udaipur</a>
        <a href="<?php echo esc_url(home_url('/luxury-wedding-planner-udaipur/')); ?>">Luxury wedding planner in Udaipur</a>
        <a href="<?php echo esc_url(home_url('/palace-wedding-venues-in-udaipur/')); ?>">Palace wedding venues in Udaipur</a>
        <a href="<?php echo esc_url(home_url('/weddings-in-udaipur/')); ?>">Weddings in Udaipur guide</a>
      </nav>
    </div>
  </section>

</main>

<?php get_footer(); ?>

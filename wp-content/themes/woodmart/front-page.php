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
$quotes = wvn_testimonials();
$gallery = wvn_gallery_images();
$stories = wvn_stories();
$press_sheets = array_reverse(wvn_pressbook_sheets());
$press_logos = wvn_press_logos();
$service_count = count($services);
?>

<main id="content">
  <section class="wvn-opening" data-pin="opening">
    <div class="wvn-hero">
      <div class="wvn-hero-frame">
        <img src="<?php echo esc_url(wvn_hero_image()); ?>" alt="Destination wedding in Udaipur planned by Wedding Vows by Nikhil" fetchpriority="high" decoding="async">
      </div>
      <div class="wvn-hero-copy"><?php echo esc_html(wvn_home_text('home_hero_copy', 'We work behind the scenes, because your wedding deserves to be planned beautifully.')); ?></div>
    </div>
    <div class="wvn-hero-travel" aria-hidden="true"></div>
    <section class="wvn-intro">
      <div class="wvn-intro-body">
        <?php echo wvn_home_intro_html(); ?>
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

  <section class="wvn-achieve">
    <h2 class="wvn-display"><?php echo esc_html(wvn_home_text('home_achieve_heading', 'Achievements')); ?></h2>
    <p class="wvn-lede"><?php echo esc_html(wvn_home_text('home_achieve_lede', 'We offer complete destination wedding planning, so you only ever deal with one team — from the first venue visit to the final farewell.')); ?></p>
    <div class="wvn-pressbook" data-book>
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
        <button type="button" data-book-prev aria-label="Previous page">‹</button>
        <button type="button" data-book-next aria-label="Next page">›</button>
      </div>
    </div>
    <div class="wvn-logos">
      <?php foreach ($press_logos as $logo) : ?>
        <span><?php echo esc_html($logo); ?></span>
      <?php endforeach; ?>
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
  $cin_quotes = array_values(array_filter($quotes, function ($q) {
      return !empty($q['text']) && !empty($q['name']);
  }));
  $cin_quotes = array_slice($cin_quotes, 0, 6);
  $cin_gallery = array_values(array_filter($gallery));
  if (!$cin_gallery) {
      $cin_gallery = $cin['mosaic'];
  }
  ?>
  <section class="wvn-cin-cites" id="testimonials" data-wvn-cin-cites aria-label="Testimonials">
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
          <?php foreach ($cin_quotes as $i => $quote) :
              $meta = trim($quote['time'] ?? '');
              if (!$meta && !empty($quote['tags']) && is_array($quote['tags'])) {
                  $meta = implode(' · ', array_slice($quote['tags'], 0, 2));
              }
              $img = !empty($quote['image']) ? $quote['image'] : ($cin_gallery[$i % count($cin_gallery)] ?? '');
              $vid = !empty($quote['video']) ? $quote['video'] : '';
              $card_media = (($quote['media'] ?? '') === 'video' && $vid !== '') ? 'video' : 'photo';
              ?>
            <article
              class="wvn-cin-cites__card<?php echo $i === 0 ? ' is-active' : ''; ?>"
              data-wvn-cin-cites-card
              data-index="<?php echo (int) $i; ?>"
              style="--o: <?php echo (int) $i; ?>"
              role="group"
              aria-roledescription="slide"
              aria-label="<?php echo esc_attr(($i + 1) . ' of ' . count($cin_quotes)); ?>"
              <?php echo $i === 0 ? '' : ' aria-hidden="true"'; ?>
            >
              <div class="wvn-cin-cites__card-media">
                <?php if ($card_media === 'video') : ?>
                  <video muted autoplay loop playsinline preload="metadata"<?php echo $img ? ' poster="' . esc_url($img) . '"' : ''; ?>>
                    <source src="<?php echo esc_url($vid); ?>" type="video/mp4">
                  </video>
                <?php elseif ($img) : ?>
                  <img src="<?php echo esc_url($img); ?>" alt="" loading="lazy" decoding="async">
                <?php endif; ?>
              </div>
              <div class="wvn-cin-cites__card-body">
                <p class="wvn-cin-cites__kicker"><?php echo esc_html($cin['cites_kicker']); ?></p>
                <blockquote class="wvn-cin-cites__quote">“<?php echo esc_html($quote['text']); ?>”</blockquote>
                <div class="wvn-cin-cites__credit">
                  <cite class="wvn-cin-cites__name"><?php echo esc_html($quote['name']); ?></cite>
                  <?php if ($meta) : ?>
                    <span class="wvn-cin-cites__meta"><?php echo esc_html($meta); ?></span>
                  <?php endif; ?>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="wvn-cin-cites__nav">
        <button type="button" class="wvn-cin-cites__btn" data-wvn-cin-cites-prev aria-label="Previous story">←</button>
        <div class="wvn-cin-cites__dots" data-wvn-cin-cites-dots role="tablist" aria-label="Choose a story">
          <?php foreach ($cin_quotes as $i => $quote) : ?>
            <button
              type="button"
              class="wvn-cin-cites__dot<?php echo $i === 0 ? ' is-active' : ''; ?>"
              data-wvn-cin-cites-dot
              data-index="<?php echo (int) $i; ?>"
              aria-label="Go to story <?php echo (int) ($i + 1); ?>"
              <?php echo $i === 0 ? ' aria-current="true"' : ''; ?>
            ></button>
          <?php endforeach; ?>
        </div>
        <button type="button" class="wvn-cin-cites__btn" data-wvn-cin-cites-next aria-label="Next story">→</button>
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

  <section class="wvn-gallery">
    <p class="wvn-kicker wvn-center"><?php echo esc_html(wvn_home_text('home_gallery_kicker', 'Gallery')); ?></p>
    <h2 class="wvn-display wvn-center"><?php echo esc_html(wvn_home_text('home_gallery_heading', 'Moments, captured behind the scenes')); ?></h2>
    <p class="wvn-lede"><?php echo esc_html(wvn_home_text('home_gallery_lede', 'A glimpse into the celebrations we have quietly orchestrated — from first looks to the last dance.')); ?></p>
    <div class="wvn-mosaic">
      <?php foreach ($gallery as $image) : ?>
        <a href="<?php echo esc_url($image); ?>" data-wvn-lightbox><img src="<?php echo esc_url($image); ?>" alt="Destination wedding in Udaipur — Wedding Vows by Nikhil" loading="lazy" decoding="async"></a>
      <?php endforeach; ?>
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
  <section class="wvn-home-seo-copy" aria-labelledby="wvn-home-seo-heading">
    <div class="wvn-home-seo-copy__inner">
      <p class="wvn-kicker">Wedding planning in Udaipur</p>
      <h2 id="wvn-home-seo-heading">Wedding &amp; Event Planner in Udaipur</h2>
      <p>Wedding Vows by Nikhil plans destination weddings and events in Udaipur, from palace celebrations and lakeside ceremonies to intimate and large multi-day weddings. Our team coordinates venue sourcing, wedding décor and design, guest hospitality, production and on-ground execution.</p>
      <p>Planning a destination wedding in Udaipur? Explore our <a href="<?php echo esc_url(home_url('/weddings-in-udaipur/')); ?>">Udaipur wedding planning guide</a>, compare <a href="<?php echo esc_url(home_url('/wedding-venues-udaipur/')); ?>">wedding venues in Udaipur</a>, review <a href="<?php echo esc_url(home_url('/udaipur-wedding-cost/')); ?>">Udaipur wedding costs</a>, or see our <a href="<?php echo esc_url(home_url('/portfolio/')); ?>">real wedding portfolio</a>.</p>
    </div>
  </section>
</main>

<?php get_footer(); ?>

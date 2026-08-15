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
      <p class="wvn-kicker"><?php echo esc_html(wvn_home_text('home_intro_kicker', 'Destination wedding planner in Udaipur')); ?></p>
      <h1 class="wvn-display"><?php echo esc_html(wvn_home_text('home_intro_heading', 'Destination weddings in Udaipur, planned with quiet luxury.')); ?></h1>
      <p><?php echo esc_html(wvn_home_text('home_intro_text', 'Wedding Vows by Nikhil is an Udaipur-based destination wedding studio. We plan palace, lakeside and heritage weddings across Udaipur, Jaipur, Jodhpur and Goa — one team from the first venue walk to the last pheras.')); ?></p>
    </section>
  </section>

  <section class="wvn-collective">
    <p class="wvn-kicker wvn-center wvn-reveal"><?php echo esc_html(wvn_home_text('home_collective_kicker', 'WVN Wedding Collective')); ?></p>
    <h2 class="wvn-display wvn-reveal"><?php echo esc_html(wvn_home_text('home_collective_heading', 'Before we tell you our story, let our weddings speak for us.')); ?></h2>
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
  </section>

  <section class="wvn-quotes">
    <p class="wvn-kicker wvn-center"><?php echo esc_html(wvn_home_text('home_quotes_kicker', 'Testimonials')); ?></p>
    <h2 class="wvn-display wvn-center"><?php echo esc_html(wvn_home_text('home_quotes_heading', 'See what our couples say')); ?></h2>
    <p class="wvn-lede"><?php echo esc_html(wvn_home_text('home_quotes_lede', 'Real stories from the families we’ve had the honour to celebrate with.')); ?></p>
    <div class="wvn-masonry">
      <?php foreach ($quotes as $quote) : ?>
        <article class="wvn-quote<?php echo !empty($quote['dark']) ? ' is-dark' : ''; ?>">
          <header>
            <strong><?php echo esc_html($quote['name']); ?></strong>
            <span><?php echo esc_html($quote['time']); ?></span>
          </header>
          <div class="wvn-stars">★★★★★</div>
          <div class="wvn-tags">
            <?php foreach ($quote['tags'] as $tag) : ?><span><?php echo esc_html($tag); ?></span><?php endforeach; ?>
          </div>
          <p><?php echo esc_html($quote['text']); ?></p>
        </article>
      <?php endforeach; ?>
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
      <?php foreach (array_slice($stories, 0, 3) as $story) : ?>
        <figure class="wvn-story">
          <img src="<?php echo esc_url($story['image']); ?>" alt="<?php echo esc_attr($story['title']); ?>">
          <?php if (!empty($story['video'])) : ?>
            <video playsinline preload="metadata" src="<?php echo esc_url($story['video']); ?>"></video>
            <button class="wvn-story-play" type="button" data-story-play aria-label="Play story"></button>
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
</main>

<?php get_footer(); ?>

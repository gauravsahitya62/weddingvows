<?php
/**
 * Portfolio / Weddings page — cinematic layout matching the weddings design board.
 */

function wvn_portfolio_filter_map() {
    return array(
        'udaipur'  => array('udaipur'),
        'palace'   => array('palace', 'leela', 'oberoi', 'taj', 'fairmont', 'raffles', 'jagmandir', 'udaivilas'),
        'lakeside' => array('lake', 'lakeside', 'pichola', 'lakeside'),
        'nri'      => array('nri', 'usa', 'uk', 'abroad', 'outstation', 'international', 'overseas'),
        'intimate' => array('intimate', 'small', 'micro', 'quiet'),
        'grand'    => array('grand', 'multi-day', 'large', 'celebration'),
    );
}

function wvn_portfolio_infer_tags($title, $venue, $pills = '') {
    $hay = strtolower(trim($title . ' ' . $venue . ' ' . $pills));
    $tags = array();
    foreach (wvn_portfolio_filter_map() as $tag => $needles) {
        foreach ($needles as $needle) {
            if ($needle !== '' && strpos($hay, $needle) !== false) {
                $tags[] = $tag;
                break;
            }
        }
    }
    if (!$tags) {
        $tags[] = 'udaipur';
    }
    return array_values(array_unique($tags));
}

function wvn_portfolio_wedding_gallery($id) {
    $urls = array();
    $captions = array();
    $add = function ($url, $caption = '') use (&$urls, &$captions) {
        $url = is_string($url) ? trim($url) : '';
        if ($url === '' || isset($urls[$url])) {
            return;
        }
        $urls[$url] = true;
        $captions[$url] = is_string($caption) ? trim($caption) : '';
    };

    $add(get_the_post_thumbnail_url($id, 'full'));

    if (function_exists('get_field')) {
        $add(wvn_image_url(get_field('portfolio_hero_image', $id), ''));

        $gallery_rows = get_field('gallery_images', $id);
        if (is_array($gallery_rows)) {
            foreach ($gallery_rows as $row) {
                if (is_array($row)) {
                    $add(wvn_image_url($row['image'] ?? $row, ''), isset($row['caption']) ? (string) $row['caption'] : '');
                } else {
                    $add(wvn_image_url($row, ''));
                }
            }
        }

        $events = get_field('portfolio_events', $id);
        if (is_array($events)) {
            foreach ($events as $event) {
                if (!is_array($event)) {
                    continue;
                }
                $event_title = isset($event['event_title']) ? (string) $event['event_title'] : '';
                foreach (array('photo_1', 'photo_2', 'photo_3') as $key) {
                    if (!empty($event[$key])) {
                        $add(wvn_image_url($event[$key], ''), $event_title);
                    }
                }
            }
        }
    }

    $list = array();
    foreach (array_keys($urls) as $url) {
        $list[] = array(
            'url'     => $url,
            'caption' => $captions[$url] ?? '',
        );
    }
    if (!$list && function_exists('wvn_hero_image')) {
        $list[] = array('url' => wvn_hero_image(), 'caption' => '');
    }
    return $list;
}

function wvn_portfolio_cards($limit = 48) {
    $items = array();
    $query = new WP_Query(array(
        'post_type'              => 'portfolio',
        'posts_per_page'         => (int) $limit,
        'post_status'            => 'publish',
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'ignore_sticky_posts'    => true,
        'no_found_rows'          => false,
        'update_post_meta_cache' => true,
        'update_post_term_cache' => false,
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $id = get_the_ID();
            $title = get_the_title($id);
            $venue = '';
            $pills = '';
            if (function_exists('get_field')) {
                $venue = trim((string) get_field('portfolio_venue', $id));
                $pills = trim((string) get_field('portfolio_pills', $id));
                $subtitle = trim((string) get_field('portfolio_subtitle', $id));
                if (!$venue && $subtitle) {
                    $venue = $subtitle;
                }
            }
            if (!$venue) {
                $venue = trim(get_the_excerpt($id)) ?: 'Udaipur, Rajasthan';
            }
            $gallery = wvn_portfolio_wedding_gallery($id);
            $thumb = get_the_post_thumbnail_url($id, 'large') ?: get_the_post_thumbnail_url($id, 'full');
            $items[] = array(
                'id'      => $id,
                'title'   => $title,
                'venue'   => $venue,
                'url'     => get_permalink($id),
                'image'   => $thumb ?: ($gallery[0]['url'] ?? wvn_hero_image()),
                'gallery' => $gallery,
                'tags'    => wvn_portfolio_infer_tags($title, $venue, $pills),
            );
        }
        wp_reset_postdata();
    }

    return $items;
}

function wvn_render_portfolio_page() {
    $cards = wvn_portfolio_cards(48);
    $quotes = function_exists('wvn_testimonials') ? wvn_testimonials() : array();
    $hero = function_exists('wvn_hero_image') ? wvn_hero_image() : '';
    $intro_image = '';
    if (!empty($cards[1]['image'])) {
        $intro_image = $cards[1]['image'];
    } elseif (!empty($cards[0]['image'])) {
        $intro_image = $cards[0]['image'];
    } else {
        $intro_image = $hero;
    }
    $film_image = function_exists('wvn_home_image')
        ? wvn_home_image('home_showreel_image', $hero)
        : $hero;
    $film_caption = function_exists('wvn_home_text')
        ? wvn_home_text('home_showreel_caption', 'The Real Story Behind a Dream Wedding')
        : 'The Real Story Behind a Dream Wedding';

    $filters = array(
        'all'      => 'All',
        'udaipur'  => 'Udaipur',
        'palace'   => 'Palace',
        'lakeside' => 'Lakeside',
        'nri'      => 'NRI',
        'intimate' => 'Intimate',
        'grand'    => 'Grand',
    );

    $hero_cats = array(
        array('n' => '01', 'label' => 'Udaipur', 'filter' => 'udaipur'),
        array('n' => '02', 'label' => 'Palace Weddings', 'filter' => 'palace'),
        array('n' => '03', 'label' => 'Lakeside Celebrations', 'filter' => 'lakeside'),
        array('n' => '04', 'label' => 'Intimate Affairs', 'filter' => 'intimate'),
        array('n' => '05', 'label' => 'Grand Celebrations', 'filter' => 'grand'),
        array('n' => '06', 'label' => 'NRI & Outstation', 'filter' => 'nri'),
    );

    $initial = 6;
    ?>
<main id="content" class="wvn-pf">
  <section class="wvn-pf-hero">
    <div class="wvn-pf-hero__media" style="background-image:url('<?php echo esc_url($hero); ?>')" aria-hidden="true"></div>
    <div class="wvn-pf-hero__veil" aria-hidden="true"></div>
    <div class="wvn-pf-hero__grain" aria-hidden="true"></div>
    <div class="wvn-pf-hero__inner">
      <p class="wvn-pf-eyebrow">Wedding Vows · Portfolio</p>
      <h1 class="wvn-display">Love stories<br><em>beyond destinations.</em></h1>
      <p class="wvn-pf-lede">Palace, lakeside and heritage celebrations planned in Udaipur and across India — each one shaped around the people at its centre.</p>
      <a class="wvn-pf-btn wvn-pf-btn--ghost" href="#wvn-pf-stories">Explore our weddings <span aria-hidden="true">→</span></a>
    </div>
    <p class="wvn-pf-scroll" aria-hidden="true"><span>Scroll</span></p>
    <nav class="wvn-pf-hero-cats" aria-label="Wedding categories">
      <?php foreach ($hero_cats as $cat) : ?>
        <button type="button" class="wvn-pf-hero-cat" data-pf-filter="<?php echo esc_attr($cat['filter']); ?>">
          <span><?php echo esc_html($cat['n']); ?></span>
          <?php echo esc_html($cat['label']); ?>
        </button>
      <?php endforeach; ?>
    </nav>
  </section>

  <section class="wvn-pf-intro">
    <div class="wvn-pf-intro__copy">
      <p class="wvn-pf-eyebrow wvn-pf-eyebrow--dark">Our Weddings</p>
      <h2 class="wvn-display">Extraordinary people.<br><em>Timeless places.</em></h2>
      <p>We plan destination weddings the way a film is directed — with atmosphere, pacing and intimacy. Every celebration is built around the venue, the guest journey and the way the couple wants the days to feel.</p>
      <a class="wvn-pf-btn wvn-pf-btn--solid" href="#wvn-pf-stories">View all weddings <span aria-hidden="true">→</span></a>
    </div>
    <figure class="wvn-pf-intro__frame">
      <img src="<?php echo esc_url($intro_image); ?>" alt="A Wedding Vows celebration in Udaipur" loading="lazy" decoding="async">
      <figcaption>Stories That Stay</figcaption>
    </figure>
  </section>

  <section class="wvn-pf-stories" id="wvn-pf-stories">
    <div class="wvn-pf-stories__head">
      <p class="wvn-pf-eyebrow">Featured Weddings</p>
      <h2 class="wvn-display">Curated <em>stories.</em></h2>
    </div>

    <div class="wvn-pf-filters" role="tablist" aria-label="Filter weddings">
      <?php foreach ($filters as $key => $label) : ?>
        <button type="button" class="wvn-pf-filter<?php echo $key === 'all' ? ' is-active' : ''; ?>" data-pf-filter="<?php echo esc_attr($key); ?>" role="tab" aria-selected="<?php echo $key === 'all' ? 'true' : 'false'; ?>">
          <?php echo esc_html($label); ?>
        </button>
      <?php endforeach; ?>
    </div>

    <?php if ($cards) : ?>
      <div class="wvn-pf-grid" data-pf-grid data-pf-page-size="<?php echo (int) $initial; ?>">
        <?php foreach ($cards as $index => $card) :
            $tag_str = implode(' ', $card['tags']);
            $hidden = $index >= $initial ? ' is-beyond' : '';
            $gallery = !empty($card['gallery']) ? $card['gallery'] : array(array('url' => $card['image'], 'caption' => ''));
            ?>
          <article
            class="wvn-pf-card<?php echo esc_attr($hidden); ?>"
            data-pf-tags="<?php echo esc_attr($tag_str); ?>"
            data-pf-index="<?php echo (int) $index; ?>"
            data-pf-gallery
          >
            <button type="button" class="wvn-pf-card__hit" data-pf-open-gallery aria-label="<?php echo esc_attr('Open gallery: ' . $card['title']); ?>">
              <figure>
                <img src="<?php echo esc_url($card['image']); ?>" alt="<?php echo esc_attr($card['title']); ?>" loading="lazy" decoding="async">
              </figure>
              <div class="wvn-pf-card__meta">
                <h3><?php echo esc_html($card['title']); ?></h3>
                <p><?php echo esc_html($card['venue']); ?></p>
              </div>
              <span class="wvn-pf-card__go" aria-hidden="true">↗</span>
            </button>
            <div class="wvn-pf-card__slides" hidden>
              <?php foreach ($gallery as $gi => $gitem) :
                  $gurl = is_array($gitem) ? ($gitem['url'] ?? '') : $gitem;
                  $gcap = is_array($gitem) ? trim((string) ($gitem['caption'] ?? '')) : '';
                  if ($gcap === '') {
                      $gcap = $card['title'];
                      if (!empty($card['venue'])) {
                          $gcap .= ' — ' . $card['venue'];
                      }
                  }
                  if ($gurl === '') {
                      continue;
                  }
                  ?>
                <a href="<?php echo esc_url($gurl); ?>" data-wvn-lightbox data-caption="<?php echo esc_attr($gcap); ?>"><?php echo esc_html($card['title'] . ' photo ' . ((int) $gi + 1)); ?></a>
              <?php endforeach; ?>
            </div>
            <a class="wvn-pf-card__story" href="<?php echo esc_url($card['url']); ?>">Full story</a>
          </article>
        <?php endforeach; ?>
      </div>
      <?php if (count($cards) > $initial) : ?>
        <div class="wvn-pf-more-wrap">
          <button type="button" class="wvn-pf-btn wvn-pf-btn--ghost" data-pf-more>Load more weddings <span aria-hidden="true">→</span></button>
        </div>
      <?php endif; ?>
    <?php else : ?>
      <p class="wvn-pf-empty">Add weddings under Portfolio in wp-admin — each one appears here.</p>
    <?php endif; ?>
  </section>

  <section class="wvn-pf-film">
    <div class="wvn-pf-film__media" style="background-image:url('<?php echo esc_url($film_image); ?>')" aria-hidden="true"></div>
    <div class="wvn-pf-film__veil" aria-hidden="true"></div>
    <div class="wvn-pf-film__copy">
      <p class="wvn-pf-eyebrow">The Film</p>
      <h2 class="wvn-display">It’s more than<br><em>a wedding.</em></h2>
      <p><?php echo esc_html($film_caption); ?></p>
      <button type="button" class="wvn-pf-btn wvn-pf-btn--ghost" data-open-showreel>
        <span class="wvn-pf-play" aria-hidden="true">▶</span>
        Watch our film
      </button>
    </div>
  </section>

  <?php if ($quotes) :
      $gallery_fallback = function_exists('wvn_gallery_images') ? wvn_gallery_images() : array();
      if (!$gallery_fallback && $cards) {
          foreach ($cards as $card) {
              if (!empty($card['image'])) {
                  $gallery_fallback[] = $card['image'];
              }
          }
      }
      if (!$gallery_fallback) {
          $gallery_fallback[] = $hero;
      }
      ?>
  <section class="wvn-cin-cites wvn-pf-cites" id="wvn-pf-testimonials" data-wvn-cin-cites aria-label="Couple stories">
    <div class="wvn-cin-cites__atmosphere" aria-hidden="true">
      <div class="wvn-cin-cites__glow"></div>
      <div class="wvn-cin-cites__grain"></div>
    </div>

    <div class="wvn-cin-cites__inner">
      <header class="wvn-cin-cites__head">
        <p class="wvn-cin-cites__eyebrow">Kind Words</p>
        <h2 class="wvn-cin-cites__title">From our <em>couples.</em></h2>
      </header>

      <div class="wvn-cin-cites__deck" data-wvn-cin-cites-deck>
        <div class="wvn-cin-cites__rail" aria-hidden="true"></div>
        <div class="wvn-cin-cites__stage" data-wvn-cin-cites-stage>
          <?php foreach (array_values($quotes) as $i => $quote) :
              $text = $quote['text'] ?? $quote['quote'] ?? '';
              $name = $quote['name'] ?? $quote['client'] ?? '';
              $meta = trim($quote['time'] ?? '');
              if (!$meta && !empty($quote['tags']) && is_array($quote['tags'])) {
                  $meta = implode(' · ', array_slice($quote['tags'], 0, 2));
              }
              $img = !empty($quote['image']) ? $quote['image'] : ($gallery_fallback[$i % count($gallery_fallback)] ?? '');
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
              aria-label="<?php echo esc_attr(($i + 1) . ' of ' . count($quotes)); ?>"
              <?php echo $i === 0 ? '' : ' aria-hidden="true"'; ?>
            >
              <div class="wvn-cin-cites__card-media">
                <?php if ($card_media === 'video') : ?>
                  <video muted autoplay loop playsinline preload="metadata"<?php echo $img ? ' poster="' . esc_url($img) . '"' : ''; ?>>
                    <source src="<?php echo esc_url($vid); ?>" type="video/mp4">
                  </video>
                  <button type="button" class="wvn-cin-cites__play" aria-label="Play story" tabindex="-1"><span></span></button>
                <?php elseif ($img) : ?>
                  <img src="<?php echo esc_url($img); ?>" alt="" loading="lazy" decoding="async">
                <?php endif; ?>
              </div>
              <div class="wvn-cin-cites__card-body">
                <p class="wvn-cin-cites__kicker">Couple Story</p>
                <blockquote class="wvn-cin-cites__quote">“<?php echo esc_html($text); ?>”</blockquote>
                <div class="wvn-cin-cites__credit">
                  <cite class="wvn-cin-cites__name"><?php echo esc_html($name); ?></cite>
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
          <?php foreach (array_values($quotes) as $i => $quote) : ?>
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
  <?php endif; ?>

  <section class="wvn-pf-cta">
    <p class="wvn-pf-eyebrow">Begin</p>
    <h2 class="wvn-display">Let’s create something<br><em>extraordinary.</em></h2>
    <div class="wvn-pf-cta__actions">
      <a class="wvn-pf-btn wvn-pf-btn--rose" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Book a consultation</a>
      <a class="wvn-pf-btn wvn-pf-btn--ghost" href="<?php echo esc_url(home_url('/what-we-do/')); ?>">View our services</a>
    </div>
  </section>
</main>
    <?php
}

<?php
/**
 * Single Venue — detail page matching mockup (cream + oxblood).
 */
get_header();

while (have_posts()) :
    the_post();

    if (function_exists('wvn_elementor_editing') && wvn_elementor_editing()) :
        ?>
<main id="content" class="wvn-page">
  <?php the_content(); ?>
</main>
        <?php
        get_footer();
        return;
    endif;

    $v = function_exists('wvn_venue_detail') ? wvn_venue_detail(get_the_ID()) : array();
    $title = $v['title'] ?? get_the_title();
    $contact = home_url('/contact/');
    ?>
<main id="content" class="wvn-venue-single">

  <section class="wvn-venue-hero"<?php echo !empty($v['hero']) ? ' style="background-image:url(\'' . esc_url($v['hero']) . '\');"' : ''; ?>>
    <div class="wvn-venue-hero__shade" aria-hidden="true"></div>
    <div class="wvn-venue-hero__inner">
      <div class="wvn-venue-hero__copy">
        <h1 class="wvn-venue-hero__title"><?php echo esc_html($title); ?></h1>
        <?php if (!empty($v['location'])) : ?>
          <p class="wvn-venue-hero__location"><?php echo esc_html($v['location']); ?></p>
        <?php endif; ?>
        <ul class="wvn-venue-hero__stats">
          <?php if (!empty($v['rating'])) : ?>
            <li>
              <span class="wvn-venue-hero__stat-icon" aria-hidden="true">★</span>
              <span>
                <strong><?php echo esc_html($v['rating']); ?></strong>
                <?php if (!empty($v['reviews'])) : ?>
                  <em>/ <?php echo esc_html($v['reviews']); ?> Reviews</em>
                <?php endif; ?>
              </span>
            </li>
          <?php endif; ?>
          <?php if (!empty($v['region'])) : ?>
            <li>
              <span class="wvn-venue-hero__stat-icon" aria-hidden="true">⌖</span>
              <span><?php echo esc_html($v['region']); ?></span>
            </li>
          <?php endif; ?>
          <?php if (!empty($v['view'])) : ?>
            <li>
              <span class="wvn-venue-hero__stat-icon" aria-hidden="true">◉</span>
              <span><?php echo esc_html($v['view']); ?></span>
            </li>
          <?php endif; ?>
          <?php if (!empty($v['duration'])) : ?>
            <li>
              <span class="wvn-venue-hero__stat-icon" aria-hidden="true">◷</span>
              <span><?php echo esc_html($v['duration']); ?></span>
            </li>
          <?php elseif (!empty($v['capacity'])) : ?>
            <li>
              <span class="wvn-venue-hero__stat-icon" aria-hidden="true">◷</span>
              <span><?php echo esc_html($v['capacity']); ?> guests</span>
            </li>
          <?php endif; ?>
        </ul>
      </div>
      <?php if (!empty($v['starting_price']) || !empty($v['rooms_count'])) : ?>
        <aside class="wvn-venue-hero__chips" aria-label="Quick facts">
          <?php if (!empty($v['capacity'])) : ?>
            <div><span>Capacity</span><strong><?php echo esc_html($v['capacity']); ?></strong></div>
          <?php endif; ?>
          <?php if (!empty($v['rooms_count'])) : ?>
            <div><span>Rooms</span><strong><?php echo esc_html($v['rooms_count']); ?></strong></div>
          <?php endif; ?>
          <?php if (!empty($v['starting_price'])) : ?>
            <div><span>From</span><strong><?php echo esc_html($v['starting_price']); ?></strong></div>
          <?php endif; ?>
        </aside>
      <?php endif; ?>
    </div>
  </section>

  <nav class="wvn-venue-nav" data-wvn-venue-nav aria-label="Venue sections">
    <div class="wvn-venue-nav__inner">
      <a href="#pricing">Pricing</a>
      <a href="#photos">Photos &amp; Videos</a>
      <a href="#spaces">Venues</a>
      <a href="#rooms">Rooms</a>
      <a href="#inclusions">Wedding Inclusions</a>
      <a href="#policies">Policies</a>
      <a href="#about">About</a>
    </div>
  </nav>

  <div class="wvn-venue-layout">
    <div class="wvn-venue-main">

      <section class="wvn-venue-card" id="pricing">
        <h2 class="wvn-venue-card__title">Pricing</h2>
        <?php if (!empty($v['price_range'])) : ?>
          <p class="wvn-venue-price"><?php echo esc_html($v['price_range']); ?></p>
        <?php endif; ?>
        <?php if (!empty($v['price_note'])) : ?>
          <p class="wvn-venue-price-note"><?php echo esc_html($v['price_note']); ?></p>
        <?php endif; ?>
        <?php if (!empty($v['pricing'])) : ?>
          <ul class="wvn-venue-price-list">
            <?php foreach ($v['pricing'] as $row) :
                $label = is_array($row) ? ($row['label'] ?? '') : '';
                $value = is_array($row) ? ($row['value'] ?? '') : '';
                if ($label === '' && $value === '') {
                    continue;
                }
                ?>
              <li>
                <span><?php echo esc_html($label); ?></span>
                <strong><?php echo esc_html($value); ?></strong>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
        <?php if (!empty($v['price_disclaimer'])) : ?>
          <p class="wvn-venue-disclaimer"><?php echo esc_html($v['price_disclaimer']); ?></p>
        <?php endif; ?>
      </section>

      <?php if (!empty($v['gallery']) || !empty($v['video_url'])) : ?>
        <section class="wvn-venue-card" id="photos">
          <h2 class="wvn-venue-card__title">Photos &amp; Videos</h2>
          <?php if (!empty($v['video_url'])) : ?>
            <p class="wvn-venue-video-link">
              <a href="<?php echo esc_url($v['video_url']); ?>" target="_blank" rel="noopener">Watch venue film →</a>
            </p>
          <?php endif; ?>
          <?php if (!empty($v['gallery'])) : ?>
            <div class="wvn-venue-gallery" data-wvn-venue-gallery>
              <?php foreach ($v['gallery'] as $gi => $gurl) : ?>
                <a href="<?php echo esc_url($gurl); ?>" class="wvn-venue-gallery__item" data-index="<?php echo (int) $gi; ?>">
                  <img src="<?php echo esc_url($gurl); ?>" alt="" loading="lazy" decoding="async">
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </section>
      <?php endif; ?>

      <section class="wvn-venue-card" id="spaces">
        <h2 class="wvn-venue-card__title">Venues</h2>
        <?php if (!empty($v['spaces_intro'])) : ?>
          <p class="wvn-venue-lead"><?php echo esc_html($v['spaces_intro']); ?></p>
        <?php endif; ?>
        <?php if (!empty($v['spaces'])) : ?>
          <ul class="wvn-venue-spaces">
            <?php foreach ($v['spaces'] as $space) :
                $sname = is_array($space) ? ($space['name'] ?? '') : '';
                $smeta = is_array($space) ? ($space['meta'] ?? '') : '';
                $scap  = is_array($space) ? ($space['capacity'] ?? '') : '';
                if ($sname === '') {
                    continue;
                }
                ?>
              <li>
                <span class="wvn-venue-spaces__icon" aria-hidden="true"></span>
                <div class="wvn-venue-spaces__copy">
                  <strong><?php echo esc_html($sname); ?></strong>
                  <?php if ($smeta) : ?><em><?php echo esc_html($smeta); ?></em><?php endif; ?>
                </div>
                <?php if ($scap) : ?>
                  <span class="wvn-venue-spaces__cap"><?php echo esc_html($scap); ?></span>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </section>

      <section class="wvn-venue-card" id="rooms">
        <h2 class="wvn-venue-card__title"><?php echo esc_html($v['rooms_heading'] ?: 'Rooms'); ?></h2>
        <?php if (!empty($v['rooms_gallery'])) : ?>
          <div class="wvn-venue-rooms-grid">
            <?php foreach (array_slice($v['rooms_gallery'], 0, 4) as $rurl) : ?>
              <figure><img src="<?php echo esc_url($rurl); ?>" alt="" loading="lazy" decoding="async"></figure>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <?php if (!empty($v['rooms_text'])) : ?>
          <div class="wvn-venue-prose"><?php echo wp_kses_post(wpautop($v['rooms_text'])); ?></div>
        <?php endif; ?>
      </section>

      <?php if (!empty($v['inclusions'])) : ?>
        <section class="wvn-venue-card" id="inclusions">
          <h2 class="wvn-venue-card__title">Wedding Inclusions</h2>
          <ul class="wvn-venue-inclusions">
            <?php foreach ($v['inclusions'] as $inc) :
                $text = is_array($inc) ? ($inc['text'] ?? '') : (string) $inc;
                if ($text === '') {
                    continue;
                }
                ?>
              <li><span aria-hidden="true">✓</span><?php echo esc_html($text); ?></li>
            <?php endforeach; ?>
          </ul>
        </section>
      <?php endif; ?>

      <?php if (!empty($v['policies'])) : ?>
        <section class="wvn-venue-card" id="policies">
          <h2 class="wvn-venue-card__title">Policies</h2>
          <div class="wvn-venue-policies">
            <?php foreach ($v['policies'] as $pol) :
                $pt = is_array($pol) ? ($pol['title'] ?? '') : '';
                $px = is_array($pol) ? ($pol['text'] ?? '') : '';
                if ($pt === '' && $px === '') {
                    continue;
                }
                ?>
              <article>
                <span class="wvn-venue-policies__icon" aria-hidden="true"></span>
                <div>
                  <?php if ($pt) : ?><h3><?php echo esc_html($pt); ?></h3><?php endif; ?>
                  <?php if ($px) : ?><p><?php echo esc_html($px); ?></p><?php endif; ?>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        </section>
      <?php endif; ?>

      <section class="wvn-venue-card" id="about">
        <h2 class="wvn-venue-card__title">
          <?php
          $about_h = $v['about_heading'] ?: '';
          if ($about_h === '') {
              $about_h = 'About / A day at ' . $title;
          }
          echo esc_html($about_h);
          ?>
        </h2>
        <?php if (!empty($v['about'])) : ?>
          <div class="wvn-venue-prose"><?php echo wp_kses_post($v['about']); ?></div>
        <?php endif; ?>
      </section>

    </div>

    <aside class="wvn-venue-aside">
      <div class="wvn-venue-form" data-wvn-venue-form>
        <h2 class="wvn-venue-form__title"><?php echo esc_html($v['form_heading'] ?: 'Get the latest price'); ?></h2>
        <p class="wvn-venue-form__lead">Tell us a little about your celebration and we’ll share current availability and packages.</p>

        <?php if (!empty($v['form_shortcode'])) : ?>
          <div class="wvn-venue-form__cf7">
            <?php echo do_shortcode($v['form_shortcode']); ?>
          </div>
        <?php else : ?>
          <form class="wvn-venue-form__fields" action="<?php echo esc_url($contact); ?>" method="get">
            <input type="hidden" name="venue" value="<?php echo esc_attr($title); ?>">
            <label>
              <span>Full name</span>
              <input type="text" name="name" required autocomplete="name" placeholder="Your name">
            </label>
            <label>
              <span>Phone / WhatsApp</span>
              <input type="tel" name="phone" required autocomplete="tel" placeholder="+91">
            </label>
            <label>
              <span>Email</span>
              <input type="email" name="email" required autocomplete="email" placeholder="you@email.com">
            </label>
            <label>
              <span>Event date</span>
              <input type="date" name="event_date">
            </label>
            <label>
              <span>No. of guests</span>
              <input type="text" name="guests" placeholder="e.g. 250">
            </label>
            <label>
              <span>Any special requests</span>
              <textarea name="message" rows="3" placeholder="Ceremonies, stay, décor notes…"></textarea>
            </label>
            <button type="submit" class="wvn-venue-form__submit">Request Best Price</button>
          </form>
        <?php endif; ?>
      </div>
    </aside>
  </div>

</main>
    <?php
endwhile;

get_footer();

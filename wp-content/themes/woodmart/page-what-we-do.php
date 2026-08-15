<?php
/**
 * Template Name: What we do / Services
 */
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
    $sections = wvn_services_sections();
    ?>
<main id="content" class="wvn-svc-page">
  <?php foreach ($sections as $section) :
      $layout = $section['layout'] ?? '';
      if ($layout === 'hero') : ?>
    <section class="wvn-svc-hero" style="--svc-hero:url('<?php echo esc_url($section['image']); ?>')">
      <div class="wvn-svc-hero-copy">
        <?php if (!empty($section['crumb'])) : ?><p class="wvn-svc-crumb"><?php echo esc_html($section['crumb']); ?></p><?php endif; ?>
        <h1 class="wvn-display"><?php echo esc_html($section['heading'] ?: get_the_title()); ?></h1>
        <?php if (!empty($section['text'])) : ?><p><?php echo esc_html($section['text']); ?></p><?php endif; ?>
      </div>
    </section>
      <?php elseif ($layout === 'intro') : ?>
    <section class="wvn-svc-intro">
      <?php if (!empty($section['kicker'])) : ?><p class="wvn-kicker"><?php echo esc_html($section['kicker']); ?></p><?php endif; ?>
      <?php if (!empty($section['heading'])) : ?><h2 class="wvn-display"><?php echo esc_html($section['heading']); ?></h2><?php endif; ?>
      <div class="wvn-svc-intro-cols">
        <?php if (!empty($section['left'])) : ?><p><?php echo esc_html($section['left']); ?></p><?php endif; ?>
        <?php if (!empty($section['right'])) : ?><p><?php echo esc_html($section['right']); ?></p><?php endif; ?>
      </div>
      <?php if (!empty($section['stats'])) : ?>
        <div class="wvn-svc-stats">
          <?php foreach ($section['stats'] as $stat) : ?>
            <div>
              <strong><?php echo esc_html($stat['value']); ?></strong>
              <span><?php echo esc_html($stat['label']); ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
      <?php elseif ($layout === 'core') : ?>
    <section class="wvn-svc-core">
      <div class="wvn-svc-core-head">
        <?php if (!empty($section['kicker'])) : ?><p class="wvn-kicker"><?php echo esc_html($section['kicker']); ?></p><?php endif; ?>
        <?php if (!empty($section['heading'])) : ?><h2 class="wvn-display"><?php echo esc_html($section['heading']); ?></h2><?php endif; ?>
        <?php if (!empty($section['text'])) : ?><p><?php echo esc_html($section['text']); ?></p><?php endif; ?>
      </div>
      <?php if (!empty($section['cards'])) : ?>
        <div class="wvn-svc-bento" data-count="<?php echo (int) count($section['cards']); ?>">
          <?php foreach ($section['cards'] as $card) :
              $style = $card['style'] ?: 'photo';
              ?>
            <article class="wvn-svc-card is-<?php echo esc_attr($style); ?>">
              <?php if ($style === 'venue') : ?>
                <div class="wvn-svc-polaroids" aria-hidden="true">
                  <?php if (!empty($card['image_2'])) : ?><figure class="is-back"><img src="<?php echo esc_url($card['image_2']); ?>" alt=""></figure><?php endif; ?>
                  <?php if (!empty($card['image'])) : ?>
                    <figure class="is-front">
                      <img src="<?php echo esc_url($card['image']); ?>" alt="">
                      <?php if (!empty($card['caption'])) : ?><figcaption><?php echo esc_html($card['caption']); ?></figcaption><?php endif; ?>
                    </figure>
                  <?php endif; ?>
                </div>
              <?php elseif ($style === 'photo' && !empty($card['image'])) : ?>
                <img src="<?php echo esc_url($card['image']); ?>" alt="<?php echo esc_attr($card['title']); ?>">
              <?php endif; ?>
              <div class="wvn-svc-card-copy">
                <?php if (!empty($card['label'])) : ?><p class="wvn-svc-label"><?php echo esc_html($card['label']); ?></p><?php endif; ?>
                <?php if (!empty($card['title'])) : ?><h3 class="wvn-display"><?php echo esc_html($card['title']); ?></h3><?php endif; ?>
                <?php if (!empty($card['text'])) : ?><p><?php echo esc_html($card['text']); ?></p><?php endif; ?>
                <?php if ($style === 'tags' && !empty($card['tags'])) : ?>
                  <div class="wvn-svc-tags">
                    <?php foreach ($card['tags'] as $tag) : ?><span><?php echo esc_html($tag); ?></span><?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
      <?php elseif ($layout === 'specials') : ?>
    <section class="wvn-svc-specials">
      <?php if (!empty($section['cards'])) : ?>
        <div class="wvn-svc-mosaic" data-count="<?php echo (int) count($section['cards']); ?>">
          <?php foreach ($section['cards'] as $card) :
              $style = $card['style'] ?: 'photo';
              $tone = $card['tone'] ?: 'deep';
              ?>
            <article class="wvn-svc-tile is-<?php echo esc_attr($style); ?> is-<?php echo esc_attr($tone); ?>">
              <?php if ($style === 'photo' && !empty($card['image'])) : ?>
                <img src="<?php echo esc_url($card['image']); ?>" alt="<?php echo esc_attr($card['title']); ?>">
              <?php endif; ?>
              <?php if (!empty($card['number'])) : ?><span class="wvn-svc-num"><?php echo esc_html($card['number']); ?></span><?php endif; ?>
              <?php if ($style === 'star' || $style === 'intro' || $style === 'brand') : ?>
                <?php echo wvn_svc_star(); ?>
              <?php endif; ?>
              <?php if ($style !== 'star') : ?>
                <div class="wvn-svc-tile-copy">
                  <?php if (!empty($card['title'])) : ?><h3 class="wvn-display"><?php echo esc_html($card['title']); ?></h3><?php endif; ?>
                  <?php if (!empty($card['text'])) : ?><p><?php echo esc_html($card['text']); ?></p><?php endif; ?>
                  <?php if (!empty($card['link'])) : ?>
                    <a href="<?php echo esc_url($card['url'] ?: home_url('/contact-us/')); ?>"><?php echo esc_html($card['link']); ?> ↗</a>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <?php if ($style === 'intro' || $style === 'brand') : ?>
                <?php echo wvn_svc_star(); ?>
              <?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
      <?php elseif ($layout === 'glance') : ?>
    <section class="wvn-svc-glance">
      <?php if (!empty($section['kicker'])) : ?><p class="wvn-kicker"><?php echo esc_html($section['kicker']); ?></p><?php endif; ?>
      <?php if (!empty($section['heading'])) : ?><h2 class="wvn-display"><?php echo esc_html($section['heading']); ?></h2><?php endif; ?>
      <?php if (!empty($section['text'])) : ?><p class="wvn-svc-glance-lede"><?php echo esc_html($section['text']); ?></p><?php endif; ?>
      <?php if (!empty($section['columns'])) : ?>
        <div class="wvn-svc-glance-grid">
          <?php foreach ($section['columns'] as $column) : ?>
            <div>
              <?php if (!empty($column['heading'])) : ?><p class="wvn-svc-colhead"><?php echo esc_html($column['heading']); ?></p><?php endif; ?>
              <ol>
                <?php foreach ($column['items'] as $i => $item) : ?>
                  <li>
                    <strong><?php echo ($i + 1) . '. ' . esc_html($item['title']); ?></strong>
                    <?php if (!empty($item['text'])) : ?> — <?php echo esc_html($item['text']); ?><?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ol>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
      <?php elseif ($layout === 'why') : ?>
    <section class="wvn-svc-why" data-why>
      <?php if (!empty($section['kicker'])) : ?><p class="wvn-kicker"><?php echo esc_html($section['kicker']); ?></p><?php endif; ?>
      <?php if (!empty($section['heading'])) : ?><h2 class="wvn-display"><?php echo esc_html($section['heading']); ?></h2><?php endif; ?>
      <?php if (!empty($section['text'])) : ?><p class="wvn-svc-why-lede"><?php echo esc_html($section['text']); ?></p><?php endif; ?>
      <?php if (!empty($section['features'])) : ?>
        <div class="wvn-svc-why-grid">
          <?php foreach ($section['features'] as $feature) : ?>
            <article>
              <span class="wvn-svc-why-icon"><?php echo wvn_svc_icon($feature['icon']); ?></span>
              <h3><?php echo esc_html($feature['title']); ?></h3>
              <p><?php echo esc_html($feature['text']); ?></p>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($section['articles'])) : ?>
        <div class="wvn-svc-why-articles">
          <?php foreach ($section['articles'] as $index => $article) : ?>
            <article<?php echo $index > 1 ? ' class="is-more"' : ''; ?>>
              <h3 class="wvn-display"><?php echo esc_html($article['heading']); ?></h3>
              <p><?php echo esc_html($article['text']); ?></p>
            </article>
          <?php endforeach; ?>
        </div>
        <?php if (count($section['articles']) > 2 && !empty($section['button'])) : ?>
          <button class="wvn-svc-more" type="button" data-why-more><?php echo esc_html($section['button']); ?> <span>+</span></button>
        <?php endif; ?>
      <?php endif; ?>
    </section>
      <?php endif;
  endforeach; ?>
</main>
    <?php
endwhile;
get_footer();

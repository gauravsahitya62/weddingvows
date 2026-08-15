<?php
get_header();
while (have_posts()) :
    the_post();
    $id = get_the_ID();
    $image = get_the_post_thumbnail_url($id, 'full') ?: wvn_hero_image();
    $cat = wvn_post_category($id);
    $meta = wvn_post_meta($id);
    $blog_url = get_permalink((int) get_option('page_for_posts')) ?: home_url('/blog/');
    $mins = wvn_reading_time($id);
    $prev = get_previous_post();
    $next = get_next_post();
    $next_card = wvn_next_blog_post($id);
    ?>
<main id="content" class="wvn-article">
  <figure class="wvn-article-hero">
    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
    <?php if (!empty($meta['overlay']) || !empty($meta['sub'])) : ?>
      <figcaption>
        <?php if (!empty($meta['overlay'])) : ?><strong><?php echo esc_html($meta['overlay']); ?></strong><?php endif; ?>
        <?php if (!empty($meta['sub'])) : ?><span><?php echo esc_html($meta['sub']); ?></span><?php endif; ?>
        <em>Wedding Vows by Nikhil</em>
      </figcaption>
    <?php endif; ?>
  </figure>

  <div class="wvn-article-layout">
    <article class="wvn-article-main">
      <p class="wvn-article-crumb">
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <span>/</span>
        <a href="<?php echo esc_url($blog_url); ?>">Journal</a>
        <?php if ($cat) : ?>
          <span>/</span>
          <a href="<?php echo esc_url(get_category_link($cat)); ?>"><?php echo esc_html($cat->name); ?></a>
        <?php endif; ?>
      </p>
      <h1 class="wvn-display"><?php the_title(); ?></h1>
      <p class="wvn-article-meta">
        <strong>Wedding Vows by Nikhil</strong>
        <span>•</span>
        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('M j, Y')); ?></time>
        <span>•</span>
        <?php echo (int) $mins; ?> min read
      </p>

      <div class="wvn-article-body">
        <?php the_content(); ?>
      </div>

      <?php if (!empty($meta['gallery'])) : ?>
        <div class="wvn-article-gallery">
          <?php foreach ($meta['gallery'] as $url) : ?>
            <img src="<?php echo esc_url($url); ?>" alt="">
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($meta['faqs'])) : ?>
        <section class="wvn-article-faq">
          <h2 class="wvn-display"><?php echo esc_html($meta['faq_heading']); ?></h2>
          <div class="wvn-acc">
            <?php foreach ($meta['faqs'] as $i => $faq) : ?>
              <details<?php echo $i === 0 ? ' open' : ''; ?>>
                <summary><?php echo esc_html($faq['q']); ?></summary>
                <p><?php echo esc_html($faq['a']); ?></p>
              </details>
            <?php endforeach; ?>
          </div>
        </section>
      <?php endif; ?>

      <section class="wvn-article-cta">
        <h2 class="wvn-display"><?php echo esc_html($meta['cta_heading']); ?></h2>
        <p><?php echo esc_html($meta['cta_text']); ?></p>
        <a class="wvn-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>"><?php echo esc_html($meta['cta_button']); ?></a>
      </section>

      <?php if ($prev || $next) : ?>
        <nav class="wvn-article-pager">
          <?php if ($prev) : ?>
            <a href="<?php echo esc_url(get_permalink($prev)); ?>">&lt; <?php echo esc_html(get_the_title($prev)); ?></a>
          <?php else : ?><span></span><?php endif; ?>
          <?php if ($next) : ?>
            <a href="<?php echo esc_url(get_permalink($next)); ?>"><?php echo esc_html(get_the_title($next)); ?> &gt;</a>
          <?php endif; ?>
        </nav>
      <?php endif; ?>
    </article>

    <aside class="wvn-article-side">
      <div class="wvn-article-quote">
        <h3 class="wvn-display">Plan your wedding</h3>
        <p>Tell us about your day and get a personalised quote from our planning team.</p>
        <a class="wvn-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Get a quote</a>
      </div>
      <?php if ($next_card) :
          $next_cat = wvn_post_category($next_card->ID);
          $next_image = wvn_blog_image($next_card->ID, 'large');
          ?>
        <a class="wvn-article-next" href="<?php echo esc_url(get_permalink($next_card)); ?>">
          <p class="wvn-blog-cat">Next story</p>
          <figure>
            <img src="<?php echo esc_url($next_image); ?>" alt="<?php echo esc_attr(get_the_title($next_card)); ?>">
          </figure>
          <?php if ($next_cat) : ?>
            <p class="wvn-article-next-cat"><?php echo esc_html($next_cat->name); ?></p>
          <?php endif; ?>
          <strong><?php echo esc_html(get_the_title($next_card)); ?></strong>
          <em>Read the story →</em>
        </a>
      <?php endif; ?>
    </aside>
  </div>
</main>
    <?php
endwhile;
get_footer();

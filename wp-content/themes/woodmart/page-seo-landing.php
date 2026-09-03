<?php
/**
 * Template Name: SEO Landing Page
 * Template Post Type: page
 */
get_header();
while (have_posts()) :
    the_post();
    $slug = get_post_field('post_name', get_the_ID());
    $config = function_exists('wvn_seo_landing_config') ? wvn_seo_landing_config($slug) : array();
    $hero_image = !empty($config['image']) ? $config['image'] : wvn_hero_image();
    ?>
<main id="content" class="wvn-seo-landing">
  <section class="wvn-svc-hero" style="--svc-hero:url('<?php echo esc_url($hero_image); ?>')">
    <div class="wvn-svc-hero-copy">
      <p class="wvn-svc-crumb">Wedding Vows by Nikhil · Udaipur</p>
      <h1 class="wvn-display"><?php the_title(); ?></h1>
      <?php if (!empty($config['intro'])) : ?><p><?php echo esc_html($config['intro']); ?></p><?php endif; ?>
    </div>
  </section>

  <section class="wvn-svc-intro">
    <?php the_content(); ?>
  </section>

  <?php if (!empty($config['highlights'])) : ?>
  <section class="wvn-svc-core">
    <div class="wvn-svc-core-head">
      <p class="wvn-kicker">Why couples choose us</p>
      <h2 class="wvn-display">Planning that feels effortless</h2>
    </div>
    <div class="wvn-svc-bento" data-count="<?php echo count($config['highlights']); ?>">
      <?php foreach ($config['highlights'] as $highlight) : ?>
        <article class="wvn-svc-card is-intro">
          <div class="wvn-svc-card-copy">
            <p class="wvn-svc-label"><?php echo esc_html($highlight['label']); ?></p>
            <h3 class="wvn-display"><?php echo esc_html($highlight['title']); ?></h3>
            <p><?php echo esc_html($highlight['text']); ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <?php if (!empty($config['faqs'])) : ?>
  <section class="wvn-faq">
    <p class="wvn-kicker wvn-center">FAQs</p>
    <h2 class="wvn-display wvn-center">Questions, answered</h2>
    <div class="wvn-acc">
      <?php foreach ($config['faqs'] as $faq) : ?>
        <details>
          <summary><?php echo esc_html($faq['q']); ?></summary>
          <p><?php echo esc_html($faq['a']); ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <section class="wvn-cta">
    <div class="wvn-cta-box">
      <h2 class="wvn-display">Planning a wedding in Udaipur?</h2>
      <p class="wvn-lede">Tell us your date, guest count and the kind of celebration you want. We will help you understand the right venue, timeline and next steps.</p>
      <a class="wvn-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Book a Consultation ↗</a>
    </div>
  </section>
</main>
    <?php
endwhile;
get_footer();

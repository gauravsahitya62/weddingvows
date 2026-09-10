<?php
/**
 * Template Name: Wedding Vows Commercial SEO Page
 * Template Post Type: page
 */
get_header();
while (have_posts()) :
    the_post();
    $slug = get_post_field('post_name', get_the_ID());
    $pages = function_exists('wvn_commercial_seo_pages') ? wvn_commercial_seo_pages() : array();
    $config = isset($pages[$slug]) ? $pages[$slug] : array();
    $hero_image = function_exists('wvn_hero_image') ? wvn_hero_image() : '';
    if (!empty($config['image'])) {
        $hero_image = $config['image'];
    }
?>
<main id="content" class="wvn-seo-landing wvn-commercial-landing">
  <section class="wvn-svc-hero" style="--svc-hero:url('<?php echo esc_url($hero_image); ?>')">
    <div class="wvn-svc-hero-copy">
      <p class="wvn-svc-crumb"><?php echo esc_html($config['eyebrow'] ?? 'Wedding Vows by Nikhil · Udaipur'); ?></p>
      <h1 class="wvn-display"><?php the_title(); ?></h1>
      <?php if (!empty($config['intro'])) : ?>
        <p><?php echo esc_html($config['intro']); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <section class="wvn-svc-intro">
    <?php the_content(); ?>
  </section>

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
      <p class="wvn-lede">Tell us your date, guest count and the kind of celebration you want. We will help you shortlist the right venue, shape the budget and plan the guest journey.</p>
      <a class="wvn-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Book a Consultation ↗</a>
    </div>
  </section>
</main>
<?php
endwhile;
get_footer();

<?php
/**
 * Editorial testimonials page.
 *
 * Uses the same ACF home_quotes data as the homepage testimonial book.
 */
get_header();

$quotes = array_values(array_filter(wvn_testimonials(), function ($q) {
    return !empty($q['text']) && !empty($q['name']);
}));
?>
<main id="content" class="wvn-testimonials-page">
  <section class="wvn-testimonials-hero">
    <p class="wvn-kicker">In Their Words</p>
    <h1 class="wvn-display">Stories worth <em>remembering.</em></h1>
    <p class="wvn-lede">The celebrations, details and quiet moments our couples chose to share.</p>
  </section>

  <section class="wvn-testimonials-list" aria-label="Testimonials">
    <?php if ($quotes) : ?>
      <?php foreach ($quotes as $index => $q) :
          $image = !empty($q['image']) ? $q['image'] : wvn_hero_image();
          $meta = trim((string) ($q['time'] ?? ''));
          $side = $index % 2 === 0 ? 'image-left' : 'image-right';
          ?>
        <article class="wvn-testimonial-detail <?php echo esc_attr($side); ?>">
          <div class="wvn-testimonial-detail__image">
            <img
              src="<?php echo esc_url($image); ?>"
              alt="<?php echo esc_attr($q['name'] . ' testimonial for Wedding Vows by Nikhil'); ?>"
              loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"
              decoding="async"
            >
          </div>
          <div class="wvn-testimonial-detail__content">
            <p class="wvn-testimonial-detail__eyebrow"><?php echo esc_html($meta !== '' ? $meta : 'A couple story'); ?></p>
            <h2><?php echo esc_html($q['name']); ?></h2>
            <blockquote>“<?php echo esc_html(trim($q['text'])); ?>”</blockquote>
            <div class="wvn-testimonial-detail__rule" aria-hidden="true"></div>
            <p class="wvn-testimonial-detail__signature">Wedding Vows by Nikhil</p>
          </div>
        </article>
      <?php endforeach; ?>
    <?php else : ?>
      <div class="wvn-testimonial-empty">
        <h2>Testimonials are being prepared.</h2>
        <p>Add reviews under the Testimonials tab on the Home page in WordPress.</p>
      </div>
    <?php endif; ?>
  </section>
</main>
<?php get_footer(); ?>

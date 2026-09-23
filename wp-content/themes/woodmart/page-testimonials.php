<?php
/**
 * Editorial testimonial detail page.
 *
 * Uses the existing ACF home_quotes data and supports both:
 * - /testimonials/{stable-slug}/
 * - legacy /testimonials/?testimonial={index}
 */
get_header();

$current = function_exists('wvn_testimonial_current') ? wvn_testimonial_current() : null;
$quotes  = array_values(array_filter(wvn_testimonials(), function ($q) {
    return !empty($q['text']) && !empty($q['name']);
}));

if ($current) {
    $q = $current['quote'];
    $index = (int) $current['index'];
} else {
    $q = null;
    $index = -1;
}
?>

<?php if ($q) :
    $gallery = function_exists('wvn_gallery_images') ? array_values(array_filter(wvn_gallery_images())) : array();
    $image = !empty($q['image']) ? $q['image'] : ($gallery[$index % max(1, count($gallery))] ?? wvn_hero_image());
    $meta = trim((string) ($q['time'] ?? ''));
    $tags = !empty($q['tags']) && is_array($q['tags']) ? array_values(array_filter(array_map('trim', $q['tags']))) : array();
    $text = trim(wp_strip_all_tags((string) ($q['text'] ?? '')));
    $video = !empty($q['video']) ? $q['video'] : '';

    $sentences = preg_split('/(?<=[.!?])\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
    if (!is_array($sentences)) {
        $sentences = array($text);
    }

    $chunks = array();
    if (count($sentences) <= 2) {
        $chunks[] = trim($text);
    } else {
        $target = max(1, (int) ceil(count($sentences) / 3));
        $first = trim(implode(' ', array_slice($sentences, 0, $target)));
        $second = trim(implode(' ', array_slice($sentences, $target, $target)));
        $third = trim(implode(' ', array_slice($sentences, $target * 2)));
        foreach (array($first, $second, $third) as $chunk) {
            if ($chunk !== '') {
                $chunks[] = $chunk;
            }
        }
    }

    if (!$chunks) {
        $chunks[] = $text;
    }

    $story_images = array();
    $story_images[] = $image;
    if ($video !== '') {
        $story_images[] = $image;
    }
    foreach ($gallery as $gallery_image) {
        if (count($story_images) >= count($chunks)) {
            break;
        }
        if ($gallery_image !== $image) {
            $story_images[] = $gallery_image;
        }
    }
    while (count($story_images) < count($chunks)) {
        $story_images[] = $image;
    }

    $story_labels = array('Their story', 'The feeling', 'The details', 'A lasting memory');
    $date_or_meta = $meta !== '' ? $meta : (!empty($tags) ? implode(' · ', array_slice($tags, 0, 2)) : 'A couple story');
    $back_url = home_url('/testimonials/');
    $detail_url = function_exists('wvn_testimonial_detail_url') ? wvn_testimonial_detail_url($q, $index) : home_url('/testimonials/');
    ?>
<main id="content" class="wvn-testimonial-story-page">
  <header class="wvn-testimonial-story-hero">
    <div class="wvn-testimonial-story-hero__media">
      <img
        src="<?php echo esc_url($image); ?>"
        alt="<?php echo esc_attr($q['name'] . ' — Wedding Vows by Nikhil'); ?>"
        loading="eager"
        fetchpriority="high"
        decoding="async"
      >
    </div>
    <div class="wvn-testimonial-story-hero__shade" aria-hidden="true"></div>
    <div class="wvn-testimonial-story-hero__inner">
      <a class="wvn-testimonial-story__back" href="<?php echo esc_url($back_url); ?>">← Back to Testimonials</a>
      <p class="wvn-testimonial-story-hero__eyebrow">Real Wedding · In Their Words</p>
      <h1 class="wvn-testimonial-story-hero__title"><?php echo esc_html($q['name']); ?></h1>
      <p class="wvn-testimonial-story-hero__meta"><?php echo esc_html($date_or_meta); ?></p>
      <p class="wvn-testimonial-story-hero__lede"><?php echo esc_html(wvn_testimonial_excerpt_plain($text, 155)); ?></p>
    </div>
  </header>

  <section class="wvn-testimonial-story-intro">
    <div class="wvn-testimonial-story-intro__inner">
      <p class="wvn-kicker">Their story</p>
      <h2 class="wvn-display">A celebration remembered <em>in their own words.</em></h2>
      <?php if (!empty($tags)) : ?>
        <div class="wvn-testimonial-story-tags" aria-label="Testimonial highlights">
          <?php foreach ($tags as $tag) : ?>
            <span><?php echo esc_html($tag); ?></span>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <section class="wvn-testimonial-story-sections" aria-label="Wedding story">
    <?php foreach ($chunks as $story_index => $chunk) :
        $reverse = $story_index % 2 === 1;
        $story_image = $story_images[$story_index] ?? $image;
        $has_video = $video !== '' && $story_index === 1;
        ?>
      <article class="wvn-testimonial-story-section<?php echo $reverse ? ' is-reversed' : ''; ?>">
        <div class="wvn-testimonial-story-section__media">
          <?php if ($has_video) : ?>
            <video
              src="<?php echo esc_url($video); ?>"
              poster="<?php echo esc_url($image); ?>"
              playsinline
              muted
              controls
              preload="metadata"
              aria-label="<?php echo esc_attr($q['name'] . ' wedding testimonial film'); ?>"
            ></video>
          <?php else : ?>
            <img
              src="<?php echo esc_url($story_image); ?>"
              alt="<?php echo esc_attr($q['name'] . ' wedding story — ' . ($story_labels[$story_index] ?? 'Their story')); ?>"
              loading="lazy"
              decoding="async"
            >
          <?php endif; ?>
        </div>
        <div class="wvn-testimonial-story-section__content">
          <p class="wvn-testimonial-story-section__eyebrow"><?php echo esc_html($story_labels[$story_index] ?? 'Their story'); ?></p>
          <h2><?php echo esc_html($story_index === 0 ? $q['name'] : ($tags[$story_index - 1] ?? 'A moment worth remembering')); ?></h2>
          <blockquote>“<?php echo esc_html($chunk); ?>”</blockquote>
          <div class="wvn-testimonial-story-section__rule" aria-hidden="true"></div>
          <p class="wvn-testimonial-story-section__meta"><?php echo esc_html($date_or_meta); ?></p>
        </div>
      </article>
    <?php endforeach; ?>
  </section>

  <section class="wvn-testimonial-story-close">
    <div class="wvn-testimonial-story-close__inner">
      <p class="wvn-kicker">Keep exploring</p>
      <h2 class="wvn-display">More stories from <em>our couples.</em></h2>
      <p>Return to the testimonial collection and discover more celebrations, details and moments shared in their own words.</p>
      <a class="wvn-testimonial-story-close__cta" href="<?php echo esc_url($back_url); ?>">← Back to Testimonials</a>
    </div>
  </section>
</main>
<?php else : ?>
<main id="content" class="wvn-testimonials-page">
  <section class="wvn-testimonials-hero">
    <p class="wvn-kicker">In Their Words</p>
    <h1 class="wvn-display">Stories worth <em>remembering.</em></h1>
    <p class="wvn-lede">The celebrations, details and quiet moments our couples chose to share.</p>
  </section>

  <section class="wvn-testimonials-list" aria-label="Testimonials">
    <?php if ($quotes) : ?>
      <?php foreach ($quotes as $index => $quote) :
          $quote_image = !empty($quote['image']) ? $quote['image'] : (function_exists('wvn_gallery_images') ? (wvn_gallery_images()[$index % max(1, count(wvn_gallery_images()))] ?? wvn_hero_image()) : wvn_hero_image());
          $quote_url = function_exists('wvn_testimonial_detail_url') ? wvn_testimonial_detail_url($quote, $index) : add_query_arg('testimonial', $index, home_url('/testimonials/'));
          ?>
        <article class="wvn-testimonial-detail">
          <a class="wvn-testimonial-detail__image" href="<?php echo esc_url($quote_url); ?>" aria-label="<?php echo esc_attr('Read ' . $quote['name'] . ' testimonial'); ?>">
            <img src="<?php echo esc_url($quote_image); ?>" alt="<?php echo esc_attr($quote['name'] . ' testimonial for Wedding Vows by Nikhil'); ?>" loading="lazy" decoding="async">
          </a>
          <div class="wvn-testimonial-detail__content">
            <p class="wvn-testimonial-detail__eyebrow"><?php echo esc_html(trim((string) ($quote['time'] ?? '')) ?: 'A couple story'); ?></p>
            <h2><?php echo esc_html($quote['name']); ?></h2>
            <blockquote>“<?php echo esc_html(wvn_testimonial_excerpt_plain($quote['text'] ?? '', 260)); ?>”</blockquote>
            <a class="wvn-testimonial-detail__cta" href="<?php echo esc_url($quote_url); ?>">Read their story <span aria-hidden="true">→</span></a>
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
<?php endif; ?>
<?php get_footer(); ?>

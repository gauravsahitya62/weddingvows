<?php
/* Template Name: Cinematic Test */
get_header();
$hero = function_exists('wvn_hero_image') ? wvn_hero_image() : '';
$gallery = function_exists('wvn_gallery_images') ? wvn_gallery_images() : array();
$founder = function_exists('wvn_founder_image') ? wvn_founder_image() : '';
$stories = function_exists('wvn_stories') ? wvn_stories() : array();
$services = function_exists('wvn_services') ? wvn_services() : array();
$weddings = function_exists('wvn_weddings') ? wvn_weddings() : array();
$images = array_values(array_filter(array_merge(array($hero), $gallery)));
$story_image = !empty($stories[0]['image']) ? $stories[0]['image'] : ($images[1] ?? $hero);
$service_image = !empty($services[0]['image']) ? $services[0]['image'] : ($images[2] ?? $hero);
$wedding_image = !empty($weddings[0]['image']) ? $weddings[0]['image'] : ($images[3] ?? $hero);
?>
<main class="wvn-cinematic-test" aria-label="Wedding Vows cinematic test experience">
  <section class="wvn-cine-hero" data-cine-parallax>
    <div class="wvn-cine-hero-media" style="background-image:url('<?php echo esc_url($hero); ?>')" aria-hidden="true"></div>
    <div class="wvn-cine-vignette" aria-hidden="true"></div>
    <div class="wvn-cine-hero-copy wvn-cine-reveal">
      <p class="wvn-cine-eyebrow">Wedding Vows by Nikhil · Udaipur</p>
      <h1>Weddings,<br><em>beautifully felt.</em></h1>
      <p class="wvn-cine-lede">A cinematic direction for destination weddings — intimate, editorial and built around the moments that stay with you.</p>
      <a class="wvn-cine-cta" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Begin your story <span>↗</span></a>
    </div>
    <div class="wvn-cine-scroll" aria-hidden="true"><span>Scroll</span><i></i></div>
  </section>

  <section class="wvn-cine-intro wvn-cine-section">
    <div class="wvn-cine-intro-word wvn-cine-reveal">The art<br>of <em>arrival.</em></div>
    <div class="wvn-cine-intro-copy wvn-cine-reveal">
      <p class="wvn-cine-eyebrow">A different pace</p>
      <h2>Let the place<br>set the mood.</h2>
      <p>From the first welcome to the final farewell, every transition should feel intentional. This concept uses space, scale and motion to let your photography lead the story.</p>
    </div>
  </section>

  <section class="wvn-cine-image-split wvn-cine-section">
    <figure class="wvn-cine-image wvn-cine-reveal"><img src="<?php echo esc_url($story_image); ?>" alt="Wedding celebration captured by Wedding Vows by Nikhil" loading="lazy"></figure>
    <div class="wvn-cine-image-caption wvn-cine-reveal"><span>01</span><p>The quiet moments between the celebrations deserve their own frame.</p></div>
  </section>

  <section class="wvn-cine-quote wvn-cine-section wvn-cine-reveal">
    <p class="wvn-cine-eyebrow">Editorial rhythm</p>
    <blockquote>“Nothing should compete with the photographs.<br>The design should make you look longer.”</blockquote>
  </section>

  <section class="wvn-cine-full-image wvn-cine-section" data-cine-parallax>
    <img src="<?php echo esc_url($service_image); ?>" alt="Luxury wedding scene in Udaipur captured for Wedding Vows by Nikhil" loading="lazy">
    <div class="wvn-cine-full-image-copy wvn-cine-reveal"><span>02</span><h2>Space for<br><em>emotion.</em></h2></div>
  </section>

  <section class="wvn-cine-story wvn-cine-section">
    <div class="wvn-cine-story-copy wvn-cine-reveal">
      <p class="wvn-cine-eyebrow">A wedding in chapters</p>
      <h2>Designed to unfold,<br>not just scroll.</h2>
      <p>Asymmetric compositions, oversized type and slow reveals create a sense of movement without turning the experience into a spectacle. The photography remains the hero.</p>
    </div>
    <figure class="wvn-cine-story-image wvn-cine-reveal"><img src="<?php echo esc_url($wedding_image); ?>" alt="Destination wedding in Udaipur from the Wedding Vows by Nikhil portfolio" loading="lazy"></figure>
  </section>

  <section class="wvn-cine-mosaic wvn-cine-section">
    <?php foreach (array_slice($images, 0, 4) as $index => $image) : ?>
      <figure class="wvn-cine-mosaic-item wvn-cine-reveal mosaic-<?php echo (int) $index; ?>"><img src="<?php echo esc_url($image); ?>" alt="Wedding Vows by Nikhil portfolio photograph <?php echo (int) ($index + 1); ?>" loading="lazy"></figure>
    <?php endforeach; ?>
  </section>

  <section class="wvn-cine-close wvn-cine-section wvn-cine-reveal">
    <div>
      <p class="wvn-cine-eyebrow">Wedding Vows by Nikhil</p>
      <h2>Make your wedding<br><em>feel like yours.</em></h2>
      <a class="wvn-cine-cta" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Book a consultation <span>↗</span></a>
    </div>
  </section>
</main>
<?php get_footer(); ?>

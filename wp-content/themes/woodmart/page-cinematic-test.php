<?php
/* Template Name: Cinematic Test */
get_header();
$hero = function_exists('wvn_hero_image') ? wvn_hero_image() : '';
$gallery = function_exists('wvn_gallery_images') ? wvn_gallery_images() : array();
$stories = function_exists('wvn_stories') ? wvn_stories() : array();
$services = function_exists('wvn_services') ? wvn_services() : array();
$weddings = function_exists('wvn_weddings') ? wvn_weddings() : array();
$images = array_values(array_filter(array_merge(array($hero), $gallery)));
$story_image = !empty($stories[0]['image']) ? $stories[0]['image'] : ($images[1] ?? $hero);
$service_image = !empty($services[0]['image']) ? $services[0]['image'] : ($images[2] ?? $hero);
$wedding_image = !empty($weddings[0]['image']) ? $weddings[0]['image'] : ($images[3] ?? $hero);
$rail_images = array_slice($images, 0, 6);
?>
<main class="wvn-cinematic-test" aria-label="Wedding Vows cinematic test experience">
  <section class="wvn-cine-hero" data-cine-parallax>
    <div class="wvn-cine-hero-media" style="background-image:url('<?php echo esc_url($hero); ?>')" aria-hidden="true"></div>
    <div class="wvn-cine-vignette" aria-hidden="true"></div>
    <div class="wvn-cine-hero-copy wvn-cine-reveal">
      <p class="wvn-cine-eyebrow">Wedding Vows by Nikhil · Udaipur</p>
      <h1>Weddings,<br><em>beautifully felt.</em></h1>
      <p class="wvn-cine-lede">A cinematic direction for destination weddings — immersive, editorial and built around the moments that deserve to linger.</p>
      <a class="wvn-cine-cta" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Begin your story <span>↗</span></a>
    </div>
    <div class="wvn-cine-scroll" aria-hidden="true"><span>Scroll</span><i></i></div>
  </section>

  <section class="wvn-cine-manifesto wvn-cine-section">
    <div class="wvn-cine-manifesto-inner">
      <p class="wvn-cine-eyebrow wvn-cine-reveal">The cinematic direction</p>
      <h2 class="wvn-cine-manifesto-heading wvn-cine-reveal">A wedding website should feel like a <em>film.</em></h2>
      <p class="wvn-cine-manifesto-copy wvn-cine-reveal">Not a catalogue of sections. A sequence of moments, images and pauses that lets the story unfold at its own pace.</p>
    </div>
  </section>

  <section class="wvn-cine-chapter" data-cine-pin>
    <div class="wvn-cine-pin-stage">
      <img class="wvn-cine-pin-media" src="<?php echo esc_url($story_image); ?>" alt="Wedding celebration captured by Wedding Vows by Nikhil" loading="lazy">
      <div class="wvn-cine-pin-shade"></div>
      <div class="wvn-cine-pin-heading">
        <span>01</span>
        <h2>The arrival.</h2>
      </div>
      <div class="wvn-cine-pin-copy">
        <p class="wvn-cine-eyebrow">A sense of place</p>
        <p>The first frame should establish atmosphere before it asks the visitor to read anything.</p>
      </div>
    </div>
  </section>

  <section class="wvn-cine-image-split wvn-cine-section">
    <figure class="wvn-cine-image wvn-cine-reveal"><img src="<?php echo esc_url($service_image); ?>" alt="Luxury wedding scene in Udaipur captured for Wedding Vows by Nikhil" loading="lazy"></figure>
    <div class="wvn-cine-image-caption wvn-cine-reveal"><span>02</span><p>Then give the image room. Let the page slow down.</p></div>
  </section>

  <section class="wvn-cine-quote wvn-cine-section wvn-cine-reveal">
    <p class="wvn-cine-eyebrow">Editorial rhythm</p>
    <blockquote>“The movement should make you<br>look <em>longer.</em>”</blockquote>
  </section>

  <section class="wvn-cine-chapter is-dark" data-cine-pin>
    <div class="wvn-cine-pin-stage">
      <img class="wvn-cine-pin-media" src="<?php echo esc_url($wedding_image); ?>" alt="Destination wedding in Udaipur from the Wedding Vows by Nikhil portfolio" loading="lazy">
      <div class="wvn-cine-pin-shade"></div>
      <div class="wvn-cine-pin-heading">
        <span>03</span>
        <h2>The celebration.</h2>
      </div>
      <div class="wvn-cine-pin-copy">
        <p class="wvn-cine-eyebrow">The frame changes</p>
        <p>Typography, image scale and layered transitions create the feeling of moving through a wedding story rather than browsing a page.</p>
      </div>
    </div>
  </section>

  <section class="wvn-cine-rail" data-cine-rail aria-label="Wedding image sequence">
    <div class="wvn-cine-rail-intro wvn-cine-reveal">
      <p class="wvn-cine-eyebrow">Frames from the story</p>
      <h2>Moments that <em>move.</em></h2>
    </div>
    <div class="wvn-cine-rail-window">
      <div class="wvn-cine-rail-track">
        <?php foreach ($rail_images as $index => $image) : ?>
          <figure class="wvn-cine-rail-card">
            <img src="<?php echo esc_url($image); ?>" alt="Wedding Vows by Nikhil portfolio photograph <?php echo esc_attr((string) ($index + 1)); ?>" loading="lazy">
            <figcaption>0<?php echo esc_html((string) ($index + 1)); ?></figcaption>
          </figure>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="wvn-cine-story wvn-cine-section">
    <div class="wvn-cine-story-copy wvn-cine-reveal">
      <p class="wvn-cine-eyebrow">A wedding in chapters</p>
      <h2>Designed to unfold,<br>not just <em>scroll.</em></h2>
      <p>Asymmetric compositions, oversized type, image crops and scroll-linked movement create a sense of progression while keeping the photography at the center.</p>
    </div>
    <figure class="wvn-cine-story-image wvn-cine-reveal"><img src="<?php echo esc_url($story_image); ?>" alt="Destination wedding planning and celebration in Udaipur" loading="lazy"></figure>
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

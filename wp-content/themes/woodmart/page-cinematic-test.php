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
  <div class="wvn-cine-preloader" data-cine-preloader aria-hidden="true">
    <div class="wvn-cine-preloader-word">WEDDING VOWS</div>
    <div class="wvn-cine-preloader-meta">by Nikhil · Udaipur</div>
    <div class="wvn-cine-preloader-count"><span data-cine-counter>0</span><i></i></div>
  </div>
  <div class="wvn-cine-progress" data-cine-progress></div>
  <div class="wvn-cine-grain" aria-hidden="true"></div>
  <div class="wvn-cine-vignette-global" aria-hidden="true"></div>

  <section class="wvn-cine-hero" id="home" data-cine-hero>
    <div class="wvn-cine-hero-runway">
      <div class="wvn-cine-hero-stage">
        <div class="wvn-cine-hero-media" style="background-image:url('<?php echo esc_url($hero); ?>')" aria-hidden="true"></div>
        <div class="wvn-cine-hero-leak" aria-hidden="true"></div>
        <div class="wvn-cine-hero-vignette" aria-hidden="true"></div>
        <div class="wvn-cine-hero-copy">
          <p class="wvn-cine-eyebrow">Wedding Vows · Udaipur</p>
          <h1>YOUR LOVE.<br><span>YOUR VOWS.</span><br>YOUR WEDDING.</h1>
          <p class="wvn-cine-hero-sub">Destination weddings directed with the pace, atmosphere and intimacy of a film.</p>
          <div class="wvn-cine-hero-actions">
            <a class="wvn-cine-button" data-testid="cine-hero-plan" href="#contact">Plan your celebration <span>↗</span></a>
            <a class="wvn-cine-text-link" data-testid="cine-hero-weddings" href="#weddings">Explore the weddings</a>
          </div>
        </div>
        <div class="wvn-cine-scroll-hint" aria-hidden="true"><span>Scroll to enter</span><i></i></div>
      </div>
    </div>
  </section>

  <section class="wvn-cine-marquee" aria-label="Wedding Vows services">
    <div class="wvn-cine-marquee-track">
      <span>DESTINATION WEDDINGS ✦</span><span>ROYAL PALACES ✦</span><span>BESPOKE DÉCOR ✦</span><span>CURATED GASTRONOMY ✦</span><span>GUEST HOSPITALITY ✦</span><span>UDAIPUR · RAJASTHAN ✦</span>
      <span aria-hidden="true">DESTINATION WEDDINGS ✦</span><span aria-hidden="true">ROYAL PALACES ✦</span><span aria-hidden="true">BESPOKE DÉCOR ✦</span><span aria-hidden="true">CURATED GASTRONOMY ✦</span><span aria-hidden="true">GUEST HOSPITALITY ✦</span><span aria-hidden="true">UDAIPUR · RAJASTHAN ✦</span>
    </div>
  </section>

  <section class="wvn-cine-curtain" id="about" data-cine-curtain>
    <div class="wvn-cine-curtain-image"><img src="<?php echo esc_url($story_image); ?>" alt="Wedding Vows by Nikhil celebration" loading="lazy"></div>
    <div class="wvn-cine-curtain-panel curtain-left"></div><div class="wvn-cine-curtain-panel curtain-right"></div>
    <div class="wvn-cine-curtain-copy"><span>THE OPENING</span><h2>EVERY VOW, A<br><em>MASTERPIECE.</em></h2></div>
  </section>

  <section class="wvn-cine-about wvn-cine-section">
    <div class="wvn-cine-about-media"><figure class="wvn-cine-clip-image"><img src="<?php echo esc_url($service_image); ?>" alt="Luxury destination wedding in Udaipur" loading="lazy"></figure><figure class="wvn-cine-float-image"><img src="<?php echo esc_url($wedding_image); ?>" alt="Wedding Vows destination wedding portfolio" loading="lazy"></figure><div class="wvn-cine-badge">Since 2013<br><small>UDAIPUR · RAJASTHAN</small></div></div>
    <div class="wvn-cine-about-copy">
      <p class="wvn-cine-eyebrow">ABOUT WEDDING VOWS</p>
      <h2>Bespoke destination weddings in the <em>city of lakes.</em></h2>
      <p>Every celebration begins with a place, a feeling and the people at its centre. This prototype turns that philosophy into an editorial visual language built around existing Wedding Vows imagery.</p>
      <div class="wvn-cine-stats"><div><strong>150+</strong><span>Celebrations</span></div><div><strong>40+</strong><span>Destinations</span></div><div><strong>12</strong><span>Years</span></div></div>
      <a class="wvn-cine-line-link" data-testid="cine-about-planner" href="#planner">Meet Nikhil <span>↗</span></a>
    </div>
  </section>

  <section class="wvn-cine-weddings wvn-cine-section" id="weddings">
    <div class="wvn-cine-section-head"><div><p class="wvn-cine-eyebrow">THE WEDDINGS</p><h2>Before we tell you our story,<br><em>let the weddings speak.</em></h2></div><p>Existing portfolio imagery becomes the visual spine of the experience, arranged as a moving editorial rather than a static gallery.</p></div>
    <div class="wvn-cine-bento">
      <?php foreach (array_slice($images, 0, 7) as $index => $image) : ?><figure class="wvn-cine-bento-card bento-<?php echo (int)$index; ?>"><img src="<?php echo esc_url($image); ?>" alt="Wedding Vows portfolio photograph <?php echo (int)($index + 1); ?>" loading="lazy"><figcaption>0<?php echo (int)($index + 1); ?></figcaption></figure><?php endforeach; ?>
    </div>
  </section>

  <section class="wvn-cine-title-card" id="planner">
    <div class="wvn-cine-title-video" aria-hidden="true"><img src="<?php echo esc_url($hero); ?>" alt="" loading="lazy"></div><div class="wvn-cine-letterbox letterbox-top"></div><div class="wvn-cine-letterbox letterbox-bottom"></div>
    <div class="wvn-cine-title-copy"><span>A FILM BY</span><strong>WEDDING VOWS</strong><em>every frame, engineered for emotion.</em></div>
  </section>

  <section class="wvn-cine-planner wvn-cine-section">
    <div class="wvn-cine-planner-copy"><p class="wvn-cine-outline-word">NIKHIL</p><div class="wvn-cine-planner-text"><p class="wvn-cine-eyebrow">MEET THE PLANNER</p><h2>Nikhil — the storyteller behind your celebration.</h2><p>Planning here is presented as direction: structure, hospitality, design and human moments moving together as one story.</p><blockquote>“The celebration should feel effortless in the room, even when every frame was engineered with intention.”</blockquote><div class="wvn-cine-highlights"><span>Wine-led visual direction</span><span>Editorial storytelling</span><span>Guest-first planning</span></div><a class="wvn-cine-button" data-testid="cine-planner-contact" href="#contact">Plan with Nikhil <span>↗</span></a></div></div>
    <div class="wvn-cine-planner-image"><img src="<?php echo esc_url($story_image); ?>" alt="Nikhil and Wedding Vows celebration imagery" loading="lazy"></div>
  </section>

  <section class="wvn-cine-rituals" id="rituals" data-cine-horizontal>
    <div class="wvn-cine-ritual-pin"><div class="wvn-cine-ritual-heading"><p class="wvn-cine-eyebrow">THE RITUALS</p><h2>Six frames.<br><em>One celebration.</em></h2></div><div class="wvn-cine-ritual-track">
      <?php $rituals = array('Baraat','Varmala','Phere','Sangeet','Reception','Vidai'); foreach ($rituals as $index => $ritual) : $img = $rail_images[$index] ?? $hero; ?><article class="wvn-cine-ritual-card"><div class="wvn-cine-ritual-image"><img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($ritual); ?> wedding moment" loading="lazy"></div><span>0<?php echo $index + 1; ?></span><h3><?php echo esc_html($ritual); ?></h3><p>A cinematic chapter in the rhythm of the celebration.</p></article><?php endforeach; ?>
    </div></div>
  </section>

  <section class="wvn-cine-showreel wvn-cine-section" id="stories">
    <div class="wvn-cine-showreel-head"><p class="wvn-cine-eyebrow">THE SHOWREEL</p><h2>Every wedding,<br><em>a motion picture.</em></h2></div>
    <div class="wvn-cine-showreel-frame"><img src="<?php echo esc_url($wedding_image); ?>" alt="Wedding Vows showreel placeholder" loading="lazy"><div class="wvn-cine-showreel-overlay"><button type="button" data-testid="cine-showreel-toggle" class="wvn-cine-control">Play</button><button type="button" data-testid="cine-showreel-mute" class="wvn-cine-control">Mute</button></div></div>
  </section>

  <section class="wvn-cine-statement wvn-cine-section"><p class="wvn-cine-watermark">STORY</p><div class="wvn-cine-statement-copy"><p class="wvn-cine-eyebrow">THE APPROACH</p><p class="cine-word-line">We turn <span>place</span>, <span>ritual</span>, <span>design</span> and <span>emotion</span> into a visual language that feels personal to every celebration.</p><i></i></div></section>

  <section class="wvn-cine-featured wvn-cine-section">
    <div class="wvn-cine-featured-copy"><p class="wvn-cine-eyebrow">FEATURED STORY</p><h2><?php echo esc_html(!empty($weddings[0]['title']) ? $weddings[0]['title'] : 'A Wedding Vows celebration'); ?></h2><p><?php echo esc_html(!empty($weddings[0]['description']) ? wp_strip_all_tags($weddings[0]['description']) : 'An existing Wedding Vows portfolio story presented in a cinematic editorial chapter.'); ?></p><a class="wvn-cine-line-link" data-testid="cine-featured-story" href="<?php echo esc_url(!empty($weddings[0]['url']) ? $weddings[0]['url'] : '#weddings'); ?>">Enter the story <span>↗</span></a></div><figure><img src="<?php echo esc_url($wedding_image); ?>" alt="Featured Wedding Vows story" loading="lazy"></figure></section>

  <section class="wvn-cine-curtain wvn-cine-curtain-2" data-cine-curtain><div class="wvn-cine-curtain-image"><img src="<?php echo esc_url($service_image); ?>" alt="Wedding celebration atmosphere" loading="lazy"></div><div class="wvn-cine-curtain-panel curtain-left"></div><div class="wvn-cine-curtain-panel curtain-right"></div><div class="wvn-cine-curtain-copy"><span>YOUR TURN</span><h2>LET THE CELEBRATION<br><em>BEGIN.</em></h2></div></section>

  <section class="wvn-cine-parallax-banner"><img src="<?php echo esc_url($story_image); ?>" alt="Wedding décor and atmosphere" loading="lazy"><div><p>“Where palaces whisper,<br><em>love answers.</em>”</p></div></section>

  <section class="wvn-cine-wordstrip"><div>UDAIPUR CITY OF LAKES</div><div class="outline">DESTINATION WEDDINGS</div><div>ROYAL PALACES</div></section>

  <section class="wvn-cine-services wvn-cine-section" id="services"><div class="wvn-cine-services-intro"><p class="wvn-cine-eyebrow">THE SERVICES</p><h2>Everything the celebration<br><em>needs to breathe.</em></h2></div><div class="wvn-cine-service-stack">
    <?php $service_titles = array('Royal Venues','Bespoke Décor','Curated Gastronomy','Guest Hospitality'); foreach ($service_titles as $index => $title) : $service = $services[$index] ?? array(); $copy = !empty($service['description']) ? wp_strip_all_tags($service['description']) : 'A fully considered layer of the destination wedding experience, designed to feel seamless from first arrival to final farewell.'; $img = !empty($service['image']) ? $service['image'] : ($rail_images[$index] ?? $hero); ?><article class="wvn-cine-service-card"><div><span>0<?php echo $index + 1; ?></span><h3><?php echo esc_html($title); ?></h3><p><?php echo esc_html($copy); ?></p><small>Planning · Direction · Hospitality</small></div><figure><img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy"></figure></article><?php endforeach; ?>
  </div></section>

  <section class="wvn-cine-partners wvn-cine-section"><p class="wvn-cine-eyebrow">PLACES WE LOVE TO CELEBRATE</p><div class="wvn-cine-partner-marquee"><?php $venues = array(); foreach ($weddings as $w) { if (!empty($w['venue'])) $venues[] = $w['venue']; } $venues = array_values(array_unique($venues)); if (!$venues) $venues = array('Udaipur','Rajasthan','Destination Weddings'); foreach (array_merge($venues,$venues) as $venue) : ?><span><?php echo esc_html($venue); ?> ✦</span><?php endforeach; ?></div></section>

  <section class="wvn-cine-testimonials wvn-cine-section" id="stories"><div class="wvn-cine-section-head"><div><p class="wvn-cine-eyebrow">CLIENT WORDS</p><h2>What the couples<br><em>remember.</em></h2></div><button type="button" class="wvn-cine-icon-button" data-testid="cine-testimonial-pause" aria-label="Pause testimonial rotation">Pause</button></div><div class="wvn-cine-testimonial-track"><?php $testimonials = function_exists('wvn_testimonials') ? wvn_testimonials() : array(); foreach (array_slice($testimonials,0,6) as $index => $item) : ?><article class="wvn-cine-testimonial" data-cine-testimonial><blockquote>“<?php echo esc_html($item['quote'] ?? $item['text'] ?? 'Every detail felt considered and every moment felt completely ours.'); ?>”</blockquote><p><?php echo esc_html($item['name'] ?? $item['client'] ?? 'Wedding Vows couple'); ?></p></article><?php endforeach; ?></div></section>

  <section class="wvn-cine-faq wvn-cine-section" id="faq"><div class="wvn-cine-section-head"><div><p class="wvn-cine-eyebrow">FAQ</p><h2>The details,<br><em>without the noise.</em></h2></div></div><div class="wvn-cine-faq-list"><?php $faqs = function_exists('wvn_faqs') ? wvn_faqs() : array(); foreach (array_slice($faqs,0,10) as $index => $faq) : ?><details><summary data-testid="cine-faq-<?php echo (int)$index; ?>"><?php echo esc_html($faq['question'] ?? $faq['q'] ?? 'Frequently asked question'); ?><span>+</span></summary><div><?php echo wp_kses_post($faq['answer'] ?? $faq['a'] ?? ''); ?></div></details><?php endforeach; ?></div></section>

  <section class="wvn-cine-contact wvn-cine-section" id="contact"><p class="wvn-cine-forever">FOREVER</p><div class="wvn-cine-contact-copy"><p class="wvn-cine-eyebrow">BEGIN YOUR FOREVER</p><h2>Let’s make something<br><em>worth remembering.</em></h2><p>Tell us where you’re dreaming of celebrating, what matters most, and how you want the day to feel.</p><a class="wvn-cine-button" data-testid="cine-contact-start" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Start the conversation <span>↗</span></a></div></section>

  <footer class="wvn-cine-footer"><div class="wvn-cine-footer-brand">WEDDING VOWS</div><div class="wvn-cine-footer-grid"><a data-testid="cine-footer-about" href="#about">About</a><a data-testid="cine-footer-weddings" href="#weddings">Weddings</a><a data-testid="cine-footer-planner" href="#planner">Planner</a><a data-testid="cine-footer-services" href="#services">Services</a><a data-testid="cine-footer-stories" href="#stories">Stories</a><a data-testid="cine-footer-faq" href="#faq">FAQ</a><a data-testid="cine-footer-contact" href="#contact">Contact</a></div><div class="wvn-cine-footer-bottom"><span>Wedding Vows by Nikhil · Udaipur</span><a data-testid="cine-footer-top" href="#home">Back to top ↑</a></div></footer>
</main>
<?php get_footer(); ?>

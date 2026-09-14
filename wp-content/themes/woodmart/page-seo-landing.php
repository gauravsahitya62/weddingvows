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
<main id="content" class="wvn-seo-landing wvn-money-page">
  <section class="wvn-money-hero" style="--svc-hero:url('<?php echo esc_url($hero_image); ?>')">
    <div class="wvn-money-hero-media" aria-hidden="true"></div>
    <div class="wvn-money-hero-overlay"></div>
    <div class="wvn-money-hero-inner">
      <div class="wvn-money-hero-copy">
        <p class="wvn-svc-crumb">Wedding Vows by Nikhil · Udaipur</p>
        <h1 class="wvn-display"><?php the_title(); ?></h1>
        <?php if (!empty($config['intro'])) : ?><p class="wvn-money-hero-lede"><?php echo esc_html($config['intro']); ?></p><?php endif; ?>
        <div class="wvn-money-actions">
          <a class="wvn-money-btn wvn-money-btn-primary" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Plan Your Udaipur Wedding <span aria-hidden="true">↗</span></a>
          <a class="wvn-money-btn wvn-money-btn-ghost" href="<?php echo esc_url(home_url('/portfolio/')); ?>">View Real Weddings <span aria-hidden="true">→</span></a>
        </div>
      </div>
      <div class="wvn-money-hero-side" aria-label="Service strengths">
        <div><span>01</span> Local Udaipur Expertise</div>
        <div><span>02</span> End-to-End Planning</div>
        <div><span>03</span> Guest Experience</div>
        <div><span>04</span> On-Ground Execution</div>
      </div>
    </div>
  </section>

  <section class="wvn-money-proof" aria-label="Wedding planning strengths">
    <div><strong>Udaipur-based</strong><span>Local venue & vendor network</span></div>
    <div><strong>End-to-end</strong><span>Planning through event-day execution</span></div>
    <div><strong>Destination-ready</strong><span>Built for outstation & international guests</span></div>
    <div><strong>Editorial approach</strong><span>Design, hospitality & logistics together</span></div>
  </section>

  <section class="wvn-money-intro">
    <div class="wvn-money-intro-copy">
      <p class="wvn-kicker">Why couples choose us</p>
      <h2 class="wvn-display">More than a beautiful wedding. A seamless experience.</h2>
      <div class="wvn-money-content">
        <?php the_content(); ?>
      </div>
    </div>
    <aside class="wvn-money-contact-card">
      <p class="wvn-money-card-kicker">Let’s plan together</p>
      <h2 class="wvn-display">Tell us what you’re imagining.</h2>
      <p>Share your date, guest count and the kind of celebration you want. We will help you understand the right venue, timeline and next steps.</p>
      <a class="wvn-money-card-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Request a Consultation <span aria-hidden="true">↗</span></a>
      <p class="wvn-money-card-note">Prefer to speak directly? <a href="tel:+919660809000">+91 96608 09000</a></p>
    </aside>
  </section>

  <?php if (!empty($config['highlights'])) : ?>
  <section class="wvn-money-services">
    <div class="wvn-money-section-head">
      <div>
        <p class="wvn-kicker">Planning, design & execution</p>
        <h2 class="wvn-display">Everything connected, nothing overlooked.</h2>
      </div>
      <p class="wvn-money-section-lede">From the first venue shortlist to the last guest transfer, the team stays close to the decisions that shape the experience.</p>
    </div>
    <div class="wvn-money-services-grid">
      <?php foreach ($config['highlights'] as $index => $highlight) : ?>
        <article class="wvn-money-service-card">
          <div class="wvn-money-service-index"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></div>
          <p class="wvn-svc-label"><?php echo esc_html($highlight['label']); ?></p>
          <h3 class="wvn-display"><?php echo esc_html($highlight['title']); ?></h3>
          <p><?php echo esc_html($highlight['text']); ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <section class="wvn-money-proof-cta">
    <div>
      <p class="wvn-kicker">See the work before you decide</p>
      <h2 class="wvn-display">Real weddings. Real Udaipur venues. Real execution.</h2>
    </div>
    <div class="wvn-money-proof-links">
      <a href="<?php echo esc_url(home_url('/portfolio/')); ?>">Explore the portfolio <span aria-hidden="true">↗</span></a>
      <a href="<?php echo esc_url(home_url('/weddings-in-udaipur/')); ?>">Read the Udaipur planning guide <span aria-hidden="true">↗</span></a>
    </div>
  </section>

  <?php if (!empty($config['faqs'])) : ?>
  <section class="wvn-money-faq">
    <div class="wvn-money-section-head wvn-money-faq-head">
      <div>
        <p class="wvn-kicker">Questions, answered</p>
        <h2 class="wvn-display">Planning an Udaipur wedding?</h2>
      </div>
    </div>
    <div class="wvn-money-faq-grid">
      <?php foreach ($config['faqs'] as $faq) : ?>
        <details>
          <summary><?php echo esc_html($faq['q']); ?></summary>
          <p><?php echo esc_html($faq['a']); ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <section class="wvn-money-final-cta">
    <div class="wvn-money-final-cta-copy">
      <p class="wvn-kicker">Start with your date</p>
      <h2 class="wvn-display">Extraordinary begins with a clear plan.</h2>
      <p>Tell us your dates, guest count and vision. We’ll help you turn the Udaipur setting into a wedding that feels effortless from the inside.</p>
    </div>
    <a class="wvn-money-btn wvn-money-btn-primary" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Book a Consultation <span aria-hidden="true">↗</span></a>
  </section>
</main>
    <?php
endwhile;
get_footer();

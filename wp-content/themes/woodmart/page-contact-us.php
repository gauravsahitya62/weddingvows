<?php
/**
 * Contact Us — cinematic consultation page.
 * Auto-applied via slug: page-contact-us.php
 * Keeps the existing Contact Form 7 form (id 205).
 */
get_header();

while (have_posts()) :
    the_post();

    $hero = get_the_post_thumbnail_url(get_the_ID(), 'full');
    if (!$hero && function_exists('wvn_hero_image')) {
        $hero = wvn_hero_image();
    }

    $address = function_exists('wvn_home_text')
        ? wvn_home_text('home_footer_address', '53, Sun city, Delhite, Behind Celebration Mall, Bhuwana, Udaipur, Rajasthan 313001')
        : '53, Sun city, Delhite, Behind Celebration Mall, Bhuwana, Udaipur, Rajasthan 313001';

    $form_shortcode = '';
    $raw = (string) get_post_field('post_content', get_the_ID());
    if (preg_match('/\[contact-form-7[^\]]*\]/', $raw, $match)) {
        $form_shortcode = $match[0];
    } else {
        $form_shortcode = '[contact-form-7 id="0e46edc" title="Contact form 1"]';
    }
    ?>
<main id="content" class="wvn-contact">
  <section class="wvn-contact-stage">
    <div class="wvn-contact-stage__media" style="background-image:url('<?php echo esc_url($hero); ?>')" aria-hidden="true"></div>
    <div class="wvn-contact-stage__veil" aria-hidden="true"></div>
    <div class="wvn-contact-stage__grain" aria-hidden="true"></div>

    <div class="wvn-contact-stage__grid">
      <aside class="wvn-contact-copy wvn-cin-reveal">
        <p class="wvn-contact-eyebrow">Consultation · Udaipur</p>
        <h1 class="wvn-display">Let’s create something<br><em>unforgettable.</em></h1>
        <p class="wvn-contact-lede">Share your date, guest count and the kind of celebration you want. We’ll reply with a clear next step for your Udaipur wedding.</p>

        <ul class="wvn-contact-meta">
          <li>
            <span>Studio</span>
            <strong><?php echo esc_html($address); ?></strong>
          </li>
          <li>
            <span>Email</span>
            <a href="mailto:weddingvowsbynikhil@gmail.com">weddingvowsbynikhil@gmail.com</a>
          </li>
          <li>
            <span>Phone</span>
            <a href="tel:+919660809000">+91 96608 09000</a>
          </li>
          <li>
            <span>WhatsApp</span>
            <a href="https://wa.me/message/ECDOSKZJH772M1" target="_blank" rel="noopener">Message the studio ↗</a>
          </li>
        </ul>

        <div class="wvn-contact-social" aria-label="Social">
          <a href="https://www.instagram.com/weddingvowsbynikhil" target="_blank" rel="noopener">Instagram</a>
          <a href="https://www.facebook.com/share/16DJ386egg/?mibextid=wwXIfr" target="_blank" rel="noopener">Facebook</a>
        </div>
      </aside>

      <div class="wvn-contact-panel wvn-cin-reveal" data-delay="2">
        <div class="wvn-contact-panel__head">
          <p class="wvn-contact-eyebrow">Enquiry</p>
          <h2 class="wvn-display">Begin the conversation</h2>
        </div>
        <div class="wvn-contact-form">
          <?php echo do_shortcode($form_shortcode); ?>
        </div>
      </div>
    </div>
  </section>
</main>
    <?php
endwhile;

get_footer();

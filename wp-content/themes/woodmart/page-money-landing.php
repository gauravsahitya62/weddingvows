<?php
/**
 * Template Name: Premium Money Landing
 * Template Post Type: page
 */

get_header();
while (have_posts()) :
    the_post();

    $slug = get_post_field('post_name', get_the_ID());
    $config = function_exists('wvn_seo_landing_config') ? wvn_seo_landing_config($slug) : array();
    $hero_image = !empty($config['image']) ? $config['image'] : (function_exists('wvn_hero_image') ? wvn_hero_image() : '');

    $is_event = ($slug === 'event-planner-udaipur');
    if ($is_event) {
        $eyebrow = 'Event Planner in Udaipur';
        $title = 'A Local Planning Team\nFrom Brief to Execution';
        $lede = 'Wedding Vows by Nikhil plans weddings and destination events in Udaipur with one local team coordinating the venue, design, vendors, guest experience and event-day execution.';
        $highlights = array(
            array('label' => '01 · Udaipur expertise', 'title' => 'Venue-first decisions', 'text' => 'Palace hotels, heritage properties and resorts each have different access, production and guest-flow realities. We plan around the venue.'),
            array('label' => '02 · Design', 'title' => 'A clear creative direction', 'text' => 'Décor, florals, lighting, stationery and production are developed as one visual language so the event feels considered from arrival to farewell.'),
            array('label' => '03 · Production', 'title' => 'The details behind the show', 'text' => 'Schedules, vendor access, stage requirements, sound, lighting, entertainment and function transitions are coordinated before guests arrive.'),
            array('label' => '04 · Execution', 'title' => 'Calm on event day', 'text' => 'A detailed run sheet and on-ground team keep vendors, timelines and guest movement aligned while hosts stay focused on the celebration.'),
        );
        $section_intro = 'A strong event planner is more than a vendor list. We turn a brief into a clear plan, align the right vendors, manage production, and make sure the guest experience feels seamless from arrival to the final celebration.';
        $service_link = home_url('/what-we-do/');
        $cta_title = 'Let’s bring your celebration to life';
        $cta_text = 'Tell us your date, guest count, venue and the kind of experience you want to create.';
    } else {
        $eyebrow = 'Destination Wedding Planning in Udaipur';
        $title = get_the_title();
        $lede = !empty($config['intro']) ? $config['intro'] : get_the_excerpt();
        $highlights = !empty($config['highlights']) ? $config['highlights'] : array();
        $section_intro = get_the_excerpt() ?: 'Thoughtful planning, local knowledge and calm execution for destination celebrations in Udaipur.';
        $service_link = home_url('/what-we-do/');
        $cta_title = 'Planning your Udaipur celebration?';
        $cta_text = 'Share your date, guest count and the kind of celebration you want. We will help you understand the right venue, timeline and next steps.';
    }
    ?>

<main id="content" class="wvn-money-page">
  <section class="wvn-money-hero">
    <div class="wvn-money-hero-media" style="--svc-hero:url('<?php echo esc_url($hero_image); ?>')" aria-hidden="true"></div>
    <div class="wvn-money-hero-overlay" aria-hidden="true"></div>
    <div class="wvn-money-hero-inner">
      <div class="wvn-money-hero-copy">
        <p class="wvn-money-eyebrow"><?php echo esc_html($eyebrow); ?> · Udaipur</p>
        <h1 class="wvn-display"><?php echo nl2br(esc_html($title)); ?></h1>
        <p class="wvn-money-hero-lede"><?php echo esc_html($lede); ?></p>
        <div class="wvn-money-actions">
          <a class="wvn-money-btn wvn-money-btn-primary" href="<?php echo esc_url(home_url('/contact-us/')); ?>"><?php echo $is_event ? 'Plan Your Event' : 'Plan Your Udaipur Wedding'; ?> <span aria-hidden="true">→</span></a>
          <a class="wvn-money-btn wvn-money-btn-ghost" href="<?php echo esc_url(home_url('/portfolio/')); ?>">View Our Work <span aria-hidden="true">●</span></a>
        </div>
      </div>
      <aside class="wvn-money-hero-side" aria-label="Key planning strengths">
        <div><span>01</span>Udaipur<br>local expertise</div>
        <div><span>02</span>End-to-end<br>planning & design</div>
        <div><span>03</span>Trusted vendor<br>network</div>
        <div><span>04</span>Guest hospitality<br>& execution</div>
      </aside>
    </div>
  </section>

  <section class="wvn-money-proof" aria-label="Planning strengths">
    <div><strong>Udaipur</strong><span>Local expertise</span></div>
    <div><strong>End-to-end</strong><span>Planning & design</span></div>
    <div><strong>Guest-first</strong><span>Hospitality & logistics</span></div>
    <div><strong>On-ground</strong><span>Event execution</span></div>
  </section>

  <section class="wvn-money-intro">
    <div class="wvn-money-intro-copy">
      <p class="wvn-kicker"><?php echo esc_html($is_event ? 'Event planning in Udaipur' : 'Why couples choose Wedding Vows by Nikhil'); ?></p>
      <h2><?php echo esc_html($is_event ? 'A local planning team from brief to execution' : 'More than an event. A seamless experience.'); ?></h2>
      <div class="wvn-money-content">
        <?php if ($is_event) : ?>
          <p><?php echo esc_html($section_intro); ?></p>
          <p>From venue research and event concept to production, hospitality and vendor management, every moving part is kept in one planning system. Our Udaipur base means we can coordinate directly with venues and city-based partners instead of managing the event entirely from another city.</p>
          <h2>What we can coordinate</h2>
          <ul>
            <li>Venue research, selection and coordination</li>
            <li>Event concept, décor and styling</li>
            <li>Production, lighting, sound and stage requirements</li>
            <li>Entertainment and artist coordination</li>
            <li>Guest hospitality, movement and timelines</li>
            <li>Vendor management and on-ground execution</li>
          </ul>
        <?php else : ?>
          <?php the_content(); ?>
        <?php endif; ?>
      </div>
    </div>

    <aside class="wvn-money-contact-card">
      <p class="wvn-money-card-kicker">Let’s plan together</p>
      <h2><?php echo esc_html($is_event ? 'Tell us about your event' : 'Start your wedding conversation'); ?></h2>
      <p>Share your date, guest count and the kind of celebration you want. We’ll come back with a clear next step.</p>
      <a class="wvn-money-card-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Request a Consultation <span aria-hidden="true">→</span></a>
      <p class="wvn-money-card-note">Prefer to browse first? <a href="<?php echo esc_url($service_link); ?>">Explore our services</a></p>
    </aside>
  </section>

  <section class="wvn-money-services">
    <div class="wvn-money-section-head">
      <div>
        <p class="wvn-kicker">Why clients choose a local team</p>
        <h2>Planning that stays connected</h2>
      </div>
      <p class="wvn-money-section-lede">The best destination celebrations feel effortless because venue, design, production, hospitality and execution are treated as one connected experience.</p>
    </div>

    <div class="wvn-money-services-grid">
      <?php foreach ($highlights as $i => $highlight) : ?>
        <article class="wvn-money-service-card">
          <span class="wvn-money-service-index"><?php echo esc_html(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)); ?></span>
          <p class="wvn-svc-label"><?php echo esc_html($highlight['label'] ?? 'Planning'); ?></p>
          <h3><?php echo esc_html($highlight['title'] ?? 'Thoughtful planning'); ?></h3>
          <p><?php echo esc_html($highlight['text'] ?? 'Careful planning, clear communication and detailed execution.'); ?></p>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="wvn-money-proof-cta">
      <div>
        <p class="wvn-kicker">See the work before you decide</p>
        <h2>Real weddings. Local planning. Beautifully executed.</h2>
      </div>
      <a class="wvn-money-btn wvn-money-btn-primary" href="<?php echo esc_url(home_url('/portfolio/')); ?>">Explore Real Weddings <span aria-hidden="true">→</span></a>
    </div>
  </section>

  <?php if (!empty($config['faqs']) || $is_event) : ?>
  <section class="wvn-money-faq">
    <div class="wvn-money-section-head">
      <div>
        <p class="wvn-kicker">FAQs</p>
        <h2>Questions, answered</h2>
      </div>
      <p class="wvn-money-section-lede">Straight answers to the questions couples ask before choosing a planning team in Udaipur.</p>
    </div>
    <div class="wvn-money-faq-grid">
      <?php
      $faqs = !empty($config['faqs']) ? $config['faqs'] : array(
        array('q' => 'What does an event planner in Udaipur handle?', 'a' => 'Venue sourcing, planning timelines, décor and production, entertainment, guest hospitality, vendor management and event-day execution.'),
        array('q' => 'Do you only plan weddings?', 'a' => 'Weddings and destination celebrations are our core work, with selected private and destination events supported when the scope fits our planning and production approach.'),
        array('q' => 'Why hire a local event planner in Udaipur?', 'a' => 'A local team can work directly with venues, vendors, production teams and guest logistics in the city, reducing coordination gaps around the event.'),
        array('q' => 'Can you manage planning and event-day execution?', 'a' => 'Yes. We can coordinate the planning scope before the event and run a detailed event-day schedule so vendors, timelines and guest movement remain aligned.'),
      );
      foreach ($faqs as $faq) : ?>
        <details>
          <summary><?php echo esc_html($faq['q']); ?><span aria-hidden="true">+</span></summary>
          <p><?php echo esc_html($faq['a']); ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <section class="wvn-money-final-cta">
    <p class="wvn-kicker">Planning in Udaipur?</p>
    <h2><?php echo esc_html($cta_title); ?></h2>
    <p><?php echo esc_html($cta_text); ?></p>
    <a class="wvn-money-btn wvn-money-btn-primary" href="<?php echo esc_url(home_url('/contact-us/')); ?>"><?php echo $is_event ? 'Plan Your Event' : 'Plan Your Wedding'; ?> <span aria-hidden="true">→</span></a>
  </section>
</main>

<?php
endwhile;
get_footer();

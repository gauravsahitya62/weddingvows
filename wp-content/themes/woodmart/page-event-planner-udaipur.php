<?php
/**
 * Template Name: Event Planner Udaipur
 * Template Post Type: page
 */
get_header();
while (have_posts()) :
    the_post();
    ?>
<main id="content" class="wvn-seo-landing">
  <section class="wvn-svc-hero" style="--svc-hero:url('<?php echo esc_url(function_exists('wvn_hero_image') ? wvn_hero_image() : ''); ?>')">
    <div class="wvn-svc-hero-copy">
      <p class="wvn-svc-crumb">Wedding Vows by Nikhil · Udaipur</p>
      <h1 class="wvn-display">Best Event Planner in Udaipur</h1>
      <p>Thoughtful event planning, design, production and on-ground coordination for weddings, private celebrations and destination events in Udaipur.</p>
    </div>
  </section>

  <section class="wvn-svc-intro">
    <p class="wvn-kicker">Event planning in Udaipur</p>
    <h2 class="wvn-display">A local planning team from brief to execution</h2>
    <?php the_content(); ?>
  </section>

  <section class="wvn-svc-core">
    <div class="wvn-svc-core-head">
      <p class="wvn-kicker">Why clients choose a local team</p>
      <h2 class="wvn-display">Planning that stays connected</h2>
    </div>
    <div class="wvn-svc-bento" data-count="4">
      <article class="wvn-svc-card is-intro"><div class="wvn-svc-card-copy"><p class="wvn-svc-label">01 · Udaipur knowledge</p><h3 class="wvn-display">Venue-first decisions</h3><p>Palace hotels, heritage properties and resorts each have different access, production and guest-flow realities. We plan around the venue rather than forcing a generic template onto it.</p></div></article>
      <article class="wvn-svc-card is-intro"><div class="wvn-svc-card-copy"><p class="wvn-svc-label">02 · Design</p><h3 class="wvn-display">A clear creative direction</h3><p>Décor, florals, lighting, stationery and production are developed as one visual language so the event feels considered from arrival to final farewell.</p></div></article>
      <article class="wvn-svc-card is-intro"><div class="wvn-svc-card-copy"><p class="wvn-svc-label">03 · Production</p><h3 class="wvn-display">The details behind the show</h3><p>Schedules, vendor access, stage requirements, sound, lighting, entertainment and function transitions are coordinated before guests arrive.</p></div></article>
      <article class="wvn-svc-card is-intro"><div class="wvn-svc-card-copy"><p class="wvn-svc-label">04 · Execution</p><h3 class="wvn-display">Calm on event day</h3><p>A detailed run sheet and on-ground team keep vendors, timelines and guest movement aligned while the hosts stay focused on the celebration.</p></div></article>
    </div>
  </section>

  <section class="wvn-faq">
    <p class="wvn-kicker wvn-center">FAQs</p>
    <h2 class="wvn-display wvn-center">Questions, answered</h2>
    <div class="wvn-acc">
      <details><summary>What does an event planner in Udaipur handle?</summary><p>An event planner can coordinate venue sourcing, planning timelines, décor and production, entertainment, guest hospitality, vendor management and on-ground execution. The exact scope depends on the event.</p></details>
      <details><summary>Do you only plan weddings?</summary><p>Wedding Vows by Nikhil is focused on wedding and destination-event experiences, and the planning approach can also support private celebrations and selected destination events that need detailed coordination.</p></details>
      <details><summary>Why hire a local event planner in Udaipur?</summary><p>A local planning team can work directly with venues, vendors, production teams and guest logistics in the city, which helps reduce coordination gaps before and during the event.</p></details>
      <details><summary>Can you manage both planning and event-day execution?</summary><p>Yes. The scope can cover pre-event coordination and a detailed event-day run sheet, with the on-ground team responsible for keeping vendors, timelines and guest movement aligned.</p></details>
    </div>
  </section>

  <section class="wvn-cta">
    <div class="wvn-cta-box">
      <h2 class="wvn-display">Planning an event in Udaipur?</h2>
      <p class="wvn-lede">Tell us your date, guest count, venue and the kind of experience you want to create.</p>
      <a class="wvn-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Plan your event ↗</a>
    </div>
  </section>
</main>
<?php
endwhile;
get_footer();

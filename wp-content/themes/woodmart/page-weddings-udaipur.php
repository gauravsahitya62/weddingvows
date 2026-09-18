<?php
/**
 * Template Name: Weddings in Udaipur
 */
get_header();
while (have_posts()) :
    the_post();
    $pid = get_the_ID();

    // Intro / Header
    $kicker  = get_field('guide_kicker', $pid) ?: 'Udaipur destination weddings';
    $heading = get_field('guide_heading', $pid) ?: get_the_title();
    $lede    = get_field('guide_lede', $pid) ?: 'A local planner’s guide to venues, guest counts, and what a celebration actually costs — written from our studio in Bhuwana.';
    $intro_body = get_field('guide_intro_body', $pid);

    // Venues
    $venues_heading = get_field('guide_venues_heading', $pid) ?: 'Top wedding venues in Udaipur';
    $venues_desc    = get_field('guide_venues_desc', $pid);
    $venue_groups   = get_field('guide_venue_groups', $pid);
    if (empty($venue_groups) || !is_array($venue_groups)) {
        $venue_groups = function_exists('wvn_udaipur_guide_venues') ? wvn_udaipur_guide_venues() : array();
    }

    // Costs
    $costs_heading = get_field('guide_costs_heading', $pid) ?: 'Estimated cost of a wedding in Udaipur (150–200 guests)';
    $costs_intro   = get_field('guide_costs_intro', $pid);
    $costs_table   = get_field('guide_costs_table', $pid);
    if (empty($costs_table) || !is_array($costs_table)) {
        $costs_table = function_exists('wvn_udaipur_guide_costs') ? wvn_udaipur_guide_costs() : array();
    }
    $costs_footer  = get_field('guide_costs_footer', $pid);

    // Steps
    $steps_heading = get_field('guide_steps_heading', $pid) ?: 'How a destination wedding in Udaipur is planned';
    $steps         = get_field('guide_steps', $pid);

    // FAQs & CTA
    $faq_heading = get_field('guide_faq_heading', $pid) ?: 'Questions families ask';
    $faqs        = get_field('guide_faqs', $pid);
    if (empty($faqs) || !is_array($faqs)) {
        $faqs = function_exists('wvn_udaipur_guide_faqs') ? wvn_udaipur_guide_faqs() : array();
    }

    $cta_heading = get_field('guide_cta_heading', $pid) ?: 'Plan your wedding in Udaipur';
    $cta_text    = get_field('guide_cta_text', $pid) ?: 'Share your season, guest count, and whether you are looking at a palace, a lakeside hotel, or a heritage courtyard. We will reply with a clear next step.';
    $cta_btn_txt = get_field('guide_cta_btn_text', $pid) ?: 'Book a consultation ↗';
    $cta_btn_url = get_field('guide_cta_btn_url', $pid) ?: home_url('/contact-us/');
    $venue_links = array(
        'Taj Lake Palace' => 'taj-lake-palace-wedding',
        'Jagmandir Island Palace' => 'jagmandir-wedding-udaipur',
        'The Leela Palace Udaipur' => 'leela-palace-udaipur-wedding',
        'The Oberoi Udaivilas' => 'oberoi-udaivilas-wedding',
        'Fairmont Udaipur Palace' => 'fairmont-udaipur-wedding',
        'Raffles Udaipur' => 'raffles-udaipur-wedding',
    );
    ?>
<main id="content" class="wvn-page wvn-guide">
  <header class="wvn-page-hero">
    <div class="wvn-page-hero__media" style="background-image:url('<?php echo esc_url(function_exists('wvn_hero_image') ? wvn_hero_image() : ''); ?>')" aria-hidden="true"></div>
    <div class="wvn-page-hero__veil" aria-hidden="true"></div>
    <div class="wvn-page-hero__grain" aria-hidden="true"></div>
    <div class="wvn-page-hero__inner">
      <p class="wvn-page-hero__eyebrow"><?php echo esc_html($kicker); ?></p>
      <h1 class="wvn-display"><?php echo esc_html($heading); ?></h1>
      <?php if ($lede) : ?>
        <p class="wvn-page-hero__lede"><?php echo esc_html($lede); ?></p>
      <?php endif; ?>
    </div>
  </header>

  <div class="wvn-content wvn-guide-body">
    <?php if (!empty($intro_body)) : ?>
      <?php echo wp_kses_post($intro_body); ?>
    <?php else : ?>
      <p>Udaipur is one of India’s most requested destination wedding cities: lake palaces, hilltop resorts, and heritage courtyards within a compact guest journey. Families come for the setting. They stay because the city can host a two- to four-day wedding without moving everyone across the state.</p>
      <p><strong>Hosting a 2-day wedding for 150 to 200 guests in Udaipur typically ranges from ₹50 lakhs to ₹3+ crores</strong>, depending on whether you take a palace buyout, a luxury resort campus, or a boutique heritage property — and how much of décor, catering, and rooms sit inside the hotel quote.</p>
      <p>Wedding Vows by Nikhil is based in Udaipur. We shortlist venues against dates and headcount, then plan décor, hospitality, and the run of show so the number you approve is the wedding you host. <a href="<?php echo esc_url(home_url('/contact-us/')); ?>">Talk to us about your dates</a>.</p>

      <h2>Why Udaipur is famous for weddings</h2>
      <p>The city photographs like a palace film, but the practical reasons matter more. Lake Pichola and the palaces give ceremonies a clear sense of place. Most luxury hotels can hold mehendi, sangeet, pheras and a send-off on one campus, so grandparents are not in traffic between functions. The airport is close enough for destination guests, and neighbourhoods such as Malla Talai, Fatehpura and Hiran Magri already cluster outdoor lawns, resorts and intimate heritage stays.</p>
      <p>Peak season (October–February, plus selected monsoon dates for lakeside photographs) fills eight to twelve months ahead. If the guest list is 150+, start with rooms and ceremony lawns, not the Instagram still.</p>
    <?php endif; ?>

    <?php if (!empty($venues_heading)) : ?>
      <h2><?php echo esc_html($venues_heading); ?></h2>
    <?php endif; ?>
    <?php if (!empty($venues_desc)) : ?>
      <p><?php echo esc_html($venues_desc); ?></p>
    <?php endif; ?>

    <?php if (!empty($venue_groups) && is_array($venue_groups)) : ?>
      <?php foreach ($venue_groups as $group) : ?>
        <?php if (!empty($group['label'])) : ?>
          <h3><?php echo esc_html($group['label']); ?></h3>
        <?php endif; ?>
        <?php if (!empty($group['items']) && is_array($group['items'])) : ?>
          <ul class="wvn-guide-venues">
            <?php foreach ($group['items'] as $venue) : ?>
            <li>
              <strong><?php echo esc_html($venue['name'] ?? ''); ?></strong>
              <span><?php echo esc_html($venue['note'] ?? ''); ?></span>
              <?php if (!empty($venue['name']) && !empty($venue_links[$venue['name']])) : ?>
                <a href="<?php echo esc_url(home_url('/' . $venue_links[$venue['name']] . '/')); ?>">View the <?php echo esc_html($venue['name']); ?> wedding guide ↗</a>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($costs_heading)) : ?>
      <h2><?php echo esc_html($costs_heading); ?></h2>
    <?php endif; ?>
    <?php if (!empty($costs_intro)) : ?>
      <p><?php echo esc_html($costs_intro); ?></p>
    <?php endif; ?>

    <?php if (!empty($costs_table) && is_array($costs_table)) : ?>
      <table class="wvn-guide-table">
        <thead>
          <tr>
            <th>Line</th>
            <th>Typical range</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($costs_table as $row) : ?>
          <tr>
            <td><?php echo esc_html($row['item'] ?? ''); ?></td>
            <td><?php echo esc_html($row['range'] ?? ''); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <?php if (!empty($costs_footer)) : ?>
      <p><?php echo esc_html($costs_footer); ?></p>
    <?php endif; ?>

    <?php if (!empty($steps_heading)) : ?>
      <h2><?php echo esc_html($steps_heading); ?></h2>
    <?php endif; ?>

    <?php if (!empty($steps) && is_array($steps)) : ?>
      <ol class="wvn-guide-steps">
        <?php foreach ($steps as $st) : ?>
          <li><strong><?php echo esc_html($st['title'] ?? ''); ?></strong> <?php echo esc_html($st['desc'] ?? ''); ?></li>
        <?php endforeach; ?>
      </ol>
    <?php else : ?>
      <ol class="wvn-guide-steps">
        <li><strong>Dates and headcount.</strong> Season and rooms decide the venue list. Peak palace weekends in Udaipur are often held a year out.</li>
        <li><strong>Venue walk.</strong> Ceremony lawn, sangeet indoor option, and how many rooms you must block. See <a href="<?php echo esc_url(home_url('/how-to-plan-a-destination-wedding-in-udaipur/')); ?>">how to plan a destination wedding in Udaipur</a>.</li>
        <li><strong>Guest journey.</strong> Airport transfers, welcome dinner, and a quiet morning before pheras — the parts directories rarely price.</li>
        <li><strong>Design and vendors.</strong> Mandap, lighting, hospitality desks, and the artists. <a href="<?php echo esc_url(home_url('/what-we-do/')); ?>">What our studio handles</a>.</li>
        <li><strong>On-ground days.</strong> One team on the floor until the last farewell. <a href="<?php echo esc_url(home_url('/portfolio/')); ?>">Real Udaipur weddings</a>.</li>
      </ol>
    <?php endif; ?>
  </div>

  <?php if (!empty($faqs) && is_array($faqs)) : ?>
  <section class="wvn-faq wvn-guide-faq" aria-labelledby="wvn-guide-faq-title">
    <h2 id="wvn-guide-faq-title" class="wvn-display"><?php echo esc_html($faq_heading); ?></h2>
    <div class="wvn-acc">
      <?php foreach ($faqs as $faq) : ?>
      <details>
        <summary><?php echo esc_html($faq['q'] ?? ''); ?></summary>
        <p><?php echo esc_html($faq['a'] ?? ''); ?></p>
      </details>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <section class="wvn-cta">
    <div class="wvn-cta-box">
      <h2 class="wvn-display"><?php echo esc_html($cta_heading); ?></h2>
      <p class="wvn-lede"><?php echo esc_html($cta_text); ?></p>
      <a class="wvn-btn" href="<?php echo esc_url($cta_btn_url); ?>"><?php echo esc_html($cta_btn_txt); ?></a>
    </div>
  </section>
</main>
    <?php
endwhile;
get_footer();
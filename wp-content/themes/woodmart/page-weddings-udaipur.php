<?php
/**
 * Template Name: Weddings in Udaipur
 */
get_header();
while (have_posts()) :
    the_post();
    $venues = wvn_udaipur_guide_venues();
    $costs  = wvn_udaipur_guide_costs();
    $faqs   = wvn_udaipur_guide_faqs();
    ?>
<main id="content" class="wvn-page wvn-guide">
  <p class="wvn-kicker">Udaipur destination weddings</p>
  <h1>Weddings in Udaipur</h1>
  <p class="wvn-lede">A local planner’s guide to venues, guest counts, and what a celebration actually costs — written from our studio in Bhuwana.</p>

  <div class="wvn-content wvn-guide-body">
    <p>Udaipur is one of India’s most requested destination wedding cities: lake palaces, hilltop resorts, and heritage courtyards within a compact guest journey. Families come for the setting. They stay because the city can host a two- to four-day wedding without moving everyone across the state.</p>
    <p><strong>Hosting a 2-day wedding for 150 to 200 guests in Udaipur typically ranges from ₹50 lakhs to ₹3+ crores</strong>, depending on whether you take a palace buyout, a luxury resort campus, or a boutique heritage property — and how much of décor, catering, and rooms sit inside the hotel quote.</p>
    <p>Wedding Vows by Nikhil is based in Udaipur. We shortlist venues against dates and headcount, then plan décor, hospitality, and the run of show so the number you approve is the wedding you host. <a href="<?php echo esc_url(home_url('/contact-us/')); ?>">Talk to us about your dates</a>.</p>

    <h2>Why Udaipur is famous for weddings</h2>
    <p>The city photographs like a palace film, but the practical reasons matter more. Lake Pichola and the palaces give ceremonies a clear sense of place. Most luxury hotels can hold mehendi, sangeet, pheras and a send-off on one campus, so grandparents are not in traffic between functions. The airport is close enough for destination guests, and neighbourhoods such as Malla Talai, Fatehpura and Hiran Magri already cluster outdoor lawns, resorts and intimate heritage stays.</p>
    <p>Peak season (October–February, plus selected monsoon dates for lakeside photographs) fills eight to twelve months ahead. If the guest list is 150+, start with rooms and ceremony lawns, not the Instagram still.</p>

    <h2>Top wedding venues in Udaipur</h2>
    <p>These are the properties couples ask for most often. The right one depends on guest count, whether you need a full hotel buyout, and which rituals need a lawn versus a courtyard. We walk sites with you — <a href="<?php echo esc_url(home_url('/palace-wedding-venues-in-udaipur/')); ?>">how we help you choose a palace</a>.</p>

    <?php foreach ($venues as $group) : ?>
    <h3><?php echo esc_html($group['label']); ?></h3>
    <ul class="wvn-guide-venues">
      <?php foreach ($group['items'] as $venue) : ?>
      <li>
        <strong><?php echo esc_html($venue['name']); ?></strong>
        <span><?php echo esc_html($venue['note']); ?></span>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endforeach; ?>

    <h2>Estimated cost of a wedding in Udaipur (150–200 guests)</h2>
    <p>Figures below are planning ranges for a two-day destination wedding, not a hotel tariff card. Season, buyout versus lawn hire, and whether guests stay on campus move the total more than any single décor choice.</p>
    <table class="wvn-guide-table">
      <thead>
        <tr>
          <th>Line</th>
          <th>Typical range</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($costs as $row) : ?>
        <tr>
          <td><?php echo esc_html($row['item']); ?></td>
          <td><?php echo esc_html($row['range']); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p>A quieter boutique wedding can sit near the lower end. A palace or hilltop resort with a full room block, destination catering, and a produced sangeet sits toward the upper end. We put every line in writing before artists are booked.</p>

    <h2>How a destination wedding in Udaipur is planned</h2>
    <ol class="wvn-guide-steps">
      <li><strong>Dates and headcount.</strong> Season and rooms decide the venue list. Peak palace weekends in Udaipur are often held a year out.</li>
      <li><strong>Venue walk.</strong> Ceremony lawn, sangeet indoor option, and how many rooms you must block. See <a href="<?php echo esc_url(home_url('/how-to-plan-a-destination-wedding-in-udaipur/')); ?>">how to plan a destination wedding in Udaipur</a>.</li>
      <li><strong>Guest journey.</strong> Airport transfers, welcome dinner, and a quiet morning before pheras — the parts directories rarely price.</li>
      <li><strong>Design and vendors.</strong> Mandap, lighting, hospitality desks, and the artists. <a href="<?php echo esc_url(home_url('/what-we-do/')); ?>">What our studio handles</a>.</li>
      <li><strong>On-ground days.</strong> One team on the floor until the last farewell. <a href="<?php echo esc_url(home_url('/portfolio/')); ?>">Real Udaipur weddings</a>.</li>
    </ol>
  </div>

  <?php if ($faqs) : ?>
  <section class="wvn-faq wvn-guide-faq" aria-labelledby="wvn-guide-faq-title">
    <h2 id="wvn-guide-faq-title" class="wvn-display">Questions families ask</h2>
    <div class="wvn-acc">
      <?php foreach ($faqs as $faq) : ?>
      <details>
        <summary><?php echo esc_html($faq['q']); ?></summary>
        <p><?php echo esc_html($faq['a']); ?></p>
      </details>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <section class="wvn-cta">
    <div class="wvn-cta-box">
      <h2 class="wvn-display">Plan your wedding in Udaipur</h2>
      <p class="wvn-lede">Share your season, guest count, and whether you are looking at a palace, a lakeside hotel, or a heritage courtyard. We will reply with a clear next step.</p>
      <a class="wvn-btn" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Book a consultation ↗</a>
    </div>
  </section>
</main>
    <?php
endwhile;
get_footer();

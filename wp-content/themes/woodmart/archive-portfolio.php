<?php get_header(); ?>
<main id="content" class="wvn-page wvn-portfolio">
  <p class="wvn-kicker wvn-center">Real destination weddings</p>
  <h1>Destination weddings in Udaipur, captured behind the scenes</h1>
  <p class="wvn-lede">Palace, lakeside and heritage celebrations planned in Udaipur and across India by Wedding Vows by Nikhil.</p>
  <div class="wvn-story-copy">
    <p>Explore real wedding stories from our planning work — from intimate palace ceremonies to multi-day destination celebrations. Each wedding is shaped around the venue, guest experience, family traditions and the way the couple wants the celebration to feel.</p>
    <p>Looking for the right property? Start with our <a href="<?php echo esc_url(home_url('/weddings-in-udaipur/')); ?>">Udaipur wedding venues and cost guide</a>, then <a href="<?php echo esc_url(home_url('/contact-us/')); ?>">talk to our Udaipur wedding planning team</a>.</p>
  </div>
  <div class="wvn-mosaic">
    <?php foreach (wvn_portfolio_images() as $index => $image) : ?>
      <a href="<?php echo esc_url($image); ?>" data-wvn-lightbox>
        <img src="<?php echo esc_url($image); ?>" alt="Wedding Vows by Nikhil — Udaipur destination wedding gallery moment <?php echo (int) ($index + 1); ?>" loading="lazy" decoding="async">
      </a>
    <?php endforeach; ?>
  </div>
</main>
<?php get_footer(); ?>

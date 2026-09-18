<?php
/**
 * Portfolio page fallback.
 *
 * Used when WordPress has a normal Page with the /portfolio/ slug. This keeps
 * the public Portfolio URL working even when the page and Portfolio CPT share
 * the same route.
 */
get_header();

$portfolio_query = new WP_Query(array(
    'post_type'      => 'portfolio',
    'post_status'    => 'publish',
    'posts_per_page' => 24,
    'orderby'        => 'date',
    'order'          => 'DESC',
));
?>
<main id="content" class="wvn-page wvn-portfolio">
  <p class="wvn-kicker wvn-center">Real destination weddings</p>
  <h1>Destination weddings in Udaipur, captured behind the scenes</h1>
  <p class="wvn-lede">Palace, lakeside and heritage celebrations planned in Udaipur and across India by Wedding Vows by Nikhil.</p>

  <div class="wvn-story-copy">
    <p>Explore real wedding stories from our planning work — from intimate palace ceremonies to multi-day destination celebrations. Each wedding is shaped around the venue, guest experience, family traditions and the way the couple wants the celebration to feel.</p>
    <p>Looking for the right property? Start with our <a href="<?php echo esc_url(home_url('/weddings-in-udaipur/')); ?>">Udaipur wedding venues and cost guide</a>, then <a href="<?php echo esc_url(home_url('/contact-us/')); ?>">talk to our Udaipur wedding planning team</a>.</p>
  </div>

  <?php if ($portfolio_query->have_posts()) : ?>
    <div class="wvn-mosaic wvn-portfolio-mosaic">
      <?php while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
          $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
      ?>
        <a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr('View wedding: ' . get_the_title()); ?>">
          <?php if ($thumb) : ?>
            <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" decoding="async">
          <?php else : ?>
            <span aria-hidden="true"></span>
          <?php endif; ?>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  <?php else : ?>
    <div class="wvn-mosaic">
      <?php foreach (wvn_portfolio_images() as $index => $image) : ?>
        <a href="<?php echo esc_url($image); ?>" data-wvn-lightbox>
          <img src="<?php echo esc_url($image); ?>" alt="Wedding Vows by Nikhil — Udaipur destination wedding gallery moment <?php echo (int) ($index + 1); ?>" loading="lazy" decoding="async">
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>
<?php get_footer(); ?>

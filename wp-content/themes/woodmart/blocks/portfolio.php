<section class="recent-weddings">
  <div class="container">
    <div class="gallery-grid">
      <?php
      $weddings = new WP_Query([
        'post_type' => 'portfolio',
        'posts_per_page' => 3,
        'post_status' => 'publish',
      ]);
      if ($weddings->have_posts()) :
        while ($weddings->have_posts()) : $weddings->the_post(); 
          $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
          ?>
          <a href="<?php the_permalink(); ?>" class="gallery-card">
            <?php if ($thumbnail): ?>
              <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php the_title_attribute(); ?>" class="gallery-thumb" />
            <?php else: ?>
              <img src="<?php echo get_template_directory_uri(); ?>/images/fallback.jpg" alt="No Image" class="gallery-thumb" />
            <?php endif; ?>
            <div class="overlay-text"><?php the_title(); ?></div>
          </a>
        <?php endwhile;
      else : ?>
        <p>No portfolios found.</p>
      <?php endif;
      wp_reset_postdata(); ?>
    </div>
  </div>
</section>

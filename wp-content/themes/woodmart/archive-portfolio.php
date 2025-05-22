<?php get_header(); ?>

<section class="wedding-archive">
  <div class="container">
    <h1 class="section-title">Our Wedding Stories</h1>
    <div class="gallery-grid">
      <?php
      if (have_posts()) :
        while (have_posts()) : the_post(); ?>
          <a href="<?php the_permalink(); ?>" class="gallery-card">
            <div class="overlay-text"><?php the_title(); ?></div>
            <?php the_post_thumbnail('large'); ?>
          </a>
      <?php endwhile;
      endif; ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>

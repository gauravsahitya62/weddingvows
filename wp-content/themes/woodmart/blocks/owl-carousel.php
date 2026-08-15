<?php if (have_rows('services_carousel')) : ?>
  <div class="owl-carousel promo-carousel">
    <?php while (have_rows('services_carousel')) : the_row(); 
      $image = get_sub_field('image');      // Image Array
      $title = get_sub_field('title');      // Text
      $link  = get_sub_field('link');       // Link Array
    ?>
      <div class="promo-item">
        <div class="promo-inner">
          <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($title); ?>">
          <div class="promo-overlay">
            <h2 class="promo-title"><?php echo esc_html($title); ?></h2>
          </div>
        </div>
      </div>

    <?php endwhile; ?>
  </div>
<?php endif; ?>

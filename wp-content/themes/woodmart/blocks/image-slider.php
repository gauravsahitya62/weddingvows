<div class="swiper mySwiper full-width-slider">
  <div class="swiper-wrapper">
    <?php while (have_rows('images')) : the_row(); 
      $image = get_sub_field('image');
      if ($image):
    ?>
      <div class="swiper-slide">
        <div class="slide-inner">
          <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
          <div class="slide-text-overlay">
            <p>WHISPERING LIFE INTO<br>WEDDING DREAMS</p>
          </div>
        </div>
      </div>
    <?php endif; endwhile; ?>
  </div>

  <!-- Swiper Controls -->
  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>
</div>

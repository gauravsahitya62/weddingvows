<?php if (have_rows('steps_section')) : ?>
  <section class="step-block">
    <?php $i = 0; while (have_rows('steps_section')) : the_row(); 
      $label = get_sub_field('label');
      $number = get_sub_field('number');
      $title = get_sub_field('title');
      $desc = get_sub_field('description');
      $image = get_sub_field('image');
      $i++;
      $reverse = ($i % 2 === 0) ? 'reverse' : '';
    ?>
    <div class="step-row <?php echo $reverse; ?>">
      <div class="step-image">
        <?php if ($image): ?>
          <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($title); ?>">
        <?php endif; ?>
      </div>
      <div class="step-content">
        <?php if ($label && $number): ?>
          <p class="step-label"><?php echo esc_html($label); ?> <span><?php echo esc_html($number); ?></span></p>
        <?php endif; ?>
        <?php if ($title): ?>
          <h3 class="step-title"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>
        <?php if ($desc): ?>
          <div class="step-desc"><?php echo wp_kses_post($desc); ?></div>
        <?php endif; ?>
      </div>
    </div>
    <?php endwhile; ?>
  </section>
<?php endif; ?>

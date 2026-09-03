<?php get_header(); ?>
<main id="content">
    <?php while (have_posts()) : the_post(); ?>
        <article class="wbc-single">
            <header class="wbc-single-hero">
                <img src="<?php echo esc_url(wbc_image_url(get_the_ID(), 'palace')); ?>" alt="<?php echo esc_attr('Destination weddings in ' . get_the_title()); ?>">
                <div>
                    <p class="wbc-kicker"><?php echo esc_html(wbc_meta(get_the_ID(), 'wbc_region', 'India')); ?></p>
                    <h1>Destination weddings in <?php the_title(); ?></h1>
                    <p class="wbc-answer"><?php echo esc_html(wbc_excerpt(get_the_ID(), 32)); ?></p>
                    <p class="wbc-updated">Updated <?php echo esc_html(wbc_updated_label()); ?></p>
                </div>
            </header>
            <div class="wbc-details">
                <span><b>Best season</b><?php echo esc_html(wbc_meta(get_the_ID(), 'wbc_best_season', 'Peak winter')); ?></span>
                <span><b>Venues</b><?php echo esc_html(wbc_meta(get_the_ID(), 'wbc_venue_types', 'Palaces and heritage hotels')); ?></span>
                <span><b>Studio</b><?php echo esc_html(wbc_brand_name()); ?></span>
            </div>
            <div class="wbc-content"><?php the_content(); ?></div>
        </article>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>

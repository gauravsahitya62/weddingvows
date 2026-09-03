<?php get_header(); ?>
<main id="content">
    <?php while (have_posts()) : the_post(); ?>
        <article class="wbc-single">
            <header class="wbc-page-hero">
                <p class="wbc-kicker"><?php echo esc_html(wbc_meta(get_the_ID(), 'wbc_service_kicker', 'Service')); ?></p>
                <h1><?php the_title(); ?></h1>
                <p class="wbc-answer"><?php echo esc_html(wbc_excerpt(get_the_ID(), 32)); ?></p>
                <p class="wbc-updated">Updated <?php echo esc_html(wbc_updated_label()); ?></p>
            </header>
            <figure class="wbc-wide-figure">
                <img src="<?php echo esc_url(wbc_image_url(get_the_ID(), 'service-1')); ?>" alt="<?php the_title_attribute(); ?>">
            </figure>
            <div class="wbc-content"><?php the_content(); ?></div>
        </article>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>

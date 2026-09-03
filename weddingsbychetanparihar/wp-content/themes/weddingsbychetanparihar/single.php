<?php get_header(); ?>
<main id="content" class="wbc-page">
    <?php while (have_posts()) : the_post(); ?>
        <article class="wbc-post">
            <header class="wbc-single-hero">
                <img src="<?php echo esc_url(wbc_image_url(get_the_ID(), 'palace')); ?>" alt="<?php the_title_attribute(); ?>">
                <div>
                    <p class="wbc-kicker"><?php echo esc_html(get_the_date()); ?></p>
                    <h1><?php the_title(); ?></h1>
                    <p><?php echo esc_html(wbc_excerpt(get_the_ID(), 28)); ?></p>
                    <p class="wbc-updated">Updated <?php echo esc_html(wbc_updated_label()); ?></p>
                </div>
            </header>
            <div class="wbc-content"><?php the_content(); ?></div>
        </article>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>

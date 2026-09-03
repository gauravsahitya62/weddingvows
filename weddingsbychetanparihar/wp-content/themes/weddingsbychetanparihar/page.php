<?php get_header(); ?>
<main id="content" class="wbc-page">
    <?php while (have_posts()) : the_post(); ?>
        <article>
            <header class="wbc-page-hero">
                <p class="wbc-kicker"><?php echo esc_html(wbc_brand_name()); ?></p>
                <h1><?php the_title(); ?></h1>
                <p class="wbc-updated">Updated <?php echo esc_html(wbc_updated_label()); ?></p>
            </header>
            <div class="wbc-content"><?php the_content(); ?></div>
        </article>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>

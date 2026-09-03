<?php get_header(); ?>
<main id="content" class="wbc-archive">
    <section class="wbc-page-hero">
        <p class="wbc-kicker">Journal</p>
        <h1>Wedding planning notes for thoughtful celebrations.</h1>
        <p>Destination guides, design notes, venue thinking and practical timelines from <?php echo esc_html(wbc_brand_name()); ?>.</p>
    </section>
    <section class="wbc-listing">
        <?php while (have_posts()) : the_post(); ?>
            <article class="wbc-list-card">
                <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo esc_url(wbc_image_url(get_the_ID(), 'palace')); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                    <span><?php echo esc_html(get_the_date()); ?></span>
                    <h2><?php the_title(); ?></h2>
                    <p><?php echo esc_html(wbc_excerpt(get_the_ID(), 22)); ?></p>
                </a>
            </article>
        <?php endwhile; ?>
    </section>
    <?php the_posts_pagination(); ?>
</main>
<?php get_footer(); ?>

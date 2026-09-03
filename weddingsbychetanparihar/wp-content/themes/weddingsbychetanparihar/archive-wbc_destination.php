<?php get_header(); ?>
<main id="content" class="wbc-archive">
    <section class="wbc-page-hero">
        <p class="wbc-kicker">Destinations</p>
        <h1>Wedding cities we plan, from Udaipur outward.</h1>
        <p class="wbc-answer">Each destination page is written for couples — and for search and answer engines — with season, venue types and local planning notes. Edit them under Destinations in wp-admin.</p>
    </section>
    <section class="wbc-dest-grid is-page">
        <?php $i = 0; while (have_posts()) : the_post(); $i++; ?>
            <a class="wbc-dest-card" href="<?php the_permalink(); ?>">
                <img src="<?php echo esc_url(wbc_image_url(get_the_ID(), $i % 2 ? 'palace' : 'udaipur')); ?>" alt="<?php echo esc_attr('Destination wedding planner in ' . get_the_title()); ?>" loading="lazy">
                <div>
                    <span><?php echo esc_html(wbc_meta(get_the_ID(), 'wbc_region', 'India')); ?></span>
                    <h3><?php the_title(); ?></h3>
                    <p><?php echo esc_html(wbc_excerpt(get_the_ID(), 18)); ?></p>
                </div>
            </a>
        <?php endwhile; ?>
    </section>
</main>
<?php get_footer(); ?>

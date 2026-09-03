<?php get_header(); ?>
<main id="content" class="wbc-archive">
    <section class="wbc-page-hero">
        <p class="wbc-kicker">Services</p>
        <h1>Wedding planning, design and guest care — one studio.</h1>
        <p class="wbc-answer">Venue, decor, production, hospitality and vendors are held as a single conversation so families are never stitching twelve teams together.</p>
    </section>
    <section class="wbc-section wbc-services">
        <div class="wbc-service-list">
        <?php $i = 0; while (have_posts()) : the_post(); $i++; ?>
            <article>
                <span><?php echo esc_html(str_pad((string) $i, 2, '0', STR_PAD_LEFT)); ?></span>
                <div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php echo esc_html(wbc_excerpt(get_the_ID(), 28)); ?></p>
                </div>
            </article>
        <?php endwhile; ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>

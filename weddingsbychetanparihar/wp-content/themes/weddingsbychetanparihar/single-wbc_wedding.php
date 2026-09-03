<?php get_header(); ?>
<main id="content">
    <?php while (have_posts()) : the_post(); ?>
        <article class="wbc-single">
            <header class="wbc-single-hero">
                <img src="<?php echo esc_url(wbc_image_url(get_the_ID(), 'ceremony')); ?>" alt="<?php the_title_attribute(); ?>">
                <div>
                    <p class="wbc-kicker"><?php echo esc_html(wbc_meta(get_the_ID(), 'wbc_location', 'India')); ?></p>
                    <h1><?php the_title(); ?></h1>
                    <p><?php echo esc_html(wbc_excerpt(get_the_ID(), 28)); ?></p>
                    <?php if (wbc_meta(get_the_ID(), 'wbc_couple')) : ?>
                        <p class="wbc-sign"><?php echo esc_html(wbc_meta(get_the_ID(), 'wbc_couple')); ?></p>
                    <?php endif; ?>
                </div>
            </header>
            <div class="wbc-details">
                <span><b>Venue</b><?php echo esc_html(wbc_meta(get_the_ID(), 'wbc_venue', 'Destination venue')); ?></span>
                <span><b>Season</b><?php echo esc_html(wbc_meta(get_the_ID(), 'wbc_season', 'Wedding season')); ?></span>
                <span><b>Guests</b><?php echo esc_html(wbc_meta(get_the_ID(), 'wbc_guest_count', 'Private celebration')); ?></span>
                <?php if (wbc_meta(get_the_ID(), 'wbc_style')) : ?>
                    <span><b>Style</b><?php echo esc_html(wbc_meta(get_the_ID(), 'wbc_style')); ?></span>
                <?php endif; ?>
            </div>
            <div class="wbc-content"><?php the_content(); ?></div>
            <?php
            $ids = wbc_gallery_ids(get_the_ID());
            if ($ids) : ?>
                <div class="wbc-gallery" data-lightbox>
                    <?php foreach ($ids as $id) : ?>
                        <a href="<?php echo esc_url(wp_get_attachment_image_url($id, 'full')); ?>">
                            <?php echo wp_get_attachment_image($id, 'wbc-card'); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (wbc_meta(get_the_ID(), 'wbc_video_url')) : ?>
                <p class="wbc-center-link"><a class="wbc-textlink" href="<?php echo esc_url(wbc_meta(get_the_ID(), 'wbc_video_url')); ?>" target="_blank" rel="noopener">Watch the film <?php echo wbc_svg_icon('arrow'); ?></a></p>
            <?php endif; ?>
            <?php if (wbc_meta(get_the_ID(), 'wbc_planner_note')) : ?>
                <aside class="wbc-note">
                    <p class="wbc-kicker">Planning note</p>
                    <p><?php echo esc_html(wbc_meta(get_the_ID(), 'wbc_planner_note')); ?></p>
                </aside>
            <?php endif; ?>
        </article>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>

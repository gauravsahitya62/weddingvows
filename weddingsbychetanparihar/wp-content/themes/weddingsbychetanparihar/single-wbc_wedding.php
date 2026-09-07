<?php
get_header();
?>
<main id="content">
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $id = get_the_ID();
        wbc_render_page_band(array(
            'kicker'   => wbc_entry_kicker($id, wbc_meta($id, 'wbc_location', 'India')),
            'title'    => wbc_entry_headline($id),
            'lead'     => wbc_entry_intro($id, wbc_excerpt($id, 28)),
            'cta'      => wbc_gallery_ids($id) ? 'View the gallery' : 'View the portfolio',
            'cta_url'  => wbc_gallery_ids($id) ? '#gallery' : wbc_weddings_url(),
            'image'    => wbc_entry_cover($id, 'ceremony'),
            'fallback' => 'ceremony',
        ));
        ?>
        <article class="wbc-single">
            <div class="wbc-details">
                <span><b>Venue</b><?php echo esc_html(wbc_meta($id, 'wbc_venue', 'Destination venue')); ?></span>
                <span><b>Season</b><?php echo esc_html(wbc_meta($id, 'wbc_season', 'Wedding season')); ?></span>
                <span><b>Guests</b><?php echo esc_html(wbc_meta($id, 'wbc_guest_count', 'Private celebration')); ?></span>
                <?php if (wbc_meta($id, 'wbc_style')) : ?>
                    <span><b>Style</b><?php echo esc_html(wbc_meta($id, 'wbc_style')); ?></span>
                <?php endif; ?>
            </div>
            <div class="wbc-content"><?php the_content(); ?></div>
            <?php
            $ids = wbc_gallery_ids($id);
            if ($ids) :
                ?>
                <div id="gallery" class="wbc-gallery" data-lightbox>
                    <?php foreach ($ids as $attachment) : ?>
                        <a href="<?php echo esc_url(wp_get_attachment_image_url($attachment, 'full')); ?>">
                            <?php echo wp_get_attachment_image($attachment, 'wbc-card'); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (wbc_meta($id, 'wbc_video_url')) : ?>
                <p class="wbc-center-link"><a class="wbc-textlink" href="<?php echo esc_url(wbc_meta($id, 'wbc_video_url')); ?>" target="_blank" rel="noopener">Watch the film</a></p>
            <?php endif; ?>
            <?php if (wbc_meta($id, 'wbc_planner_note')) : ?>
                <aside class="wbc-note">
                    <p class="wbc-kicker">Planning note</p>
                    <p><?php echo esc_html(wbc_meta($id, 'wbc_planner_note')); ?></p>
                </aside>
            <?php endif; ?>
        </article>
        <?php
        wbc_render_related_film(wbc_related_posts($id, 'wbc_wedding', 6), array(
            'kicker'   => 'Portfolio',
            'title'    => 'More celebrations from the studio.',
            'link'     => wbc_weddings_url(),
            'label'    => 'View the portfolio',
            'meta_key' => 'wbc_location',
            'fallback' => 'couple',
        ));
        ?>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>

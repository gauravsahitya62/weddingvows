<?php
get_header();
?>
<main id="content" class="wbc-page">
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $id = get_the_ID();
        wbc_render_page_band(array(
            'kicker'   => wbc_entry_kicker($id, get_the_date()),
            'title'    => wbc_entry_headline($id),
            'lead'     => wbc_entry_intro($id, wbc_excerpt($id, 28)),
            'cta'      => 'Back to the journal',
            'cta_url'  => wbc_journal_url(),
            'image'    => wbc_entry_cover($id, 'palace'),
            'fallback' => 'palace',
        ));
        ?>
        <article class="wbc-post">
            <div class="wbc-content"><?php the_content(); ?></div>
            <p class="wbc-center-link">
                <a class="wbc-textlink" href="<?php echo esc_url(wbc_journal_url()); ?>">All notes</a>
            </p>
        </article>
        <?php
        wbc_render_related_film(wbc_related_posts($id, 'post', 6), array(
            'kicker'   => 'Journal',
            'title'    => 'More notes from the studio.',
            'link'     => wbc_journal_url(),
            'label'    => 'Visit the journal',
            'fallback' => 'palace',
        ));
        ?>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>

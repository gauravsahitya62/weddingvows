<?php
get_header();
$notes = array();
while (have_posts()) {
    the_post();
    $notes[] = get_post();
}
$lead = $notes ? array_shift($notes) : null;
?>
<main id="content" class="wbc-archive">
    <?php
    wbc_render_page_band(array(
        'kicker'   => wbc_listing_mod('journal', 'kicker'),
        'title'    => wbc_listing_mod('journal', 'title'),
        'lead'     => wbc_listing_mod('journal', 'text'),
        'cta'      => wbc_listing_mod('journal', 'cta'),
        'cta_url'  => $lead ? get_permalink($lead) : wbc_contact_url(),
        'image'    => wbc_listing_mod('journal', 'image') ?: ($lead ? wbc_image_url($lead->ID, 'journal-1') : ''),
        'fallback' => 'journal-1',
    ));
    ?>

    <?php if ($lead) : ?>
    <section class="wbc-editorial is-light">
        <figure>
            <a href="<?php echo esc_url(get_permalink($lead)); ?>">
                <img src="<?php echo esc_url(wbc_image_url($lead->ID, 'journal-1')); ?>" alt="<?php echo esc_attr(get_the_title($lead)); ?>">
            </a>
        </figure>
        <div>
            <p class="wbc-kicker"><?php echo esc_html(get_the_date('', $lead)); ?></p>
            <h2><a href="<?php echo esc_url(get_permalink($lead)); ?>"><?php echo esc_html(get_the_title($lead)); ?></a></h2>
            <p class="wbc-answer"><?php echo esc_html(wbc_excerpt($lead->ID, 32)); ?></p>
            <a class="wbc-textlink" href="<?php echo esc_url(get_permalink($lead)); ?>">Read the note</a>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($notes) : ?>
    <section class="wbc-section">
        <div class="wbc-section-head is-center">
            <p class="wbc-kicker">More notes</p>
            <h2>From the planning table.</h2>
        </div>
        <div class="wbc-story-grid">
            <?php foreach ($notes as $i => $item) : ?>
                <?php
                wbc_render_story_card($item, array(
                    'meta'     => get_the_date('', $item),
                    'fallback' => 'palace',
                    'eager'    => $i < 2,
                ));
                ?>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
    <?php the_posts_pagination(); ?>
</main>
<?php get_footer(); ?>

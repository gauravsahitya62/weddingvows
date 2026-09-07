<?php
get_header();
$cities = array();
$weddings = array();
while (have_posts()) {
    the_post();
    $wedding = get_post();
    $weddings[] = $wedding;
    $city = wbc_meta($wedding->ID, 'wbc_location');
    if ($city) {
        $cities[$city] = $city;
    }
}
?>
<main id="content" class="wbc-archive">
    <?php
    wbc_render_page_band(array(
        'kicker'   => wbc_listing_mod('weddings', 'kicker'),
        'title'    => wbc_listing_mod('weddings', 'title'),
        'lead'     => wbc_listing_mod('weddings', 'text'),
        'cta'      => wbc_listing_mod('weddings', 'cta'),
        'cta_url'  => wbc_contact_url(),
        'image'    => wbc_listing_mod('weddings', 'image'),
        'fallback' => 'wedding-1',
    ));
    ?>

    <?php if ($cities) : ?>
    <div class="wbc-filters" data-filters>
        <button type="button" class="is-active" data-filter="all">All</button>
        <?php foreach ($cities as $city) : ?>
            <button type="button" data-filter="<?php echo esc_attr(sanitize_title($city)); ?>"><?php echo esc_html($city); ?></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <section class="wbc-story-grid">
        <?php foreach ($weddings as $i => $wedding) : ?>
            <?php
            wbc_render_story_card($wedding, array(
                'meta'     => wbc_meta($wedding->ID, 'wbc_location', 'India'),
                'city'     => sanitize_title(wbc_meta($wedding->ID, 'wbc_location')),
                'fallback' => 'wedding-' . (($i % 4) + 1),
                'eager'    => $i < 3,
            ));
            ?>
        <?php endforeach; ?>
    </section>
    <?php the_posts_pagination(); ?>
</main>
<?php get_footer(); ?>

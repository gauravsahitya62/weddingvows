<?php
get_header();
$cities = array();
foreach (wbc_get_ordered_posts('wbc_wedding') as $wedding) {
    $city = wbc_meta($wedding->ID, 'wbc_location');
    if ($city) {
        $cities[$city] = $city;
    }
}
?>
<main id="content" class="wbc-archive">
    <section class="wbc-page-hero">
        <p class="wbc-kicker">Portfolio</p>
        <h1>Real weddings by <?php echo esc_html(wbc_brand_name()); ?></h1>
        <p>Palace, heritage, lakeside and destination celebrations — each story is edited from wp-admin with venue, city, gallery and planning notes.</p>
    </section>
    <?php if ($cities) : ?>
    <div class="wbc-filters" data-filters>
        <button type="button" class="is-active" data-filter="all">All</button>
        <?php foreach ($cities as $city) : ?>
            <button type="button" data-filter="<?php echo esc_attr(sanitize_title($city)); ?>"><?php echo esc_html($city); ?></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <section class="wbc-listing">
        <?php while (have_posts()) : the_post(); ?>
            <article class="wbc-list-card" data-city="<?php echo esc_attr(sanitize_title(wbc_meta(get_the_ID(), 'wbc_location'))); ?>">
                <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo esc_url(wbc_image_url(get_the_ID(), 'couple')); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                    <span><?php echo esc_html(wbc_meta(get_the_ID(), 'wbc_location', 'India')); ?></span>
                    <h2><?php the_title(); ?></h2>
                    <p><?php echo esc_html(wbc_excerpt(get_the_ID(), 22)); ?></p>
                </a>
            </article>
        <?php endwhile; ?>
    </section>
    <?php the_posts_pagination(); ?>
</main>
<?php get_footer(); ?>

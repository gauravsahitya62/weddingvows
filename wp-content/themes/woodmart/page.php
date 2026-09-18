<?php
/**
 * Standard page template.
 * Keep page rendering explicit so pages that do not use a custom template
 * still receive the shared header, content and footer.
 */
get_header();

$hero_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
if (!$hero_image && function_exists('wvn_hero_image')) {
    $hero_image = wvn_hero_image();
}
$excerpt = has_excerpt() ? get_the_excerpt() : '';
?>

<main id="content" class="wvn-content-page">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('wvn-standard-page'); ?>>
            <header class="wvn-page-hero">
                <div class="wvn-page-hero__media" style="background-image:url('<?php echo esc_url($hero_image); ?>')" aria-hidden="true"></div>
                <div class="wvn-page-hero__veil" aria-hidden="true"></div>
                <div class="wvn-page-hero__grain" aria-hidden="true"></div>
                <div class="wvn-page-hero__inner">
                    <p class="wvn-page-hero__eyebrow">Wedding Vows by Nikhil · Udaipur</p>
                    <h1 class="wvn-display"><?php the_title(); ?></h1>
                    <?php if ($excerpt) : ?>
                        <p class="wvn-page-hero__lede"><?php echo esc_html($excerpt); ?></p>
                    <?php endif; ?>
                </div>
            </header>
            <div class="wvn-standard-page-inner">
                <div class="wvn-standard-page-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>

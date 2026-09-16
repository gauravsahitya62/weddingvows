<?php
/**
 * Standard page template.
 * Keep page rendering explicit so pages that do not use a custom template
 * still receive the shared header, content and footer.
 */
get_header();
?>

<main id="content" class="wvn-content-page">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('wvn-standard-page'); ?>>
            <div class="wvn-standard-page-inner">
                <header class="wvn-standard-page-header">
                    <p class="wvn-kicker">Wedding Vows by Nikhil · Udaipur</p>
                    <h1 class="wvn-display"><?php the_title(); ?></h1>
                </header>
                <div class="wvn-standard-page-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>

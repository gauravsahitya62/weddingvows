<?php /* Template Name: Default */
get_header();
?>

<main id="content" class="wvn-content-page">
    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php get_footer(); ?>

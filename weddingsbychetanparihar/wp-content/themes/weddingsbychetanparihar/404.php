<?php get_header(); ?>
<main id="content" class="wbc-page">
    <section class="wbc-page-hero">
        <p class="wbc-kicker">404</p>
        <h1>This page has quietly moved.</h1>
        <p>Return to the wedding stories, or begin an enquiry with the studio.</p>
        <div class="wbc-actions">
            <a class="wbc-btn" href="<?php echo esc_url(home_url('/')); ?>">Go home <?php echo wbc_svg_icon('arrow'); ?></a>
            <a class="wbc-textlink" href="<?php echo esc_url(wbc_contact_url()); ?>">Enquire</a>
        </div>
    </section>
</main>
<?php get_footer(); ?>

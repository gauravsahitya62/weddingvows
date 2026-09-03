<?php
/**
 * Template Name: About
 */
get_header();
$image = wbc_mod('wbc_about_image', wbc_default_image('about'));
$founder = wbc_mod('wbc_founder_image', wbc_default_image('founder'));
$faqs = wbc_get_ordered_posts('wbc_faq', 8);
?>
<main id="content" class="wbc-about">
    <section class="wbc-page-hero">
        <p class="wbc-kicker"><?php echo esc_html(wbc_brand_name()); ?></p>
        <h1><?php echo esc_html(wbc_mod('wbc_about_title', 'A Udaipur studio for destination weddings that feel personal.')); ?></h1>
        <p class="wbc-answer"><?php echo esc_html(wbc_mod('wbc_about_text', 'Chetan Parihar Weddings specialises in destination weddings, corporate celebrations and event styling.')); ?></p>
        <p class="wbc-updated">Updated <?php echo esc_html(wbc_updated_label()); ?></p>
    </section>
    <section class="wbc-editorial is-light">
        <figure><img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(wbc_brand_name()); ?>"></figure>
        <div>
            <p class="wbc-kicker">The studio</p>
            <h2><?php echo esc_html(wbc_mod('wbc_founder_kicker', 'Weddings are planned by people, not companies.')); ?></h2>
            <p><?php echo esc_html(wbc_mod('wbc_founder_bio', 'Chetan Parihar leads a Udaipur-based studio that plans destination weddings with a design-first eye and a calm ground team.')); ?></p>
            <p class="wbc-sign"><?php echo esc_html(wbc_mod('wbc_founder_name', 'Chetan Parihar')); ?></p>
        </div>
    </section>
    <section class="wbc-content">
        <?php while (have_posts()) : the_post(); the_content(); endwhile; ?>
    </section>
    <section class="wbc-planner">
        <div class="wbc-planner-card">
            <figure class="wbc-planner-photo">
                <img src="<?php echo esc_url($founder); ?>" alt="<?php echo esc_attr(wbc_mod('wbc_founder_name', 'Chetan Parihar')); ?>">
            </figure>
            <div class="wbc-planner-copy">
                <h2>Visit the studio</h2>
                <p><?php echo esc_html(wbc_full_address()); ?></p>
                <p><?php echo esc_html(wbc_mod('wbc_hours', 'Mo-Sa 10:00-19:00')); ?></p>
                <a class="wbc-textlink" href="<?php echo esc_url(wbc_contact_url()); ?>">Book a consultation <?php echo wbc_svg_icon('arrow'); ?></a>
            </div>
        </div>
    </section>
    <?php if ($faqs) : ?>
    <section class="wbc-section wbc-faq">
        <div class="wbc-section-head">
            <p class="wbc-kicker">Answers</p>
            <h2>What families usually ask first.</h2>
        </div>
        <div class="wbc-faq-list">
            <?php foreach ($faqs as $faq) : ?>
                <details>
                    <summary><?php echo esc_html(get_the_title($faq)); ?></summary>
                    <p class="wbc-answer"><?php echo esc_html(wp_strip_all_tags($faq->post_content)); ?></p>
                </details>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</main>
<?php get_footer(); ?>

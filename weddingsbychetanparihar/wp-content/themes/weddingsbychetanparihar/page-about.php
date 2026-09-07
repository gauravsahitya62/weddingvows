<?php
/**
 * Template Name: About
 */
get_header();
$image = wbc_mod('wbc_about_image', wbc_default_image('about'));
$founder = wbc_mod('wbc_founder_image', wbc_default_image('founder'));
$faqs = wbc_get_ordered_posts('wbc_faq', 8);
$testimonials = wbc_get_ordered_posts('wbc_testimonial', 1);
$featured_quote = $testimonials ? $testimonials[0] : null;
$pillars = wbc_default_pillars();
?>
<main id="content" class="wbc-about">
    <?php
    wbc_render_page_band(array(
        'kicker'   => wbc_mod('wbc_about_kicker', wbc_brand_name()),
        'title'    => wbc_mod('wbc_about_title', 'A Udaipur studio for destination weddings that feel personal.'),
        'lead'     => wbc_mod('wbc_about_text', 'Chetan Parihar Weddings specialises in destination weddings, corporate celebrations and event styling.'),
        'cta'      => wbc_mod('wbc_about_cta', 'Begin the conversation'),
        'cta_url'  => wbc_contact_url(),
        'image'    => $image,
        'fallback' => 'about',
    ));
    ?>

    <section class="wbc-editorial is-light">
        <figure>
            <img src="<?php echo esc_url($founder); ?>" alt="<?php echo esc_attr(wbc_mod('wbc_founder_name', 'Chetan Parihar')); ?>">
        </figure>
        <div>
            <p class="wbc-kicker"><?php echo esc_html(wbc_mod('wbc_founder_kicker', 'A studio, not a production house')); ?></p>
            <h2><?php echo esc_html(wbc_mod('wbc_founder_title', 'Weddings are planned by people, not companies.')); ?></h2>
            <p><?php echo esc_html(wbc_mod('wbc_founder_bio', 'Chetan Parihar leads a Udaipur-based studio that plans destination weddings with a design-first eye and a calm ground team.')); ?></p>
            <p class="wbc-sign"><?php echo esc_html(wbc_mod('wbc_founder_name', 'Chetan Parihar')); ?></p>
        </div>
    </section>

    <?php
    $page_content = '';
    while (have_posts()) :
        the_post();
        $page_content = trim(get_the_content());
        if ($page_content) :
            ?>
            <section class="wbc-content"><?php the_content(); ?></section>
        <?php endif;
    endwhile;
    ?>

    <section class="wbc-section wbc-pillars">
        <div class="wbc-section-head is-center">
            <p class="wbc-kicker"><?php echo esc_html(wbc_mod('wbc_pillars_kicker', 'How the studio works')); ?></p>
            <h2><?php echo esc_html(wbc_mod('wbc_pillars_title', 'The same discipline that holds the homepage holds every wedding.')); ?></h2>
        </div>
        <div class="wbc-pillar-grid">
            <?php foreach ($pillars as $i => $pillar) : ?>
                <article class="wbc-pillar">
                    <span><?php echo esc_html($pillar['label']); ?></span>
                    <h3><?php echo esc_html(wbc_mod('wbc_pillar_' . $i . '_title', $pillar['title'])); ?></h3>
                    <p><?php echo esc_html(wbc_mod('wbc_pillar_' . $i . '_text', $pillar['text'])); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <?php if ($featured_quote) : ?>
    <section class="wbc-kind">
        <div class="wbc-kind-media" data-parallax>
            <img src="<?php echo esc_url(wbc_slot_image('kind', 'kind')); ?>" alt="<?php echo esc_attr('Kind words from families planned by ' . wbc_brand_name()); ?>" loading="lazy" decoding="async">
        </div>
        <div class="wbc-kind-copy">
            <p class="wbc-kicker">Kind words</p>
            <blockquote>
                <p>“<?php echo esc_html(wp_strip_all_tags($featured_quote->post_content)); ?>”</p>
                <cite><?php echo esc_html(get_the_title($featured_quote)); ?><?php if (wbc_meta($featured_quote->ID, 'wbc_event')) : ?> — <?php echo esc_html(wbc_meta($featured_quote->ID, 'wbc_event')); ?><?php endif; ?></cite>
            </blockquote>
        </div>
    </section>
    <?php endif; ?>

    <section class="wbc-planner">
        <div class="wbc-planner-card">
            <figure>
                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(wbc_brand_name()); ?>">
            </figure>
            <div>
                <p class="wbc-kicker"><?php echo esc_html(wbc_mod('wbc_visit_kicker', 'Visit the studio')); ?></p>
                <h2><?php echo esc_html(wbc_mod('wbc_visit_title', 'Udaipur is home. The map is wider.')); ?></h2>
                <p><?php echo esc_html(wbc_full_address()); ?></p>
                <p><?php echo esc_html(wbc_mod('wbc_hours', 'Mo-Sa 10:00-19:00')); ?></p>
                <a class="wbc-textlink" href="<?php echo esc_url(wbc_contact_url()); ?>">Book a consultation</a>
            </div>
        </div>
    </section>

    <?php if ($faqs) : ?>
    <?php $faq_image = wbc_faq_image(); ?>
    <section id="faq" class="wbc-faq-block<?php echo $faq_image ? '' : ' is-plain'; ?>">
        <?php if ($faq_image) : ?>
        <div class="wbc-faq-bg" data-parallax>
            <img src="<?php echo esc_url($faq_image); ?>" alt="<?php echo esc_attr(wbc_mod('wbc_faq_title', 'Questions couples ask before they book.')); ?>" loading="lazy" decoding="async">
            <span class="wbc-faq-veil" aria-hidden="true"></span>
        </div>
        <?php endif; ?>
        <div class="wbc-section wbc-faq">
            <div class="wbc-section-head">
                <p class="wbc-kicker<?php echo $faq_image ? ' is-light' : ''; ?>"><?php echo esc_html(wbc_mod('wbc_faq_kicker', 'Answers')); ?></p>
                <h2><?php echo esc_html(wbc_mod('wbc_faq_title', 'Questions couples ask before they book.')); ?></h2>
            </div>
            <div class="wbc-faq-list">
                <?php foreach ($faqs as $faq) : ?>
                    <details>
                        <summary><?php echo esc_html(get_the_title($faq)); ?></summary>
                        <p class="wbc-answer"><?php echo esc_html(wp_strip_all_tags($faq->post_content)); ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>
<?php get_footer(); ?>

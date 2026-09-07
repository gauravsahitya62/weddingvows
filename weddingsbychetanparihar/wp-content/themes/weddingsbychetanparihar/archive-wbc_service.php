<?php
get_header();
$steps = wbc_get_ordered_posts('wbc_process', 6);
$i = 0;
?>
<main id="content" class="wbc-archive">
    <?php
    wbc_render_page_band(array(
        'kicker'   => wbc_listing_mod('services', 'kicker'),
        'title'    => wbc_listing_mod('services', 'title'),
        'lead'     => wbc_listing_mod('services', 'text'),
        'cta'      => wbc_listing_mod('services', 'cta'),
        'cta_url'  => wbc_contact_url(),
        'image'    => wbc_listing_mod('services', 'image'),
        'fallback' => 'service-1',
    ));
    ?>

    <section class="wbc-section wbc-services">
        <div class="wbc-section-head">
            <div>
                <p class="wbc-kicker"><?php echo esc_html(wbc_mod('wbc_services_kicker', 'Planning & design')); ?></p>
                <h2><?php echo esc_html(wbc_mod('wbc_services_title', 'Impeccable logistics, inspired creative direction, and design held in-house.')); ?></h2>
            </div>
            <a class="wbc-textlink" href="<?php echo esc_url(wbc_contact_url()); ?>">Begin the conversation</a>
        </div>
        <div class="wbc-stats">
            <?php foreach (wbc_default_stats() as $s => $stat) : ?>
                <div>
                    <strong><?php echo esc_html(wbc_mod('wbc_stat_' . $s . '_value', $stat['value'])); ?></strong>
                    <span><?php echo esc_html(wbc_mod('wbc_stat_' . $s . '_label', $stat['label'])); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="wbc-svc-covers">
            <?php while (have_posts()) : the_post(); $i++; ?>
                <a class="wbc-svc-cover" href="<?php the_permalink(); ?>">
                    <img src="<?php echo esc_url(wbc_image_url(get_the_ID(), 'service-1')); ?>" alt="<?php the_title_attribute(); ?>" loading="<?php echo $i < 3 ? 'eager' : 'lazy'; ?>" decoding="async">
                    <div>
                        <span><?php echo esc_html(str_pad((string) $i, 2, '0', STR_PAD_LEFT)); ?></span>
                        <h3><?php the_title(); ?></h3>
                        <p><?php echo esc_html(wbc_excerpt(get_the_ID(), 18)); ?></p>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </section>

    <section id="process" class="wbc-process-block">
        <div class="wbc-process-bg<?php echo wbc_slot_uses_video('process') ? ' is-embed' : ''; ?>" data-parallax>
            <?php wbc_render_band_media('process', array(
                'alt'      => wbc_mod('wbc_process_kicker', 'A uniquely comprehensive process'),
                'fallback' => 'process',
            )); ?>
            <span class="wbc-process-veil" aria-hidden="true"></span>
        </div>
        <div class="wbc-section wbc-process">
            <div class="wbc-section-head is-center">
                <p class="wbc-kicker is-light"><?php echo esc_html(wbc_mod('wbc_process_kicker', 'A uniquely comprehensive process')); ?></p>
                <h2><?php echo esc_html(wbc_mod('wbc_process_title', 'From the first story to the last farewell.')); ?></h2>
                <p class="wbc-answer"><?php echo esc_html(wbc_mod('wbc_process_text', 'Impeccable logistics, inspired creative direction, and design held in-house — from story to soirée.')); ?></p>
            </div>
            <?php if ($steps) : ?>
            <ol class="wbc-steps">
                <?php foreach ($steps as $step) : ?>
                    <li>
                        <span><?php echo esc_html(wbc_meta($step->ID, 'wbc_step_label', 'STEP')); ?></span>
                        <h3><?php echo esc_html(get_the_title($step)); ?></h3>
                        <p><?php echo esc_html(wp_strip_all_tags($step->post_content)); ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
            <?php endif; ?>
        </div>
    </section>

    <section class="wbc-editorial">
        <figure>
            <img src="<?php echo esc_url(wbc_slot_image('editorial', 'editorial')); ?>" alt="<?php echo esc_attr('Wedding design by ' . wbc_brand_name()); ?>" loading="lazy" decoding="async">
        </figure>
        <div>
            <p class="wbc-kicker"><?php echo esc_html(wbc_mod('wbc_editorial_kicker', 'Our promise')); ?></p>
            <h2><?php echo esc_html(wbc_mod('wbc_editorial_title', 'We coordinate so you can celebrate.')); ?></h2>
            <p class="wbc-answer"><?php echo esc_html(wbc_mod('wbc_editorial_text', 'Couples are asking for weddings that feel intentional, personal and immersive. This studio is built the same way.')); ?></p>
            <a class="wbc-textlink" href="<?php echo esc_url(wbc_contact_url()); ?>">Start an enquiry</a>
        </div>
    </section>
</main>
<?php get_footer(); ?>

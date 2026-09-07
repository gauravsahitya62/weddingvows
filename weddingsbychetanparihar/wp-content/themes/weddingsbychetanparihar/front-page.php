<?php
get_header();
$weddings = wbc_get_ordered_posts('wbc_wedding', 6);
$services = wbc_get_ordered_posts('wbc_service', 8);
$destinations = wbc_get_ordered_posts('wbc_destination', 8);
$steps = wbc_get_ordered_posts('wbc_process', 6);
$testimonials = wbc_get_ordered_posts('wbc_testimonial', 6);
$faqs = wbc_get_ordered_posts('wbc_faq', 10);
$founder = wbc_mod('wbc_founder_image', wbc_default_image('founder'));
$featured_quote = $testimonials ? $testimonials[0] : null;
$more_quotes = $testimonials ? array_slice($testimonials, 1) : array();
?>
<main id="content">
    <section class="wbc-hero">
        <div class="wbc-hero-media<?php echo wbc_slot_uses_video('hero') ? ' is-embed' : ''; ?>" data-parallax>
            <?php wbc_render_band_media('hero', array(
                'alt'      => wbc_brand_name() . ' destination wedding in Udaipur',
                'fallback' => 'hero',
                'eager'    => true,
            )); ?>
        </div>
        <div class="wbc-hero-copy">
            <p class="wbc-kicker is-light"><?php echo esc_html(wbc_mod('wbc_hero_kicker', 'Udaipur, India')); ?></p>
            <p class="wbc-hero-title"><?php echo esc_html(wbc_mod('wbc_hero_title', 'Destination weddings, held with stillness.')); ?></p>
            <p class="wbc-hero-lead"><?php echo esc_html(wbc_mod('wbc_hero_text', 'Palace, heritage, and celebration design — planned in-house from the first story to the last farewell.')); ?></p>
            <a class="wbc-textlink is-light" href="<?php echo esc_url(wbc_contact_url()); ?>"><?php echo esc_html(wbc_mod('wbc_hero_cta', 'Begin the conversation')); ?></a>
        </div>
        <a class="wbc-scroll" href="#intro">Scroll to Explore</a>
    </section>

    <?php
    $intro = wbc_intro_defaults();
    $intro_icons = wbc_intro_icons();
    $intro_image = wbc_intro_image();
    ?>
    <section id="intro" class="wbc-art" aria-label="<?php echo esc_attr(wbc_intro_value('title', 'wbc_intro_title')); ?>">
        <?php if ($intro_image) : ?>
        <div class="wbc-art-media" aria-hidden="true">
            <img src="<?php echo esc_url($intro_image); ?>" alt="" width="1920" height="1080" loading="eager" decoding="async">
        </div>
        <span class="wbc-art-veil" aria-hidden="true"></span>
        <?php endif; ?>
        <div class="wbc-art-inner">
            <div class="wbc-art-copy">
                <p class="wbc-kicker"><?php echo esc_html(wbc_intro_value('kicker', 'wbc_intro_kicker')); ?></p>
                <h1><?php echo esc_html(wbc_intro_value('title', 'wbc_intro_title')); ?></h1>
                <p><?php echo esc_html(wbc_intro_value('text', 'wbc_intro_text')); ?></p>
                <a class="wbc-art-cta" href="<?php echo esc_url(wbc_intro_cta_url()); ?>">
                    <span><?php echo esc_html(wbc_mod('wbc_intro_cta', $intro['cta'])); ?></span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>
            <?php if ($intro_icons) : ?>
            <ul class="wbc-art-icons">
                <?php foreach ($intro_icons as $item) : ?>
                    <li>
                        <?php if (!empty($item['url'])) : ?><a href="<?php echo esc_url($item['url']); ?>"><?php endif; ?>
                            <?php if (!empty($item['icon'])) : ?>
                                <img src="<?php echo esc_url($item['icon']); ?>" alt="" width="58" height="58">
                            <?php endif; ?>
                            <?php if (!empty($item['label'])) : ?>
                                <span><?php echo esc_html($item['label']); ?></span>
                            <?php endif; ?>
                        <?php if (!empty($item['url'])) : ?></a><?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </section>

    <section class="wbc-section wbc-latest">
        <div class="wbc-section-head is-center">
            <p class="wbc-kicker"><?php echo esc_html(wbc_mod('wbc_portfolio_kicker', 'Latest celebrations')); ?></p>
            <h2><?php echo esc_html(wbc_mod('wbc_portfolio_title', 'See the work — stories told through rooms, rituals, and light.')); ?></h2>
        </div>
        <div class="wbc-film" data-film>
            <div class="wbc-film-track">
                <?php foreach ($weddings as $i => $wedding) : ?>
                    <a class="wbc-film-card" href="<?php echo esc_url(get_permalink($wedding)); ?>">
                        <figure>
                            <img src="<?php echo esc_url(wbc_image_url($wedding->ID, 'wedding-' . ($i + 1))); ?>" alt="<?php echo esc_attr(get_the_title($wedding)); ?>" loading="<?php echo $i < 3 ? 'eager' : 'lazy'; ?>" decoding="async">
                        </figure>
                        <span><?php echo esc_html(wbc_meta($wedding->ID, 'wbc_location', 'India')); ?></span>
                        <h3><?php echo esc_html(get_the_title($wedding)); ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="wbc-center-link">
            <a class="wbc-textlink" href="<?php echo esc_url(wbc_weddings_url()); ?>">View the portfolio</a>
        </div>
    </section>

    <?php if ($featured_quote) : ?>
    <section class="wbc-kind">
        <div class="wbc-kind-media<?php echo wbc_slot_uses_video('kind') ? ' is-embed' : ''; ?>" data-parallax>
            <?php wbc_render_band_media('kind', array(
                'alt'      => 'Kind words from families planned by ' . wbc_brand_name(),
                'fallback' => 'kind',
            )); ?>
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
                <img src="<?php echo esc_url($founder); ?>" alt="<?php echo esc_attr(wbc_mod('wbc_founder_name', 'Chetan Parihar')); ?>">
            </figure>
            <div>
                <p class="wbc-kicker"><?php echo esc_html(wbc_mod('wbc_founder_kicker', 'A studio, not a production house')); ?></p>
                <h2><?php echo esc_html(wbc_mod('wbc_founder_title', 'Meet the planner')); ?></h2>
                <p><?php echo esc_html(wbc_mod('wbc_founder_bio', 'Chetan Parihar leads a Udaipur-based studio that plans destination weddings with a design-first eye and a calm ground team.')); ?></p>
                <p class="wbc-sign"><?php echo esc_html(wbc_mod('wbc_founder_name', 'Chetan Parihar')); ?></p>
                <a class="wbc-textlink" href="<?php echo esc_url(wbc_about_url()); ?>">The studio story</a>
            </div>
        </div>
    </section>

    <?php if ($destinations) : ?>
    <section class="wbc-section wbc-destinations">
        <div class="wbc-section-head">
            <div>
                <p class="wbc-kicker"><?php echo esc_html(wbc_mod('wbc_dest_kicker', 'Udaipur, and beyond')); ?></p>
                <h2><?php echo esc_html(wbc_mod('wbc_dest_title', 'Destination planning with a home city, and a wide map.')); ?></h2>
            </div>
            <a class="wbc-textlink" href="<?php echo esc_url(wbc_destinations_url()); ?>">All destinations</a>
        </div>
        <div class="wbc-coverflow" data-coverflow>
            <button type="button" class="wbc-coverflow-nav is-prev" data-coverflow-prev aria-label="Previous destination">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M14.5 6 8.5 12l6 6"/></svg>
            </button>
            <div class="wbc-coverflow-stage">
                <?php foreach ($destinations as $i => $place) : ?>
                    <a class="wbc-coverflow-card" href="<?php echo esc_url(get_permalink($place)); ?>">
                        <img src="<?php echo esc_url(wbc_image_url($place->ID, 'udaipur')); ?>" alt="<?php echo esc_attr('Destination weddings in ' . get_the_title($place)); ?>" loading="lazy">
                        <div>
                            <span><?php echo esc_html(wbc_meta($place->ID, 'wbc_region', 'India')); ?></span>
                            <h3><?php echo esc_html(get_the_title($place)); ?></h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            <button type="button" class="wbc-coverflow-nav is-next" data-coverflow-next aria-label="Next destination">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m9.5 6 6 6-6 6"/></svg>
            </button>
        </div>
    </section>
    <?php endif; ?>

    <section id="services" class="wbc-section wbc-services">
        <div class="wbc-section-head">
            <div>
                <p class="wbc-kicker"><?php echo esc_html(wbc_mod('wbc_services_kicker', 'Planning & design')); ?></p>
                <h2><?php echo esc_html(wbc_mod('wbc_services_title', 'Impeccable logistics, inspired creative direction, and design held in-house.')); ?></h2>
            </div>
            <a class="wbc-textlink" href="<?php echo esc_url(wbc_services_url()); ?>">All services</a>
        </div>
        <div class="wbc-stats">
            <?php foreach (wbc_default_stats() as $s => $stat) : ?>
                <div>
                    <strong><?php echo esc_html(wbc_mod('wbc_stat_' . $s . '_value', $stat['value'])); ?></strong>
                    <span><?php echo esc_html(wbc_mod('wbc_stat_' . $s . '_label', $stat['label'])); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="wbc-svc-tiles">
            <?php foreach ($services as $i => $service) : ?>
                <article>
                    <span><?php echo esc_html(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                    <h3><a href="<?php echo esc_url(get_permalink($service)); ?>"><?php echo esc_html(get_the_title($service)); ?></a></h3>
                    <p><?php echo esc_html(wbc_excerpt($service->ID, 22)); ?></p>
                </article>
            <?php endforeach; ?>
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
        <figure class="<?php echo wbc_slot_uses_video('editorial') ? 'is-embed' : ''; ?>">
            <?php wbc_render_band_media('editorial', array(
                'alt'      => 'Wedding design by ' . wbc_brand_name(),
                'fallback' => 'editorial',
            )); ?>
        </figure>
        <div>
            <p class="wbc-kicker"><?php echo esc_html(wbc_mod('wbc_editorial_kicker', 'Our promise')); ?></p>
            <h2><?php echo esc_html(wbc_mod('wbc_editorial_title', 'We coordinate so you can celebrate.')); ?></h2>
            <p class="wbc-answer"><?php echo esc_html(wbc_mod('wbc_editorial_text', 'Couples are asking for weddings that feel intentional, personal and immersive. This studio is built the same way.')); ?></p>
            <a class="wbc-textlink" href="<?php echo esc_url(wbc_contact_url()); ?>">Start an enquiry</a>
        </div>
    </section>

    <?php if ($more_quotes) : ?>
    <section class="wbc-section wbc-testimonials">
        <div class="wbc-section-head">
            <p class="wbc-kicker">From families</p>
            <h2>What remains after the music fades.</h2>
        </div>
        <div class="wbc-quote-grid">
            <?php foreach ($more_quotes as $quote) : ?>
                <article class="wbc-quote">
                    <p>“<?php echo esc_html(wp_strip_all_tags($quote->post_content)); ?>”</p>
                    <strong><?php echo esc_html(get_the_title($quote)); ?></strong>
                    <?php if (wbc_meta($quote->ID, 'wbc_event')) : ?><span><?php echo esc_html(wbc_meta($quote->ID, 'wbc_event')); ?></span><?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

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

<?php
get_header();
$weddings = wbc_get_ordered_posts('wbc_wedding', 6);
$services = wbc_get_ordered_posts('wbc_service', 8);
$destinations = wbc_get_ordered_posts('wbc_destination', 8);
$steps = wbc_get_ordered_posts('wbc_process', 6);
$press = wbc_get_ordered_posts('wbc_press', 6);
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
        <a class="wbc-scroll" href="#intro">Scroll to Explore</a>
    </section>

    <?php if ($press) : ?>
    <section class="wbc-seen">
        <p>As seen in</p>
        <div class="wbc-seen-mask" data-marquee>
            <div class="wbc-seen-run">
                <?php foreach ($press as $item) : ?>
                    <span><?php echo esc_html(wbc_meta($item->ID, 'wbc_publication', get_the_title($item))); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section id="intro" class="wbc-intro">
        <p class="wbc-kicker"><?php echo esc_html(wbc_mod('wbc_intro_kicker', 'Destination wedding planner in Udaipur, India')); ?></p>
        <h1 class="wbc-display"><?php echo esc_html(wbc_mod('wbc_intro_title', 'You want a wedding that feels elegant, effortless, and completely your own.')); ?></h1>
        <p class="wbc-answer"><?php echo esc_html(wbc_mod('wbc_intro_text', 'Chetan Parihar Weddings plans destination celebrations from Udaipur across Rajasthan, Gujarat, Goa and beyond. One team designs the rooms, holds the vendors, and stays on the ground until the last farewell.')); ?></p>
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
            <?php for ($s = 1; $s <= 4; $s++) : ?>
                <div>
                    <strong><?php echo esc_html(wbc_mod('wbc_stat_' . $s . '_value', $s === 1 ? '1' : '8+')); ?></strong>
                    <span><?php echo esc_html(wbc_mod('wbc_stat_' . $s . '_label', $s === 1 ? 'Team, end to end' : 'Cities planned')); ?></span>
                </div>
            <?php endfor; ?>
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

    <section class="wbc-frame">
        <div class="wbc-frame-inner">
            <div class="wbc-frame-media<?php echo wbc_slot_uses_video('process') ? ' is-embed' : ''; ?>" data-parallax>
                <?php wbc_render_band_media('process', array(
                    'alt'      => wbc_mod('wbc_process_kicker', 'A uniquely comprehensive process'),
                    'fallback' => 'process',
                )); ?>
            </div>
            <div class="wbc-frame-box">
                <p class="wbc-kicker is-light"><?php echo esc_html(wbc_mod('wbc_process_kicker', 'A uniquely comprehensive process')); ?></p>
                <h2><?php echo esc_html(wbc_mod('wbc_process_title', 'From the first story to the last farewell.')); ?></h2>
                <p><?php echo esc_html(wbc_mod('wbc_process_text', 'Impeccable logistics, inspired creative direction, and design held in-house — from story to soirée.')); ?></p>
            </div>
        </div>
    </section>

    <?php if ($steps) : ?>
    <section class="wbc-section wbc-process">
        <ol class="wbc-steps">
            <?php foreach ($steps as $step) : ?>
                <li>
                    <span><?php echo esc_html(wbc_meta($step->ID, 'wbc_step_label', 'STEP')); ?></span>
                    <h3><?php echo esc_html(get_the_title($step)); ?></h3>
                    <p><?php echo esc_html(wp_strip_all_tags($step->post_content)); ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </section>
    <?php endif; ?>

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
    <section class="wbc-section wbc-faq">
        <div class="wbc-section-head">
            <p class="wbc-kicker">Answers</p>
            <h2>Questions couples ask before they book.</h2>
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

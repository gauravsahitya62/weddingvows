<?php
get_header();
?>
<main id="content">
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $id = get_the_ID();
        wbc_render_page_band(array(
            'kicker'   => wbc_meta($id, 'wbc_service_kicker', 'Service'),
            'title'    => wbc_entry_headline($id),
            'lead'     => wbc_entry_intro($id, wbc_excerpt($id, 32)),
            'cta'      => 'Begin the conversation',
            'cta_url'  => wbc_contact_url(),
            'image'    => wbc_entry_cover($id, 'service-1'),
            'fallback' => 'service-1',
        ));
        ?>
        <article class="wbc-single">
            <div class="wbc-content"><?php the_content(); ?></div>
        <?php wbc_render_faq_list(wbc_service_faq_items($id), 'Questions about ' . get_the_title($id)); ?>
            <p class="wbc-center-link">
                <a class="wbc-textlink" href="<?php echo esc_url(wbc_services_url()); ?>">All services</a>
            </p>
        </article>
        <?php
        wbc_render_related_film(wbc_related_posts($id, 'wbc_service', 6), array(
            'kicker'   => 'Planning & design',
            'title'    => 'Other ways the studio holds a wedding.',
            'link'     => wbc_services_url(),
            'label'    => 'All services',
            'meta_key' => 'wbc_service_kicker',
            'fallback' => 'service-1',
        ));
        ?>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>

<?php
get_header();
?>
<main class="wcp-setup">
    <div>
        <h1><?php bloginfo('name'); ?></h1>
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php the_excerpt(); ?>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php esc_html_e('Local WordPress is running. Theme pages will be built from the approved reference images.', 'wcp'); ?></p>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();

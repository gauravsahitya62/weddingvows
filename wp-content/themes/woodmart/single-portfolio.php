<?php get_header(); ?>

<div class="wedding-gallery-single">
    <h1 class="title"><?php the_title(); ?></h1>

    <div class="gallery-lightbox">
        <?php if (have_rows('gallery_images')) :
            while (have_rows('gallery_images')) : the_row();
                $img = get_sub_field('image'); ?>
                <a href="<?php echo esc_url($img['url']); ?>" data-lightbox="gallery">
                    <img src="<?php echo esc_url($img['sizes']['medium']); ?>" alt="">
                </a>
            <?php endwhile;
        endif; ?>
    </div>
</div>

<?php get_footer(); ?>
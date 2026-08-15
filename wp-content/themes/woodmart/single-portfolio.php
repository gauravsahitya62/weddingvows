<?php
get_header();
if (wvn_elementor_editing()) :
    while (have_posts()) :
        the_post();
        ?>
<main id="content" class="wvn-page">
  <?php the_content(); ?>
</main>
        <?php
    endwhile;
    get_footer();
    return;
endif;
$id = get_the_ID();
$images = array();
$seen = array();
$thumb = get_the_post_thumbnail_url($id, 'full');
if ($thumb) {
    $images[] = $thumb;
    $seen[$thumb] = true;
}
$rows = function_exists('get_field') ? get_field('gallery_images', $id) : null;
if (is_array($rows)) {
    foreach ($rows as $row) {
        $url = wvn_image_url(is_array($row) ? ($row['image'] ?? $row) : $row, '');
        if ($url && empty($seen[$url])) {
            $seen[$url] = true;
            $images[] = $url;
        }
    }
}
if (!$images) {
    $images = wvn_gallery_images();
}
?>
<main id="content" class="wedding-gallery-single wvn-page">
  <p class="wvn-kicker wvn-center">Real wedding</p>
  <h1 class="title"><?php the_title(); ?></h1>
  <div class="wvn-mosaic">
    <?php foreach ($images as $image) : ?>
      <a href="<?php echo esc_url($image); ?>" data-wvn-lightbox>
        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
      </a>
    <?php endforeach; ?>
  </div>
</main>
<?php get_footer(); ?>

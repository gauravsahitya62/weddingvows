<?php
/* Block Name: Page Header */

$image = get_field('image');
$header_h1 = get_field('header');
$image_url = !empty($image) ? esc_url($image['url']) : get_theme_file_uri('/img/hero-city.jpg');
$image_alt = !empty($image) ? esc_attr($image['alt']) : 'Design Element';
$landing_page_about = 'about-skogman';
$landing_page_contact = 'contact-us';
?>

<?php if (!is_front_page() && !is_home() && !is_page($landing_page_about) && !is_page($landing_page_contact)){ ?>
        <section class="secondary-page page-hdr">
    <?php }else{?>
        <section class="page-hdr">
    <?php }; ?>
    <figure>
        <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
    </figure>
   
    <div class="content">
        <nav aria-label="breadcrumb">
            <?php if (function_exists('yoast_breadcrumb')) : ?>
                <?php yoast_breadcrumb('<ol class="breadcrumb-nav">', '</ol>'); ?>
            <?php endif; ?>
        </nav>
	<?php if ($header_h1) {
	    echo '<h1>' . $header_h1 . '</h1>';
        } else { ?>
            <h1><?php the_title(); ?></h1>
       <?php } ?>
        
    </div>
</section>

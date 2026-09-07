<!doctype html>
<html <?php language_attributes(); ?> data-theme="light">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f7f7f7">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="wbc-skip" href="#content">Skip to content</a>
<div class="wbc-progress" data-progress aria-hidden="true"></div>
<?php
$brand_parts = wbc_brand_parts();
$brand_line = $brand_parts[0] ?: wbc_brand_name();
$brand_script = $brand_parts[0] && $brand_parts[1] ? $brand_parts[1] : 'weddings';
?>
<header class="wbc-header" data-header>
    <a class="wbc-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(wbc_brand_name()); ?>">
        <?php if (wbc_logo_url()) : ?>
            <img src="<?php echo esc_url(wbc_logo_url()); ?>" alt="<?php echo esc_attr(wbc_brand_name()); ?>">
        <?php else : ?>
            <strong><?php echo esc_html($brand_line); ?></strong>
            <em><?php echo esc_html(strtolower($brand_script)); ?></em>
        <?php endif; ?>
    </a>
    <nav class="wbc-nav" id="site-nav" data-nav aria-label="<?php esc_attr_e('Primary navigation', 'weddingsbychetanparihar'); ?>">
        <?php foreach (wbc_header_nav_items() as $item) : ?>
            <?php
            $is_cta = !empty($item['script']);
            $classes = trim(($is_cta ? 'wbc-nav-cta ' : '') . (wbc_nav_is_active($item) ? 'is-active' : ''));
            ?>
            <?php if ($is_cta) : ?>
                <span class="wbc-nav-rule" aria-hidden="true"></span>
            <?php endif; ?>
            <a class="<?php echo esc_attr($classes); ?>" href="<?php echo esc_url($item['url']); ?>">
                <?php echo esc_html($is_cta ? 'Contact' : $item['label']); ?>
            </a>
        <?php endforeach; ?>
    </nav>
    <button class="wbc-menu" type="button" data-menu aria-expanded="false" aria-controls="site-nav" aria-label="Open menu">
        <span></span><span></span>
    </button>
</header>

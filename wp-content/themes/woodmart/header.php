<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-M74VGCHK');</script>
<!-- End Google Tag Manager -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    
</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M74VGCHK"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


    <header class="custom-header">
        <div class="container">
            <nav class="nav-container">
                <ul class="nav-left">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'left-menu',
                        'container' => false,
                        'items_wrap' => '%3$s', // removes extra ul wrapper
                        'depth' => 1
                    ]);
                    ?>
                </ul>

                <div class="logo">
                    <a href="<?php echo home_url(); ?>">
                        <img src="<?php echo get_theme_file_uri('/images/logo-bg-dark.png'); ?>" alt="Wedding Logo" />
                    </a>
                </div>
                <ul class="nav-right">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'right-menu',
                        'container' => false,
                        'items_wrap' => '%3$s',
                        'depth' => 1
                    ]);
                    ?>
                </ul>
                <div class="burger" id="burger">&#9776;</div> <!-- Burger Icon -->
            </nav>
            <div class="mobile-nav" id="mobile-nav">
                <ul>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'left-menu',
                        'container' => false,
                        'items_wrap' => '%3$s',
                        'depth' => 1
                    ]);
                    wp_nav_menu([
                        'theme_location' => 'right-menu',
                        'container' => false,
                        'items_wrap' => '%3$s',
                        'depth' => 1
                    ]);
                    ?>
                </ul>
            </div>

        </div>
    </header>
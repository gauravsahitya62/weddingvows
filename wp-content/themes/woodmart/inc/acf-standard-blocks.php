<?php

/* ACF Custom Block Registry  */
function hfm_acf_init_standard_blocks() {

    if ( function_exists( 'acf_register_block_type' ) ) {
        acf_register_block_type(
            array(
                'name'            => 'page-header',
                'title'           => 'Page Header',
                'description'     => 'A basic header with image, text, and breadcrumb',
                'render_template' => 'blocks/page-header.php',
                'category'        => 'custom',
                'icon'            => 'align-wide',
                'keywords'        => array( 'header', 'page' ),
                'mode'            => 'preview',
                'align'           => 'full',
                'supports'        => array(
                    'align'			=> true,
                    'anchor'		=> true,
                    'customClassName'	=> true,
                    'jsx' 			=> true,
               ),
            )
        );
        acf_register_block_type(
            array(
                'name'            => 'theme-image',
                'title'           => 'Theme Image',
                'description'     => 'Add branded images to your layouts',
                'render_template' => 'blocks/theme-image.php',
                'category'        => 'custom',
                'align'           => 'full',
                'icon'            => 'images-alt',
                'keywords'        => array( 'image', 'theme', 'img' ),
                'mode'            => 'preview',
                'supports'		=> [
                    'align'			=> true,
                    'anchor'		=> true,
                    'customClassName'	=> true,
                    'jsx' 			=> true,
                ]
            )
        );
        acf_register_block_type(
            array(
                'name'            => 'theme-cta',
                'title'           => 'Theme CTA',
                'description'     => 'Call to action for your layouts',
                'render_template' => 'blocks/theme-cta.php',
                'category'        => 'custom',
                'align'           => 'full',
                'icon'            => 'admin-comments',
                'keywords'        => array( 'call', 'theme', 'action' ),
                'mode'            => 'preview',
                'supports'		=> [
                    'align'			=> true,
                    'anchor'		=> true,
                    'customClassName'	=> true,
                    'jsx' 			=> true,
                ]
            )
        );
        acf_register_block_type(
            array(
                'name'            => 'theme-cards',
                'title'           => 'Theme Cards',
                'description'     => 'Add cards of every shape and size to your layouts',
                'render_template' => 'blocks/theme-cards.php',
                'category'        => 'custom',
                'align'           => 'full',
                'icon'            => 'admin-page',
                'keywords'        => array( 'cards', 'theme', 'card' ),
                'mode'            => 'preview',
                'supports'		=> [
                    'align'			=> true,
                    'anchor'		=> true,
                    'customClassName'	=> true,
                    'jsx' 			=> true,
                ]
            )
        );
        acf_register_block_type(
            array(
                'name'            => 'accordion',
                'title'           => 'Accordion',
                'description'     => 'Add expandable items to your layouts',
                'render_template' => 'blocks/accordion.php',
                'category'        => 'custom',
                'align'           => 'full',
                'icon'            => 'arrow-down-alt',
                'keywords'        => array( 'Accordion', 'expand' ),
                'mode'            => 'preview',
                'supports'		=> [
                    'align'			=> true,
                    'anchor'		=> true,
                    'customClassName'	=> true,
                    'jsx' 			=> true,
                ]
            )
        );

        acf_register_block_type(
            array(
                'name'            => 'hero',
                'title'           => 'Hero',
                'description'     => 'Page header with content and image area',
                'render_template' => 'blocks/hero.php',
                'category'        => 'custom',
                'align'           => 'full',
                'icon'            => 'superhero-alt',
                'keywords'        => array( 'Hero', 'header' ),
                'mode'            => 'preview',
                'supports'		=> [
                    'align'			=> true,
                    'anchor'		=> true,
                    'customClassName'	=> true,
                    'jsx' 			=> true,
                ]
            )
        );

        acf_register_block_type(
            array(
                'name'            => 'testimonials',
                'title'           => 'Testimonials',
                'description'     => 'List some great quotes on your website',
                'render_template' => 'blocks/testimonials.php',
                'enqueue_script'  => get_template_directory_uri() . '/js/swiper.min.js',
                'enqueue_style'   => get_template_directory_uri() . '/css/swiper.min.css',
                'category'        => 'theme',
                'icon'            => 'editor-quote',
                'keywords'        => array( 'quote', 'testimonial' ),
                'mode'            => 'preview',
                'supports'        => array(
                          'jsx'   => true,
               ),
            )
        );

        
        acf_register_block_type(
            array(
                'name'            => 'post list',
                'title'           => 'Post List',
                'description'     => 'List your posts within your page layouts',
                'render_template' => 'blocks/post-list.php',
                'category'        => 'theme',
                'icon'            => 'list-view',
                'keywords'        => array( 'post', 'blog', 'list' ),
                'mode'            => 'preview',
                'supports'        => array(
                          'jsx'   => true,
               ),
            )
        );
        
        acf_register_block_type(
            array(
                'name'            => 'sidebar-nav',
                'title'           => 'Sidebar Nav',
                'description'     => 'Display a list of child pages in a sidebar',
                'render_template' => 'blocks/sidebar-nav.php',
                'category'        => 'theme',
                'icon'            => 'menu',
                'keywords'        => array( 'sidebar', 'nav' ),
                'mode'            => 'preview',
                'align'           => 'full',
                'supports'        => array(
                    'align'			=> true,
                    'anchor'		=> true,
                    'customClassName'	=> true,
                    'jsx' 			=> true,
               ),
            )
        );
    }
}

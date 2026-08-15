<?php

/* ACF Custom Block Registry  */
function hfm_acf_init_custom_blocks() {

    if ( function_exists( 'acf_register_block_type' ) ) {



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
                'name'            => 'fullside-image',
                'title'           => 'Full Side Image',
                'description'     => 'Page header with content and image area',
                'render_template' => 'blocks/fullside-image.php',
                'category'        => 'custom',
                'align'           => 'full',
                'icon'            => 'superhero-alt',
                'keywords'        => array( 'Hero', 'header','Image' ),
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
                'name'            => 'image-slider',
                'title'           => 'Full Image slider',
                'description'     => 'Page header with content and image area',
                'render_template' => 'blocks/image-slider.php',
                'category'        => 'custom',
                'align'           => 'full',
                'icon'            => 'superhero-alt',
                'keywords'        => array( 'Hero', 'header','Image' ),
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
                'name'            => 'owl-slider',
                'title'           => 'Owl Card slider',
                'description'     => 'Owl carousel with content and image area',
                'render_template' => 'blocks/owl-carousel.php',
                'category'        => 'custom',
                'align'           => 'full',
                'icon'            => 'superhero-alt',
                'keywords'        => array( 'Hero', 'header','Image' ),
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
                'name'            => 'alternate-image',
                'title'           => 'Alternate Image with content',
                'description'     => 'Alternate image with content',
                'render_template' => 'blocks/alternate-image.php',
                'category'        => 'custom',
                'align'           => 'full',
                'icon'            => 'superhero-alt',
                'keywords'        => array( 'Hero', 'header','Image' ),
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
                'name'            => 'portfolio',
                'title'           => 'Portfolio',
                'description'     => 'Portfolio',
                'render_template' => 'blocks/portfolio.php',
                'category'        => 'custom',
                'align'           => 'full',
                'icon'            => 'superhero-alt',
                'keywords'        => array( 'Hero', 'header','Image' ),
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
                'name'            => 'social-block',
                'title'           => 'Social Block',
                'description'     => 'Social block',
                'render_template' => 'blocks/social-block.php',
                'category'        => 'custom',
                'align'           => 'full',
                'icon'            => 'superhero-alt',
                'keywords'        => array( 'Hero', 'header','Image' ),
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
                'name'            => 'coordinate',
                'title'           => 'Let us coordinate',
                'description'     => 'Let us coordinate block',
                'render_template' => 'blocks/coordinate.php',
                'category'        => 'custom',
                'align'           => 'full',
                'icon'            => 'superhero-alt',
                'keywords'        => array( 'Hero', 'header','Image' ),
                'mode'            => 'preview',
                'supports'		=> [
                    'align'			=> true,
                    'anchor'		=> true,
                    'customClassName'	=> true,
                    'jsx' 			=> true,
                ]
            )
        );
     

        
    }
}

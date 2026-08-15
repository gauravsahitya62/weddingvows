<?php 
/* Register Block Pattern */
function register_theme_patterns() {
    remove_theme_support( 'core-block-patterns' );
    register_block_pattern_category(
        'theme',
        array( 'label' => __( 'Theme', 'text-domain' ) )
    );
    register_block_pattern(
        'common/secondary_nav',
        array(
        'title'       => __( 'Secondary Nav', 'text-domain' ),
        'description' => _x( 'A basic page with header and column content. Great for starting a new page.', 'text-domain' ),
        'categories'  => array( 'theme' ),
        'content'     => '
        <!-- wp:acf/page-header {"name":"acf/page-header","data":{"image":"","_image":"field_65f20c6ac1ad1"},"align":"full","mode":"preview"} /-->

        <!-- wp:columns {"className":"is-style-large-gap"} -->
        <div class="wp-block-columns is-style-large-gap"><!-- wp:column -->
        <div class="wp-block-column"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
        <p class="is-style-eyebrow">use the eyebrow header</p>
        <!-- /wp:paragraph -->

        <!-- wp:heading -->
        <h2 class="wp-block-heading">Put Your Content in Headers to Help Users Scan Your Layouts</h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"className":"is-style-callout"} -->
        <p class="is-style-callout">Use the "lead" or "callout" style to help break up your content and make your text readable to visitors.</p>
        <!-- /wp:paragraph -->

        <!-- wp:paragraph -->
        <p>An has feugiat expetenda constituto, at legere efficiantur eum, vix causae instructior ut. Ea duo dignissim pertinacia, pro vidisse sensibus appellantur ex. Eam reque aliquid blandit no. An has feugiat expetenda constituto, at legere efficiantur eum, vix causae instructior ut. Ea duo dignissim pertinacia, pro vidisse sensibus appellantur ex. Eam reque aliquid blandit no.</p>
        <!-- /wp:paragraph --></div>
        <!-- /wp:column -->

        <!-- wp:column {"verticalAlignment":"top","width":"30%"} -->
        <div class="wp-block-column is-vertically-aligned-top" style="flex-basis:30%"><!-- wp:acf/sidebar-nav {"name":"acf/sidebar-nav","align":"full","mode":"preview"} /--></div>
        <!-- /wp:column --></div>
        <!-- /wp:columns -->
        ',
        )
    );
    
}
add_action( 'init', 'register_theme_patterns' );

?>
<?php
/* Add Styles to Paragraphs */
if ( function_exists( 'register_block_style' ) ) {

    /* PARAGRAPHS */
    register_block_style(
        'core/paragraph',
        array(
            'name'         => 'lead',
            'label'        => __( 'Lead', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.lead',
        ),
    );
    register_block_style(
        'core/paragraph',
        array(
            'name'         => 'eyebrow',
            'label'        => __( 'Eyebrow', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.eyebrow',
        ),
    );
    register_block_style(
        'core/paragraph',
        array(
            'name'         => 'max-width',
            'label'        => __( 'Max Width', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.max-width',
        ),
    );
    register_block_style(
        'core/heading',
        array(
            'name'         => 'max-width',
            'label'        => __( 'Max Width', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.max-width',
        ),
    );


    register_block_style(
        'core/cover',
        array(
            'name'         => 'margin-negative',
            'label'        => __( 'Bottom Overlap', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.is-style-margin-negative-bottom',
        ),
    );
    register_block_style(
        'core/group',
        array(
            'name'         => 'margin-negative',
            'label'        => __( 'Bottom Overlap', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.is-style-margin-negative-bottom',
        ),
    );
    register_block_style(
        'core/paragraph',
        array(
            'name'         => 'callout',
            'label'        => __( 'Callout', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.callout',
        ),
    );

    /* BUTTONS */
    register_block_style(
        'core/button',
        array(
            'name'         => 'btn-text',
            'label'        => __( 'Text Link', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.btn-text',
        ),
    );
    register_block_style(
        'core/button',
        array(
            'name'         => 'btn-secondary',
            'label'        => __( 'Secondary', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.btn-secondary',
        ),
    );
    /* Group BACKGROUNDS */
    register_block_style(
        'core/group',
        array(
            'name'         => 'bkg-dark',
            'label'        => __( 'Dark', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.bkg-dark',
        ),
    );
    register_block_style(
        'core/group',
        array(
            'name'         => 'bkg-accent',
            'label'        => __( 'Accent', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.bkg-accent',
        ),
    );
    register_block_style(
        'core/group',
        array(
            'name'         => 'bkg-light',
            'label'        => __( 'Light', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.bkg-light',
        ),
    );
    register_block_style(
        'core/group',
        array(
            'name'         => 'bkg-left',
            'label'        => __( 'Light Left', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.bkg-left',
        ),
    );
    register_block_style(
        'core/group',
        array(
            'name'         => 'bkg-right',
            'label'        => __( 'Light Right', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.bkg-right',
        ),
    );


    register_block_style(
        'core/group',
        array(
            'name'         => 'bkg-dark-left',
            'label'        => __( 'Dark Left', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.bkg-dark-left',
        ),
    );

    register_block_style(
        'core/group',
        array(
            'name'         => 'bkg-dark-right',
            'label'        => __( 'Dark Right', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.bkg-dark-right',
        ),
    );
    
    
    /* LIST STYLES */
    register_block_style(
        'core/list',
        array(
            'name'         => 'linklist',
            'label'        => __( 'Link List', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.is-style-linklist',
        ),
    );
    register_block_style(
        'core/list',
        array(
            'name'         => 'two-col',
            'label'        => __( 'Two Col', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.two-col',
        ),
    );
    /* COLUMNS */
    register_block_style(
        'core/columns',
        array(
            'name'         => 'small-margin',
            'label'        => __( 'Small Margin', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.small-margin',
        ),
    );
    register_block_style(
        'core/columns',
        array(
            'name'         => 'large-gap',
            'label'        => __( 'Large gap', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.large-gap',
        ),
    );
    register_block_style(
        'core/columns',
        array(
            'name'         => 'box',
            'label'        => __( 'Box', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.box',
        ),
    );
    register_block_style(
        'core/image',
        array(
            'name'         => 'theme-img',
            'label'        => __( 'Curved Corners', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.theme-img',
        ),
    );
    register_block_style(
        'core/image',
        array(
            'name'         => 'curved-corners-with-lines',
            'label'        => __( 'Curved Corners with Lines', 'textdomain' ),
            'is_default'   => false,
            'inline_style' => '.theme-img .lines',
        ),
    );
}

?>
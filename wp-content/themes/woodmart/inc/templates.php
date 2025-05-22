<?php
function theme_register_template() {
    $post_type_object = get_post_type_object( 'page' );
    $post_type_object->template = array( 
        array( 'core/pattern', array(
            'slug' => 'common/secondary_nav',
        ) )
    );
}
add_action( 'init', 'theme_register_template' );
?>
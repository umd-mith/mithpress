<?php

include_once WP_CONTENT_DIR . '/wpalchemy/MetaBox.php';
 
include_once WP_CONTENT_DIR . '/wpalchemy/MediaAccess.php';


// include css to help style our custom meta boxes
add_action( 'init', 'my_metabox_styles' );

function my_metabox_styles()
{
    if ( is_admin() ) 
    { 
        wp_enqueue_style( 'wpalchemy-metabox', get_stylesheet_directory_uri() . '/metaboxes/meta.css' );
    }
}

$wpalchemy_media_access = NEW WPAlchemy_MediaAccess();

/* eof */
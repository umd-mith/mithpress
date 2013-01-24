<?php

/* Podcast Post Type */
/*-------------------------------------------------------------------------------------------*/

add_action( 'init', 'register_cpt_podcast' );

function register_cpt_podcast() {

    $labels = array( 
        'name' => _x( 'Podcasts', 'podcast' ),
        'singular_name' => _x( 'Podcast', 'podcast' ),
        'add_new' => _x( 'Add New Podcast', 'podcast' ),
        'add_new_item' => _x( 'Add New Podcast', 'podcast' ),
        'edit_item' => _x( 'Edit Podcast', 'podcast' ),
        'new_item' => _x( 'New Podcast', 'podcast' ),
        'view_item' => _x( 'View Podcast', 'podcast' ),
        'search_items' => _x( 'Search Podcasts', 'podcast' ),
        'not_found' => _x( 'No podcasts found', 'podcast' ),
        'not_found_in_trash' => _x( 'No podcasts found in Trash', 'podcast' ),
        'menu_name' => _x( 'Podcasts', 'podcast' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'author', 'editor', 'thumbnail', 'revisions' ),
        'taxonomies' => array( 'podcast_categories', 'podcast_tags' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
		'menu_icon' => get_template_directory_uri() . '/admin/images/icon-podcasts.png',
        'menu_position' => 5,
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array('slug'=>'podcasts'),
        'capability_type' => 'post',
		
		'taxonomies' => array('category', 'post_tag')
    );

    register_post_type( 'podcast', $args );
}


/* Podcast Columns */
/*-------------------------------------------------------------------------------------------*/

add_filter( 'manage_edit-podcast_columns', 'register_podcast_columns' ) ;
add_action( 'manage_podcast_posts_custom_column', 'manage_podcast_columns', 10, 2 );

function register_podcast_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'date' => __('Date'),
		"title" => __('Title'),
		'speaker' => __('Speaker'),
		'vidurl' => __('Files')
	);

	return $columns;
}

function manage_podcast_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'speaker' :
			/* Get the post meta. */
			$speaker = get_post_meta( $post_id, 'speaker', true );

			/* If no title is found, output a default message. */
			if ( empty( $speaker ) )
				echo __( 'n/a' );

			else printf( $speaker );
			break;

		case 'vidurl' :
			/* Get the post meta. */
			$vidurl = get_post_meta( $post_id, 'vidurl', true );


			/* If nothing is found, output a default message. */
			if ( empty($vidurl) )
				echo __( '-- ');

			else printf( $vidurl );
			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}


/* Sortable Columns */
/*-------------------------------------------------------------------------------------------*/
add_filter('manage_edit-podcast_sortable_columns', 'register_podcast_sortable_columns');
function register_podcast_sortable_columns( ) {
  return array(
    'speaker'  => 'speaker',
	'affiliation' => 'affiliation',
	);
}
add_filter('request', 'handle_podcast_column_sorting');
function handle_podcast_column_sorting( $vars ){
  if( isset($vars['orderby']) && 'speaker' == $vars['orderby'] ){
    $vars = array_merge( $vars, array(
		'meta_key' => 'speaker',
		'orderby' => 'meta_value',
    ));
  }
  return $vars;
}


?>
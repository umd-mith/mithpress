<?php

/* Event Categories */
/*-------------------------------------------------------------------------------------------*/
add_action( 'init', 'register_taxonomy_event_type' );

function register_taxonomy_event_type() {

    $labels = array( 
        'name' => _x( 'Event Types', 'event type' ),
        'singular_name' => _x( 'Event Type', 'event type' ),
        'search_items' => _x( 'Search Event Types', 'event type' ),
        'popular_items' => _x( 'Popular Event Types', 'event type' ),
        'all_items' => _x( 'All Event Types', 'event type' ),
        'parent_item' => _x( 'Parent Event Type', 'event type' ),
        'parent_item_colon' => _x( 'Parent Event Type:', 'event type' ),
        'edit_item' => _x( 'Edit Event Type', 'event type' ),
        'update_item' => _x( 'Update Event Type', 'event type' ),
        'add_new_item' => _x( 'Add New Event Type', 'event type' ),
        'new_item_name' => _x( 'New Event Type Name', 'event type' ),
        'separate_items_with_commas' => _x( 'Separate event types with commas', 'event type' ),
        'add_or_remove_items' => _x( 'Add or remove event types', 'event type' ),
        'choose_from_most_used' => _x( 'Choose from the most used event types', 'event type' ),
        'menu_name' => _x( 'Event Types', 'event type' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,

        'rewrite' => true,
		'rewrite' => array(
			'slug' => 'event',
		)
    );

    register_taxonomy( 'event_type', array('event'), $args );
}


/* Event Post Type */
/*-------------------------------------------------------------------------------------------*/

add_action( 'init', 'register_cpt_event' );

function register_cpt_event() {

    $labels = array( 
        'name' => _x( 'Events', 'event' ),
        'singular_name' => _x( 'Event', 'event' ),
        'add_new' => _x( 'Add New', 'event' ),
        'add_new_item' => _x( 'Add New Event', 'event' ),
        'edit_item' => _x( 'Edit Event', 'event' ),
        'new_item' => _x( 'New Event', 'event' ),
        'view_item' => _x( 'View Event', 'event' ),
        'search_items' => _x( 'Search Events', 'event' ),
        'not_found' => _x( 'No events found', 'event' ),
        'not_found_in_trash' => _x( 'No events found in Trash', 'event' ),
        'parent_item_colon' => _x( 'Parent Event:', 'event' ),
        'menu_name' => _x( 'Events', 'event' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'featured image', 'thumbnail', 'revisions', 'custom-fields','author'),
        'taxonomies' => array( 'event_type', 'post_tag'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
		'menu_icon' => get_stylesheet_directory_uri() . '/admin/images/icon-events.png',  // Icon Path
        'menu_position' => 5,
        
		'show_in_nav_menus' => false,
        'publicly_queryable' => true,

        'rewrite' => array(
				'slug' => 'community/dh-events/event',
				'with_front' => false
		),

		'has_archive' => 'event',
        'query_var' => true,

		'exclude_from_search' => false,
        'can_export' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'event', $args );
}


/* Event Columns */
/*-------------------------------------------------------------------------------------------*/
add_filter( 'manage_edit-event_columns', 'edit_event_columns' ) ;

function edit_event_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'featured_thumbnail' => __('Thumbnail'),
		'title' => __( 'Name' ),
		'date_start' => __(' Event Date '),
		'event_type' => __( 'Type' ),
		'date' => __( 'Post Date' ),
		);

	return $columns;
}


// Add to admin_init function
add_action('manage_event_posts_custom_column', 'manage_event_columns', 10, 2);

function manage_event_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'event_date' column. */
		case 'date_start' :
			/* Get the post meta. */
			$event_date_raw = get_post_meta( $post_id, 'date_start', true );
			$event_date = date('l, F j, Y', strtotime($event_date_raw));      

			/* If nothing is found, output a default message. */
			if ( empty($event_date) )
				echo __( '-- ');

			else printf( $event_date );
			break;

		/* If displaying the 'event_type' column. */
		case 'event_type' :

			/* Get the event_types for the post. */
			$terms = get_the_terms( $post_id, 'event_type' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'event_type' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'event_type', 'display' ) )
					);
				}
				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}
			/* If no terms were found, output a default message. */
			else {
				_e( 'not assigned' );
			}
			break;
		case 'featured_thumbnail':
			if( function_exists('the_post_thumbnail') )
				echo the_post_thumbnail( 'horiz-thumbnail' );
			else
				echo '';
			break;

		default :
			break;
	}
}

/* Create Filter Dropdowns */
/*-----------------------------------------------------------------------------------*/
function add_event_taxonomy_filters() {
	global $typenow;
 
	// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
	$taxonomies = array('event_type');
 
	// must set this to the post type you want the filter(s) displayed on
	if( $typenow == 'event' ){
 
		foreach ($taxonomies as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			if(count($terms) > 0) {
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>Show All $tax_name</option>";
				foreach ($terms as $term) { 
					echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
				}
				echo "</select>";
			}
		}
	}
}
add_action( 'restrict_manage_posts', 'add_event_taxonomy_filters' );
?>
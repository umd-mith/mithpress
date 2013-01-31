<?php

/* People Categories */
/*-------------------------------------------------------------------------------------------*/
add_action( 'init', 'register_taxonomy_staffgroup' );

function register_taxonomy_staffgroup() {

    $labels = array( 
        'name' => _x( 'Staff Groups', 'staff group' ),
        'singular_name' => _x( 'Staff Group', 'staff group' ),
        'all_items' => _x( 'All Staff Groups', 'staff group' ),
        'parent_item' => _x( 'Parent Staff Group', 'staff group' ),
        'parent_item_colon' => _x( 'Parent Staff Group:', 'staff group' ),
        'edit_item' => _x( 'Edit Staff Group', 'staff group' ),
        'update_item' => _x( 'Update Staff Group', 'staff group' ),
        'add_new_item' => _x( 'Add New Staff Group', 'staff group' ),
        'new_item_name' => _x( 'New Staff Group Name', 'staff group' ),
        'separate_items_with_commas' => _x( 'Separate staff groups with commas', 'staff group' ),
        'add_or_remove_items' => _x( 'Add or remove staff groups', 'staff group' ),
        'choose_from_most_used' => _x( 'Choose from the most used staff groups', 'staff group' ),
        'menu_name' => _x( 'Staff Groups', 'staff group' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,

		'query_var' => true,
		'rewrite' => array(
			'slug' => 'people',
		)
    );

    register_taxonomy( 'staffgroup', array('people'), $args );
}


add_action( 'init', 'register_cpt_people' );


/* People Post Type */
/*-------------------------------------------------------------------------------------------*/
function register_cpt_people() {

    $peoplelabels = array( 
        'name' => _x( 'People', 'people' ),
        'singular_name' => _x( 'People', 'people' ),
        'add_new' => _x( 'Add New Person', 'people' ),
        'add_new_item' => _x( 'Add New Person', 'people' ),
        'edit_item' => _x( 'Edit Person', 'people' ),
        'new_item' => _x( 'New Person', 'people' ),
        'view_item' => _x( 'View Person', 'people' ),
        'search_items' => _x( 'Search People', 'people' ),
        'not_found' => _x( 'No people found', 'people' ),
        'not_found_in_trash' => _x( 'No people found in Trash', 'people' ),
        'menu_name' => _x( 'People', 'people' ),
    );

    $args = array( 
        'labels' => $peoplelabels,
        'hierarchical' => false,
        
        'supports' => array( 'featured image', 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', 'custom-fields'),
        'taxonomies' => array( 'tags', 'staffgroup' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
		'menu_icon' => get_template_directory_uri() . '/admin/images/icon-people.png',
        'menu_position' => 5,
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,

		'rewrite' => array (
			'slug' => 'people/person',
			'with_front' => false
		),
		
		'query_var' => true,
		'has_archive' => 'people',
		
        'exclude_from_search' => false,
        'can_export' => true,
        'capability_type' => 'post',		
		
    );

    register_post_type( 'people', $args );
}


/* People Columns */
/*-------------------------------------------------------------------------------------------*/

/* Menu Order Column */
function add_menu_order_column($header_text_columns) {
  $header_text_columns['menu_order'] = "Order";
  return $header_text_columns;
}
add_action('manage_edit-header_text_columns', 'add_menu_order_column');
 
 
/* Custom Columns */
add_filter( 'manage_edit-people_columns', 'register_people_columns' ) ;
add_action( 'manage_people_posts_custom_column', 'manage_people_columns', 10, 2 );

function register_people_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'person_thumbnail' => __('Photo'),
		'title' => __('Name'),
		'fname' => __('First'),
		'lname' => __('Last'),
		'stafftitle' => __( 'Title' ),
		'staffgroup' => __( 'Staff Group' ),
		'menu_order' => __( 'Sort Order' ),
	);

	return $columns;
}


function manage_people_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'fname' :
			/* Get the post meta. */
			$fname = get_post_meta( $post_id, 'fname', true );

			/* If no title is found, output a default message. */
			if ( empty( $fname ) )
				echo __( ' ' );

			else printf( $fname );
			break;

		case 'lname' :
			/* Get the post meta. */
			$lname = get_post_meta( $post_id, 'lname', true );

			/* If no title is found, output a default message. */
			if ( empty( $lname ) )
				echo __( ' ' );

			else printf( $lname );
			break;

		case 'pplsort' :
			/* Get the post meta. */
			$pplsort = get_post_meta( $post_id, 'pplsort', true );

			/* If no sort is found, output a default message. */
			if ( empty( $pplsort ) )
				echo __( 'none' );

			else printf( $pplsort );
			break;
	    
		case 'menu_order':
    		$order = $post->menu_order;
      		if ( empty( $order ) )
				echo __(' ');
			
			else printf( $order) ;
     		break;

		case 'stafftitle' :
			/* Get the post meta. */
			$stafftitle = get_post_meta( $post_id, 'stafftitle', true );

			/* If no title is found, output a default message. */
			if ( empty( $stafftitle ) )
				echo __( ' ' );

			else printf( $stafftitle );
			break;

		/* If displaying the 'staffgroup' column. */
		case 'staffgroup' :

			/* Get the staffgroups for the post. */
			$terms = get_the_terms( $post_id, 'staffgroup' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'staffgroup' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'staffgroup', 'display' ) )
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

		case 'person_thumbnail':
			$thumb =  get_the_post_thumbnail($page->ID, 'mini-thumbnail'); 
			if ( $thumb != '') {
				the_post_thumbnail( 'mini-thumbnail' );
			} elseif ( $thumb == '' ) { ?>
				<img src="<?php echo home_url(); ?>/wp-content/uploads/no-image-50x50.jpg">
            <?php }
			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}


/* Sortable Columns */
/*-------------------------------------------------------------------------------------------*/
add_filter('manage_edit-people_sortable_columns', 'register_people_sortable_columns');

function register_people_sortable_columns( ) {
  return array(
	'title' => 'name',
	'fname' => 'fname',
	'lname' => 'lname',
	'menu_order' => 'menu_order'
  );
}

add_filter('request', 'handle_people_column_sorting');
function handle_people_column_sorting( $vars ){
  if( isset($vars['orderby']) && 'fname' == $vars['orderby'] ){
    $vars = array_merge( $vars, array(
		'meta_key' => 'fname',
		'orderby' => 'meta_value',
    ));
  }
 elseif( isset($vars['orderby']) && 'lname' == $vars['orderby'] ){
    $vars = array_merge( $vars, array(
		'meta_key' => 'lname',
		'orderby' => 'meta_value',
    ));
  }
  return $vars;
}

/**
* make menu_order column sortable
*/
function order_column_register_sortable($columns){
  $columns['menu_order'] = 'menu_order';
  return $columns;
}
add_filter('manage_edit-header_text_sortable_columns','order_column_register_sortable');


/* Create Filter Dropdowns */
/*-----------------------------------------------------------------------------------*/
function add_people_taxonomy_filters() {
	global $typenow;
 
	// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
	$taxonomies = array('staffgroup');
 
	// must set this to the post type you want the filter(s) displayed on
	if( $typenow == 'people' ){
 
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
add_action( 'restrict_manage_posts', 'add_people_taxonomy_filters' );


?>
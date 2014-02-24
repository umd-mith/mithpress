<?php

/* Project Categories */
/*-------------------------------------------------------------------------------------------*/
function register_taxonomy_projecttype() {

    $labels = array( 
        'name' => _x( 'Project Types', 'project type' ),
        'singular_name' => _x( 'Project Type', 'project type' ),
        'search_items' => _x( 'Search Project Types', 'project type' ),
        'popular_items' => _x( 'Popular Project Types', 'project type' ),
        'all_items' => _x( 'All Project Types', 'project type' ),
        'parent_item' => _x( 'Parent Project Type', 'project type' ),
        'parent_item_colon' => _x( 'Parent Project Type:', 'project type' ),
        'edit_item' => _x( 'Edit Project Type', 'project type' ),
        'update_item' => _x( 'Update Project Type', 'project type' ),
        'add_new_item' => _x( 'Add New Project Type', 'project type' ),
        'new_item_name' => _x( 'New Project Type Name', 'project type' ),
        'separate_items_with_commas' => _x( 'Separate project types with commas', 'project type' ),
        'add_or_remove_items' => _x( 'Add or remove project types', 'project type' ),
        'choose_from_most_used' => _x( 'Choose from the most used project types', 'project type' ),
        'menu_name' => _x( 'Project Types', 'project type' ),
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
			'slug' => 'project',
		)
    );

    register_taxonomy( 'projecttype', array('project'), $args );
}

/* Research Tags */
/*-------------------------------------------------------------------------------------------*/
add_action( 'init', 'register_taxonomy_research_type' );

function register_taxonomy_research_type() {

    $labels = array( 
        'name' => _x( 'Research Types', 'research type' ),
        'singular_name' => _x( 'Research Type', 'research type' ),
        'search_items' => _x( 'Search Research Types', 'research type' ),
        'popular_items' => _x( 'Popular Research Types', 'research type' ),
        'all_items' => _x( 'All Research Types', 'research type' ),
        'parent_item' => _x( 'Parent Research Type', 'research type' ),
        'parent_item_colon' => _x( 'Parent Research Type:', 'research type' ),
        'edit_item' => _x( 'Edit Research Type', 'research type' ),
        'update_item' => _x( 'Update Research Type', 'research type' ),
        'add_new_item' => _x( 'Add New Research Type', 'research type' ),
        'new_item_name' => _x( 'New Research Type Name', 'research type' ),
        'separate_items_with_commas' => _x( 'Separate research types with commas', 'research type' ),
        'add_or_remove_items' => _x( 'Add or remove research types', 'research type' ),
        'choose_from_most_used' => _x( 'Choose from the most used research types', 'research type' ),
        'menu_name' => _x( 'Research Types', 'research type' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => false,

        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'research_type', array('project'), $args );
}

/* Project Post Type */
/*-------------------------------------------------------------------------------------------*/

add_action( 'init', 'register_cpt_project' );

function register_cpt_project() {

    $projectlabels = array( 
        'name' => _x( 'Projects', 'project' ),
        'singular_name' => _x( 'Project', 'project' ),
        'add_new' => _x( 'Add New Project', 'project' ),
        'add_new_item' => _x( 'Add New Project', 'project' ),
        'edit_item' => _x( 'Edit Project', 'project' ),
        'new_item' => _x( 'New Project', 'project' ),
        'view_item' => _x( 'View Project', 'project' ),
        'search_items' => _x( 'Search Projects', 'project' ),
        'not_found' => _x( 'No projects found', 'project' ),
        'not_found_in_trash' => _x( 'No projects found in Trash', 'project' ),
        'menu_name' => _x( 'Projects', 'project' ),
    );

    $args = array( 
        'labels' => $projectlabels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
        'taxonomies' => array( 'categories', 'tags' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
		'menu_icon' => get_stylesheet_directory_uri() . '/admin/images/icon-projects.png',
        'menu_position' => 5,
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
		'rewrite' => array (
			'slug' => 'research/project',
			'with_front' => false
		),
		'query_var' => true,
		'has_archive' => 'project',

		'exclude_from_search' => false,
        'can_export' => true,
        'capability_type' => 'post',
		
		'taxonomies' => array('projecttype', 'post_tag'),
		
    );

    register_post_type( 'project', $args );
}

add_action( 'init', 'register_taxonomy_projecttype' );


/* Project Columns */
/*-------------------------------------------------------------------------------------------*/
add_filter( 'manage_edit-project_columns', 'edit_project_columns' ) ;

function edit_project_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'featured_thumbnail' => __('Thumbnail'),
		'title' => __( 'Name' ),
		'projecttype' => __( 'Type' ),
		'tags' => __( 'Tags' ),
	);

	return $columns;
}


// Add to admin_init function
add_action('manage_project_posts_custom_column', 'manage_project_columns', 10, 2);

function manage_project_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'projecttype' column. */
		case 'projecttype' :

			/* Get the projecttypes for the post. */
			$terms = get_the_terms( $post_id, 'projecttype' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'projecttype' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'projecttype', 'display' ) )
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
function add_project_taxonomy_filters() {
	global $typenow;
 
	// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
	$taxonomies = array('projecttype');
 
	// must set this to the post type you want the filter(s) displayed on
	if( $typenow == 'project' ){
 
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
add_action( 'restrict_manage_posts', 'add_project_taxonomy_filters' );
?>
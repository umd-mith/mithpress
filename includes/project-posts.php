<?php
/* Research Types */
/*-------------------------------------------------------------------------------------------*/
add_action( 'init', 'register_taxonomy_mith_research_type' );
function register_taxonomy_mith_research_type() {

    $research_tax = array( 
        'name' => _x( 'Types', 'mith_research_type' ),
        'singular_name' => _x( 'Type', 'mith_research_type' ),
        'search_items' => _x( 'Search Types', 'mith_research_type' ),
        'popular_items' => _x( 'Popular Types', 'mith_research_type' ),
        'all_items' => _x( 'All Types', 'mith_research_type' ),
        'parent_item' => _x( 'Parent Type', 'mith_research_type' ),
        'parent_item_colon' => _x( 'Parent Type:', 'mith_research_type' ),
        'edit_item' => _x( 'Edit Type', 'mith_research_type' ),
        'update_item' => _x( 'Update Type', 'mith_research_type' ),
        'add_new_item' => _x( 'Add New Type', 'mith_research_type' ),
        'new_item_name' => _x( 'New Type', 'mith_research_type' ),
        'separate_items_with_commas' => _x( 'Separate Types with commas', 'mith_research_type' ),
        'add_or_remove_items' => _x( 'Add or remove Types', 'mith_research_type' ),
        'choose_from_most_used' => _x( 'Choose from most used Types', 'mith_research_type' ),
        'menu_name' => _x( 'Types', 'mith_research_type' ),
    );

    $research_tax_args = array( 
        'labels' => $research_tax,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => true,

        'rewrite' => array(
			'slug' => 'research-type',
		),
        'query_var' => true,
    );

    register_taxonomy( 'mith_research_type', array('mith_research', 'project'), $research_tax_args );
}

/* Research Sponsors */
/*-------------------------------------------------------------------------------------------*/
add_action( 'init', 'register_taxonomy_mith_research_sponsor' );

function register_taxonomy_mith_research_sponsor() {

    $labels = array( 
        'name' => _x( 'Sponsors', 'mith_research_sponsor' ),
        'singular_name' => _x( 'Sponsor', 'mith_research_sponsor' ),
        'search_items' => _x( 'Search Sponsors', 'mith_research_sponsor' ),
        'popular_items' => _x( 'Popular Sponsors', 'mith_research_sponsor' ),
        'all_items' => _x( 'All Sponsors', 'mith_research_sponsor' ),
        'parent_item' => _x( 'Parent Sponsor', 'mith_research_sponsor' ),
        'parent_item_colon' => _x( 'Parent Sponsor:', 'mith_research_sponsor' ),
        'edit_item' => _x( 'Edit Sponsor', 'mith_research_sponsor' ),
        'update_item' => _x( 'Update Sponsor', 'mith_research_sponsor' ),
        'add_new_item' => _x( 'Add New Sponsor', 'mith_research_sponsor' ),
        'new_item_name' => _x( 'New Sponsor', 'mith_research_sponsor' ),
        'separate_items_with_commas' => _x( 'Separate sponsors with commas', 'mith_research_sponsor' ),
        'add_or_remove_items' => _x( 'Add or remove Sponsors', 'mith_research_sponsor' ),
        'choose_from_most_used' => _x( 'Choose from most used Sponsors', 'mith_research_sponsor' ),
        'menu_name' => _x( 'Sponsors', 'mith_research_sponsor' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => false,
        'hierarchical' => false,

        'rewrite' => false,
        'query_var' => true
    );

    register_taxonomy( 'mith_research_sponsor', array('mith_research', 'project', 'podcast'), $args );
}


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

    $projectargs = array( 
        'labels' => $projectlabels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'excerpt','thumbnail', 'revisions', 'custom-fields' ),
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
		
		'taxonomies' => array('projecttype', 'mith_research_type','mith_research_topic','post_tag', 'mith_research_sponsor'),
		
    );

    register_post_type( 'project', $projectargs );
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
		//'projecttype' => __( 'Type' ),
		'mith_research_type' => __('Type'),
		'mith_topic' => __( 'Topic' ),
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
		case 'mith_research_type' :
			$terms = get_the_terms( $post_id, 'mith_research_type' );
			if ( !empty( $terms ) ) {
				$out = array();
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'mith_research_type' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'mith_research_type', 'display' ) )
					);
				}
				echo join( ', ', $out );
			}
			else {
				_e( '' );
			}
			break;
		case 'mith_topic' :
			$terms = get_the_terms( $post_id, 'mith_topic' );
			if ( !empty( $terms ) ) {
				$out = array();
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'mith_topic' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'mith_topic', 'display' ) )
					);
				}
				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}
			/* If no terms were found, output a default message. */
			else {
				_e( '' );
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


/*-------------------------------------------------------------------------------------------*/
/* TOPIC TAXONOMY */
/*-------------------------------------------------------------------------------------------*/

add_action( 'init', 'register_taxonomy_mith_topic' );
function register_taxonomy_mith_topic() {

    $research_tax = array( 
        'name' => _x( 'Topics', 'mith_topic' ),
        'singular_name' => _x( 'Topic', 'mith_topic' ),
        'search_items' => _x( 'Search Topics', 'mith_topic' ),
        'popular_items' => _x( 'Popular Topics', 'mith_topic' ),
        'all_items' => _x( 'All Topics', 'mith_topic' ),
        'parent_item' => _x( 'Parent Topic', 'mith_topic' ),
        'parent_item_colon' => _x( 'Parent Topic:', 'mith_topic' ),
        'edit_item' => _x( 'Edit Topic', 'mith_topic' ),
        'update_item' => _x( 'Update Topic', 'mith_topic' ),
        'add_new_item' => _x( 'Add New Topic', 'mith_topic' ),
        'new_item_name' => _x( 'New Topic', 'mith_topic' ),
        'separate_items_with_commas' => _x( 'Separate Topics with commas', 'mith_topic' ),
        'add_or_remove_items' => _x( 'Add or remove Topics', 'mith_topic' ),
        'choose_from_most_used' => _x( 'Choose from most used Topics', 'mith_topic' ),
        'menu_name' => _x( 'Topics', 'mith_topic' ),
    );

    $research_tax_args = array( 
        'labels' => $research_tax,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'show_admin_column' => true,
        'hierarchical' => true,

        'rewrite' => array(
			'slug' => 'topic',
		),
        'query_var' => true,
    );

    register_taxonomy( 'mith_topic', array('mith_research','mith_dialogue','project', 'post', 'podcast'), $research_tax_args );
}
?>
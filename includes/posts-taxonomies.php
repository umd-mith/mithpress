<?php 
/*
  CUSTOM POST TYPES & TAXONOMIES	---------------------------------------------------
*/

/*-------------------------------------------------------------------------------------------*/
/* Research */
/*-------------------------------------------------------------------------------------------*/

/* Research Post Type */
/*-------------------------------------------------------------------------------------------*/
add_action( 'init', 'register_cpt_mith_research' );
function register_cpt_mith_research() {

    $cpt_research = array( 
        'name' => _x( 'Research', 'mith_research' ),
        'singular_name' => _x( 'Research Item', 'mith_research' ),
        'add_new' => _x( 'Add New', 'mith_research' ),
        'add_new_item' => _x( 'Add New Research Item', 'mith_research' ),
        'edit_item' => _x( 'Edit Research', 'mith_research' ),
        'new_item' => _x( 'New Research Item', 'mith_research' ),
        'view_item' => _x( 'View Research Item', 'mith_research' ),
        'search_items' => _x( 'Search Research Items', 'mith_research' ),
        'not_found' => _x( 'No items found', 'mith_research' ),
        'not_found_in_trash' => _x( 'No items found in Trash', 'mith_research' ),
        'parent_item_colon' => _x( 'Parent Research Item:', 'mith_research' ),
        'menu_name' => _x( 'Research Items', 'mith_research' ),
    );

    $research_args = array( 
        'labels' => $cpt_research,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'mith_research_type', 'mith_partner', 'mith_research_sponsor', 'post_tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
		'menu_icon' => 'dashicons-screenoptions',
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 
            'slug' => 'research', 
            'with_front' => true,
        ),
        'capability_type' => 'post'
    );

    register_post_type( 'mith_research', $research_args );
}

/* Research Types */
/*-------------------------------------------------------------------------------------------*/
add_action( 'init', 'register_taxonomy_mith_research_type' );
function register_taxonomy_mith_research_type() {

    $research_tax = array( 
        'name' => _x( 'Research Types', 'mith_research_type' ),
        'singular_name' => _x( 'Research Type', 'mith_research_type' ),
        'search_items' => _x( 'Search Research Types', 'mith_research_type' ),
        'popular_items' => _x( 'Popular Research Types', 'mith_research_type' ),
        'all_items' => _x( 'All Research Types', 'mith_research_type' ),
        'parent_item' => _x( 'Parent Research Type', 'mith_research_type' ),
        'parent_item_colon' => _x( 'Parent Research Type:', 'mith_research_type' ),
        'edit_item' => _x( 'Edit Research Type', 'mith_research_type' ),
        'update_item' => _x( 'Update Research Type', 'mith_research_type' ),
        'add_new_item' => _x( 'Add New Research Type', 'mith_research_type' ),
        'new_item_name' => _x( 'New Research Type', 'mith_research_type' ),
        'separate_items_with_commas' => _x( 'Separate Research Types with commas', 'mith_research_type' ),
        'add_or_remove_items' => _x( 'Add or remove Research Types', 'mith_research_type' ),
        'choose_from_most_used' => _x( 'Choose from most used Research Types', 'mith_research_type' ),
        'menu_name' => _x( 'Research Types', 'mith_research_type' ),
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

    register_taxonomy( 'mith_research_type', array('mith_research'), $research_tax_args );
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

    register_taxonomy( 'mith_research_sponsor', array('mith_research'), $args );
}

/* Research Columns */
/*-------------------------------------------------------------------------------------------*/
add_filter( 'manage_edit-mith_research_columns', 'edit_mith_research_columns' ) ;
function edit_mith_research_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'featured_thumbnail' => __('Thumbnail', 'Avada' ),
		'title' => __( 'Name', 'Avada' ),
		'mith_research_type' => __( 'Type', 'Avada' ),
		'mith_topic' => __( 'Topic', 'Avada' ),
		'research_start_yr' => __('Start Year', 'Avada' ),
		'tags' => __( 'Tags', 'Avada' ),
		'mith_research_sponsors' => __('Sponsors', 'Avada')
	);
	return $columns;
}
// Add to admin_init function
add_action('manage_mith_research_posts_custom_column', 'manage_mith_research_columns', 10, 2);

function manage_mith_research_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case 'research_start_yr' :
			if ( get_post_meta( $post_id, 'research_start_yr', true) )
			echo ( get_post_meta( $post_id, 'research_start_yr', true)); 
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
		case 'mith_research_sponsors' :
			$terms = get_the_terms( $post_id, 'mith_research_sponsors' );
			if ( !empty( $terms ) ) {
				$out = array();
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'mith_research_sponsors' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'mith_research_sponsors', 'display' ) )
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
				echo the_post_thumbnail( 'recent-works-thumbnail' );
			else
				echo '';
			break;
		default :
			break;
	}
}



/* Sortable Columns */
/*-------------------------------------------------------------------------------------------*/

add_filter('manage_edit-mith_research_sortable_columns', 'register_mith_research_sortable_columns');
function register_mith_research_sortable_columns( ) {
  return array(
	'title' => 'name',
	'research_start_yr' => 'research_start_yr',
  );
}

add_filter('request', 'handle_mith_research_column_sorting');
function handle_mith_research_column_sorting( $vars ){
  if( isset($vars['orderby']) && 'research_start_yr' == $vars['orderby'] ){
    $vars = array_merge( $vars, array(
		'meta_key' => 'research_start_yr',
		'orderby' => 'meta_value_num',
    ));
  }
  return $vars;
}


/*-------------------------------------------------------------------------------------------*/
/* People */
/*-------------------------------------------------------------------------------------------*/

/* Staff Group Taxonomy */
/*-------------------------------------------------------------------------------------------*/

add_action( 'init', 'register_taxonomy_mith_staff_group' );

function register_taxonomy_mith_staff_group() {

    $ppl_tax = array( 
        'name' => _x( 'Staff Groups', 'mith_staff_group' ),
        'singular_name' => _x( 'Staff Group', 'mith_staff_group' ),
        'search_items' => _x( 'Search Staff Groups', 'mith_staff_group' ),
        'popular_items' => _x( 'Popular Staff Groups', 'mith_staff_group' ),
        'all_items' => _x( 'All Staff Groups', 'mith_staff_group' ),
        'parent_item' => _x( 'Parent Staff Group', 'mith_staff_group' ),
        'parent_item_colon' => _x( 'Parent Staff Group:', 'mith_staff_group' ),
        'edit_item' => _x( 'Edit Staff Group', 'mith_staff_group' ),
        'update_item' => _x( 'Update Staff Group', 'mith_staff_group' ),
        'add_new_item' => _x( 'Add New Staff Group', 'mith_staff_group' ),
        'new_item_name' => _x( 'New Staff Group', 'mith_staff_group' ),
        'separate_items_with_commas' => _x( 'Separate Staff Groups with commas', 'mith_staff_group' ),
        'add_or_remove_items' => _x( 'Add or remove Staff Groups', 'mith_staff_group' ),
        'choose_from_most_used' => _x( 'Choose from most used Staff Groups', 'mith_staff_group' ),
        'menu_name' => _x( 'Staff Groups', 'mith_staff_group' ),
    );

    $ptax_args = array( 
        'labels' => $ppl_tax,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => true,

        'rewrite' => array(
        	'slug' => 'people',
        ),
        'query_var' => true
    );

    register_taxonomy( 'mith_staff_group', array('mith_person'), $ptax_args );
}

/* People Post Type */
/*-------------------------------------------------------------------------------------------*/

add_action( 'init', 'register_cpt_mith_person' );

function register_cpt_mith_person() {

    $cpt_person = array( 
        'name' => _x( 'People', 'mith_person' ),
        'singular_name' => _x( 'Person', 'mith_person' ),
        'add_new' => _x( 'Add New', 'mith_person' ),
        'add_new_item' => _x( 'Add New Person', 'mith_person' ),
        'edit_item' => _x( 'Edit Person', 'mith_person' ),
        'new_item' => _x( 'New Person', 'mith_person' ),
        'view_item' => _x( 'View Person', 'mith_person' ),
        'search_items' => _x( 'Search People', 'mith_person' ),
        'not_found' => _x( 'No people found', 'mith_person' ),
        'not_found_in_trash' => _x( 'No people found in Trash', 'mith_person' ),
        'parent_item_colon' => _x( 'Parent Person:', 'mith_person' ),
        'menu_name' => _x( 'People', 'mith_person' ),
    );

    $person_args = array( 
        'labels' => $cpt_person,
        'hierarchical' => false,
        
        'supports' => array( 'featured_image', 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'post_tag', 'mith_staff_group' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
		'menu_icon' => 'dashicons-groups',
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => 'people',
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 
            'slug' => 'people/person', 
            'with_front' => false,
            'feeds' => false,
            'pages' => false
        ),
        'capability_type' => 'post'
    );

    register_post_type( 'mith_person', $person_args );
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
add_filter( 'manage_edit-mith_person_columns', 'register_mith_person_columns' ) ;
add_action( 'manage_mith_person_posts_custom_column', 'manage_mith_person_columns', 10, 2 );
function register_mith_person_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'person_thumbnail' => __('Photo'),
		'title' => __('Name'),
		'first_name' => __('First'),
		'last_name' => __('Last'),
		'person_title' => __( 'Title' ),
		'mith_staff_group' => __( 'Staff Group' ),
		'menu_order' => __( 'Sort Order' ),
	);
	return $columns;
}
function manage_mith_person_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case 'first_name' :
			/* Get the post meta. */
			$first_name = get_post_meta( $post_id, 'first_name', true );
			/* If no title is found, output a default message. */
			if ( empty( $first_name ) )
				echo __( ' ' );
			else printf( $first_name );
			break;
		case 'last_name' :
			/* Get the post meta. */
			$last_name = get_post_meta( $post_id, 'last_name', true );
			/* If no title is found, output a default message. */
			if ( empty( $last_name ) )
				echo __( ' ' );
			else printf( $last_name );
			break;
		case 'ppl_sort' :
			/* Get the post meta. */
			$ppl_sort = get_post_meta( $post_id, 'ppl_sort', true );
			/* If no sort is found, output a default message. */
			if ( empty( $ppl_sort ) )
				echo __( 'none' );
			else printf( $ppl_sort );
			break;
		case 'menu_order':
    		$order = $post->menu_order;
      		if ( empty( $order ) )
				echo __(' ');
			
			else printf( $order) ;
     		break;
		case 'person_title' :
			/* Get the post meta. */
			$person_title = get_post_meta( $post_id, 'person_title', true );
			/* If no title is found, output a default message. */
			if ( empty( $person_title ) )
				echo __( ' ' );
			else printf( $person_title );
			break;
		/* If displaying the 'mith_staff_group' column. */
		case 'mith_staff_group' :
			/* Get the mith_staff_group for the post. */
			$terms = get_the_terms( $post_id, 'mith_staff_group' );
			/* If terms were found. */
			if ( !empty( $terms ) ) {
				$out = array();
				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'mith_staff_group' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'mith_staff_group', 'display' ) )
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
			$thumb =  get_the_post_thumbnail($post_id, 'mini-thumbnail'); 
			if ( $thumb != '') {
				the_post_thumbnail( 'recent-works-thumbnail' );
			} elseif ( $thumb == '' ) { ?>
				<img src="<?php echo get_template_directory_uri() ?>/images/no-image-50x50.jpg">
            <?php }
			break;
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

/* Sortable Columns */
/*-------------------------------------------------------------------------------------------*/

add_filter('manage_edit-mith_person_sortable_columns', 'register_mith_person_sortable_columns');
function register_mith_person_sortable_columns( ) {
  return array(
	'title' => 'name',
	'first_name' => 'first_name',
	'last_name' => 'last_name',
	'menu_order' => 'menu_order'
  );
}

add_filter('request', 'handle_mith_person_column_sorting');
function handle_mith_person_column_sorting( $vars ){
  if( isset($vars['orderby']) && 'first_name' == $vars['orderby'] ){
    $vars = array_merge( $vars, array(
		'meta_key' => 'first_name',
		'orderby' => 'meta_value',
    ));
  }
 elseif( isset($vars['orderby']) && 'last_name' == $vars['orderby'] ){
    $vars = array_merge( $vars, array(
		'meta_key' => 'last_name',
		'orderby' => 'meta_value',
    ));
  }
  return $vars;
}

/* Make menu_order Column Sortable */

function order_column_register_sortable($columns){
  $columns['menu_order'] = 'menu_order';
  return $columns;
}
add_filter('manage_edit-header_text_sortable_columns','order_column_register_sortable');

/* Create Filter Dropdowns */
/*-----------------------------------------------------------------------------------*/
function add_mith_person_taxonomy_filters() {
	global $typenow;
 
	// an array of all the taxonomies you want to display. Use the taxonomy name or slug
	$taxonomies = array('mith_staff_group');
 
	// must set this to the post type you want the filter(s) displayed on
	if( $typenow == 'mith_person' ){
 
		foreach ($taxonomies as $tax_slug) {
			$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			if(count($terms) > 0) {
				echo "<select name='" . $tax_slug . "' id='" . $tax_slug . "' class='postform'>";
				echo "<option value=''>Show All " . $tax_name . "</option>";
				foreach ($terms as $term) { 
					echo '<option value='. $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>';
					echo $term->name .' (' . $term->count .')</option>'; 
				}
				echo "</select>";
			}
		}
	}
}
add_action( 'restrict_manage_posts', 'add_mith_person_taxonomy_filters' );

/*-------------------------------------------------------------------------------------------*/
/* Dialogues */
/*-------------------------------------------------------------------------------------------*/

/* Dialogue Series Taxonomy */
/*-------------------------------------------------------------------------------------------*/

add_action( 'init', 'register_taxonomy_mith_dialogue_series' );
function register_taxonomy_mith_dialogue_series() {
    $pcast_tax = array( 
        'name' => _x( 'Dialogue Series', 'mith_dialogue_series' ),
        'singular_name' => _x( 'Dialogue Series', 'mith_dialogue_series' ),
        'all_items' => _x( 'All Dialogue Series', 'mith_dialogue_series' ),
        'parent_item' => _x( 'Parent Dialogue Series', 'mith_dialogue_series' ),
        'parent_item_colon' => _x( 'Parent Dialogue Series:', 'mith_dialogue_series' ),
        'edit_item' => _x( 'Edit Dialogue Series', 'mith_dialogue_series' ),
        'update_item' => _x( 'Update Dialogue Series', 'mith_dialogue_series' ),
        'add_new_item' => _x( 'Add New Dialogue Series', 'mith_dialogue_series' ),
        'new_item_name' => _x( 'New Dialogue Series', 'mith_dialogue_series' ),
        'separate_items_with_commas' => _x( 'Separate dialogue series with commas', 'mith_dialogue_series' ),
        'add_or_remove_items' => _x( 'Add or remove dialogue series', 'mith_dialogue_series' ),
        'choose_from_most_used' => _x( 'Choose from the most used dialogue series', 'mith_dialogue_series' ),
        'menu_name' => _x( 'Series', 'mith_dialogue_series' ),
    );
    $args = array( 
        'labels' => $pcast_tax,
        'public' => true,
        'show_in_nav_menus' => true,
		'publicly_queryable' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => false,
		'query_var' => true,
		'rewrite' => true
    );
    register_taxonomy( 'mith_dialogue_series', array('mith_dialogue'), $args );
}

/* Dialogue Post Type */
/*-------------------------------------------------------------------------------------------*/

add_action( 'init', 'register_cpt_mith_dialogue' );
function register_cpt_mith_dialogue() {
    $pcast_cpt = array( 
        'name' => _x( 'Dialogues', 'mith_dialogue' ),
        'singular_name' => _x( 'Dialogue', 'mith_dialogue' ),
        'add_new' => _x( 'Add New Dialogue', 'mith_dialogue' ),
        'add_new_item' => _x( 'Add New Dialogue', 'mith_dialogue' ),
        'edit_item' => _x( 'Edit Dialogue', 'mith_dialogue' ),
        'new_item' => _x( 'New Dialogue', 'mith_dialogue' ),
        'view_item' => _x( 'View Dialogue', 'mith_dialogue' ),
        'search_items' => _x( 'Search Dialogues', 'mith_dialogue' ),
        'not_found' => _x( 'No dialogues found', 'mith_dialogue' ),
        'not_found_in_trash' => _x( 'No dialogues found in Trash', 'mith_dialogue' ),
        'menu_name' => _x( 'Dialogues', 'mith_dialogue' ),
    );
    $args = array( 
        'labels' => $pcast_cpt,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'author', 'editor', 'thumbnail', 'revisions', 'custom-fields','excerpt' ),
        'taxonomies' => array( 'mith_dialogue_categories', 'mith_dialogue_tags' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
		'menu_icon' => 'dashicons-format-chat',
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'rewrite' => array(
			'slug'=>'dialogues',
			'with_front' => true
		),
        'has_archive' => 'digital-dialogues/dialogues',
        'query_var' => true,
        'can_export' => true,
        'capability_type' => 'post',
		
		'taxonomies' => array('mith_dialogue_series','category', 'post_tag')
    );
    register_post_type( 'mith_dialogue', $args );
}

/* Dialogue Columns */
/*-------------------------------------------------------------------------------------------*/

add_filter( 'manage_edit-mith_dialogue_columns', 'register_mith_dialogue_columns' ) ;
add_action( 'manage_mith_dialogue_posts_custom_column', 'manage_mith_dialogue_columns', 10, 2 );

function register_mith_dialogue_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'date' => __('Date'),
		'dd_series' => __('Series'),
		'title' => __('Title'),
		'dd_speaker' => __('Speaker'),
		'dd_speaker_aff' => __('Affiliation'),
		'dd_file_url' => __('Files')
	);
	return $columns;
}

function manage_mith_dialogue_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		case 'dd_speaker' :
			/* Get the post meta. */
			$speaker = get_post_meta( $post_id, 'dialogue_speakers_0_dialogue_speaker_name', true );
			$speaker_title = get_post_meta( $post_id, 'dialogue_speakers_0_dialogue_speaker_title', true );
			$speaker_affiliation = get_post_meta( $post_id, 'dialogue_speakers_0_dialogue_speaker_affiliation', true );
			/* If no title is found, output a default message. */
			if ( empty( $speaker ) )
				echo __( 'n/a' );
			else printf( $speaker . ', ' . $speaker_title );
			break;
		case 'dd_speaker_aff' :
			$speaker_affiliation = get_post_meta( $post_id, 'dialogue_speakers_0_dialogue_speaker_affiliation', true );
			if ( empty ( $speaker_affiliation ) )
				echo __( 'n/a' );
			else printf( $speaker_affiliation );
			break; 
		case 'dd_file_url' :
			/* Get the post meta. */
			$file_url = get_post_meta( $post_id, 'dialogue_files_0_dialogue_file_url', true );
			
			/* If nothing is found, output a default message. */
			if ( empty($file_url) )
				echo __( '-- ');
			else printf( $file_url );
			break;
		case 'dd_series' :
			/* Get the mith_dialogue_seriess for the post. */
			$terms = get_the_terms( $post_id, 'mith_dialogue_series' );
			/* If terms were found. */
			if ( !empty( $terms ) ) {
				$out = array();
				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'mith_dialogue_series' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'mith_dialogue_series', 'display' ) )
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
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

/* Dialogue Sortable Columns */
/*-------------------------------------------------------------------------------------------*/

add_filter('manage_edit-mith_dialogue_sortable_columns', 'register_mith_dialogue_sortable_columns');

function register_mith_dialogue_sortable_columns( ) {
  return array(
    'dd_speaker'  => 'dialogue_speaker_name',
	'dd_affiliation' => 'dialogue_speaker_affiliation',
	);
}

add_filter('request', 'handle_mith_dialogue_column_sorting');

function handle_mith_dialogue_column_sorting( $vars ){
  if( isset($vars['orderby']) && 'dd_speaker' == $vars['orderby'] ){
    $vars = array_merge( $vars, array(
		'meta_key' => 'dialogue_speakers_0_dialogue_speaker_name',
		'orderby' => 'meta_value',
    ));
  }
  return $vars;
}

/* Create Dialogue Filter Dropdowns */
/*-----------------------------------------------------------------------------------*/

function add_mith_dialogue_taxonomy_filters() {
	global $typenow;
 
	// an array of all the taxonomies you want to display. Use the taxonomy name or slug
	$taxonomies = array('mith_dialogue_series');
 
	// must set this to the post type you want the filter(s) displayed on
	if( $typenow == 'mith_dialogue' ){
 
		foreach ($taxonomies as $tax_slug) {
			$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			if(count($terms) > 0) {
				echo "<select name='" . $tax_slug . "' id='" . $tax_slug . "' class='postform'>";
				echo "<option value=''>Show All " . $tax_name . "</option>";
				foreach ($terms as $term) { 
					echo '<option value='. $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>';
					echo $term->name .' (' . $term->count .')</option>'; 
				}
				echo "</select>";
			}
		}
	}
}
add_action( 'restrict_manage_posts', 'add_mith_dialogue_taxonomy_filters' );

/* Dialogue Details Snippet Function */
/*-----------------------------------------------------------------------------------*/

function mith_dialogue_info_snippet() {
	global $post;
	
	$dialogue_speakers = get_field('dialogue_speakers', get_the_ID());
	
	if( get_field('dialogue_speakers') ) :
	$i = 0;
	$count = $dialogue_speakers;
					
	while(has_sub_field('dialogue_speakers')) :
		// get speaker metadata
		$speaker_name = get_sub_field('dialogue_speaker_name', get_the_ID());
		$speaker_title = get_sub_field('dialogue_speaker_title', get_the_ID());
		$speaker_affiliation = get_sub_field('dialogue_speaker_affiliation', get_the_ID());
		$speaker_website = get_sub_field('speaker_website');
		$speaker_twitter = get_sub_field('twitter_handle', get_the_ID());
		if ($speaker_title != '') {
			$speaker_t = ', <span class="post-stitle">' . $speaker_title . '</span>';
		}
		
		$speaker_info = '<span class="post-speaker">' . $speaker_name;
		$speaker_info .= $speaker_t . '</span>';
		$speaker_info .= '<span class="post-affiliation">' . $speaker_affiliation . '</span>';
		
		if ( $speaker_twitter != '') { 
			$speaker_info .='<span class="post-twitter"><a href="http://www.twitter.com/' . $speaker_twitter .'" rel="nofollow" target="_blank">@' .$speaker_twitter .'</a></span>';
		}
		if ( $speaker_website != '') { 
			$speaker_info .='<span class="post-website"><a href="http://' . $speaker_website .'" rel="nofollow" target="_blank">' .$speaker_website .'</a></span>';
		}
		
	$i++; 
	endwhile; endif; 
	
	// get remaining metadata
	$date_raw = get_post_meta( get_the_ID(), 'dialogue_date', TRUE);
	$time = get_post_meta( get_the_ID(), 'dialogue_time', TRUE);
	$location = get_post_meta( get_the_ID(), 'dialogue_location', TRUE); 
	$sponsor = get_post_meta( get_the_ID(), 'dialogue_sponsors', TRUE );
	$dialogue_details = '<section class="dialogue-details">';
	$dialogue_details .= '<span class="info-location">';
	if ($location != '') { 
		$dialogue_details .= $location; 
	} else { 
		$dialogue_details .= 'MITH Conference Room';
	}
	$dialogue_details .= '</span>';
	
	$dialogue_details .= '<span class="info-dates">';
	if ($date_raw != '') { $date = date('l, F j, Y', strtotime($date_raw)); } 
    elseif ( get_post_meta(get_the_ID(), 'talk-date', TRUE) != '') { $date = get_post_meta(get_the_ID(), 'talk-date', TRUE); } 
    else { $date = the_date( 'l, F j, Y' ); } 
	$dialogue_details .= $date;
	$dialogue_details .= '</span>';
	if ($time != '') { 
		$dialogue_details .='<span class="info-times">' . $time . '</span>'; 
	}
	if ($sponsor != '') {
		$dialogue_details .= '<span class="post-sponsor">' . $sponsor . '</span>';
	}
	$dialogue_details .= '</section>';
	
	$dialogue_info = $speaker_info; 
	$dialogue_info .= $dialogue_details;
	
return $dialogue_info; 
}

/* Add Shortlink to Dialogue Posts */
/*-----------------------------------------------------------------------------------*/

add_filter( 'pre_get_shortlink', 'mithpress_shortlinks_for_dialogue', 10, 3 );

function mithpress_shortlinks_for_dialogue( $shortlink, $id, $context ) {
     $post_id = 0;
	 
    if ( 'query' == $context && is_singular( 'mith_dialogue' ) ) { 
        // If context is query use current queried object for ID
        $post_id = get_queried_object_id();
    }
    elseif ( 'post' == $context ) {
        // If context is post use the passed $id
        $post_id = $id;
    }
    // Only do something if mith_dialogue post type
    if ( 'mith_dialogue' == get_post_type( $post_id ) ) {
        $shortlink = home_url( '?p=' . $post_id );
    }
 
    return $shortlink;
}

/* Show Future Dialogue Posts */
/*-----------------------------------------------------------------------------------*/

add_filter( 'the_posts', 'mith_future_dialogues', 10, 2 );

function mith_future_dialogues( $posts, $query ) {
	global $wpdb;
	// We will skip if -
	// - there's already found posts 
	// - or it isn't a single post page
	// - or User is loggedin
	if( !empty($posts) || ! $query->is_singular() || is_user_logged_in() )
		return $posts;
	if( $post_name = $query->get('name') ){
		$post_type = $query->get('post_type') ? $query->get('post_type') : 'mith_dialogue';
		$post_status = 'future';
		$post_ID = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status= %s", $post_name, $post_type, $post_status ) );
		if( $post_ID ){
			$posts = array( get_post($post_ID) );
		}
	}
	return $posts;
}


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

    register_taxonomy( 'mith_topic', array('mith_research', 'post', 'mith_dialogue'), $research_tax_args );
}

?>
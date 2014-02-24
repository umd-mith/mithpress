<?php

/* Podcast Series Taxonomy */
/*-------------------------------------------------------------------------------------------*/
add_action( 'init', 'register_taxonomy_podcast_series' );

function register_taxonomy_podcast_series() {

    $pcast_tax = array( 
        'name' => _x( 'Podcast Series', 'podcast_series' ),
        'singular_name' => _x( 'Podcast Series', 'podcast_series' ),
        'all_items' => _x( 'All Podcast Series', 'podcast_series' ),
        'parent_item' => _x( 'Parent Podcast Series', 'podcast_series' ),
        'parent_item_colon' => _x( 'Parent Podcast Series:', 'podcast_series' ),
        'edit_item' => _x( 'Edit Podcast Series', 'podcast_series' ),
        'update_item' => _x( 'Update Podcast Series', 'podcast_series' ),
        'add_new_item' => _x( 'Add New Podcast Series', 'podcast_series' ),
        'new_item_name' => _x( 'New Podcast Series', 'podcast_series' ),
        'separate_items_with_commas' => _x( 'Separate podcasts series with commas', 'podcast_series' ),
        'add_or_remove_items' => _x( 'Add or remove podcasts series', 'podcast_series' ),
        'choose_from_most_used' => _x( 'Choose from the most used podcasts series', 'podcast_series' ),
        'menu_name' => _x( 'Series', 'podcast_series' ),
    );

    $args = array( 
        'labels' => $pcast_tax,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => false,

		'query_var' => true,
		'rewrite' => true
    );

    register_taxonomy( 'podcast_series', array('podcast'), $args );
}

/* Podcast Post Type */
/*-------------------------------------------------------------------------------------------*/

add_action( 'init', 'register_cpt_podcast' );

function register_cpt_podcast() {

    $pcast_cpt = array( 
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
        'labels' => $pcast_cpt,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'author', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
        'taxonomies' => array( 'podcast_categories', 'podcast_tags' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
		'menu_icon' => get_stylesheet_directory_uri() . '/admin/images/icon-podcasts.png',
        'menu_position' => 5,
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,

        'rewrite' => array(
			'slug'=>'podcasts',
			'with_front' => true
		),

        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'capability_type' => 'post',
		
		'taxonomies' => array('podcast_series','category', 'post_tag')
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
		'series' => __('Series'),
		'title' => __('Title'),
		'speaker' => __('Speaker'),
		'file_url' => __('Files')
	);

	return $columns;
}

function manage_podcast_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'speaker' :
			/* Get the post meta. */
			$speaker = get_post_meta( $post_id, 'podcast_speakers_0_podcast_speaker_name', true );

			/* If no title is found, output a default message. */
			if ( empty( $speaker ) )
				echo __( 'n/a' );

			else printf( $speaker );
			break;

		case 'file_url' :
			/* Get the post meta. */
			$file_url = get_post_meta( $post_id, 'podcast_files_0_podcast_file_url', true );
			

			/* If nothing is found, output a default message. */
			if ( empty($file_url) )
				echo __( '-- ');

			else printf( $file_url );
			break;

		case 'series' :

			/* Get the podcast_seriess for the post. */
			$terms = get_the_terms( $post_id, 'podcast_series' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'podcast_series' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'podcast_series', 'display' ) )
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


/* Sortable Columns */
/*-------------------------------------------------------------------------------------------*/
add_filter('manage_edit-podcast_sortable_columns', 'register_podcast_sortable_columns');
function register_podcast_sortable_columns( ) {
  return array(
    'speaker'  => 'podcast_speaker_name',
	'affiliation' => 'podcast_speaker_affiliation',
	);
}
add_filter('request', 'handle_podcast_column_sorting');
function handle_podcast_column_sorting( $vars ){
  if( isset($vars['orderby']) && 'speaker' == $vars['orderby'] ){
    $vars = array_merge( $vars, array(
		'meta_key' => 'podcast_speakers_0_podcast_speaker_name',
		'orderby' => 'meta_value',
    ));
  }
  return $vars;
}

/* Create Filter Dropdowns */
/*-----------------------------------------------------------------------------------*/
function add_podcast_taxonomy_filters() {
	global $typenow;
 
	// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
	$taxonomies = array('podcast_series');
 
	// must set this to the post type you want the filter(s) displayed on
	if( $typenow == 'podcast' ){
 
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
add_action( 'restrict_manage_posts', 'add_podcast_taxonomy_filters' );

/* Podcast Details Snippet Function */
/*-----------------------------------------------------------------------------------*/
function podcast_info_snippet() {
	global $post;
	
	$podcast_speakers = get_field('podcast_speakers', get_the_ID());
	
	if( get_field('podcast_speakers') ) :
	$i = 0;
	$count = $podcast_speakers;
					
	while(has_sub_field('podcast_speakers')) :
		// get speaker metadata
		$speaker_name = get_sub_field('podcast_speaker_name', get_the_ID());
		$speaker_title = get_sub_field('podcast_speaker_title', get_the_ID());
		$speaker_affiliation = get_sub_field('podcast_speaker_affiliation', get_the_ID());
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
	$date_raw = get_post_meta( get_the_ID(), 'podcast_date', TRUE);
	$time = get_post_meta( get_the_ID(), 'podcast_time', TRUE);
	$location = get_post_meta( get_the_ID(), 'podcast_location', TRUE); 
	$sponsor = get_post_meta( get_the_ID(), 'podcast_sponsors', TRUE );

	$podcast_details = '<section class="podcast-details">';
	$podcast_details .= '<span class="info-location">';
	if ($location != '') { 
		$podcast_details .= $location; } else { 
		$podcast_details .= 'MITH Conference Room';
	}
	$podcast_details .= '</span>';
	
	$podcast_details .= '<span class="info-dates">';
	if ($date_raw != '') { $date = date('l, F j, Y', strtotime($date_raw)); } 
    elseif ( get_post_meta(get_the_ID(), 'talk-date', TRUE) != '') { $date = get_post_meta(get_the_ID(), 'talk-date', TRUE); } 
    else { $date = the_date( 'l, F j, Y' ); } 
	$podcast_details .= $date;
	$podcast_details .= '</span>';
	if ($time != '') { 
		$podcast_details .='<span class="info-times">' . $time . '</span>'; 
	}
	if ($sponsor != '') {
		$podcast_details .= '<span class="post-sponsor">' . $sponsor . '</span>';
	}
	$podcast_details .= '</section>';
	

	$podcast_info = $speaker_info; 
	$podcast_info .= $podcast_details;
	
return $podcast_info; 
}


/* Add Shortlink to Podcast Posts */
/*-----------------------------------------------------------------------------------*/

function mithpress_shortlinks_for_podcast( $shortlink, $id, $context ) {
 
    // Context can be post/blog/meta ID or query
    $post_id = 0;
 
    if ( 'query' == $context && is_singular( 'podcast' ) ) {
 
        // If context is query use current queried object for ID
        $post_id = get_queried_object_id();
 
    }
    elseif ( 'post' == $context ) {
 
        // If context is post use the passed $id
        $post_id = $id;
 
    }
 
    // Only do something if of podcast post type
    if ( 'podcast' == get_post_type( $post_id ) ) {
        $shortlink = home_url( '?p=' . $post_id );
    }
 
    return $shortlink;
}
add_filter( 'pre_get_shortlink', 'mithpress_shortlinks_for_podcast', 10, 3 );


/* Show Future Podcast Posts */
/*-----------------------------------------------------------------------------------*/
add_filter( 'the_posts', 'mithpress_the_future_posts', 10, 2 );
function mithpress_the_future_posts( $posts, $query )
{
	global $wpdb;

	// We will skip if -
	// - there's already found posts 
	// - or it isn't a single post page
	// - or User is loggedin
	if( !empty($posts) || ! $query->is_singular() || is_user_logged_in() )
		return $posts;

	if( $post_name = $query->get('name') ){
		$post_type = $query->get('post_type') ? $query->get('post_type') : 'podcast';
		$post_status = 'future';
		$post_ID = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status= %s", $post_name, $post_type, $post_status ) );
		if( $post_ID ){
			$posts = array( get_post($post_ID) );
		}
	}

	return $posts;
}


/* Future Postslist Shortcode */
/*-----------------------------------------------------------------------------------*/
function future_postlist_shortcode($atts)
{
	extract( shortcode_atts( array(
		'post_type' => 'podcast',
		'total' 	=> '-1',
		'order' 	=> 'DESC',
		'orderby' 	=> 'date',
	), $atts ));


	$html  = '';
	$query = new WP_Query( array( 
		'order' 			=> $order,
		'orderby' 			=> $orderby,
		'post_type' 		=> $post_type,
		'post_status' 		=> 'future',
		'posts_per_page'	=> $total
	));

	if( $query->have_posts() ):
	$html .= '<ul>';
		while( $query->have_posts()) : $query->the_post();
		$html .= sprintf( 
			'<li><a href="%1$s">%2$s</a> - <span title="will be available within %3$s">in %3$s</span></li>',
			get_permalink(),
			get_the_title(),
			human_time_diff( strtotime(get_post()->post_date), current_time('timestamp') )
		);
		endwhile;
	$html .= '</ul>';
	endif;

	return $html;
}

add_shortcode( 'future_postlist', 'future_postlist_shortcode' );
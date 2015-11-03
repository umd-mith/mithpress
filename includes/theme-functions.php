<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Post Thumbnail 
- Post Type Classes
- Nav Menus
- Misc
- Admin Functions 
- Login Logo

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Thumbnail Support */
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'post-thumbnails', array('page','post','people','project','podcast','event','job' ) );

function mithpress_thumbnails() {
    //add_image_size( 'featured-image', 640, 130 ); 
	update_option('medium_size_w', 225);
	update_option('medium_size_h', 225);
	update_option('large_size_w', 410);
	update_option('large_size_h', 410);

	//add_image_size( 'Medium', 225, 225, false);
    add_image_size( 'mini-thumbnail', 50, 50, true );
	add_image_size( 'med-thumbnail', 130, 130, true ); // staff/person photo size
	add_image_size( 'horiz-thumbnail', 200, 90, false ); // project icon
    add_image_size( 'slide', 640, 290, true );
}

add_action( 'init', 'mithpress_thumbnails' );


/*-----------------------------------------------------------------------------------*/
/* Add Image Sizes to Media Uploader */
/*-----------------------------------------------------------------------------------*/
/**
 * Filter callback to add image sizes to Media Uploader
 * See image_size_input_fields() in wp-admin/includes/media.php
 * Tested with WP 3.3 beta 1
 *
 * @uses get_intermediate_image_sizes()
 *
 * @param $sizes, array of default image sizes (associative array)
 * @return $new_sizes, array of all image sizes (associative array)
 */
function sgr_display_image_size_names_muploader( $sizes ) {
	
	$new_sizes = array();
	
	$added_sizes = get_intermediate_image_sizes();
	
	// $added_sizes is an indexed array, therefore need to convert it
	// to associative array, using $value for $key and $value
	foreach( $added_sizes as $key => $value) {
		$new_sizes[$value] = $value;
	}
	
	// This preserves the labels in $sizes, and merges the two arrays
	$new_sizes = array_merge( $new_sizes, $sizes );
	
	return $new_sizes;
}
add_filter('image_size_names_choose', 'sgr_display_image_size_names_muploader', 11, 1);

/*-----------------------------------------------------------------------------------*/
/* Remove Standard Image Sizes */
/*-----------------------------------------------------------------------------------*/
/**
 * Remove standard image sizes so that these sizes are not created during the Media Upload process
 * Tested with WP 3.2.1
 *
 * Hooked to intermediate_image_sizes_advanced filter
 * See wp_generate_attachment_metadata( $attachment_id, $file ) in wp-admin/includes/image.php
 *
 * @param $sizes, array of default and added image sizes
 * @return $sizes, modified array of image sizes
 */
function sgr_filter_image_sizes( $sizes) {
		
	unset( $sizes['thumbnail']);
	//unset( $sizes['medium']);
	//unset( $sizes['large']);
	
	return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'sgr_filter_image_sizes');

/*-----------------------------------------------------------------------------------*/
/* Remove Standard Image Sizes */
/*-----------------------------------------------------------------------------------*/

add_filter('post_thumbnail_html', 'remove_feat_img_title');
function remove_feat_img_title($img) {
    $img = preg_replace('/title=\"(.*?)\"/','',$img);
    return $img;
}

function modify_post_mime_types($post_mime_types) {
    $post_mime_types['application/pdf'] = array(__('PDF'), __('Manage PDF'), _n_noop('PDF <span class="count">(%s)</span>', 'PDF <span class="count">(%s)</span>'));
    return $post_mime_types;
}
add_filter('post_mime_types', 'modify_post_mime_types');

 
/*-----------------------------------------------------------------------------------*/
/* Set Featured Image Thumbnail w/ First Post Image */
/*-----------------------------------------------------------------------------------*/

function mithpress_get_featured_thumb ($text, $size){

	global $post;
    $img_url = "";

    // Check to see which image is set as "Featured Image" and get ID
    $img_id = get_post_thumbnail_id($post->ID);
    
	// Get source and alt tag for featured image
    $img_src = wp_get_attachment_image_src( $img_id, $size );
    $img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );

	// Set $img_url to Featured Image
    $img_url = $img_src[0];
	
    // If there is no "Featured Image" set, move on and get the first image attached to the post
    if (!$img_url) {
        
		// Extract the thumbnail from the first attached imaged
        $allimages =& get_children('post_type=attachment&post_mime_type=image&post_parent=' . $post->ID );

        foreach ($allimages as $img){
            $img_src = wp_get_attachment_image_src( $img->ID, $size );
		    $img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
            break;
        }
		
        // Set $img_url to first attached image
        $img_url = $img_src[0];
    }

    // If there is no image attached to the post, look for anything that looks like an image and get that
    if (!$img_url) {
        preg_match('/<\s*img [^\>]*src\s*=\s*[\""\']?([^\""\'>]*)/i' ,  $text, $matches);
        $img_url = $matches[1];
    }

	// Spit out the image path
	if ($img_url && $img_alt) { 
    	return '<img src="' . $img_url . '" alt="' . $img_alt . '" />';
	} elseif ($img_url) {
    	return '<img src="' . $img_url . '" />';
	} else { 
		// do nothing
	}
}

/*-----------------------------------------------------------------------------------*/
/* Nav Menus Support */
/*-----------------------------------------------------------------------------------*/

if ( function_exists('wp_nav_menu') ) {
	add_theme_support( 'nav-menus' );
		register_nav_menus( array( 
		'main-menu' => __( 'Main Menu' ), 
		'about-menu' => __( 'About Menu' ),
		'research-menu' => __( 'Research Menu' ),
		'staff-menu' => __( 'Staff Menu' ),
		'digital-dialogues-menu' => __( 'Digital Dialogues Menu'),
		'footer-textlinks' => __( 'Footer Text Links ' ),
		'footer-menu' => __( 'Footer Menu' )
	)
  );
}     

/*------------------------------------------------------------------------------------*/
function is_tree( $pid ) {      // $pid = The ID of the page we're looking for pages underneath
    global $post;               // load details about this page

    if ( is_page($pid) )
        return true;            // we're at the page or at a sub page

    $anc = get_post_ancestors( $post->ID );
    foreach ( $anc as $ancestor ) {
        if( is_page() && $ancestor == $pid ) {
            return true;
        }
    }

    return false;  // we arn't at the page, and the page is not an ancestor
}



/*-----------------------------------------------------------------------------------*/
/* Misc */
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'automatic-feed-links' );
 

/* Add page slug as body class. Also include the page parent */
/*-----------------------------------------------------------------------------------*/
function mithpress_body_classes($classes, $class='') {
    global $wp_query;
    // detecting the 404 page since the $post_id won't be valid 
    // if we're on a 404 page and we'll get a debug error
    if( !is_404() && !is_tax() && !is_archive() ){
        $post_id = $wp_query->post->ID;
        if(is_page($post_id )){
            $page = get_page($post_id);
            //check for parent
            if($page->post_parent>0){
                $parent = get_page($page->post_parent);
                $classes[] = 'page-parent-'. sanitize_title($parent->post_title);
            }
            $classes[] = 'page-'. sanitize_title($page->post_title);
        }
		if (is_single()) {
			 
			$post = $wp_query->get_queried_object();
			$classes[] = $post->post_type . '-' . $post->post_name;

		    $event_terms = get_the_terms($post_id, 'event_type');
			if ($event_terms) {
			  foreach ($event_terms as $event_term) {
				$classes[] = 'event-' . $event_term->slug;
			  }
			}

		    $staff_terms = get_the_terms($post_id, 'staffgroup');
			if ($staff_terms) {
			  foreach ($staff_terms as $staff_term) {
				$classes[] = 'staff-' . $staff_term->slug;
			  }
			}

		    $podcast_terms = get_the_terms($post_id, 'podcast_series');
			if ($podcast_terms) {
			  foreach ($podcast_terms as $podcast_term) {
				$classes[] = 'podcast-series-' . $podcast_term->slug;
			  }
			}

		}
    }// ends check for 404 page
    return $classes;// return the $classes array
}
add_filter('body_class','mithpress_body_classes');


/*-----------------------------------------------------------------------------------*/
/* Misc Admin */
/*-----------------------------------------------------------------------------------*/

// More Sorting Options for the Media Library 
/*-----------------------------------------------------------------------------------*/

add_filter('post_mime_types', 'add_post_mime_type');
function add_post_mime_type( $post_mime_types ) {
    //$post_mime_types['application'] = array(__('Doc'), __('Manage Doc'), _n_noop('Doc <span class="count">(%s)</span>', 'Doc <span class="count">(%s)</span>'));
    $post_mime_types['application/pdf'] = array(__('PDF'), __('Manage PDF'), _n_noop('PDF <span class="count">(%s)</span>', 'PDF <span class="count">(%s)</span>'));
    $post_mime_types['application/msword'] = array(__('DOC'), __('Manage DOC'), _n_noop('DOC <span class="count">(%s)</span>', 'DOC <span class="count">(%s)</span>'));
    return $post_mime_types;
}


// List Category ID in Quick Actions
//--------------------------------------------------------------
add_filter( "tag_row_actions", 'add_cat_id_to_quick_edit', 10, 2 );
function add_cat_id_to_quick_edit( $actions, $tag ) {
    $actions['cat_id'] = 'ID: '.$tag->term_id;
    return $actions;
}

// Easier Access to Media File from Media Library
//--------------------------------------------------------------
/* will add a link to the ‘row actions’ for the File URL (as opposed the the attachment URL you’ll get with the ‘view’ link)*/

add_filter ('media_row_actions','add_direct_link', 10, 3 );
function add_direct_link( $actions, $post, $detached ) {
    $actions['file_url'] = '<a href="' . wp_get_attachment_url($post->ID) . '">Actual File</a>';
    return $actions;
}


// Customize Admin Bar
//--------------------------------------------------------------
function remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('updates');
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );



// Remove Dashboard Widgets
//--------------------------------------------------------------

add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets', 20, 0 );
//add_action('admin_init', 'remove_dashboard_widgets');
function remove_dashboard_widgets() {

	//Plugins
    wp_unregister_sidebar_widget( 'dashboard_plugins' );
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');

	// Twitter Plugin
    wp_unregister_sidebar_widget( 'xpf-dashboard-widget' );
	remove_meta_box( 'xpf-dashboard-widget', 'dashboard', 'normal' );
	remove_meta_box( 'xpf-dashboard-widget', 'dashboard', 'side' );

    //Right Now
    wp_unregister_sidebar_widget( 'dashboard_right_now' );
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
 
    //Recent Comments
    //wp_unregister_sidebar_widget( 'dashboard_recent_comments' );
    //remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 
    //Incoming Links
    //wp_unregister_sidebar_widget( 'dashboard_incoming_links' );
    //remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
	
	//WordPress Blog
    wp_unregister_sidebar_widget( 'dashboard_primary' );
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
 
    //Other WordPress News
    wp_unregister_sidebar_widget( 'dashboard_secondary' );
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
 
    //Quick Press
    wp_unregister_sidebar_widget( 'dashboard_quick_press' );
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
 
    //Recent Drafts
    wp_unregister_sidebar_widget( 'dashboard_recent_drafts' );
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
}


/*-----------------------------------------------------------------------------------*/
// CUSTOM LOGIN LOGO
/*-----------------------------------------------------------------------------------*/

function my_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('. get_stylesheet_directory_uri() .'/images/logo_mith_skinny_blk.png) !important; background-size: auto !important; width: auto !important; }
    </style>';
}

add_action('login_head', 'my_custom_login_logo');

// CUSTOM DASHBOARD LOGO
add_action('admin_head', 'my_custom_logo');

function my_custom_logo() {
   echo '<style type="text/css">
         #header-logo { background-image: url('. get_stylesheet_directory_uri() .'/images/logo_mith_skinny_blk.png) !important; }
		 </style>';
}
?>
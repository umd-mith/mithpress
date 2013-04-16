<?php

define('MY_WORDPRESS_FOLDER',$_SERVER['DOCUMENT_ROOT']);
define('MY_THEME_FOLDER',str_replace('\\','/',dirname(__FILE__)));
define('MY_THEME_PATH','/' . substr(MY_THEME_FOLDER,stripos(MY_THEME_FOLDER,'wp-content'))); 

/*-----------------------------------------------------------------------------------*/
// Set path to theme specific functions
/*-----------------------------------------------------------------------------------*/

$functions_path = TEMPLATEPATH . '/functions/';
$includes_path = TEMPLATEPATH . '/includes/';
$scripts_path = TEMPLATEPATH . '/js/';
$metabox_path = TEMPLATEPATH . '/metaboxes/';
//$admin_path = TEMPLATEPATH . '/admin/';

/*-----------------------------------------------------------------------------------*/
// Function & Metabox & Custom Post Type Files
/*-----------------------------------------------------------------------------------*/

require_once ($includes_path . 'theme-functions.php'); 		// Custom theme functions
require_once ($includes_path . 'theme-styles.php');			// Theme styles
require_once ($includes_path . 'theme-widgets.php');		// Theme widgets
require_once ($includes_path . 'theme-comments.php');		// Comments & Pingbacks, etc
require_once ($includes_path . 'theme-posts.php');		
require_once ($includes_path . 'mithpress-breadcrumbs.php');// Breadcrumbs function
//require_once ($admin_path . 'taxonomy-class.php'); // taxonomy meta

require_once ($includes_path . 'project-posts.php');
require_once ($includes_path . 'podcast-posts.php');
require_once ($includes_path . 'people-posts.php');
require_once ($includes_path . 'job-posts.php');
require_once ($includes_path . 'event-posts.php');

include_once ($metabox_path . 'setup.php');
include_once ($metabox_path . 'full-spec.php');

/*-----------------------------------------------------------------------------------*/
// Shortcodes
/*-----------------------------------------------------------------------------------*/

require_once ($includes_path . 'mithpress-shortcodes.php');  

add_filter('the_content', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');

/*-----------------------------------------------------------------------------------*/
/* Options Framework Theme
/*-----------------------------------------------------------------------------------*/

/**
 * Optional: set 'ot_show_pages' filter to false.
 * This will hide the settings & documentation pages.
 */
add_filter( 'ot_show_pages', '__return_false' );

/**
 * Required: set 'ot_theme_mode' filter to true.
 */
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Required: include OptionTree.
 */
include_once( 'option-tree/ot-loader.php' );

require_once ($includes_path . 'theme-options.php' );


/* 
 * Turns off the default options panel from Twenty Eleven
 */
 
add_action('after_setup_theme','remove_twentyeleven_options', 100);

function remove_twentyeleven_options() {
	remove_action( 'admin_menu', 'twentyeleven_theme_options_add_page' );
}

/*-----------------------------------------------------------------------------------*/
/* Conditional Tags for Custom Taxonomy Pages */
/*-----------------------------------------------------------------------------------*/

function has_project_tax_category( $custom_tax_category, $_post = null ) {
	if ( empty( $custom_tax_category ) )
		return false;
	if ( $_post )
		$_post = get_post( $_post );
	else
		$_post =& $GLOBALS['post'];
	if ( !$_post )
		return false;
	$r = is_object_in_term( $_post->ID, 'projettype', $custom_tax_category );
	if ( is_wp_error( $r ) )
		return false;
	return $r;
}

/**
 * Tests if any of a post's assigned categories are descendants of target categories
 *
 * @param int|array $cats The target categories. Integer ID or array of integer IDs
 * @param int|object $_post The post. Omit to test the current post in the Loop or main query
 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
 * @see get_term_by() You can get a category by name or slug, then pass ID to this function
 * @uses get_term_children() Passes $cats
 * @uses in_category() Passes $_post (can be empty)
 * @version 2.7
 * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
 */
function post_is_in_descendant_category( $cats, $_post = null )
{
	foreach ( (array) $cats as $cat ) {
		// get_term_children() accepts integer ID only
		$descendants = get_term_children( (int) $cat, 'category');
		if ( $descendants && in_category( $descendants, $_post ) )
			return true;
	}
	return false;
}
?>
<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Clean Up Header
- Add/Remove Scripts/Styles
- Add Admin Scripts/Styles
- Add Page/Post Specifit Scripts/Styles

-----------------------------------------------------------------------------------*/

//////////////////////////////////////////////////////////////
/* Clean up Header */
//////////////////////////////////////////////////////////////

remove_action('wp_head', 'wp_generator');
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

//////////////////////////////////////////////////////////////
/* Add and Remove Styles */
//////////////////////////////////////////////////////////////

add_action('wp_enqueue_scripts', 'mp_enqueue_scripts');

// wp_register_style( $handle, $src, $deps, $ver, $media );
// wp_register_script( $handle, $src, $deps, $ver, $in_footer );

function mp_enqueue_scripts() {
	
	// scripts
	wp_deregister_script('jquery');
	wp_register_script('jquery', ('http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'), array(), '1.8.3', false);
	wp_register_script('jquery-ui', ('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js'), array(), '1.9.2', false);
			
	wp_register_script('custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), false, false);
	wp_register_script('superfish', get_template_directory_uri() .'/js/superfish.js', array('jquery'), '1.4.8', false);
	wp_register_script('supersubs', get_template_directory_uri() .'/js/supersubs.js', array('jquery'), '0.2', false);

	wp_register_script('slimbox', get_template_directory_uri() . '/js/jquery.slimbox-2.04.js', array('jquery'), '2.04', false);
	wp_register_script('easing', get_template_directory_uri() . '/js/jquery.easing.js', array('jquery'), '1.3', false);		
	wp_register_script('gigpress', get_template_directory_uri() . '/js/gigpress.js', array('jquery'), false, false);

	wp_register_script('grayscale', get_template_directory_uri() .'/js/grayscale.js', array(), false, true);
	
	// styles
	wp_register_style('superfish', get_template_directory_uri() .'/css/superfish.css', array(), '1.4.8', 'all' );
	wp_register_style('slimbox', get_template_directory_uri() .'/css/slimbox.css', array(), '2.04', 'screen, projection' );

	// enqueue scripts
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui');
	wp_enqueue_script('superfish');
	wp_enqueue_script('supersubs');
	wp_enqueue_script('slimbox');
	wp_enqueue_script('easing');
	wp_enqueue_script('gigpress');
	wp_enqueue_script('custom');

	// enqueue styles
	wp_enqueue_style('slimbox');	
	wp_enqueue_style('superfish');
}


//////////////////////////////////////////////////////////////
/* Add Admin Scripts and Styles */
//////////////////////////////////////////////////////////////
add_action( 'admin_enqueue_scripts', 'mp_admin_enqueue_scripts' );

function mp_admin_enqueue_scripts() {
	// admin scripts
	wp_register_script('jquery-ui', ('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js'), array(), '1.9.2', false);
	wp_register_script('timepicker', get_template_directory_uri() .'/admin/jquery-ui-timepicker-addon.js', array('jquery-ui'), false, false);
	wp_register_script('admin-scripts', get_template_directory_uri() . '/admin/admin.js', array('jquery'), false, false);
	
	// admin styles
	wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css', array(), '1.9.2', 'screen'); 
	wp_register_style('admin-styles', get_template_directory_uri() .'/admin/admin.css', array(), false, 'screen');

	// enqueue admin scripts and styles
	wp_enqueue_style('jquery-ui');
	wp_enqueue_style('admin-styles');
	
	wp_enqueue_script('admin-scripts');
	wp_enqueue_script('jquery-ui');
	wp_enqueue_script('timepicker');
}

//////////////////////////////////////////////////////////////
/* Add Page/Post Specifit Scripts and Styles */
//////////////////////////////////////////////////////////////

// Comments Script

function mp_js_comments() {
	if(is_singular() || is_page())
	wp_enqueue_script( 'comment-reply' );
}
add_action('wp_print_scripts', 'mp_js_comments');

// People Scripts

function mp_js_people()  {
	if ('people' == get_post_type())
	wp_enqueue_script('grayscale');
}
add_action('wp_print_scripts', 'mp_js_people');


//////////////////////////////////////////////////////////////
/* Paging  */
//////////////////////////////////////////////////////////////

if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
    update_option( 'posmp_per_page', 12 );
    update_option( 'paging_mode', 'default' );
}

//////////////////////////////////////////////////////////////

add_action('wp_head','mithpress_theme_head');

function mithpress_theme_head() { ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />

<!--[if lt IE 7]>
<script defer type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/pngfix.js"></script>
<![endif]-->
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/html5.js"></script>
<![endif]-->

<?php } 

/*-----------------------------------------------------------------------------------*/
/* Get Attachment ID from Image Source */
/*-----------------------------------------------------------------------------------*/

function get_attachment_id_from_src ($image_src) {

	global $wpdb;
	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
	$id = $wpdb->get_var($query);
	return $id;

}
?>
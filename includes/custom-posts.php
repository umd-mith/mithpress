<?php

/*-------------------------------------------------------------------------------------------*/
/* Custom Post Type Settings */
/*-------------------------------------------------------------------------------------------*/


/*-------------------------------------------------------------------------------------------*/
/* Meta Box Title Changes */
/*-------------------------------------------------------------------------------------------*/

add_filter('gettext', 'admin_custom_rewrites', 10, 4);

function admin_custom_rewrites($translation, $text, $domain) {
	global $post;
        if ( ! isset( $post->post_type ) ) {
            return $translation;
        }
	$translations = &get_translations_for_domain($domain);
	$translation_array = array();
 
	switch ($post->post_type) {
		case 'people': 
			$translation_array = array(
				'Enter title here' => 'Enter full name here',
				'Featured Image' => 'Bio Picture',
				'Set featured image' => 'Assign image'
			);
			break;
		case 'podcast': 
			$translation_array = array(
				'Enter title here' => 'Enter talk title here',
				'Featured Image' => 'Speaker Photo',
				'Set featured image' => 'Assign image'
			);
			break;
		case 'project': 
			$translation_array = array(
				'Enter title here' => 'Enter project title here',
				'Featured Image' => 'Project Thumbnail',
				'Set featured image' => 'Assign image'
			);
			break;
	}
 
	if (array_key_exists($text, $translation_array)) {
		return $translations->translate($translation_array[$text]);
	}
	return $translation;
}



/*-------------------------------------------------------------------------------------------*/
/* Create Sortable Columns */
/*-------------------------------------------------------------------------------------------*/


/* Podcast Columns */
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

/* Project Columns */
/*-------------------------------------------------------------------------------------------*/
add_filter( "manage_edit-project_sortable_columns", "register_project_sortable_columns" );


/* People Columns */
/*-------------------------------------------------------------------------------------------*/
add_filter('manage_edit-people_sortable_columns', 'register_people_sortable_columns');
function register_people_sortable_columns( ) {
  return array(
	'staffgroup' => 'staffgroup',
	'title' => 'name',
	'fname' => 'fname',
	'lname' => 'lname'
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


?>
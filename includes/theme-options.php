<?php
/**
 * Initialize the options before anything else.
 */
add_action( 'admin_init', 'custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array(
      
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'homepage_slides',
        'title'       => 'Homepage Slides'
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'home_slides',
        'label'       => 'Image Slides',
        'desc'        => '',
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'homepage_slides',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'settings'    => array( 
          array(
            'id'          => 'slide_img',
            'label'       => 'Image',
            'desc'        => '',
            'std'         => '',
            'type'        => 'upload',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          ),
          array(
            'id'          => 'slide_desc',
            'label'       => 'Description',
            'desc'        => 'This text is added to the left of the slide.',
            'std'         => '',
            'type'        => 'textarea',
            'rows'        => '4',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          ),
          array(
            'id'          => 'slide_link',
            'label'       => 'Link',
            'desc'        => 'Enter complete post/page url.',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          )
        )
      )
    )
  );
   
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}
<?php

/* Jop Post Type */
/*-------------------------------------------------------------------------------------------*/
add_action( 'init', 'register_cpt_job' );

function register_cpt_job() {

    $labels = array( 
        'name' => _x( 'Jobs', 'job' ),
        'singular_name' => _x( 'Job', 'job' ),
        'add_new' => _x( 'Add New', 'job' ),
        'add_new_item' => _x( 'Add New Job', 'job' ),
        'edit_item' => _x( 'Edit Job', 'job' ),
        'new_item' => _x( 'New Job', 'job' ),
        'view_item' => _x( 'View Job', 'job' ),
        'search_items' => _x( 'Search Jobs', 'job' ),
        'not_found' => _x( 'No jobs found', 'job' ),
        'not_found_in_trash' => _x( 'No jobs found in Trash', 'job' ),
        'parent_item_colon' => _x( 'Parent Job:', 'job' ),
        'menu_name' => _x( 'Jobs', 'job' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'revisions', 'page-attributes' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => get_template_directory_uri() . '/admin/images/icon-jobs.png',
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'job', $args );
}

/* Job Columns */
/*-------------------------------------------------------------------------------------------*/
 

?>
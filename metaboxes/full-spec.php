<?php
$project_mb = new WPAlchemy_MetaBox(array(
	'id' => '_project_details',
	'title' => 'Project Details',
	'types' => array('project'), 
	'priority' => 'high', 
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'template' => get_stylesheet_directory() . '/metaboxes/project-meta.php'
));

$projectfiles_mb = new WPAlchemy_MetaBox(array(
	'id' => '_project_files',
	'title' => 'Project Files',
	'types' => array('project'), 
	'template' => get_stylesheet_directory() . '/metaboxes/project-meta-files.php'
));

$projectlinks_mb = new WPAlchemy_MetaBox(array(
	'id' => '_project_links',
	'title' => 'Links',
	'types' => array('project'),
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'template' => get_stylesheet_directory() . '/metaboxes/project-meta-links.php',	
));

$people_mb = new WPAlchemy_MetaBox(array(
	'id' => '_people_info',
	'title' => 'Personal Information',
	'types' => array('people'), 
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'template' => get_stylesheet_directory() . '/metaboxes/people-meta.php'
));

$peoplelinks_mb = new WPAlchemy_MetaBox(array(
	'id' => '_people_links',
	'title' => 'Links',
	'types' => array('people'),
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'template' => get_stylesheet_directory() . '/metaboxes/people-meta-links.php',	
));

$peopledates_mb = new WPAlchemy_MetaBox(array(
	'id' => '_people_dates',
	'title' => 'Dates',
	'types' => array('people'),
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'template' => get_stylesheet_directory() . '/metaboxes/people-meta-dates.php',	
));

$podcast_mb = new WPAlchemy_MetaBox(array(
	'id' => '_podcast_info',
	'title' => 'Podcast Details',
	'types' => array('podcast'), 
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'template' => get_stylesheet_directory() . '/metaboxes/podcast-meta.php',
	'priority' => 'high'
));

$podcast2_mb = new WPAlchemy_MetaBox(array(
	'id' => '_podcast_files',
	'title' => 'Podcast Files',
	'types' => array('podcast'), 
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'template' => get_stylesheet_directory() . '/metaboxes/podcast-meta-uploads.php'
));

$event_mb = new WPAlchemy_MetaBox(array(
	'id' => '_event_details',
	'title' => 'Event Details',
	'types' => array('event'), 
	'priority' => 'high', 
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'template' => get_stylesheet_directory() . '/metaboxes/event-meta.php'
));

$job_mb = new WPAlchemy_MetaBox(array(
	'id' => '_job_details',
	'title' => 'Job Details',
	'types' => array('job'), 
	'priority' => 'high', 
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'template' => get_stylesheet_directory() . '/metaboxes/job-meta.php'
));

/* eof */
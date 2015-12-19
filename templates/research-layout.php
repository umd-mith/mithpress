<?php 
$events_list = '';
// get event category name
if ( has_term( array('mith-event', 'event-conference', 'event-workshop', 'event-symposium', 'event-training-institute', 'event-institute', 'event-meeting'), 'mith_research_type') ) : // check if research item is an event
	$parent_term = get_term_by( 'slug', 'mith-event', 'mith_research_type' ); 
	$parent = $parent_term->term_id;
	$cat_terms = get_terms( 'mith_research_type', array( 'parent' => $parent, ) );
	$parent_terms = array();
	foreach ($cat_terms as $cat) $parent_terms[] = $cat->slug; // create array of term slugs			
	$terms = get_the_terms( $post->ID, 'mith_research_type' );										
	if ( $terms && ! is_wp_error( $terms ) ) : 
		$type_terms = array();
		foreach ( $terms as $term ) {
			if ( in_array( $term->slug, $parent_terms ) ) // check if item term is in parent array
			$type_terms[] = $term->name;
		}
		$research_event_category = $type_terms[0];
	endif;
endif;
					
if( have_rows('research_events') ) : 
$events_list .= '<div class="research-events-content">';

while( have_rows('research_events') ): the_row(); 
	$event_details = '';
	$event_title = get_sub_field('event_title');
	$event_loc = get_sub_field('event_location');
	$event_desc = get_sub_field('event_description');
	$event_start_date_raw = get_sub_field('event_date_start');
	$event_end_date_raw = get_sub_field('event_date_end');
	$event_start_time_raw = get_sub_field('event_time_start');
	$event_end_time_raw = get_sub_field('event_time_end');

	if ( $event_title) $event_label = $event_title;
	elseif ( $research_event_category ) $event_label = $research_event_category;
	else $event_label = 'Event';
	//title
	$event_details .= sprintf('<h3 style="margin-bottom:0;margin-top:0;">%s</h3>', __($event_label, 'Avada') );

	// date
	if ($event_start_date_raw ) $event_start_date = date('D, M j, Y', strtotime($event_start_date_raw)); 
	if ($event_end_date_raw ) $event_end_date = date('D, M j, Y', strtotime($event_end_date_raw));
	
	if ( $event_start_date_raw ) { 
		$event_date = $event_start_date;
		if ( $event_end_date ) $event_date .= sprintf('<span class="dates-sep"> &ndash; </span>%s', $event_end_date);
	$event_details .= sprintf( '<div class="event-date"><i class="fa fa-calendar"></i> <span>%s</span></div>', $event_date );
	}
	//times
	if ($event_start_time_raw) $event_start_time = $event_start_time_raw;
	if ($event_end_time_raw) $event_end_time = $event_end_time_raw;
	
	if ($event_start_time_raw) {
		$event_times = $event_start_time;
		if ( $event_end_time ) $event_times .= sprintf('<span class="dates-sep"> &ndash; </span>%s', $event_end_time);
	$event_details .= sprintf( '<div class="event-time"><i class="fa fa-clock-o"></i> <span>%s</span></div>', $event_times );
	}
	
	//location
	if ($event_loc ) 
	$event_details .= sprintf( '<div class="event-location"><i class="fa fa-map-marker"></i> <span>%s</span></div>', $event_loc );
					
	//description 
	if ( $event_desc )
	$event_details .= do_shortcode('[accordian divider_line="yes" class="event-desc" id=""]
	[toggle title="' . __('Description', 'Avada') . '" open="no"]' . $event_desc .'[/toggle]');				
	
	$events_list .= do_shortcode('[one_full spacing="yes" class="event-meta" last="no" margin_bottom="20px"]' . $event_details . '[/one_full]');
	//event-details

endwhile; 			
$events_list .= '</div>'; 
endif; //research-events-content

//meta
$start_date_raw = get_post_meta( $post->ID, 'research_start_yyyymm', true);
if ($start_date_raw ) {
	$start_date = date('M Y', strtotime($start_date_raw)); 
} else { 
	$start_date = get_post_meta($post->ID, 'research_start_yr', true);
}
$end_date_raw = get_post_meta( $post->ID, 'research_end_yyyymm', true);
if ($end_date_raw ) {
	$end_date = date('M Y', strtotime($end_date_raw)); 
} else {
	$end_date = get_post_meta($post->ID, 'research_end_yr', true);
}

$research_date = '<i class="fa fa-calendar-o"></i> ' . $start_date;
if ( $end_date ) $research_date .= '<span class="dates-sep"> &ndash; </span>' . $end_date;
$metadata .= sprintf( '<span>%s</span><span class="fusion-inline-sep">|</span>', $research_date );

//Director
$director_arr = array();
$director_int_obj = get_post_meta($post->ID, 'research_director_int', true);
$director_int = get_the_title($director_int_obj);
$director_ext = get_post_meta($post->ID, 'research_director_ext', true);
if ($director_int) $director_arr['int'] = $director_int;
if ($director_ext) $director_arr['ext'] = $director_ext;

if ( $director_int || $director_ext ) : 			
	if ( $director_int && $director_ext) :
		$director_header = __('Directors',  'Avada' ); 
		$directors = $director_int . ' &#183; ' . $director_ext; 
	else : 
		$director_header = __('Director',  'Avada' ); 
		$directors = $director_int . $director_ext; 
	endif;
	$metadata .= sprintf( '<i class="fa fa-user"></i> %s: <span>%s</span><span class="fusion-inline-sep">|</span>', $director_header, $directors );
endif; 

//Sponsors
$research_sponsors = get_post_meta($post->ID, 'research_sponsors', true);
$research_sponsors_array = get_post_meta($post->ID, 'research_sponsors_array', true);
if ( $research_sponsors > 0) :
	$int_sponsors = $ext_sponsors = array();
	$count = $research_sponsors;
	while(has_sub_field('research_sponsors')):
	$sponsor_name = get_sub_field('research_sponsor_name');
	$sponsor_url = get_sub_field('research_sponsor_link');
	$sponsor_type = get_sub_field('research_sponsor_type');
	$research_sponsor = sprintf( '<a href="%s" title="%s" class="sponsor-' . $sponsor_type . '">%s</a>', $sponsor_url, $sponsor_name, $sponsor_name);
		if ( $sponsor_type = 'int') {
			$int_sponsors[] .= $research_sponsor;
		} elseif ( $sponsor_type = 'ext' ) {
			$ext_sponsors[] .= $research_sponsor;
		} 
	endwhile;
	$arrays_merge = array_merge($int_sponsors, $ext_sponsors);
	$sponsors_list = implode( ' &#183; ', $arrays_merge );
	if ( $research_sponsors > 1 ) $sponsors_label = 'Sponsors'; else $sponsors_label = 'Sponsor';
	$metadata .= sprintf( '<i class="fa fa-money"></i> %s: <span>%s</span><span class="fusion-inline-sep">|</span>', __( $sponsors_label, 'Avada' ), $sponsors_list);
endif;

//Topics
ob_start();
echo get_the_term_list( $post->ID, 'mith_topic', '<i class="fa fa-tags"></i> ' . __( 'Topics', 'Avada' ) . ': <span>', ', ', '</span>' );
$topics = ob_get_clean();
if ( $topics )
$metadata .= sprintf( '%s<span class="fusion-inline-sep">|</span>', $topics );

//Partnerships
$partnerships = get_post_meta($post->ID, 'research_partners', true);
if ( $partnerships > 0 ) :
$partners = '';
$ext_partners = $int_partners = array();

	while ( has_sub_field('research_partners') ) :
		$partner_int = get_sub_field('research_partner_int'); 
		$partner_int_obj = get_sub_field_object('research_partner_int');
		$partner_int_val = get_sub_field('research_partner_int');
		$partner_ext = get_sub_field('research_partner_ext');
		$partner_ext_obj = get_sub_field_object('research_partner_ext');
		$partner_ext_val = get_sub_field('research_partner_ext');
		foreach( $partner_ext_obj['choices'] as $e => $ev ): 
			if( $e == $partner_ext_val ):
				$ext_partners[] .= sprintf('<span class="partner-ext %s">%s</span>', $e, $ev );
			endif;
		endforeach;
		foreach( $partner_int_obj['choices'] as $i => $iv ): 
			if( $i == $partner_int_val ):
				$int_partners[] .= sprintf('<span class="partner-int %s">%s</span>', $i, $iv );
			endif;
		endforeach; 				
	endwhile;
$partners_merge = array_merge($int_partners, $ext_partners);
$partners = implode( ' &#183; ', $partners_merge);
if ( $partnerships > 1 ) $partners_label = 'Partners'; else $partners_label = 'Partner';				
$metadata .= sprintf( '<i class="fa fa-university"></i> %s: %s<span class="fusion-inline-sep">|</span>', __( $partners_label, 'Avada' ), $partners);

endif;	

$html = $events_list . sprintf ( '<div class="fusion-meta-info"><div class="fusion-meta-info-wrapper">%s</div></div>', $metadata);
echo $html; ?>
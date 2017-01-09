<?php 
function person_info_snippet($size = 'full') {
	global $post;
	
	$person_info = '';
	$post_thumbnail = '';
	$person_details = '';
	$person_link = get_permalink( get_the_ID());
	
	$info_column = 'two_third';
	$margin_bottom = '';
	$size_css = sprintf( 'info-layout-%s', $size); // get size of info box content
	
	if ( !has_post_thumbnail() || $size == 'name-only') { // no image = full width info box
		$post_thumbnail = 'no-thumb'; 
		$info_column = 'one_full';
	}
	
	if (has_post_thumbnail() && $size != 'name-only' ) :
	
	$image_id = get_post_thumbnail_id($post->ID);
	$image_src = wp_get_attachment_image_src( $image_id, 'medium-square' );
	$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true);

	$image_frame = '[imageframe lightbox="no" lightbox_image="no" style_type="" bordercolor="" bordersize="" borderradius="" stylecolor="" align="" link="' . $person_link . '" linktarget="" animation_type="" animation_direction="" animation_speed="" class="" id=""]<img alt="' .$image_alt . '" src="' . $image_src[0] . '" />[/imageframe]';
	$person_info .= do_shortcode('[one_third last="no" spacing="yes" id=""]' . $image_frame . '[/one_third]'); 
	 
	 endif; // end post_thumbnail check
	?> 

	<?php 
	$person_title = get_post_meta( get_the_ID(), 'person_title', true );
	$person_affiliation = get_post_meta( get_the_ID(), 'person_affiliation', true);
	$person_email = get_post_meta( get_the_ID(),'person_email', true );
	$person_phone = get_post_meta( get_the_ID(),'person_phone', true );
	$person_website = get_post_meta( get_the_ID(),'person_website', true );
	$person_twitter = get_post_meta( get_the_ID(),'person_twitter_handle', true ); 
	
	if ( $size == 'name-only') : 
	$person_details .= '<h3 class="post-info-name">' . get_the_title( get_the_ID() ) . '</h3>';
	else : 
	$person_details .= '<h3 class="post-info-name"><a href="' . $person_link . '" title="' . get_the_title( get_the_ID() ) . '">' . get_the_title( get_the_ID() ) . '</a></h3>';
	endif; 
	if ( $size != 'name-only') : 
	$person_details .= '<h4 class="post-info-title">' . $person_title . '</h4>';
		if ( $person_affiliation ) $person_details .= '<h4 class="post-affiliation">' . $person_affiliation. '</h4>';
	
		if ( $size == 'full') :  // only render the following on single pages
		
			if ( $person_email != '') : 
			$icon_email = '[fontawesome icon="envelope" circle="no" size="medium" iconcolor="#999999" circlecolor="" circlebordercolor="" flip="" rotate="" spin="" animation_type="" animation_direction="" animation_speed="" alignment="left" class="speaker-email" id=""]';
			$person_details .= '<div class="post-email fusion-clearfix clearfix"><a href="mailto:' . $person_email .'">' . do_shortcode($icon_email) .  $person_email . '</a></div>';
			endif;
		
			if ( $person_phone != '') : 
			$icon_phone = '[fontawesome icon="phone" circle="no" size="medium" iconcolor="#999999" circlecolor="" circlebordercolor="" flip="" rotate="" spin="" animation_type="" animation_direction="" animation_speed="" alignment="left" class="speaker-phone" id=""]';
			$person_details .= '<div class="post-phone fusion-clearfix clearfix"><a href="mailto:' . $person_phone .'">' . do_shortcode($icon_phone) .  $person_phone . '</a></div>';
			endif;
		
			if ( $person_twitter != '') : 
			$icon_twitter = '[fontawesome icon="twitter" circle="no" size="medium" iconcolor="#00aced" circlecolor="" circlebordercolor="" flip="" rotate="" spin="" animation_type="" animation_direction="" animation_speed="" alignment="left" class="speaker-twitter" id=""]';
			$person_details .= '<div class="post-twitter fusion-clearfix clearfix"><a href="http://www.twitter.com/' . $person_twitter .'" rel="nofollow" target="_blank">' . do_shortcode($icon_twitter) . '@' . $person_twitter . '</a></div>';
			endif;
		
			if ( $person_website != '') :
			$icon_web = '[fontawesome icon="external-link-square" circle="no" size="medium" iconcolor="#999999" circlecolor="" circlebordercolor="" flip="" rotate="" spin="" animation_type="" animation_direction="" animation_speed="" alignment="left" class="speaker-website" id=""]';
			$person_details .= '<div class="post-website fusion-clearfix clearfix" style="clear:both"><a href="http://' . $person_website . '" rel="nofollow" target="_blank">' . do_shortcode($icon_web) . '' . __('Website', 'Avada') . '</a></div>';
			endif; 
			
		endif;
	endif; 

	//$person_dates = get_post-meta( $post->ID, 'person_dates' );
	if ( $size == 'name-only' && get_field( 'person_dates', get_the_ID() ) ) :
		$margin_bottom = '0';
		$person_info_dates .= '<div class="info-dates">';
		while(has_sub_field('person_dates')) :
			$psn_title = get_sub_field('person_dates_title'); 
			$psn_date_start = get_sub_field('person_dates_start');
			$psn_date_end = get_sub_field('person_dates_end');
			
			$person_info_dates .= '<h4 class="span-date">'; 
			if ( $psn_title != '') { 
				$person_info_dates .= '<em>' . $psn_title; }
				if ( $psn_date_start != '' || $psn_date_end != '' ) { 
					$person_info_dates .= ',&nbsp;</em>'; } 
				else { 
					$person_info_dates .= '</em>'; 
				}
				if ( $psn_date_start != '') { 
					$person_info_dates .= $psn_date_start;
				} 
				if ( $psn_date_start != '' && $psn_date_end != '' ) { 
					$person_info_dates .= '&nbsp;&ndash;&nbsp;';  
				} 
				if ( $psn_date_end != '') { 
					$person_info_dates .= $psn_date_end;
			} 
			$person_info_dates .= '</h4>';		
		endwhile; 
		$person_info_dates .= '</div>';
		$person_details .= $person_info_dates;
	endif; 	
	
	$person_info .= do_shortcode('[' . $info_column . ' last="yes" spacing="yes" background_color="" background_image="" background_repeat="" background_position="" border_size="" border_color="" border_style="" padding="" margin_top="" margin_bottom="' . $margin_bottom . '" animation_type="" animation_direction="" animation_speed="" class="person-info ' . $post_thumbnail . $size_css .'" id=""]' . $person_details . '<!-- /podcast-info -->[/' . $info_column . ']'); 
	
	return $person_info;
					
}
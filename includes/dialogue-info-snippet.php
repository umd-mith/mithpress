<?php 
function dialogue_info_snippet( $size = 'full', $col = 'two_third', $date_time = '' ) {
	
	$talk_date_raw = get_post_meta( get_the_ID(), 'dialogue_date', TRUE);
	$talk_time = get_post_meta( get_the_ID(), 'dialogue_time', TRUE);
	$talk_location = get_post_meta( get_the_ID(), 'dialogue_location', TRUE); 
	$talk_title = get_post_meta( get_the_ID(), 'dialogue_title', TRUE );
	$talk_sponsor = get_post_meta( get_the_ID(), 'dialogue_sponsors', TRUE );
	
	$dialogue_info = '';
	$post_thumbnail = '';
	$dialogue_details = '';
	$speaker_info = '';
	$speaker_details = '';
	
	$info_column = $col;
	$size_css = sprintf( ' info-layout-%s', $size); // get size of info box content
	$h = 'h3'; // set whether title is h3 or div tag
	
	if ( has_post_thumbnail() && $info_column != 'one_full' ) : 
		$post_thumbnail = 'has-thumb';
		$info_column = 'two_third';
	else : // no image = full width info box
		$post_thumbnail = 'no-thumb'; 
		$info_column = 'one_full';
	endif; 
	
	if ( $info_column == 'one_full' || $size == 'excerpt' ) : $h = 'div'; 
	else : $h = 'h3'; endif; 
	
	/* Image Check */
	if (has_post_thumbnail()) :
	$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium-square' );
	$image_url_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
	$image_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
	
		if ( $info_column != 'one_full') : // if not a full width info box, add image to dialogue info
			$image_src = '<img alt="' .$image_alt . '" src="' . $image_url[0] . '" />';
			$image_frame = '[imageframe lightbox="no" lightbox_image="no" style_type="" bordercolor="" bordersize="" borderradius="" stylecolor="" align="" link="" linktarget="" animation_type="" animation_direction="" animation_speed="" class="" id=""]' . $image_src . '[/imageframe]';
			$dialogue_info .= do_shortcode('[one_third last="no" spacing="yes" class="speaker-img" id=""]' . $image_frame . '[/one_third]'); 
		endif;
	
	endif; // end post_thumbnail check
	
	/* Dialogue Speakers */
	$dialogue_speakers = get_field('dialogue_speakers', get_the_ID());
		if( have_rows('dialogue_speakers', get_the_ID()) ) :
			while(have_rows('dialogue_speakers')) : the_row();
				$speaker_name = get_sub_field('dialogue_speaker_name', get_the_ID());
				$speaker_title = get_sub_field('dialogue_speaker_title', get_the_ID());
				$speaker_affiliation = get_sub_field('dialogue_speaker_affiliation', get_the_ID());
				$speaker_bio = get_sub_field('dialogue_speaker_bio', get_the_ID());
				$speaker_website = get_sub_field('dialogue_speaker_website', get_the_ID());
				$speaker_twitter = get_sub_field('twitter_handle', get_the_ID());
				
				if ( $h == 'h3' ) $speaker_info = do_shortcode('[title size="3" content_align="left" style_type="none" sep_color="" margin_top="0" margin_bottom="0" class="post-speaker-name" id=""]' . $speaker_name . '[/title]');
				else $speaker_info = '<div class="post-speaker-name">' . $speaker_name . '</div>'; 
					if ($speaker_title != null && $size != 'excerpt') : 
					$speaker_info .=  '<div class="post-info-title">' . $speaker_title . '</div>'; 
					endif;
					
					$speaker_info .= '<div class="post-affiliation">' . $speaker_affiliation. '</div>';
					
					if ( $speaker_twitter != '' && $size != 'excerpt' ) : 
					$icon_twitter = '[fontawesome icon="twitter" circle="no" size="medium" iconcolor="#00aced" circlecolor="" circlebordercolor="" flip="" rotate="" spin="" animation_type="" animation_direction="" animation_speed="" alignment="left" class="speaker-twitter" id=""]';
					$speaker_info .= '<div class="post-twitter"><a href="http://www.twitter.com/' . $speaker_twitter .'" rel="nofollow" target="_blank">' . do_shortcode($icon_twitter) . '@' . $speaker_twitter . '</a></div>';
					endif;
		
					if ( $speaker_website != '' && $size != 'excerpt' ) :
					$icon_web = '[fontawesome icon="external-link-square" circle="no" size="medium" iconcolor="#999999" circlecolor="" circlebordercolor="" flip="" rotate="" spin="" animation_type="" animation_direction="" animation_speed="" alignment="left" class="speaker-website" id=""]';
					$speaker_info .= '<div class="post-website" style="clear:both"><a href="http://' . $speaker_website . '" rel="nofollow" target="_blank">' . do_shortcode($icon_web) . '' . __('Speaker Website', 'Avada') . '</a></div>';
					endif; 
				$speaker_details .= '<div class="post-speaker">' . $speaker_info . '</div>';
			endwhile; 
		endif; 
		
		/* Dialogue Details */
		$dialogue_details .= '<div class="dialogue-details">';
			if ( $col != 'one_full' || $date_time = 'show') : 
				$separator = do_shortcode('[separator style_type="single" top_margin="10" bottom_margin="10" sep_color="#dfdfdf" border_size="1px" width="" alignment="" class="" id=""]');
				if ( $date_time != 'show' ) $dialogue_details .= $separator; 
				elseif ( $date_time = 'show' ) $dialogue_details .= '<div class="fusion-content-sep" style="margin-top:5px; margin-bottom:5px;"></div>';
			
				$dialogue_details .= '<span class="info-location">'; 
					if ($talk_location) : $dialogue_details .= $talk_location; else : $dialogue_details .= 'MITH Conference Room'; endif; 
				$dialogue_details .= '</span>';
			endif;	
			$dialogue_details .= '<div class="info-dates">'; 
				$date_format = 'l, F j, Y';
				if ($col == 'one_full' && $size != 'full') $date_format = 'D, M j, Y';
				if ($talk_date_raw != '') : 
					$talk_date = date($date_format, strtotime($talk_date_raw)); 
				elseif ( get_post_meta(get_the_ID(), 'talk-date', TRUE) != '') : 
					$talk_date = get_post_meta(get_the_ID(), 'talk-date', TRUE); 
				else : $talk_date = get_the_date( 'l, F j, Y' ); endif; 
			$dialogue_details .= $talk_date . '</div>';
			
			if ( ( $talk_time != '' && $col != 'one_full' ) || ( $talk_time != '' && $date_time == 'show') ) $dialogue_details .= '<div class="info-times">' . $talk_time . '</div>';     
			if ($talk_sponsor != '' && $col != 'one_full') $dialogue_details .= '<div class="post-sponsor">' . $talk_sponsor . '</div>';
			
		$dialogue_details .= '</div>';
		
		/* Assemble Columns */
		if ($col != 'one_full' || $date_time == 'show') $dialogue_details = $speaker_details . $dialogue_details;
		else $dialogue_details = $dialogue_details . $speaker_details;
		
		/* Display Shortcode */
		$dialogue_info .= do_shortcode('[' . $info_column . ' last="yes" spacing="yes" background_color="" background_image="" background_repeat="" background_position="" border_size="" border_color="" border_style="" padding="" margin_top="" margin_bottom="" animation_type="" animation_direction="" animation_speed="" class="dialogue-info ' . $post_thumbnail . $size_css .'" id=""]' . $dialogue_details . '<!-- /podcast-info -->[/' . $info_column . ']'); 
		
		$html = $dialogue_info;
		
		echo $html;			
}
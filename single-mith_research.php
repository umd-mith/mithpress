<?php get_header(); ?>
	<?php

	$content_css = 'float:left';
	$sidebar_css = 'float:right';
	$content_class = '';
	$sidebar_exists = false;
	$sidebar_left = '';
	$double_sidebars = false;

	/*$sidebar_1 = get_post_meta( $post->ID, 'sbg_selected_sidebar_replacement', true );
	$sidebar_2 = get_post_meta( $post->ID, 'sbg_selected_sidebar_2_replacement', true );

	if( $smof_data['posts_global_sidebar'] ) {
		if( $smof_data['posts_sidebar'] != 'None' ) {
			$sidebar_1 = array( $smof_data['posts_sidebar'] );
		} else {
			$sidebar_1 = '';
		}

		if( $smof_data['posts_sidebar_2'] != 'None' ) {
			$sidebar_2 = array( $smof_data['posts_sidebar_2'] );
		} else {
			$sidebar_2 = '';
		}
	}

	if( ( is_array( $sidebar_1 ) && ( $sidebar_1[0] || $sidebar_1[0] === '0' ) ) && ( is_array( $sidebar_2 ) && ( $sidebar_2[0] || $sidebar_2[0] === '0' ) ) ) {
		$double_sidebars = true;
	}

	if( is_array( $sidebar_1 ) &&
		( $sidebar_1[0] || $sidebar_1[0] === '0' ) 
	) {
		$sidebar_exists = true;
	} else {
		$sidebar_exists = false;
	}

	if( ! $sidebar_exists ) {
		$content_css = 'width:100%';
		$sidebar_css = 'display:none';
		$sidebar_exists = false;
	} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
		$content_class = 'portfolio-one-sidebar';
		$sidebar_exists = true;
		$sidebar_left = 1;
	} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right') {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
		$content_class = 'portfolio-one-sidebar';
		$sidebar_exists = true;
	} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'default' || ! metadata_exists( 'post', $post->ID, 'pyre_sidebar_position' )) {
		$content_class = 'portfolio-one-sidebar';
		if($smof_data['blog_sidebar_position'] == 'Left') {
			$content_css = 'float:right;';
			$sidebar_css = 'float:left;';
			$sidebar_exists = true;
			$sidebar_left = 1;
		} elseif($smof_data['blog_sidebar_position'] == 'Right') {
			$content_css = 'float:left;';
			$sidebar_css = 'float:right;';
			$sidebar_exists = true;
			$sidebar_left = 2;
		}
	}

	if(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right') {
		$sidebar_left = 2;
	}

	if( $smof_data['posts_global_sidebar'] ) {
		if( $smof_data['posts_sidebar'] != 'None' ) {
			$sidebar_1 = $smof_data['posts_sidebar'];
			
			if( $smof_data['blog_sidebar_position'] == 'Right' ) {
				$content_css = 'float:left;';
				$sidebar_css = 'float:right;';	
				$sidebar_left = 2;
			} else {
				$content_css = 'float:right;';
				$sidebar_css = 'float:left;';
				$sidebar_left = 1;
			}			
		}

		if( $smof_data['posts_sidebar_2'] != 'None' ) {
			$sidebar_2 = $smof_data['posts_sidebar_2'];
		}
		
		if( $smof_data['posts_sidebar'] != 'None' && $smof_data['posts_sidebar_2'] != 'None' ) {
			$double_sidebars = true;
		}
	} else {
		$sidebar_1 = '0';
		$sidebar_2 = '0';
	}
	
	if($double_sidebars == true) {
		$content_css = 'float:left;';
		$sidebar_css = 'float:left;';
		$sidebar_2_css = 'float:left;';
	} else {
		$sidebar_left = 1;
	}
	*/ ?>
	
	<div id="content" class="<?php echo $content_class; ?>" style="<?php echo $content_css; ?>">
		<?php if(have_posts()): the_post(); ?>
        
        <div id="post-<?php the_ID(); ?>" <?php post_class('post research-post'); ?>>
			<?php
			global $smof_data;
			$full_image = '';
			if( ! post_password_required($post->ID) ): // 1
			if($smof_data['featured_images_single']): // 2
			if( avada_number_of_featured_images() > 0 || get_post_meta( $post->ID, 'pyre_video', true ) ): // 3
			?>
			<div class="fusion-flexslider flexslider post-slideshow fusion-post-slideshow">
				<ul class="slides">
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li>
						<div class="full-video">
							<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
						</div>
					</li>
					<?php endif; ?>
					<?php if( has_post_thumbnail() && get_post_meta( $post->ID, 'pyre_show_first_featured_image', true ) != 'yes' ): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<?php if( ! $smof_data['status_lightbox'] && ! $smof_data['status_lightbox_single'] ): ?>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
						<?php else: ?>
						<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" />
						<?php endif; ?>
					</li>
					<?php endif; ?>
					<?php
					$i = 2;
					while($i <= $smof_data['posts_slideshow_number']):
					$attachment_new_id = kd_mfi_get_featured_image_id('featured-image-'.$i, 'post');
					if($attachment_new_id):
					?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment_new_id, 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment_new_id, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment_new_id); ?>
					<li>
						<?php if( ! $smof_data['status_lightbox'] && ! $smof_data['status_lightbox_single'] ): ?>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', $attachment_new_id); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta($attachment_new_id, '_wp_attachment_image_alt', true); ?>" /></a>
						<?php else: ?>
						<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta($attachment_new_id, '_wp_attachment_image_alt', true); ?>" />
						<?php endif; ?>
					</li>
					<?php endif; $i++; endwhile; ?>
				</ul>
			</div>
			<?php endif; // 3 ?>
			<?php endif; // 2 ?>
			<?php endif; // 1 ?>
            
			<?php if ( get_post_meta( $post->ID, 'display_entry_title', true) ) : ?>
			<h2<?php if( ! $smof_data['disable_date_rich_snippet_pages'] ) { echo ' class="entry-title"'; } ?>><?php the_title(); ?></h2>
			<?php else : ?>
			<span class="entry-title" style="display: none;"><?php the_title(); ?></span>
			<?php endif; ?>
			<div class="post-content research-content clearfix">
				<?php echo avada_render_rich_snippets_for_pages(); ?>
                <?php $side_content = ''; ?>
                <?php //ob_start();
				the_content();
				//$content = ob_get_clean();
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
									
				if( have_rows('research_events') ): 
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
				
			</div><!-- /research-content -->
			<?php //endif; ?>
            
			<?php if( ! post_password_required($post->ID) ): ?>
			<?php if( ( $smof_data['social_sharing_box'] && get_post_meta($post->ID, 'pyre_share_box', true) != 'no' ) || 
					  ( ! $smof_data['social_sharing_box'] && get_post_meta($post->ID, 'pyre_share_box', true) == 'yes' ) ):
				$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				$sharingbox_soical_icon_options = array (
					'sharingbox'		=> 'yes',
					'icon_colors' 		=> $smof_data['sharing_social_links_icon_color'],
					'box_colors' 		=> $smof_data['sharing_social_links_box_color'],
					'icon_boxed' 		=> $smof_data['sharing_social_links_boxed'],
					'icon_boxed_radius' => $smof_data['sharing_social_links_boxed_radius'],
					'tooltip_placement'	=> $smof_data['sharing_social_links_tooltip_placement'],
                	'linktarget'        => $smof_data['social_icons_new'],
					'title'				=> wp_strip_all_tags(get_the_title( $post->ID ), true),
					'description'		=> wp_strip_all_tags(get_the_title( $post->ID ), true),
					'link'				=> get_permalink( $post->ID ),
					'pinterest_image'	=> ($full_image) ? $full_image[0] : '',
				);
				?>
				<div class="fusion-sharing-box share-box">
					<h4><?php echo __('Share This Page!', 'Avada'); ?></h4>
					<?php echo $social_icons->render_social_icons( $sharingbox_soical_icon_options ); ?>
				</div>
			<?php endif; ?>
			<?php endif; ?>
		</div><!-- /.post -->
	</div>
    <?php endif; // end content ?>
    
	<?php //wp_reset_query(); ?>
	<div id="sidebar" class="sidebar" style="<?php echo $sidebar_css; ?>">
    	<?php
		$research_people_int = get_post_meta($post->ID, 'research_people_int', true);
		$research_people_ext = get_post_meta($post->ID, 'research_people_ext', true);
		$website_url = get_post_meta($post->ID, 'research_website_url', true);
		$research_links = get_post_meta($post->ID, 'research_links_ext', true);
		$research_file_links = get_post_meta($post->ID, 'research_file_links', true);
		$twitter_acct = get_post_meta($post->ID, 'research_twitter_account', true);
		$twitter_hash = get_post_meta($post->ID, 'research_twitter_hashtag', true);
		$twitter_code = get_post_meta($post->ID, 'research_twitter_code', true);
		
		// director
		if ( count($director_arr) > '0' ) : 
		if ( count($director_arr) > '1' ) $dir_title = __('Directors', 'Avada'); else $dir_title = __('Director', 'Avada');
		$dir_content .= '
		<div id="research_director" class="widget mith_research_contact-widget research-info-box research-contact">		
			<div class="heading"><h4 class="widget-title">' . $dir_title . '</h4></div>
			<ul>';
			foreach ( $director_arr as $director_name => $director_val) : 
			$dir_content .= sprintf('<li class="%s director-%s">%s</li>', 'research-director', $director_name, $director_val);
			endforeach;
		$dir_content .= ' 
			</ul>          
		</div>';
		$side_content .= $dir_content;  
		endif;
		
		// people 
		if ($research_people_int > '0' || $research_people_ext > '0' ) :
			$i = 0;
			$count = 0;
			$people = '';
			
			while(has_sub_field('research_people_int')):
				$internal_person = get_sub_field('research_person');
				$status = $internal_person->post_status; 
				if ( $status == "publish") : 
				$count++;
				endif;
			endwhile;
			while(has_sub_field('research_people_ext')):
				$external_person = get_sub_field('research_person_name');
				if ( $external_person != '') : 
				$count++;
				endif;
			endwhile;
			
			if ( $count != 0 ) { // have one or more staff 
				while(has_sub_field('research_people_int')):
					$internal_person = get_sub_field('research_person'); 
					$id = $internal_person->ID; 
					$status = $internal_person->post_status; 
					$meta_values = wp_get_object_terms($id, 'mith_staff_group');;
					$terms = array('people-past','people-past-directors','people-past-finance-administration','people-past-staff','people-past-research-associates','people-past-resident-fellows');
					$person = '';
					if ( $status == "publish") { // display person 
						$person_class = 'int-person';
						$person_name = get_the_title($id);
							if ( !has_term( $terms, 'mith_staff_group', $id) ) : 
							$person_permalink = get_permalink($id);
							$person_li = sprintf('<a href="%s" title="%s">%s</a>', $person_permalink, $person_name, $person_name);
							else : 
							$person_class .= ' people-past-staff';
							$person_li = $person_name;
							endif; 
						$person .= sprintf('<li class="%s">%s</li>', $person_class, $person_li);
					} // end published person display

					$people .= $person;
				endwhile; // end linked internal person 
				
				while(has_sub_field('research_people_ext')):
					$ext_name = get_sub_field('research_person_name'); 
					$ext_title = get_sub_field('research_person_title'); 
					$ext_dept = get_sub_field('research_person_department'); 
					$ext_aff = get_sub_field('research_person_affiliation');
					$person = '';
					$person .= '<li class="ext-person">' . $ext_name; 
					if ( $ext_title ) { $person .= '<span class="ext-person-title">' . $ext_title . '</span>'; } 
					if ( $ext_dept ) { $person .= '<span class="ext-person-dept">' . $ext_dept. '</span>'; } 
					if ( $ext_aff ) { $person .= '<span class="ext-person-aff">' . $ext_aff. '</span>'; } 
					$person .= '</li>';
					
					$people .= $person; 
				endwhile; // end linked external person 	

			$side_content .= '
			<div id="research_ppl" class="widget mith_research_ppl-widget research-info-box research-ppl">		
				<div class="heading"><h4 class="widget-title">' . __('Participating People', 'Avada') . '</h4></div>
					<ul>' . $people . '</ul>
			</div>';

			} // end count
		endif; // end linked staff
		
		if( $research_file_links > 0 ) :
		
			$i = 0;
			$count = $research_file_links;
					
			if ( $count != 0 ) : // have one or more 
			$rsch_files_content = '';
			while(has_sub_field('research_file_links')) :
				$file_id = get_sub_field('research_file_link'); 
				$file_url = wp_get_attachment_url( $file_id );
				$file_name = get_sub_field('research_file_display_name'); 
				$file_img = get_sub_field('research_file_display_image');  
				
				$rsch_files_content .= '<li>';
				if ( $file_img != '') { 		
					$img_size = 'thumbnail';	
					$image = wp_get_attachment_image_src( $file_img, $img_size);
				}
				$rsch_files_content .= '
				<a href="' . $file_url . '" target="_blank">';
					if ( $file_img ) : $rsch_files_content .= '<img src="' . $image[0] . '" alt="' . $file_name . '" />';
					else : $rsch_files_content .= $file_name; 
					endif;
				$rsch_files_content .= '
				</a>
				</li>';
			$i++;
			endwhile; // end linked file	
			
			$rsch_files = '
			<div id="research_files" class="widget mith_research_files-widget research-info-box research-files">		
				<div class="heading"><h4 class="widget-title">' . __('Files', 'Avada') . '</h4></div>
				<ul>' . $rsch_files_content . '</ul>
			</div>'; 

			endif;
			
			$side_content .= $rsch_files; 
		endif; // end files ?>
		
		<?php 
		if( $research_links > 0 || $website_url != '') :
			
			if ( $website_url ) 
			$rsch_links_content .= '<li><a href="' . $website_url . '" title="Website">' . __('Website', 'Avada') . '</a>';
		
			$count = $research_links;
			if ( $count != 0 ) : // have one or more 

			while(has_sub_field('research_links_ext')):
				$linky = get_sub_field('research_link_url'); 
				$linky_title = get_sub_field('research_link_title');
				$rsch_links_content .= '<li><a href="' . $linky . '" title=' . $linky_title . '">'; 
				if ($linky_title != '') { 
					$rsch_links_content .= $linky_title; 
				} else { 
					$rsch_links_content .= $linky; 
				} 
				$rsch_links_content .= '</a></li>';
			$i++;
			endwhile; // end link

			$rsch_links = '
			<div id="research_links" class="widget mith_research_links-widget research-info-box research-links">		
				<div class="heading"><h4 class="widget-title">' . __('Links', 'Avada') . '</h4></div>
				<ul>' . $rsch_links_content . '</ul>
			</div>'; 
			
			endif;
			$side_content .= $rsch_links; 
	
		endif; // end files		
		
		echo $side_content; 
		
 		mith_display_tagged_posts(); ?>

		<?php if ( $twitter_code != '') { 
		$twit_content .= '
        <div id="mith_recent_tweets" class="widget mith_recent_tweets-widget">
            <div class="heading"><h4 class="widget-title">' . __('Tweets', 'Avada') . '</h4></div>' . $twitter_code; ?>
                <?php if ($twitter_acct != '' || $twitter_hash != '') { 
				$twit_content .= '<div class="twitter-more">';
					if ($twitter_acct != '') { 
					$twit_content .= '<a href="http://www.twitter.com/' . $twitter_acct . '" rel="nofollow" target="_blank" class="follow">Follow @' . $twitter_acct . '</a>';
                    } elseif ($twitter_hash != '') { 
					$twit_content .= '<a href="http://www.twitter.com/search?q=%23' . $twitter_hash . '" rel="nofollow" target="_blank" class="follow">Follow #' . $twitter_hash . '</a>'; 
                    } 
				$twit_content .= '</div>';
                } 
		$twit_content .= '</div>';
		
		echo $twit_content; 
        } 
		?>
	</div><!-- /sidebar -->
    
<?php get_footer(); ?>
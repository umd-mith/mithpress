<div id="sidebar" <?php Avada()->layout->add_class( 'sidebar_1_class' ); ?> <?php Avada()->layout->add_style( 'sidebar_1_style' ); ?>>
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
</div>

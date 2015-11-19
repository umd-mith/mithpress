<?php get_header(); ?>
	<?php
	$content_css = 'float:left';
	$sidebar_css = 'float:right';
	$content_class = '';
	$sidebar_exists = false;
	$double_sidebars = false;

/*
	$sidebar_1 = get_post_meta( $post->ID, 'sbg_selected_sidebar_replacement', true );
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
	*/
	if($double_sidebars == true) {
		$content_css = 'float:left;';
		$sidebar_css = 'float:left;';
		$sidebar_2_css = 'float:left;';
	} else {
		$sidebar_left = 1;
	} 
	?>
    
	<div id="content" class="<?php echo $content_class; ?>" style="<?php echo $content_css; ?>">
		<?php if(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('post dialogue-post'); ?>>
			<h2<?php if( ! $smof_data['disable_date_rich_snippet_pages'] ) { echo ' class="entry-title"'; } ?> style="display:none;"><?php if ($talk_title) : echo $talk_title; else : the_title(); endif; ?></h2>
			<div class="post-content dialogue-content">            	
				<?php dialogue_info_snippet(); ?>
				<div class="abstract">
                <?php 
				$video_id = '';
				$vimeo_code = get_post_meta( $post->ID, 'dialogue_vimeo_embed', TRUE); 
				$vimeo_id = get_post_meta( $post->ID, 'dialogue_vimeo_id', TRUE); 
				if ($vimeo_id) : 
					$video_id = $vimeo_id; 
				elseif ($vimeo_code) :
					$video_id = str_replace("https://vimeo.com/", "", $vimeo_code);
				endif;

				
				ob_start();
				the_content();
				$content = ob_get_clean();
				//$content .= $vimeo;
				echo $content; 
				if ($video_id) :
                echo do_shortcode('[vimeo id="' . $video_id .'" width="" height="" autoplay="no" api_params="" class=""]');
                endif; ?>
                
                <?php $dialogue_speakers = get_field('dialogue_speakers');
				if( get_field('dialogue_speakers') ) : ?>
					<?php while(has_sub_field('dialogue_speakers')) : ?>
                    
						<?php if (get_sub_field('dialogue_speaker_bio') != '') : 
						echo do_shortcode('[separator style_type="single|dashed" top_margin="10" bottom_margin="20" sep_color="#d4d4d4" border_size="1px" icon="" icon_circle="" icon_circle_color="" width="" alignment="left" class="" id=""]'); ?>
                        <div class="speaker-bio"><?php echo get_sub_field('dialogue_speaker_bio'); ?></div>
                        <?php endif; ?>
                    
                    <?php endwhile; ?>
				<?php endif; ?>
				</div>
                
                <?php 
				$dd_info = get_post_meta( $post->ID, 'dialogue_info_blurb', TRUE); 
				if ( $dd_info  == '') {
					$dd_info = '<p>A continuously updated schedule of talks is also available on the Digital Dialogues webpage.</p>
<p>Unable to attend the events in person? Archived podcasts can be found on the MITH website, and you can follow our Digital Dialogues Twitter account @digdialog as well as the Twitter hashtag #mithdd to keep up with live tweets from our sessions. Viewers can watch the live stream as well.</p>
<p>All talks free and open to the public. Attendees are welcome to bring their own lunches.</p>
<p>Contact: MITH (<a href="http://mith.umd.edu">mith.umd.edu</a>, <a href="mailto:mith@umd.edu">mith@umd.edu</a>, 301.405.8927). </p>';
				}
				echo do_shortcode('[tagline_box backgroundcolor="#f9f9f9" shadow="no" shadowopacity="1" border="3px" bordercolor="#f6f6f6" highlightposition="top" content_alignment="left" link="" linktarget="" modal="" button_size="" button_shape="" button_type="" buttoncolor="" button="" title="" description="" margin_top="25px" margin_bottom="" animation_type="" animation_direction="" animation_speed="" class="dd-info" id=""]' . $dd_info . '[/tagline_box]'); ?>
                
                
			</div><!-- /post-content -->
            
			<?php if( ! post_password_required($post->ID) ): ?>
			<?php //echo avada_render_post_metadata( 'single' ); ?>
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
					<h4><?php echo __('Share This Dialogue!', 'Avada'); ?></h4>
					<?php echo $social_icons->render_social_icons( $sharingbox_soical_icon_options ); ?>
				</div>
			<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php if( ( ! $smof_data['blog_pn_nav'] && get_post_meta($post->ID, 'pyre_post_pagination', true) != 'no' ) ||
				  ( $smof_data['blog_pn_nav'] && get_post_meta($post->ID, 'pyre_post_pagination', true) == 'yes' ) ): ?>
		<div class="single-navigation clearfix">
			<?php previous_post_link('%link', __('Previous', 'Avada')); ?>
			<?php next_post_link('%link', __('Next', 'Avada')); ?>
		</div>
		<?php endif; ?>
        
	</div>
    <?php endif; // end post ?>
	<?php wp_reset_query(); ?>

	<div id="sidebar" class="sidebar" style="<?php echo $sidebar_css; ?>">
    	<?php 
    		$dialogue_files = get_field('dialogue_files');
			$video_url = '';
			$vimeo_embed = get_post_meta( $post->ID, 'dialogue_vimeo_embed', TRUE); 
			$vimeo_id = get_post_meta( $post->ID, 'dialogue_vimeo_id', TRUE); 
			if ($vimeo_embed) : 
				$video_url = $vimeo_embed;
			elseif ($vimeo_id) :
				$video_url = 'https://vimeo.com/' . $vimeo_id; 
			endif;
	
		if( $dialogue_files || $video_url ) : ?>
  			
            <div id="dialogue_files" class="widget mith_dd_files-widget">
            	<?php if( $video_url ) : // video button at top
					echo do_shortcode('[button link="' . $video_url . '" color="custom" size="medium" type="flat" shape="square" target="_blank" title="View Video" gradient_colors="#1ab7ea|#1ab7ea" gradient_hover_colors="#31bcea|#31bcea" accent_color="#ffffff" accent_hover_color="#ffffff" bevel_color="" border_width="0px" icon="fa-play-circle" icon_position="left" icon_divider="no" modal="" animation_type="0" animation_direction="left" animation_speed="1" alignment="" class="" id=""]' . __('View Dialogue Video', 'Avada') . '[/button]');
					echo do_shortcode( '[separator style_type="none" top_margin="5" bottom_margin="5" sep_color="" border_size="" icon="" icon_circle="" icon_circle_color="" width="" alignment="" class="" id=""]' );
				endif; ?>	
                                	
				<?php if ( $dialogue_files ) : ?>
				<div class="heading"><h3><?php _e( 'Resources', 'Avada' ); ?></h3></div>

                <?php $files_list = '[checklist icon="file-o" iconcolor="#e23a18" circle="no" circlecolor="#ffffff" size="small" class="dialogue-files" id=""]';
                
                foreach($dialogue_files as $file) : 
                    $title = $file['dialogue_file_name'];
                    if ( !$title ) $title = __('Download File');					
                    $type = $file['dialogue_file_type']; // slug	
                    $icon = $file['dialogue_file_icon'];
                    $url = $file['dialogue_file_url'];
                    
                    $file_item = '[li_item icon="' . $icon . '"]<a href="' . $url .'" title="' . $title . '">' . $title . '</a>[/li_item]';
                    
                    /*$file_button = '[button link="' . $url . '" color="custom" size="medium" type="flat" shape="square" target="_blank" title="' . $title . '" gradient_colors="#e23a18|#e23a18" gradient_hover_colors="#ed1a1a|#ed1a1a" accent_color="#ffffff" accent_hover_color="#ffffff" bevel_color="" border_width="0px" icon="' . $icon . '" icon_position="left" icon_divider="no" modal="" animation_type="0" animation_direction="left" animation_speed="1" alignment="" class="dialogue-' . $type .'" id=""]' . $title . '[/button]';				
                    $file_buttons .= $file_button;
                    */
                    $files_list .= $file_item;
                endforeach;
                $files_list .= '[/checklist]';                
                echo do_shortcode( $files_list ); 
				endif; ?>                

        	</div>
			
		<?php endif; ?>
        
        <?php $topics_list = get_the_term_list( $post->ID, 'mith_topic', '<li>', '</li><li>', '</li>' );
		if ($topics_list) : ?> 
			<div id="mith_topics" class="widget mith_dd_topics-widget">
            	<div class="heading"><h3><?php _e( 'Related Topics', 'Avada'); ?></h3></div>
				<ul class="topics-list"><?php echo $topics_list; ?></ul>
			</div>
		<?php endif; ?>
	<?php
		if($sidebar_left == 1) {
			generated_dynamic_sidebar($sidebar_1);
		}
		if($sidebar_left == 2) {
			generated_dynamic_sidebar_2($sidebar_2);
		}
		?>
	</div>

<?php get_footer(); ?>
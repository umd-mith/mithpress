<?php
// Template Name: DD Schedule
get_header(); ?>
	<?php
	$content_css = 'width:100%';
	$sidebar_css = 'display:none';
	$content_class = '';
	$sidebar_exists = true;
	$sidebar_left = '';
	$double_sidebars = false;
	$sidebar_class_left = '';
	$sidebar_class_right = '';

	$sidebar_1 = get_post_meta( $post->ID, 'sbg_selected_sidebar_replacement', true );
	$sidebar_2 = get_post_meta( $post->ID, 'sbg_selected_sidebar_2_replacement', true );

	if( Avada()->settings->get( 'pages_global_sidebar' ) ) {
		if( Avada()->settings->get( 'pages_sidebar' ) != 'None' ) {
			$sidebar_1 = array( Avada()->settings->get( 'pages_sidebar' ) );
		} else {
			$sidebar_1 = '';
		}

		if( Avada()->settings->get( 'pages_sidebar_2' ) != 'None' ) {
			$sidebar_2 = array( Avada()->settings->get( 'pages_sidebar_2' ) );
		} else {
			$sidebar_2 = '';
		}
	}

	if( is_array( $sidebar_2 ) &&
		( $sidebar_2[0] || $sidebar_2[0] === '0' ) ) {
		$double_sidebars = true;
	}

	if(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
		$sidebar_class = 'side-nav-left';
		$content_class = 'portfolio-one-sidebar';
		$sidebar_left = 1;
	} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right') {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
		$sidebar_class = 'side-nav-right';
		$content_class = 'portfolio-one-sidebar';
	} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'default' || ! metadata_exists( 'post', $post->ID, 'pyre_sidebar_position' )) {
		$content_class = 'portfolio-one-sidebar';
		if(Avada()->settings->get( 'default_sidebar_pos' ) == 'Left') {
			$content_css = 'float:right;';
			$sidebar_css = 'float:left;';
			$sidebar_class = 'side-nav-left';
			$sidebar_left = 1;
		} elseif(Avada()->settings->get( 'default_sidebar_pos' ) == 'Right') {
			$content_css = 'float:left;';
			$sidebar_css = 'float:right;';
			$sidebar_class = 'side-nav-right';
			$sidebar_left = 2;
		}
	}

	if(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right') {
		$sidebar_left = 2;
	}

	if( Avada()->settings->get( 'pages_global_sidebar' ) ) {
		if( Avada()->settings->get( 'pages_sidebar' ) != 'None' ) {
			$sidebar_1 = Avada()->settings->get( 'pages_sidebar' );

			if( Avada()->settings->get( 'default_sidebar_pos' ) == 'Right' ) {
				$content_css = 'float:left;';
				$sidebar_css = 'float:right;';
				$sidebar_left = 2;
			} else {
				$content_css = 'float:right;';
				$sidebar_css = 'float:left;';
				$sidebar_left = 1;
			}
		}

		if( Avada()->settings->get( 'pages_sidebar_2' ) != 'None' ) {
			$sidebar_2 = Avada()->settings->get( 'pages_sidebar_2' );
		}

		if( Avada()->settings->get( 'pages_sidebar' ) != 'None' && Avada()->settings->get( 'pages_sidebar_2' ) != 'None' ) {
			$double_sidebars = true;
		}
	} else {
		if( is_array( $sidebar_1 ) ) {
			$sidebar_1 = $sidebar_1[0];
		}
		if( is_array( $sidebar_2 ) ) {
			$sidebar_2 = $sidebar_2[0];
		}
	}

	if($double_sidebars == true) {
		$content_css = 'float:left;';
		$sidebar_css = 'float:left;';
		$sidebar_2_css = 'float:left;';
	} else {
		$sidebar_left = 1;
	}
	?>
	<div id="content" style="<?php echo $content_css; ?>">
		<?php while(have_posts()): the_post();
		$page_id = get_the_ID();
		?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php echo avada_render_rich_snippets_for_pages(); ?>
			<?php echo avada_featured_images_for_pages(); ?>
			<div class="post-content">
				<?php 
				$cats = get_terms('mith_dialogue_series', array(
					'orderby'    => 'slug',
					'order' 	 => 'DESC',
					'hide_empty' => false
				) );
				
				if ( is_page('past-dialogue-schedules') ) : 
				$cats_sort = array_keys($cats);
				$first_cat_value = $cats[$cats_sort[1]];
				$meta_compare = "<="; // only get past posts
				else : 	
				$first_cat_value = reset($cats);
				$meta_compare = ">="; // only get posts happening after today 
				endif;
				
				$first_cat_slug = $first_cat_value->slug;
				$current_date = date('Ymd');
				$date_raw = get_post_meta( get_the_ID(), 'dialogue_date', TRUE);
								
				$args = array(
					'post_type' => 'mith_dialogue',
					'post_status' => array( 'future', 'publish' ),
					'tax_query' => array(
						array(
							'taxonomy' => 'mith_dialogue_series',
							'field' => 'slug',
							'terms' => $first_cat_slug, // only posts in current series
						)
					),
					'meta_query' => array(
						array( 
							'key' => 'dialogue_date',
							'value' => $current_date,
							'compare' => $meta_compare,	// posts before or equal to todays date
							'type' => 'numeric' 
						)
					)					
				);
				
				$current_dds = new WP_Query($args); 
                $array_rev = array_reverse($current_dds->posts); //reverse the order of the posts, latest last
				$current_dds->posts = $array_rev;

				$current_cat = $first_cat_slug;
				$current_cat_posts = get_term_by('slug', $current_cat, 'mith_dialogue_series');
				$current_cat_count = $current_cat_posts->count; ?>
				
				<h2 class="post-title dialogues-series-title dialogues-header"><?php echo $current_cat_posts->name; _e( ' Digital Dialogues Schedule', 'Avada' ); ?></h2>
					
				<form id="dialogue_series_form" action="<?php esc_url( home_url( '/' ) ); ?>/" method="get">
				<div class="dialogue-series-form">
				<?php restrict_dialogues_by_series(); ?>
				<input type="submit" name="submit" value="view" />
				</div></form>
							  
				<?php if ( $current_dds->have_posts() ) :
				echo do_shortcode('[separator style_type="double" top_margin="20" bottom_margin="20" sep_color="#BBBBBB" border_size="" width="" alignment="" class="" id=""]'); ?>
				<div class="dialogue-series">
				
					<?php while ( $current_dds->have_posts() ) : $current_dds->the_post(); 
						$dialogue_date_raw = get_post_meta( get_the_ID(), 'dialogue_date', TRUE);
						if ($dialogue_date_raw != '') { $dialogue_date = date('F j, Y', strtotime($dialogue_date_raw)); } 
						elseif ( get_post_meta(get_the_ID(), 'talk-date', TRUE) != '') { $dialogue_date = get_post_meta(get_the_ID(), 'talk-date', TRUE); } 
						else { $dialogue_date = the_date( 'F j, Y' ); }
						$dialogue_time = get_post_meta( get_the_ID(), 'dialogue_time', TRUE);
						$dialogue_location = get_post_meta( get_the_ID(), 'dialogue_location', TRUE); 
						if (!$location) $dialogue_location = 'MITH Conference Room';
						$dialogue_title = get_post_meta( get_the_ID(), 'dialogue_title', TRUE );
						if (!$dialogue_title) $dialogue_title = the_title();
						$dialogue_sponsor = get_post_meta( get_the_ID(), 'dialogue_sponsors', TRUE );
						$dialogue_meta = ''; ?>
						
						<div class="dialogue-series-item">
							<?php echo do_shortcode('[one_fifth last="no" class="dialogue-date"]' . $dialogue_date . '[/one_fifth]'); 
							$dialogue_meta .= do_shortcode('[button link="' . get_permalink() . '" color="custom" size="small" type="flat" shape="square" target="" title="Link to: ' . $dialogue_title . '" gradient_colors="#ffffff|#ffffff" gradient_hover_colors="#fafafa|#fafafa" accent_color="#20558A" accent_hover_color="#2E7BC6" bevel_color="" border_width="1px" shadow="no" icon="" icon_divider="" icon_position="" modal="" animation_type="" animation_direction="" animation_speed="" alignment="right" class="dialogue-link post-link" id=""]' . __('Details', 'Avada') . '[/button]');
							
							$dialogue_speakers = get_field('dialogue_speakers');
								if( $dialogue_speakers ) :
									$i = 0;
									$count = $dialogue_speakers;
									while(has_sub_field('dialogue_speakers')) :
										$speaker_name = get_sub_field('dialogue_speaker_name');
										$speaker_title = get_sub_field('dialogue_speaker_title');
										$speaker_affiliation = get_sub_field('dialogue_speaker_affiliation');
										$speaker_twitter = get_sub_field('twitter_handle');
										
										$dialogue_speaker = '
										<span class="dialogue-speaker">' . $speaker_name . '</span>';
											if ($speaker_title != '') { $dialogue_speaker .= ', <span class="dialogue-speaker-title">' . $speaker_title . '</span>'; } 
											if ($speaker_affiliation != '') { $dialogue_speaker .= ', <span class="dialogue-affiliation">' . $speaker_affiliation . '</span>'; }
										$dialogue_meta .= $dialogue_speaker;
									$i++; endwhile; 
								endif; // end speakers 
								$dialogue_meta .= '<h4 class="dialogue-title"><a href="' . get_permalink() . '" title="Link to: ' . $dialogue_title . '">' . $dialogue_title . '</a></h4>';
								if ($dialogue_time != '') $dialogue_meta .= '<span class="dialogue-time"><strong>' . __('Time', 'Avada') . ': </strong> ' . $dialogue_time . '</span>';
								$dialogue_meta .= '<span class="dialogue-location"><strong>' . __('Location', 'Avada') . ': </strong>' . $dialogue_location . '</span>';
								if ($dialogue_sponsor != '') $dialogue_meta .= '<span class="dialogue-sponsor">' . $dialogue_sponsor . '</span>';
								
								echo do_shortcode('[four_fifth last="yes" class="dialogue-info"]' . $dialogue_meta . '[/four_fifth]'); ?>
						</div>
						<?php echo do_shortcode('[separator style_type="solid" top_margin="0" bottom_margin="10" sep_color="#BBBBBB" width="" alignment="" class="" id=""]'); ?>
					<?php endwhile; // while have posts ?>
                </div>
                <?php else : // if no posts ?>
               	<div class="no-upcoming-dialogues">
				<?php echo do_shortcode('[separator style_type="none" top_margin="5" bottom_margin="5" sep_color="" width="" alignment="" class="" id=""]'); ?>The current semester of Digital Dialogues has ended. We will add information on the upcoming semester as it becomes available. In the meantime, please check out our recent dialogues by choosing a series from the dropdown above.</div>
				<?php endif; ?>

				<?php avada_link_pages(); ?>
			</div>
			<?php if( ! post_password_required($post->ID) ): ?>
			<?php if(Avada()->settings->get( 'comments_pages' )): ?>
				<?php
				wp_reset_query();
				comments_template();
				?>
			<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php endwhile; ?>
	</div>
	<?php wp_reset_query(); ?>
	<div id="sidebar" class="sidebar <?php echo $sidebar_class; ?>" style="<?php echo $sidebar_css; ?>">
		<?php
		if( $sidebar_exists == true ) {
			if($sidebar_left == 1) {
				echo mith_display_sidenav( $page_id );
				generated_dynamic_sidebar($sidebar_1);
			}
			if($sidebar_left == 2) {
				generated_dynamic_sidebar_2($sidebar_2);
			}
		}
		?>
	</div>
	<?php if( $sidebar_exists && $double_sidebars ): ?>
	<div id="sidebar-2" class="sidebar <?php echo $sidebar_class; ?>" style="<?php echo $sidebar_2_css; ?>">
		<?php
		if($sidebar_left == 1) {
			generated_dynamic_sidebar_2($sidebar_2);
		}
		if($sidebar_left == 2) {
			echo avada_display_sidenav( $page_id );
			generated_dynamic_sidebar($sidebar_1);
		}
		?>
	</div>
	<?php endif; ?>
<?php get_footer();

// Omit closing PHP tag to avoid "Headers already sent" issues.

<?php
/**
 * Render the blog layouts
 *
 * @author 		ThemeFusion
 * @package 	Avada/Templates
 * @version     1.0
 */
 
fusion_block_direct_access();

global $wp_query, $smof_data;

// Set the correct post container layout classes
$blog_layout = 	'timeline';
$post_class = sprintf( 'fusion-post-%s', $blog_layout );
if ( $blog_layout == 'grid' ) {
	$container_class = sprintf( 'fusion-blog-layout-%s fusion-blog-layout-%s-%s isotope ', $blog_layout, $blog_layout, $smof_data['blog_grid_columns'] );
} else {
	$container_class = sprintf( 'fusion-blog-layout-%s ', $blog_layout );
}

// Set class for scrolling type
$container_class .= 'fusion-blog-infinite fusion-posts-container-infinite ';

if ( ! $smof_data['featured_images'] ) {
	$container_class .= 'fusion-blog-no-images ';
}

// Add the timeline icon
if ( $blog_layout == 'timeline' ) {
	echo '<div class="fusion-timeline-icon"><i class="fusion-icon-bubbles"></i></div>';
}

if ( is_search() && 
	 $smof_data['search_results_per_page'] 
) {
	$number_of_pages = ceil( $wp_query->found_posts / $smof_data['search_results_per_page'] );
} else {
	$number_of_pages = $wp_query->max_num_pages;
}

echo sprintf( '<div id="posts-container" class="%sfusion-blog-archive fusion-clearfix" data-pages="%s">', $container_class, $number_of_pages );

	if( $blog_layout == 'timeline' ) {
		// Initialize the time stamps for timeline month/year check
		$post_count = 1;
		$prev_post_timestamp = null;
		$prev_post_month = null;
		$prev_post_year = null;
		$first_timeline_loop = false;
		
		// Add the container that holds the actual timeline line
		echo '<div class="fusion-timeline-line"></div>';
	}

	// Start the main loop
	while ( have_posts() ): the_post();
		// Set the time stamps for timeline month/year check
		$alignment_class = '';
		if( $blog_layout == 'timeline' ) {
			$post_start_date = get_post_meta( $post->ID, 'research_start_date', true);
			$post_year =  get_post_meta($post->ID, 'research_start_yr', true);
			$current_date = get_the_date( 'o-n' );
			
			// Set the correct column class for every post
			if( $post_count % 2 ) {
				$alignment_class = 'fusion-left-column';
			} else {
				$alignment_class = 'fusion-right-column';
			}
	
			// Set the timeline month label
			if ( $prev_post_year != $post_year 
			) {
			
				if( $post_count > 1 ) {
					echo '</div>';
				}
				echo sprintf( '<h3 class="fusion-timeline-date">%s</h3>', $post_year ); 
				echo '<div class="fusion-collapse-month">';
			}
		}
		
		// Set the has-post-thumbnail if a video is used. This is needed if no featured image is present.
		$thumb_class = '';
		if ( get_post_meta( get_the_ID(), 'pyre_video', true ) ) {
			$thumb_class = ' has-post-thumbnail';
		}
		
		$post_classes = sprintf( '%s %s %s post fusion-clearfix', $post_class, $alignment_class, $thumb_class ); 
		ob_start();
		post_class( $post_classes );
		$post_classes = ob_get_clean();
		
		echo sprintf( '<div id="post-%s" %s>', get_the_ID(), $post_classes );
			// Add an additional wrapper for grid layout border
			if ( $blog_layout == 'grid' ) {
				echo '<div class="fusion-post-wrapper">';
			}
			
				// Get featured images for all but large-alternate layout
				
				// post-content-wrapper only needed for grid and timeline
				if ( $blog_layout == 'grid' || 
					 $blog_layout == 'timeline' 
				) { 
					echo '<div class="fusion-post-content-wrapper">';
				}
				
					// Add the circles for timeline layout
					if ( $blog_layout == 'timeline' ) {
						echo '<div class="fusion-timeline-circle"></div>';
						echo '<div class="fusion-timeline-arrow"></div>';
					}
					
					echo '<div class="fusion-post-content">';
					echo '<div class=""><a href="' . get_permalink() . '" title="' . get_the_title( get_the_ID() ) . '">';
					the_post_thumbnail();
					echo '</a></div>';

						// Render the post title
						echo $post_timestamp;
						echo '<h3><a href="' . get_permalink() . '" title="' . get_the_title( get_the_ID() ) . '">' . get_the_title( get_the_ID() ) . '</a></h3>';
						//echo avada_render_post_title( get_the_ID() );
					
						// Render post meta for grid and timeline layouts
						//echo avada_render_post_metadata( 'grid_timeline' );
						//echo '<div class="fusion-content-sep"></div>';
						
						echo '<div class="fusion-post-content-container">';
						$event_date = mith_research_event_date();
							if ( $event_date ) :
							$research_date = $event_date;
							/*$event_times = mith_research_event_time();
							if ( $event_times ) 
							$event_details .= sprintf( '<span>%s</span></h4>', $event_times );
							else $event_details .= '</h4>';
							*/
							else : 				
								$start_date_raw = get_post_meta( $post->ID, 'research_start_yyyymm', true);
								if ($start_date_raw ) {
									$start_date = date('F Y', strtotime($start_date_raw)); 
								} else { 
									$start_date = get_post_meta($post->ID, 'research_start_yr', true);
								}
								$research_date = $start_date;
								$end_date_raw = get_post_meta( $post->ID, 'research_end_yyyymm', true);
								if ($end_date_raw ) {
									$end_date = date('F Y', strtotime($end_date_raw)); 
									$research_date .= '<span class="dates-sep"> &ndash; </span>' . $end_date;
								} else {
									$end_date = get_post_meta($post->ID, 'research_end_yr', true);
									$research_date .= '<span class="dates-sep"> &ndash; </span>' . $end_date;
								}
							endif;
							$full_date = sprintf( '<h4 class="mith-research-dates" style="margin-top:0;margin-bottom:5px;">%s</h4>', $research_date );
							
							echo $full_date;
						
							/**
							 * avada_blog_post_content hook
							 *
							 * @hooked avada_render_blog_post_content - 10 (outputs the post content wrapped with a container)
							 */						
							echo get_the_excerpt();
							//do_action( 'avada_blog_post_content' );
							
						echo '</div>';
				
					echo '</div>'; // end post-content
					
					
					// Render post meta data according to layout
					if ( $smof_data['post_meta'] ) {
						echo '<div class="fusion-meta-info">';
							if ( $blog_layout == 'grid' || 
								 $blog_layout == 'timeline' 
							) {
								// Render read more for grid/timeline layouts
								echo '<div class="fusion-alignleft">';
									if ( ! $smof_data['post_meta_read'] ) {
										$link_target = '';
										if( fusion_get_page_option( 'link_icon_target', get_the_ID() ) == 'yes' ||
											fusion_get_page_option( 'post_links_target', get_the_ID() ) == 'yes' ) {
											$link_target = ' target="_blank"';
										}
										echo sprintf( '<a href="%s" class="fusion-read-more"%s>%s</a>', get_permalink(), $link_target, apply_filters( 'avada_blog_read_more_link', __( 'More', 'Avada' ) ) );
									}
								echo '</div>';
							
								// Render comments for grid/timeline layouts
								/*echo '<div class="fusion-alignright">';
									if ( ! $smof_data['post_meta_comments'] ) { 
										if( ! post_password_required( get_the_ID() ) ) {
											comments_popup_link('<i class="fusion-icon-bubbles"></i>&nbsp;' . __( '0', 'Avada' ), '<i class="fusion-icon-bubbles"></i>&nbsp;' . __( '1', 'Avada' ), '<i class="fusion-icon-bubbles"></i>&nbsp;' . '%' );
										} else {
											echo sprintf( '<i class="fusion-icon-bubbles"></i>&nbsp;%s', __( 'Protected', 'Avada' ) );
										}
									}
								echo '</div>';*/
							} else {
								
							}
						echo '</div>'; // end meta-info
					}
				if ( $blog_layout == 'grid' || 
					 $blog_layout == 'timeline' 
				) { 					
					echo '</div>'; // end post-content-wrapper
				}
			if ( $blog_layout == 'grid' ) {
				echo '</div>'; // end post-wrapper
			}
		echo '</div>'; // end post
		
		// Adjust the timestamp settings for next loop
		if ( $blog_layout == 'timeline' ) {
			//$prev_post_timestamp = $post_timestamp;
			//$prev_post_month = $post_month;
			$prev_post_year = $post_year;
			$post_count++;
		}
	endwhile; // end have_posts()
	
	if ( $blog_layout == 'timeline' &&
		 $post_count > 1 
	) {
		echo '</div>';
	}
echo '</div>'; // end posts-container

// If infinite scroll with "load more" button is used
if ( $smof_data['blog_pagination_type'] == 'load_more_button' ) {
	echo sprintf( '<div class="fusion-load-more-button fusion-clearfix">%s</div>', __( 'Load More Posts', 'Avada' ) );
}

// Get the pagination
fusion_pagination( $pages = '', $range = 2 );

wp_reset_query();


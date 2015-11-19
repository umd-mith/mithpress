<?php

fusion_block_direct_access();

global $wp_query, $smof_data;

// Set the correct post container layout classes
$blog_layout = 	"medium";
$post_class = sprintf( 'fusion-post-%s', $blog_layout );
$container_class = sprintf( 'fusion-blog-layout-%s ', $blog_layout );

$number_of_pages = $wp_query->max_num_pages;

// Set class for scrolling type
$container_class .= 'fusion-blog-pagination ';

if ( ! $smof_data['featured_images'] ) {
	$container_class .= 'fusion-blog-no-images ';
}

/*if ( is_search() && 
	 $smof_data['search_results_per_page'] 
) {
	$number_of_pages = ceil( $wp_query->found_posts / $smof_data['search_results_per_page'] );
} else {
	$number_of_pages = $wp_query->max_num_pages;
}*/

echo sprintf( '<div id="posts-container" class="%sfusion-blog-archive dialogue-archive fusion-clearfix" data-pages="%s">', $container_class, $number_of_pages );

	// Start the main loop
	while ( have_posts() ): the_post();
		// Set the time stamps for timeline month/year check
		$alignment_class = '';

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
			
				/* Get featured images for all but large-alternate layout
				if ( $smof_data['featured_images'] && 
					 $blog_layout == 'large-alternate' 
				) {
					get_template_part( 'new-slideshow' );				
				}			

				// Get featured images for all but large-alternate layout
				if ( $smof_data['featured_images'] &&
					 $blog_layout != 'large-alternate'
				) {
					get_template_part( 'new-slideshow' );
				}*/
					
					echo '<div class="fusion-post-content">';

				// Render the post title
				$talk_title = get_post_meta( get_the_ID(), 'dialogue_title', TRUE ); 
			
				echo avada_render_post_title( get_the_ID(), TRUE , $talk_title);
					
					/*if ( has_post_thumbnail ) : 
					echo '
					<div class="blog-medium-slideshow-container">
						<div class="fusion-flexslider flexslider blog-medium-image fusion-post-slideshow">
							<ul class="slides">
								<div class="image" aria-haspopup="true">
									<li style="width: 100%; float: left; margin-right: -100%; position: relative; opacity: 1; display: block; z-index: 2;">' . get_the_post_thumbnail( get_the_ID(), 'medium-square', trim( strip_tags( $wp_postmeta->_wp_attachment_image_alt ) )) . '</li>
								</div>
							</ul>
						</div>
					</div>';
					endif;*/
												
						// Render post meta for grid and timeline layouts
						if ( $blog_layout == 'grid' || 
							 $blog_layout == 'timeline'
						) {
							echo avada_render_post_metadata( 'grid_timeline' );

							if ( $smof_data['post_meta'] &&
								 ( $smof_data['excerpt_length_blog'] > 0 || ( ! $smof_data['post_meta_author'] || ! $smof_data['post_meta_date'] || ! $smof_data['post_meta_cats'] || ! $smof_data['post_meta_tags'] || ! $smof_data['post_meta_comments'] || ! $smof_data['post_meta_read'] || $smof_data['excerpt_length_blog'] > 0 ) )
							) {
								echo '<div class="fusion-content-sep"></div>';
							}
						// Render post meta for alternate layouts
						} elseif( $blog_layout == 'large-alternate' || 
								  $blog_layout == 'medium-alternate' 
						) {
							echo avada_render_post_metadata( 'alternate' );
						}
						
						echo '<div class="fusion-post-content-container">';
						
							dialogue_info_snippet('excerpt');
						
							/**
							 * avada_blog_post_content hook
							 *
							 * @hooked avada_render_blog_post_content - 10 (outputs the post content wrapped with a container)
							 */						
							do_action( 'avada_blog_post_content' );
							
						echo '</div>';
				
					echo '</div>'; // end post-content
					
					if( $blog_layout == 'medium' || 
						$blog_layout == 'medium-alternate' 
					) {
						echo '<div class="fusion-clearfix"></div>';
					}
					
					// Render post meta data according to layout
					if ( $smof_data['post_meta'] ) {
						echo '<div class="fusion-meta-info">';
								// Render all meta data for medium and large layouts
								if ( $blog_layout == 'large' || $blog_layout == 'medium' ) {
									//echo avada_render_post_metadata( 'standard' );
								}
								
								// Render read more for medium/large and medium/large alternate layouts
								echo '<div class="fusion-alignright">';
									if ( ! Avada()->settings->get( 'post_meta_read' ) ) {
										$link_target = '';
										if( fusion_get_page_option( 'link_icon_target', get_the_ID() ) == 'yes' ||
											fusion_get_page_option( 'post_links_target', get_the_ID() ) == 'yes' ) {
											$link_target = ' target="_blank"';
										}
										echo sprintf( '<a href="%s" class="fusion-read-more"%s>%s</a>', get_permalink(), $link_target, __( 'Read More', 'Avada' ) );
									}
								echo '</div>';
							}
						echo '</div>'; // end meta-info

		echo '</div>'; // end post
		
		// Adjust the timestamp settings for next loop
		if ( $blog_layout == 'timeline' ) {
			$prev_post_timestamp = $post_timestamp;
			$prev_post_month = $post_month;
			$prev_post_year = $post_year;
			$post_count++;
		}
	endwhile; // end have_posts()
	
echo '</div>'; // end posts-container

// If infinite scroll with "load more" button is used
if ( $smof_data['blog_pagination_type'] == 'load_more_button' ) {
	echo sprintf( '<div class="fusion-load-more-button fusion-clearfix">%s</div>', __( 'Load More Posts', 'Avada' ) );
}

// Get the pagination
fusion_pagination( $pages = '', $range = 2 );

wp_reset_query();


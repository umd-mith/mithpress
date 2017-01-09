<?php

// Do not allow directly accessing this file
if ( ! defined( 'ABSPATH' ) ) exit( 'Direct script access denied.' );

global $wp_query;

// Set the correct post container layout classes
$blog_layout = 	"medium"; 
$post_class = sprintf( 'fusion-post-%s', $blog_layout );
$container_class = sprintf( 'fusion-blog-layout-%s ', $blog_layout );

$container_class .= 'fusion-blog-pagination '; // Set class for scrolling type
$container_class .= 'fusion-blog-no-images ';
$number_of_pages = $wp_query->max_num_pages;

echo sprintf( '<div id="posts-container" class="%sfusion-blog-archive dialogue-archive fusion-clearfix" data-pages="%s">', $container_class, $number_of_pages );

	// Start the main loop
	while ( have_posts() ): the_post();

		$post_classes = sprintf( '%s %s %s post fusion-clearfix', $post_class, $alignment_class, $thumb_class );
		ob_start();
		post_class( $post_classes );
		$post_classes = ob_get_clean();

		echo sprintf( '<div id="post-%s" %s>', get_the_ID(), $post_classes );
		
					echo '<div class="fusion-post-content post-content">';

						// Render the post title
						$talk_title = get_post_meta( get_the_ID(), 'dialogue_title', TRUE ); 
						
						echo avada_render_post_title( get_the_ID() , TRUE, $talk_title );

						echo '<div class="fusion-post-content-container">';
							
							dialogue_info_snippet('excerpt', 'two_third', 'hide');

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
					if ( ( Avada()->settings->get( 'post_meta' ) && ( ! Avada()->settings->get( 'post_meta_author' ) || ! Avada()->settings->get( 'post_meta_date' ) || ! Avada()->settings->get( 'post_meta_cats' ) || ! Avada()->settings->get( 'post_meta_tags' ) || ! Avada()->settings->get( 'post_meta_comments' ) || ! Avada()->settings->get( 'post_meta_read' ) ) ) ) {
						echo '<div class="fusion-meta-info">';
						
								// Render all meta data for medium and large layouts
								if ( $blog_layout == 'large' || $blog_layout == 'medium' ) {
									echo avada_render_post_metadata( 'standard' );
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

	endwhile; // end have_posts()
	
echo '</div>'; // end posts-container

// If infinite scroll with "load more" button is used
if ( Avada()->settings->get( 'blog_pagination_type' ) == 'load_more_button' ) {
	echo sprintf( '<div class="fusion-load-more-button fusion-clearfix">%s</div>', apply_filters( 'avada_load_more_posts_name', __( 'Load More Posts', 'Avada' ) ) );
}

// Get the pagination
fusion_pagination( $pages = '', $range = 2 );

wp_reset_query();

// Omit closing PHP tag to avoid "Headers already sent" issues.

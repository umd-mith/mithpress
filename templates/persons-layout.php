<?php

fusion_block_direct_access();

global $wp_query, $smof_data;

// Set the correct post container layout classes
$blog_layout = 	"medium";
$post_class = sprintf( 'fusion-post-%s', $blog_layout );
$container_class = sprintf( 'fusion-blog-layout-%s ', $blog_layout );
$column_content = '';

echo sprintf( '<div id="posts-container" class="%sfusion-blog-archive persons-archive fusion-clearfix" data-pages="%s">', $container_class, $number_of_pages );

	$parent_term = get_term_by( 'slug', 'people-current', 'mith_staff_group' ); 
		$parent = $parent_term->term_id;
		?>
		<?php 
		$cat_terms = get_terms( 'mith_staff_group', array(
			'parent' => $parent, 
			'orderby' => 'custom_sort menu_order',
			'order' => 'ASC'
			) 
		);
		
		$count = count($cat_terms); 

		foreach ($cat_terms as $cat) : // start cycling through each category 
	
			$args = array(
				'tax_query' => array(
					array(
						'taxonomy' => 'mith_staff_group',
						'field' => 'slug',
						'terms' => $cat->slug,
					)
				),
				'post_type' => 'mith_person',
				'posts_per_page' => '-1',
				'meta_key' => 'last_name',
				'orderby' => 'custom_sort menu_order meta_value',
				'order' => 'ASC',
			);
			
			$ppl_query = new WP_Query( $args ); ?>
			
			<?php 
			if ( $ppl_query->have_posts() ) : 
			$i = 1; // set up a counter 
			
			echo '<div class="person-posts-wrapper cat-' . $cat->term_id . ' ' . $cat->slug . '">';
				echo '<h2 class="category-title">' . __( $cat->name, 'Avada') . '</h2>';
				?>
				
				<?php while ( $ppl_query->have_posts() ) : $ppl_query->the_post(); 
					if ($i % 3 != 0 ) { 
						$endclass = 'no'; 
					} else { 
						$endclass = 'yes'; 
					}  
					$post_classes = sprintf( '%s %s', $alignment_class, $thumb_class ); 
					ob_start();
					post_class( $post_classes );
					$post_classes = ob_get_clean();
					
					$column_content = sprintf( '<div id="post-%s" %s>', get_the_ID(), $post_classes ); //1
	
						$column_content .= '<div class="fusion-post-content">'; //2
							
							$column_content .= '<div class="fusion-post-content-container">'; //3
							
							$column_content .= person_info_snippet("excerpt");
							
								/**
								 * avada_blog_post_content hook
								 *
								 * @hooked avada_render_blog_post_content - 10 (outputs the post content wrapped with a container)
								 */						
								//do_action( 'avada_blog_post_content' );
								
							$column_content .= '</div>'; //3
					
						$column_content .= '</div>'; //2 end post-content
			
					$column_content .= '</div>'; //1  end post
			
					// Adjust the timestamp settings for next loop
					if ( $blog_layout == 'timeline' ) {
						$prev_post_timestamp = $post_timestamp;
						$prev_post_month = $post_month;
						$prev_post_year = $post_year;
						$post_count++;
					}
					echo do_shortcode('[one_third last="' . $endclass . '" spacing="yes" id=""]' . $column_content . '[/one_third]');
					$i++;
				
				endwhile; // end have_posts()
			
			echo '</div>'; // end person-posts-wrapper
			echo do_shortcode('[separator style_type="single" top_margin="0" bottom_margin="20" sep_color="#dfdfdf" border_size="1px" width="" alignment="" class="" id=""]'); 
			
			endif; //$ppl_query
		endforeach; ?>
		<?php wp_reset_postdata(); ?>
            
	<?php echo '</div>'; // end posts-container

//wp_reset_query();


<?php

// Do not allow directly accessing this file
if ( ! defined( 'ABSPATH' ) ) exit( 'Direct script access denied.' );

global $wp_query;

// Set the correct post container layout classes
$blog_layout = 	"medium";
$post_class = sprintf( 'fusion-post-%s', $blog_layout );
$container_class = sprintf( 'fusion-blog-layout-%s ', $blog_layout );
$container_class .= 'fusion-blog-pagination ';
$container_class .= 'fusion-blog-no-images ';
$thumb_class = ' has-post-thumbnail';
$column_content = '';

echo sprintf( '<div id="posts-container" class="%sfusion-blog-archive persons-archive fusion-clearfix" data-pages="%s">', $container_class, $number_of_pages );

	$parent_term = get_term_by( 'slug', 'people-current', 'mith_staff_group' ); 
		$parent = $parent_term->term_id;
	
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
						'taxonomy'	=> 'mith_staff_group',
						'field'		=> 'slug',
						'terms'		=> $cat->slug,
					)
				),
				'post_type'			=> 'mith_person',
				'posts_per_page'	=> '-1',
				'meta_key'			=> 'last_name',
				'orderby'			=> 'custom_sort menu_order meta_value',
				'order'				=> 'ASC',
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
					$post_classes = sprintf( '%s %s %s', $post_class, $alignment_class, $thumb_class );
					ob_start();
					post_class( $post_classes );
					$post_classes = ob_get_clean();
			
					$column_content = sprintf( '<div id="post-%s" %s>', get_the_ID(), $post_classes );
						$column_content .= '<div class="fusion-post-content">'; //2
							$column_content .= '<div class="fusion-post-content-container">'; //3
							
							$image_id = get_post_thumbnail_id($post->ID);
							$image_src = wp_get_attachment_image_src( $image_id, 'medium-square' );
							$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true);
							$person_title = get_post_meta($post->ID, 'person_title', true);
							$person_link = get_permalink( $post->ID);
							$person_name = get_the_title( $post->ID);
							
							$image_frame = '[imageframe lightbox="no" lightbox_image="no" style_type="" bordercolor="" bordersize="" borderradius="" stylecolor="" align="" link="' . $person_link . '" linktarget="" animation_type="" animation_direction="" animation_speed="" class="" id=""]<img alt="' .$image_alt . '" src="' . $image_src[0] . '" />[/imageframe]';
							$column_content .= $image_frame . sprintf('<h3 class="post-info-name"><a href="%s" title="%s">%s</a></h3>
							<h4 class="post-info-title">%s</h4>', $person_link, $person_name, $person_name, $person_title );
							$column_content .= '</div>'; //3
						$column_content .= '</div>'; //2 end post-content
					$column_content .= '</div>'; //1  end post

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


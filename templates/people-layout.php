<?php
global $wp_query;

// Set the portfolio main classes
$portfolio_classes[] = 'fusion-portfolio';

$portfolio_layout_setting = strtolower( 'Portfolio Two Column Text' );
$portfolio_layout = explode( ' ', $portfolio_layout_setting );
$portfolio_columns = $portfolio_layout[1];
$portfolio_layout = sprintf( 'fusion-portfolio-%s', $portfolio_columns );
$portfolio_classes[] = $portfolio_layout;

// Add the text class, if a text layout is used
if ( strpos( $portfolio_layout_setting, 'text' ) ||
	 strpos( $portfolio_layout_setting, 'one' )
) {
	$portfolio_classes[] = 'fusion-portfolio-text';
}

// For text layouts add the class for boxed/unboxed
if ( strpos( $portfolio_layout_setting, 'text' ) ) {
	$portfolio_text_layout = Avada()->settings->get( 'portfolio_text_layout' );
	$portfolio_classes[] = sprintf( 'fusion-portfolio-%s', $portfolio_text_layout );
} else {
	$portfolio_text_layout = 'unboxed';
}

// Set the correct image size
$portfolio_image_size = sprintf( 'portfolio-%s', $portfolio_columns );

$post_featured_image_size_dimensions = avada_get_image_size_dimensions( $portfolio_image_size );

// Get the column spacing
$column_spacing_class = $column_spacing = '';
if ( ! strpos( $portfolio_layout_setting, 'one' ) ) {
	$column_spacing_class = ' fusion-col-spacing';
	$column_spacing = sprintf( ' style="padding:%spx;"', str_replace( 'px', '', Avada()->settings->get( 'portfolio_column_spacing' ) ) / 2 );
}

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

		// Set picture size as data attribute; needed for resizing placeholders
		$data_picture_size = 'auto';
		if ( $portfolio_image_size != 'full' ) {
			$data_picture_size = 'fixed';
		}
		
		echo sprintf('<div class="fusion-portfolio-wrapper person-posts-wrapper cat-%s %s" data-picturesize="%s" data-pages="%s">', $cat->term_id, $cat->slug, $data_picture_size, $wp_query->max_num_pages );
			echo sprintf('<h2 class="category-title">%s</h2>', __( $cat->name, 'Avada') );
			?>
			
			<?php while ( $ppl_query->have_posts() ) : $ppl_query->the_post(); 
				if ($i % 3 != 0 ) { 
					$endclass = 'no'; 
				} else { 
					$endclass = 'yes'; 
				}

				echo sprintf( '<div class="fusion-portfolio-post person-post post-%s %s"%s>', get_the_ID(), $column_spacing_class, $column_spacing );

					// Open portfolio-item-wrapper for text layouts
					if ( strpos( $portfolio_layout_setting, 'text' ) ) {
						echo '<div class="fusion-portfolio-content-wrapper">';
					}

						echo avada_render_first_featured_image_markup( $post->ID, $portfolio_image_size, get_permalink( $post->ID ), TRUE );
						
						echo '<div class="fusion-portfolio-content">';
							// Render the post title
							//echo avada_render_post_title( $post->ID );

							$post_content = '';
							ob_start();
							/**
							 * avada_portfolio_post_content hook
							 *
							 * @hooked avada_get_portfolio_content - 10 (outputs the post content)
							 */
							echo person_info_snippet("excerpt");
							//do_action( 'avada_portfolio_post_content', $archive_id );
							$post_content = ob_get_clean();

							echo '<div class="fusion-post-content">';
							echo $post_content;
							echo '</div>'; // end post-content

						echo '</div>'; // end portfolio-content

					// Close portfolio-item-wrapper for text layouts
					if ( strpos( $portfolio_layout_setting, 'text' ) ) {
						echo '</div>';
					}

				echo '</div>';  // end portfolio-post
		endwhile;
	echo '</div>'; // end portfolio-wrapper
	endif;
	endforeach;
	
	// Render the pagination
	//fusion_pagination($pages = '', $range = 2);

	wp_reset_query();
echo '</div>'; // end fusion-portfolio

// Omit closing PHP tag to avoid "Headers already sent" issues.

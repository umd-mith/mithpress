<?php 

fusion_block_direct_access();

global $smof_data;
global $wp_query;

$blog_layout = 	'timeline';
$post_class = sprintf( 'fusion-post-%s', $blog_layout );
$container_class = sprintf( 'fusion-blog-layout-%s ', $blog_layout );
$container_class .= 'fusion-blog-infinite fusion-posts-container-infinite ';
//$container_class .= 'fusion-blog-no-images ';

// Add the timeline icon
if ( $blog_layout == 'timeline' ) {
	echo '<div class="fusion-timeline-icon"><i class="fusion-icon-bubbles"></i></div>';
}

$number_of_pages = $wp_query->max_num_pages;


/* Render the content of the portfolio page
while ( have_posts() ): the_post();

	ob_start();
	post_class( 'fusion-portfolio-page-content mith-research-archive-page-content' );
	$post_classes = ob_get_clean();
	
	// Set the ID of the portfolio page as variable to have it in the posts loop
	$current_page_id = $post->ID;
	
	// Get the page template slug for later check for text layouts
	$current_page_template = get_page_template_slug( $current_page_id );
	
	// Get the boxed/unboxed setting for text layouts
	if ( strpos( $current_page_template, 'text' ) ) {
		$current_page_text_layout = fusion_get_option( 'portfolio_text_layout', 'portfolio_text_layout', $current_page_id );
	} else {
		$current_page_text_layout = 'unboxed';
	}
endwhile; */

$status_exclude = array('status-active', 'status-archive', 'status-dev');
foreach ($status_exclude as $type_exclude ) :
	$status = get_term_by( 'slug', $type_exclude, 'mith_research_type');
	$types_exclude[] = $status->term_id;
endforeach;
$type_ids_exclude = implode( ',', $types_exclude);

// Start Forms
ob_start(); ?>
<?php // Sort by Start Year
$post_sort_order = "DESC";
if ($_POST['select'] == 'year_newest') { $post_sort_order = "DESC";  }
if ($_POST['select'] == 'year_oldest') { $post_sort_order = "ASC";  }
?>
<div class="gform_wrapper" id="gform_wrapper_1">
	<form method="post" id="gform_1" class="start-year-sort">
	<div class="gform_body">
		<ul class="gform_fields left_label form_sublabel_below description_above">
		<li class="gfield">
			<label class="gfield_label" for="select_yr"><?php _e('Sort By', 'Avada') ?></label>
			<div class="ginput_container">
				<select id="select_yr" class="gfield_select" name="select" onchange='this.form.submit()'>
					<option value="year_newest"<?php selected( $_POST['select'],'year_newest', 1 ); ?>><?php _e('Most Recent First', 'Avada'); ?></option>
					<option value="year_oldest"<?php selected( $_POST['select'], 'year_oldest', 1 ); ?>><?php _e('Oldest First', 'Avada'); ?></option>
				</select>
			</div>
		</li>
		</ul>
	</form>
    </div>
</div>    
<?php // Sort by Type ?>
<div class="gform_wrapper" id="gform_wrapper_2">
	<form method="post" id="gform_2" class="research-type-sort">
    <div class="gform_body">
    	<ul class="gform_fields left_label form_sublabel_below description_above">
        <li class="gfield">
            <label class="gfield_label" for="select_type"><?php _e('Filter By Type', 'Avada'); ?></label>
            <div class="ginput_container">
                <select id="select_type" class="gfield_select" name="select" onchange='this.form.submit()'>
                <?php
                $sort_option = '';
                $sort_types = get_terms( 'mith_research_type', 'include=' . $types_cats_to_display_ids . '&exclude=' . $type_ids_exclude . '&orderby=slug' ); ?>
                    <option value="research_type_all"<?php selected( $_POST['select'], 'research_type_all', 1 ); ?>><?php _e('All Research Types', 'Avada'); ?></option>
                <?php foreach ($sort_types as $sort_type ) :
                    $sort_value = 'type-' . $sort_type->slug;
                    if ($_POST['select'] == $sort_value ) { $post_sort_type = $sort_type->slug;  } ?>
                    <option value="<?php echo $sort_value; ?>"<?php selected( $_POST['select'], $sort_value, 1 ); ?>><?php _e($sort_type->name, 'Avada'); ?></option>
                <?php endforeach; ?>
                </select>
            </div>
        </li>
        </ul>
    </form>
    </div>
</div>
<?php 
//end forms

$form_filters = ob_get_clean();
echo do_shortcode('[one_fourth last="no"][/one_fourth]');
echo do_shortcode('[three_fourth last="yes"]' . $form_filters . '[/three_fourth]');

// Check if we have paged content
$paged = 1;
if(  is_front_page() ) {
	if ( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	}
} else {
	if ( get_query_var( 'paged') ) {
		$paged = get_query_var( 'paged');
	}
}

// Initialize the args that will be needed for th portfolio posts query
$posts_args = array(
	'post_type' 		=> 'mith_research',
	'paged' 			=> $paged,
	'posts_per_page' 	=> 300,
	'meta_key' => 'research_start_yr',
	'orderby' => 'meta_value',
	'order' => $post_sort_order
);

// If placeholder images are disabled, add the _thumbnail_id meta key to the query to only retrieve posts with featured images
/*if ( ! $smof_data['featured_image_placeholder'] ) {
	$posts_args['meta_key'] = '_thumbnail_id';
}*/
if ( $post_sort_type ) :
$posts_args['tax_query'] = array( 
	array(
	'taxonomy' => 'mith_research_type',
	'field'    => 'slug',
	'terms'    => $post_sort_type,
	),
);
endif;

	// Retrieve the portfolio posts that fit the arguments
	$research_posts_to_display = new WP_Query( $posts_args );
	
	// Check if the page is passowrd protected
	if ( ! post_password_required( $current_page_id ) ) {
	
// If no categories are chosen or "All categories", we need to load all available categories
$terms_args = array( 
	'orderby' => 'term_order',
	'order'   => 'ASC',
);

$type_terms = get_terms( 'mith_research_type', $terms_args );
$topic_terms = get_terms( 'mith_topic', $terms_args );

$type_cats_to_display_ids = array();
$topic_cats_to_display_ids = array();
foreach ( $type_terms as $type_term ) {
	$type_cats_to_display_ids[] = $type_term->term_id;
	$cats_to_display_ids[] = $type_term->term_id;
}
foreach ( $topic_terms as $topic_term ) {
	$topic_cats_to_display_ids[] = $topic_term->term_id;
	$cats_to_display_ids[] = $type_term->term_id;
}

// Get the category slugs and names
$cats_to_display_slugs_names = array();
$cats_to_display_ids_names = array();
$cats_to_display_arr = array();
if ( is_array( $cats_to_display_ids ) &&
	count( $cats_to_display_ids ) > 0
) {
	foreach ( $cats_to_display_ids as $category_id ) {
		$cat_object = get_term( $category_id, 'mith_research_type' );
		// Only add the category to the slugs and names array if they have posts assigned to them
		if ( $cat_object->count > 0 ) {
			$cats_to_display_arr[] = $cat_object;
			$cats_to_display_slugs_names[$cat_object->slug] = $cat_object->name;
			$cats_to_display_ids_names[$category_id] = $cat_object->name;		
		}
	}
}
// Sort the category slugs alphabetically 
/*
if ( is_array( $cats_to_display_slugs_names ) && 
	! function_exists( 'TO_activated' ) 
) {
	asort( $cats_to_display_slugs_names);
}*/

	// Add the correct term ids to the args array
	/*if ( $cats_to_display_ids ) {
		$rp_args['tax_query'][] = array( 
			'relation' => 'OR',
			array(
				'taxonomy' => 'mith_research_type', 
				'field' => 'id',
				'terms' => $type_cats_to_display_ids,
			),
			array(
				'taxonomy' => 'mith_topic',
				'field' => 'id',
				'terms' => $topic_cats_to_display_ids,
			),
		);
	}
	print_r($rp_args); */
	
	
ob_start();
				
		// First add the "All" filter then loop through all chosen categories
		echo '<ul class="fusion-filters clearfix">';
			// Check if the "All" filter should be displayed
				echo sprintf( '<li class="fusion-filter fusion-filter-all fusion-active"><a data-filter="*" href="#">%s</a></li>', apply_filters( 'avada_portfolio_all_filter_name', __( 'All', 'Avada' ) ) );
				$first_filter = FALSE;
				
				//$research_terms = get_terms( array('mith_research_type', 'mith_topic'), $cats_to_display_ids );
				$types_args = array( 'include' =>  $types_cats_to_display_ids, 'exclude' => $type_ids_exclude, 'orderby' => 'slug', 'order' => 'DESC' );
				$research_types = get_terms( 'mith_research_type', $types_args );
				$research_status = get_terms( 'mith_research_type', 'include=' . $type_ids_exclude . '&orderby=slug&order=DESC' );			
				$research_topics = get_terms( 'mith_topic', 'include=' . $topic_cats_to_display_ids . '&orderby=slug&order=ASC' );
				$research_terms = array_merge( $research_types, $research_topics );
				
				echo '<label>' . __('Status', 'Avada') . '</label>';
				foreach ($research_status as $status ) { 
					$active_class = '';
					$filter_class = '';
					if ( $first_filter ) {
						$active_class = ' fusion-active';
						$first_filter = FALSE;
					}
					echo sprintf( '<li class="fusion-filter fusion-hidden%s %s"><a data-filter=".%s" href="#">%s <span>%s</span></a></li>', $active_class, $filter_class, urldecode( $status->slug ), $status->name, $status->count );
				}
				
				$filter_header = '';
				foreach ( $research_terms as $term ) { 
					$active_class = '';
					$filter_class = '';
					if ( $first_filter ) {
						$active_class = ' fusion-active';
						$first_filter = FALSE;
					}
					if ( $term->taxonomy != $filter_header ) { 
						$tax = get_taxonomy( $term->taxonomy );
						$tax_name = $tax->label;
						echo '<label>' . $tax_name . '</label>';
						$filter_header = $term->taxonomy;
					}
					//$filter_class = 'filter-' . $term->taxonomy;
					if ( $term->parent != 0 ) $filter_class .= ' filter-child'; 
					echo sprintf( '<li class="fusion-filter fusion-hidden%s %s"><a data-filter=".%s" href="#" class="cat-%s">%s <span>%s</span></a></li>', $active_class, $filter_class, urldecode( $term->slug ), $term->term_id, $term->name, $term->count );
				}
				
				$research_posts = get_posts( 'post_type=mith_research&posts_per_page=-1');
				$research_meta_yrs = array();
				echo '<label>' . __('Start Year', 'Avada') . '</label>';
				foreach ( $research_posts as $post ) : 
				$post_meta_yr = get_post_meta( $post->ID, 'research_start_yr', true);
				if ( $post_meta_yr != '') :
					$post_query = new WP_Query( array( 'post_type' => 'mith_research', 'meta_key' => 'research_start_yr', 'meta_value' => $post_meta_yr ) );
					$post_qty = $post_query->found_posts;
					$research_meta_yrs['yr-' . $post_meta_yr] = array( 'name' => $post_meta_yr, 'qty' => $post_qty); 
				endif;
				endforeach; 
				
				if ( is_array( $research_meta_yrs ) ) { arsort( $research_meta_yrs); } 
				foreach ( $research_meta_yrs as $meta_yr ) { 
				//print_r($meta_yr);
					echo sprintf( '<li class="fusion-filter fusion-hidden%s"><a data-filter=".%s" href="#">%s <span>%s</span></a></li>', $active_class, 'yr-' . $meta_yr['name'], $meta_yr['name'], $meta_yr['qty']);
				}
				wp_reset_postdata();
				
		echo '</ul>';
		
		$research_filters = ob_get_clean();
		
	echo do_shortcode('[one_fourth last="no" spacing="yes"]' . $research_filters . '[/one_fourth]');
	
	// Get the correct featured image size
	$post_featured_image_size = avada_get_portfolio_image_size( $current_page_id );

	// Set picture size as data attribute; needed for resizing placeholders
	$data_picture_size = 'auto';
	if ( $post_featured_image_size != 'full' ) {
		$data_picture_size = 'fixed';
	}
	ob_start();
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
		// Loop through all the posts retrieved through our query based on chosen categories
		while ( $research_posts_to_display->have_posts() ) : $research_posts_to_display->the_post();

			// Set the time stamps for timeline month/year check
			$alignment_class = '';
			if( $blog_layout == 'timeline' ) {
				$post_timestamp = get_the_time( 'U' );
				$post_month = date( 'n', $post_timestamp );
				$post_year = get_the_date( 'o' );
				$current_date = get_the_date( 'o-n' );
	
				// Set the correct column class for every post
				if( $post_count % 2 ) {
					$alignment_class = 'fusion-left-column';
				} else {
					$alignment_class = 'fusion-right-column';
				}
	
				// Set the timeline month label
				if ( $prev_post_month != $post_month ||
					 $prev_post_year != $post_year
				) {
	
					if( $post_count > 1 ) {
						echo '</div>';
					}
					echo sprintf( '<h3 class="fusion-timeline-date">%s</h3>', get_the_date( Avada()->settings->get( 'timeline_date_format' ) ) );
					echo '<div class="fusion-collapse-month">';
				}
			} // end timestamp
			
			$post_classes = '';
			
			$post_classes = sprintf( '%s %s %s post fusion-clearfix', $post_class, $alignment_class, $thumb_class );
			ob_start();
			post_class( $post_classes );
			$post_classes = ob_get_clean();
	
			echo sprintf( '<div id="post-%s" %s>', get_the_ID(), $post_classes );
			
			get_template_part( 'new-slideshow' );
			
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

						// Render the post title
						echo avada_render_post_title( get_the_ID() );

						// Render post meta for grid and timeline layouts
						if ( $blog_layout == 'grid' ||
							 $blog_layout == 'timeline'
						) {
							echo avada_render_post_metadata( 'grid_timeline' );
							// echo '<div class="fusion-content-sep"></div>';
						} 


			// Set the post permalink correctly; this is important for prev/next navigation on single portfolio pages
			if ( $cats_to_display_ids ) {
				$post_permalink = fusion_add_url_parameter( get_permalink(), 'portfolioID', $current_page_id );
			} else {
				$post_permalink = get_permalink();
			}
			

			
			// Include the post categories as css classes for later useage with filters

			$post_cat_types = get_the_terms( $post->ID, 'mith_research_type');
			$post_cat_topics = get_the_terms	( $post->ID, 'mith_topic');			
			$post_meta_year = get_post_meta( $post->ID, 'research_start_yr', true);
			if ( $post_cat_types && $post_cat_topics ) :
			$post_categories = array_merge( $post_cat_topics, $post_cat_types );
			elseif ( $post_cat_types  && !$post_cat_topics ) : 
			$post_categories = $post_cat_types;
			elseif ( $post_cat_topics && !$post_cat_types ) : 
			$post_categories = $post_cat_topics;
			endif;
			//print_r($post_categories);
			if ( $post_categories ) {
				foreach ( $post_categories as $post_category ) {
					$post_classes .= urldecode( $post_category->slug ) . ' ';
				}
			}
			$post_classes .= 'yr-' . $post_meta_year . ' ';

			// Add the col-spacing class if needed
			if ( $custom_colulmn_spacing ) {
				$post_classes .= 'fusion-col-spacing';
			}

			// Add correct post class for image orientation
			//if ( $post_featured_image_size == 'full' ) {
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

				$post_classes .= ' ' . avada_get_image_orientation_class( $featured_image );
			//}

			// Render the portfolio post
			//echo sprintf( '<div class="fusion-portfolio-post mith-research-post post-%s %s">', get_the_ID(), $post_classes );

				// Open fusion-portfolio-content-wrapper for text layouts
				//echo '<div class="fusion-portfolio-content-wrapper mith-research-content-wrapper" style="opacity:1">';
				
					if ( has_post_thumbnail($post->ID) ) {
						$featured_image_markup = avada_render_first_featured_image_markup( $post->ID, $post_featured_image_size, $post_permalink, TRUE );
						echo $featured_image_markup;
					}

						echo '<div class="fusion-post-content-container">';

							/**
							 * avada_blog_post_content hook
							 *
							 * @hooked avada_render_blog_post_content - 10 (outputs the post content wrapped with a container)
							 */
							do_action( 'avada_blog_post_content' );

	
					
					// If we have a text layout render its contents
					//echo '<div class="fusion-portfolio-content mith-research-content">';
						
						// Render the post title
						//echo '<h3>' . get_the_title() . '</h3>';
						echo avada_render_post_title( $post->ID );

						// Render the post categories
						//echo sprintf( '<h4>%s</h4>', get_the_term_list( $post->ID, 'mith_research_type', '', ', ', '') ); 
						$current_date = get_the_date( 'o-n' );
						
						//start
						$start_date_yr = get_post_meta($post->ID, 'research_start_yr', true);
						$start_date_mth = get_post_meta($post->ID, 'research_start_mth', true);
						if ($start_date_yr ) {
							if ( $start_date_mth != 'null') { $start_date = date('F', strtotime($start_date_mth) ) . ' ' . $start_date_yr; }
							else { $start_date = $start_date_yr; }
							$research_date = $start_date;
						}
						//end	
						$end_date_yr = get_post_meta($post->ID, 'research_end_yr', true);
						$end_date_mth = get_post_meta($post->ID, 'research_end_mth', true);	
						if ($end_date_yr != '' && $end_date_yr != 'null' ) {
							if ( $end_date_mth ) { $end_date = date('F', strtotime($end_date_mth) ) . ' ' . $end_date_yr; }
							else { $end_date = $end_date_yr; }
							$research_date .= '<span class="dates-sep"> &ndash; </span>' . $end_date; 
						}
						$full_date = '<div class="mith-research-dates" style="margin-top:0;margin-bottom:5px;">' . $research_date . '</div>';
						
						echo avada_render_rich_snippets_for_pages( false );
						
						$post_content = '';
						ob_start();							
						echo $full_date; 
						/**
						 * avada_portfolio_post_content hook
						 *
						 * @hooked avada_get_portfolio_content - 10 (outputs the post content)
						 */						
						the_excerpt();
						//do_action( 'avada_portfolio_post_content', $current_page_id );
						$post_content = ob_get_clean(); 

							
							// Echo the post content
							echo $post_content;

						echo '</div>';

					echo '</div>'; // end post-content										

						// On unboxed one column layouts render a separator at the bottom of the post
						if ( strpos( $current_page_template, 'one' ) &&
							 $current_page_text_layout == 'unboxed'
						) {
							echo '<div class="fusion-clearfix"></div>';
							echo '<div class="fusion-separator sep-double"></div>';
						}							

					echo '</div>'; // end portfolio-content				
					
					
					
					
					//********************//
					
				// Close fusion-portfolio-content-wrapper for text layouts
				echo '</div>';
				
			echo '</div>'; // end portfolio-post
		endwhile;
	echo '</div>'; // end portfolio-wrapper
	$research_posts = ob_get_clean();
	echo do_shortcode('[three_fourth last="yes" spacing="yes"]' . $research_posts . '[/three_fourth]');
	
	// If infinite scroll with "load more" button is used
	if ( $smof_data['grid_pagination_type'] == 'load_more_button' ) {
		echo sprintf( '<div class="fusion-load-more-button fusion-clearfix">%s</div>', __( 'Load More Posts', 'Avada' ) );
	}

	// Render the pagination
	fusion_pagination( $research_posts_to_display->max_num_pages, $range = 2 );

	wp_reset_query();

} // password check
<?php 
global $smof_data;

// Render the content of the portfolio page
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
endwhile; 

$status_exclude = array('status-active', 'status-archive');
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
<?php 
//end forms

$form_sorts = ob_get_clean();

echo do_shortcode('[one_fourth last="no"][/one_fourth]');
echo do_shortcode('[three_fourth last="yes"]' . $form_sorts . '[/three_fourth]');

// Sort by Type 
ob_start(); ?>

<div class="gform_wrapper" id="gform_wrapper_2">
	<form method="post" id="gform_2" class="research-type-sort" action="">
    <div class="gform_body">
    	<ul class="gform_fields left_label form_sublabel_below description_above">
        <li class="gfield">
            <label class="gfield_label" for="select_type"><?php _e('Filter By Type', 'Avada'); ?></label>
            <div class="ginput_container">
            	<ul class="gfield_checkbox" style="padding-left:0;">
                <?php
                $sort_option = '';
                $filter_types = get_terms( 'mith_research_type', 'include=' . $types_cats_to_display_ids . '&exclude=' . $type_ids_exclude . '&orderby=slug' );
				$filter_type_values = array();
                foreach ($filter_types as $filter_type ) :
                    $sort_type_value = 'type-' . $filter_type->slug; 
					if(isset($_POST[$filter_type->term_id])) { $post_filter_type = $filter_type->slug; } ?>
                    <li class="gchoice_<?php echo $filter_type->term_id; ?>">
                    <input class="filter_input" name="<?php echo $filter_type->term_id; ?>" id="choice_<?php _e($filter_type->name, 'Avada'); ?>" value="<?php echo $sort_type_value; ?>" <?php if(isset($_POST[$filter_type->term_id])) echo "checked='checked'"; ?> type="checkbox">
                    <label for="input_<?php echo $filter_type->term_id; ?>" id="label_<?php echo $filter_type->term_id; ?>"><?php _e($filter_type->name, 'Avada'); ?></label>
                    </li>
                <?php endforeach; ?>
                    <li class="gchoice_all">
                        <input class="filter_input" name="input_all" value="research_type_all" <?php if(isset($_POST['input_all']) || $post_filter_type == '') { echo "checked='checked'"; $post_filter_type = ''; } ?> type="checkbox" <?php /* onchange="jQuery('#gform_2').submit();" */ ?>>
                        <label for="input_all" id="label_all"><?php _e('All Research Types', 'Avada'); ?></label>
                    </li>
                </ul>
            </div>
        </li>
        </ul>
    </form>
    </div>
</div>
<div class="gform_wrapper" id="gform_wrapper_3">
	<form method="post" id="gform_3" class="research-type-sort" action="">
    <div class="gform_body">
    	<ul class="gform_fields left_label form_sublabel_below description_above">
        <li class="gfield">
            <label class="gfield_label" for="select_type"><?php _e('Filter By Topic', 'Avada'); ?></label>
            <div class="ginput_container">
            	<ul class="gfield_checkbox" style="padding-left:0;">
                <?php
                $sort_option = '';
                $filter_topics = get_terms( 'mith_topic', 'include=' . $types_cats_to_display_ids . '&exclude=' . $type_ids_exclude . '&orderby=slug' );
				$filter_topic_values = array();
                foreach ($filter_topics as $filter_topic ) :
                    $sort_topic_value = 'type-' . $filter_topic->slug; 
					if(isset($_POST[$filter_topic->term_id])) { $post_filter_topic = $filter_topic->slug; } ?>
                    <li class="gchoice_<?php echo $filter_topic->term_id; ?>">
                    <input class="filter_input" name="<?php echo $filter_topic->term_id; ?>" id="choice_<?php _e($filter_topic->name, 'Avada'); ?>" value="<?php echo $sort_topic_value; ?>" <?php if(isset($_POST[$filter_topic->term_id])) echo "checked='checked'"; ?> type="checkbox" <?php /* onchange="jQuery('#gform_3').submit(); */ ?>>
                    <label for="input_<?php echo $filter_topic->term_id; ?>" id="label_<?php echo $filter_topic->term_id; ?>"><?php _e($filter_topic->name, 'Avada'); ?></label>
                    </li>
                <?php endforeach; ?>
                    <li class="gchoice_all">
                        <input class="filter_input" name="input_all" value="research_topic_all" <?php if(isset($_POST['input_all']) || $post_filter_topic == '') { echo "checked='checked'"; $post_filter_topic = ''; } ?> type="checkbox" <?php /* onchange="jQuery('#gform_3').submit();" */ ?>>
                        <label for="input_all" id="label_all"><?php _e('All Research Topics', 'Avada'); ?></label>
                    </li>
                </ul>
            </div>
        </li>
        </ul>
    </form>
    </div>
</div>
<?php $form_filters = ob_get_clean();

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
	
ob_start();

$sort_option = '';
$research_terms = get_terms( 'mith_research_type', 'include=' . $types_cats_to_display_ids . '&exclude=' . $type_ids_exclude . '&orderby=slug' );
$term_values = array();
$filter_header = '';

foreach ($research_terms as $term ) :
	$sort_value = 'type-' . $term->slug; 
	$active_class = '';
	$filter_class = '';

	if ( $first_filter ) {
		$active_class = ' fusion-active';
		$first_filter = FALSE;
	}
	if ( $term->taxonomy != $filter_header ) { 
		$tax = get_taxonomy( $term->taxonomy );
		$tax_name = $tax->label;
		echo '<legend class="gfield_label" for="select_type">' . _e($tax_name, 'Avada') . '</legend>';
		$filter_header = $term->taxonomy;
	}
	if ( $term->parent != 0 ) $filter_class .= ' filter-child'; 
	
	if(isset($_POST[$term->term_id])) { $post_filter_type = $term->slug; } 
	if(isset($_POST[$term->term_id])) $term_checked = "checked='checked'"; else $term_checked = '';
	
echo sprintf( '<li class="%s %s gchoice_%s"><input data-filter=".%s" class="filter_input" name="%s" id="choice_%s" value="%s" %s type="checkbox"><label for="input_%s" id="label_%s">%s <span>%s</span></label></li>', 
$active_class, $filter_class, $term->term_id, urldecode($term->slug), $term->term_id, $term->name, $sort_value, $term_checked, $term->term_id, $term->term_id, $term->name, $term->count );
endforeach;

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
		//$research_filters .= $form_filters; 
	
	echo do_shortcode('[one_fourth last="no" spacing="yes"]' . $form_filters . '[/one_fourth]');
	
	// Get the correct featured image size
	$post_featured_image_size = avada_get_portfolio_image_size( $current_page_id );

	// Set picture size as data attribute; needed for resizing placeholders
	$data_picture_size = 'auto';
	if ( $post_featured_image_size != 'full' ) {
		$data_picture_size = 'fixed';
	}
	ob_start();
	echo sprintf( '<div class="fusion-portfolio-wrapper" data-picturesize="%s" data-pages="%s">', $data_picture_size, $research_posts_to_display->max_num_pages );

		// For non one column layouts check if column spacing is used, and if, how big it is,
		$custom_colulmn_spacing = FALSE;
		if ( ! strpos( $current_page_template, 'one' ) ) {
			// Page option set
			if ( fusion_get_page_option( 'portfolio_column_spacing', $current_page_id ) != NULL ) {
				$custom_colulmn_spacing = TRUE;
				$column_spacing = fusion_get_page_option( 'portfolio_column_spacing', $current_page_id ) / 2;

				echo sprintf( '<style type="text/css">.fusion-portfolio-wrapper{margin: 0 %spx;}.fusion-portfolio-wrapper .fusion-col-spacing{padding:%spx;}</style>', ( -1 ) * $column_spacing, $column_spacing );
			// Page option not set, but theme option
			} else if( $smof_data['portfolio_column_spacing'] ) {
				$custom_colulmn_spacing = TRUE;
				$column_spacing = $smof_data['portfolio_column_spacing'] / 2;

				echo sprintf( '<style type="text/css">.fusion-portfolio-wrapper{margin: 0 %spx;}.fusion-portfolio-wrapper .fusion-col-spacing{padding:%spx;}</style>', ( -1 ) * $column_spacing, $column_spacing );
			}
		}
	
	
// Initialize the args that will be needed for the portfolio posts query
$posts_args = array(
	'post_type' 		=> 'mith_research',
	//'paged' 			=> $paged,
	'posts_per_page' 	=> 300,
	'meta_key' => 'research_start_yr',
	'orderby' => 'meta_value',
	'order' => $post_sort_order
);

if ( $post_filter_type != '' ) :
$posts_args['tax_query'] = array( 
	array(
	'taxonomy' => 'mith_research_type',
	'field'    => 'slug',
	'terms'    => $post_filter_type,
	),
);
endif;

if ( $post_filter_topic != '' ) :
$posts_args['tax_query'] = array( 
	'relation' => 'AND',
	array(
	'taxonomy' => 'mith_topic',
	'field'    => 'slug',
	'terms'    => $post_filter_topic,
	),
);
endif;


// Retrieve the portfolio posts that fit the arguments
$research_posts_to_display = new WP_Query( $posts_args );
	
/**** START POSTS ****/

		// Loop through all the posts retrieved through our query based on chosen categories
		while ( $research_posts_to_display->have_posts() ) : $research_posts_to_display->the_post();

			// Set the post permalink correctly; this is important for prev/next navigation on single portfolio pages
			if ( $cats_to_display_ids ) {
				$post_permalink = fusion_add_url_parameter( get_permalink(), 'portfolioID', $current_page_id );
			} else {
				$post_permalink = get_permalink();
			}

			// Include the post categories as css classes for later useage with filters
			$post_classes = '';
			
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
			echo sprintf( '<div class="fusion-portfolio-post mith-research-post post-%s %s">', get_the_ID(), $post_classes );

				// Open fusion-portfolio-content-wrapper for text layouts
				echo '<div class="fusion-portfolio-content-wrapper mith-research-content-wrapper" style="opacity:1">';
				
					if ( has_post_thumbnail($post->ID) ) {
						$featured_image_markup = avada_render_first_featured_image_markup( $post->ID, $post_featured_image_size, $post_permalink, TRUE );
						echo $featured_image_markup;
					}
					
					// If we have a text layout render its contents
					echo '<div class="fusion-portfolio-content mith-research-content">';
						
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

						// For boxed layouts add a content separator if there is a post content
						if ( $current_page_text_layout == 'boxed' &&
							 $post_content
						) {
							echo '<div class="fusion-content-sep"></div>';
						}

						echo '<div class="fusion-post-content">';
							
							// Echo the post content
							echo $post_content;

							// On one column layouts render the "Learn More" and "View Project" buttons
							if ( strpos( $current_page_template, 'one' ) ) {
								echo '<div class="fusion-portfolio-buttons">';
									// Render "Learn More" button
									echo sprintf( '<a href="%s" class="fusion-button fusion-button-small fusion-button-default fusion-button-%s fusion-button-%s">%s</a>', 
												  $post_permalink, strtolower( $smof_data['button_shape'] ), strtolower( $smof_data['button_type'] ), __( 'Learn More', 'Avada' ) );

									// Render the "View Project" button only is a project url was set
									if ( fusion_get_page_option( 'project_url', $post->ID ) ) {
										echo sprintf( '<a href="%s" class="fusion-button fusion-button-small fusion-button-default fusion-button-%s fusion-button-%s">%s</a>', fusion_get_page_option( 'project_url', $post->ID ), 
													  strtolower( $smof_data['button_shape'] ), strtolower( $smof_data['button_type'] ), __( ' View Project', 'Avada' ) );
									}
								echo '</div>';
							}

						echo '</div>'; // end post-content			

						// On unboxed one column layouts render a separator at the bottom of the post
						if ( strpos( $current_page_template, 'one' ) &&
							 $current_page_text_layout == 'unboxed'
						) {
							echo '<div class="fusion-clearfix"></div>';
							echo '<div class="fusion-separator sep-double"></div>';
						}							

					echo '</div>'; // end portfolio-content				
					
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
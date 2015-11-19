<?php 
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
	
	
//ob_start();
				
		// First add the "All" filter then loop through all chosen categories
		echo '<ul class="fusion-filters clearfix">';
			// Check if the "All" filter should be displayed
				echo sprintf( '<li class="fusion-filter fusion-filter-all fusion-active"><a data-filter="*" href="#">%s</a></li>', apply_filters( 'avada_portfolio_all_filter_name', __( 'All', 'Avada' ) ) );
				$first_filter = FALSE;
				
				$research_terms = get_terms( array('mith_research_type', 'mith_topic'), $cats_to_display_ids );
				$research_types = get_terms( 'mith_research_type', 'include=' . $types_cats_to_display_ids );
				//print_r( $research_terms); 
				$research_topics = get_terms( 'mith_research_topics', 'include=' . $topic_cats_to_display_ids );
				
				print_r($research_terms); 
				foreach ( $research_terms as $term ) { 
					$active_class = '';
					if ( $first_filter ) {
						$active_class = ' fusion-active';
						$first_filter = FALSE;
					}
					echo sprintf( '<li class="fusion-filter fusion-hidden%s filter_%s"><a data-filter=".%s" href="#" class="cat-%s">%s <span>%s</span></a></li>', $active_class, $type->taxonomy, urldecode( $type->slug ), $type->term_id, $type->name, $type->count );
				}
				/*	
				echo '<label>' .__('Research Type', 'Avada') . '</label>';
				foreach ( $research_types as $type ) { 
					$active_class = '';
					if ( $first_filter ) {
						$active_class = ' fusion-active';
						$first_filter = FALSE;
					}
					echo sprintf( '<li class="fusion-filter fusion-hidden%s filter_%s"><a data-filter=".%s" href="#" class="cat-%s">%s <span>%s</span></a></li>', $active_class, $type->taxonomy, urldecode( $type->slug ), $type->term_id, $type->name, $type->count );
				} 
				
				echo '<label>' . __('Topic', 'Avada') . '</label>';
				foreach ( $research_topics as $topic ) { 
					$active_class = '';
					if ( $first_filter ) {
						$active_class = ' fusion-active';
						$first_filter = FALSE;
					}
					echo sprintf( '<li class="fusion-filter fusion-hidden%s"><a data-filter=".%s" href="#" class="cat-%s">%s <span>%s</span></a></li>', $active_class, urldecode( $topic->slug ), $topic->term_id, $topic->name, $topic->count );
				} 
				
							
				foreach ( $cats_to_display_ids_names as $category_tax_id => $category_tax_name ) {
					// Set the first category filter to active, if the all filter isn't shown
					$category_obj = get_term( $category_tax_id, 'mith_research_type' );
					$category_tax_slug = $category_obj->slug;
					$active_class = '';
					if ( $first_filter ) {
						$active_class = ' fusion-active';
						$first_filter = FALSE;
					}
				echo sprintf( '<li class="fusion-filter fusion-hidden%s"><a data-filter=".%s" href="#" class="cat-%s">%s <span>%s</span></a></li>', $active_class, urldecode( $category_obj->slug ), $category_tax_id, $category_tax_name, $category_obj->count );
			}*/
		echo '</ul>';
		
		//$research_filters = ob_get_clean();
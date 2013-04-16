<?php
/*
Template Name: Current Events
*/

get_header(); ?>

<div id="page-container">

		<div id="primary" class="width-limit">

		  <?php get_sidebar('left'); ?>
	
			<div id="content" role="main" class="span-16 last">

			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>

			<div id="events">
			
            <?php 
			$args = array(
				'posts_per_page' => -1,
				'post_type' => 'event',
				'tax_query' => array(
					array(
						'taxonomy' => 'event_type',
						'field' => 'slug',
						'terms' => array( 'past-event', 'dd-event'),
						'operator' => 'NOT IN'
					)
				),
				'meta_key' => 'date-sort',
				'order' => 'ASC',
                'orderby' => 'meta_value_num',	
			);
			$new_query = null;
			$new_query = new WP_Query( $args ); ?>

			<?php 
			$i = 0; // set up a counter so we know which post we're currently showing
			$counter_class = ''; // set up a variable to hold an extra CSS class

			if ( $new_query -> have_posts() ) : while ( $new_query -> have_posts() ) : $new_query->the_post(); 
			$i++; // increment the counter
                if( $i % 2 != 0) { 
                $counter_class = '';
			} else {
                $counter_class = 'last'; }
				
				$event_start_date = get_post_meta($post->ID, 'date-start', true);
				//$sorting = get_post_meta($post->ID, 'date-sort', true); 
				$date_sort = date('Ymd', strtotime( $event_start_date ) ); 
				update_post_meta($post->ID, 'date-sort', $date_sort);
            ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class($counter_class . ' ' . $date_sort); ?>>
                
                    <div class="entry-content">
                        <div id="event-info" class="append-bottom">
	                    <?php if ( has_post_thumbnail() ) { ?>
                        	<a href="<?php the_permalink(); ?>" class="hasimg"><?php the_post_thumbnail( 'large'); ?></a>
                        <?php } else { ?>
                            <a href="<?php the_permalink(); ?>" class="noimg"><?php the_title(); ?></a>
                        <?php } ?>
                        </div>
                    </div>
                    <!-- /entry-content -->
                
                </article>
                <!-- /post-<?php the_ID(); ?> -->
                
				<?php endwhile; ?>
            
			<?php endif; ?>
			</div>
            <!-- /events -->
            
        </div>
		<!-- /page content -->
    
    </div>
	<div class="clear"></div>
	<!-- /primary -->

</div>
<!-- /page / start footer -->

<?php get_footer(); ?>
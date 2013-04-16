<?php
/**
Template Name: Upcoming Events
 * The template for displaying upcoming events.
*/
?>
<?php get_header(); ?>
<div id="page-container">
    
    <div id="primary" class="width-limit">
    
	<?php get_sidebar('left'); ?>
    <!-- /sidebar -->
    
        <div id="content" role="main" class="span-16 last">

        <?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
        
        <?php the_content(); ?>
        
            <div id="events">
            
            <?php 
            $args = array(
                'post_type' => 'event',
                'posts_per_page' => -1,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'event_type',
                    ),
                    array(
                        'taxonomy' => 'event_type',
                        'field' => 'slug',
                        'terms' => array( 'past-event'),
                        'operator' => 'NOT IN'
                    ),
                'orderby' => 'date',	
				'order' => 'ASC',
                )
            );
        
            $query = new WP_Query( $args ); 
			
            $i = 0; // set up a counter so we know which post we're currently showing
            $counter_class = ''; // set up a variable to hold an extra CSS class
            
            if ( $query -> have_posts() ) : 
            
            while ( $query -> have_posts() ) : $query->the_post(); 
            
            $i++; // increment the counter
                if( $i % 3 != 0) { 
                $counter_class = ''; // we're on an odd post
                } else {
                $counter_class = 'last'; }
            ?>
            
                <article id="post-<?php the_ID(); ?>" <?php post_class($counter_class); ?>>
                
                    <div class="entry-content">
                    
                        <div id="event-info" class="append-bottom">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="hasimg"><?php the_post_thumbnail( 'horiz-thumbnail'); ?></a>
                        <?php else : ?>
                            <a href="<?php the_permalink(); ?>" class="noimg"><?php the_title(); ?></a>
                        <?php endif ?>
                        </div>
                
                    </div>
                    <!-- /entry-content -->
                
                </article>
                <!-- /post-<?php the_ID(); ?> -->
                
                <?php endwhile; ?>
            
            <?php else : ?>
                <article id="post-0" <?php post_class(); ?>>
                    
                    <div class="entry-content">
                    <p>We are not currently featuring any events, however please check back here regularly.</p>
                    </div>
                
                </article>
                
            <?php endif; ?>
            </div>
            <!-- /events -->
            
        </div>
        <!-- /content -->
    
    </div>
    <!-- /primary -->

	<div class="clear"></div>

</div>
<!-- /page / start footer -->

<?php get_footer(); ?>
<?php
/*
Template Name: Current Projects
*/
?>
<?php get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">
<!--start subnav -->
		  <?php get_sidebar('left'); ?>
<!--end sidebar / start research page content-->
			<div id="content" role="main" class="span-16 last">

			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
			<div id="projects">
			<?php 
			$args = array(
				'post_type' => 'project',
				'posts_per_page' => -1,
				'order' => 'ASC',
				'orderby' => 'title',
				'tax_query' => array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'projecttype',
						'field' => 'slug',
						'terms' => array( 'project')
					),
					array(
						'taxonomy' => 'projecttype',
						'field' => 'slug',
						'terms' => array( 'archive-project'),
						'operator' => 'NOT IN'
					)
				)
			);

			$posts = new WP_Query( $args ); ?>
			<?php 
			$i = 0; // set up a counter so we know which post we're currently showing
			$counter_class = ''; // set up a variable to hold an extra CSS class
			if ( $posts -> have_posts() ) : 
			while ( $posts -> have_posts() ) : $posts->the_post(); 
			$i++; // increment the counter
                if( $i % 3 != 0) { 
                $counter_class = ''; // we're on an odd post
                } else {
                $counter_class = 'last'; }
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class($counter_class); ?>>
                
                    <div class="entry-content">
                        <div id="project-info" class="append-bottom">
	                    <?php if ( has_post_thumbnail() ) { ?>
                        	<a href="<?php the_permalink(); ?>" class="hasimg"><?php the_post_thumbnail( 'horiz-thumbnail'); ?></a>
                        <?php } else { ?>
                            <a href="<?php the_permalink(); ?>" class="noimg"><?php the_title(); ?></a>
                        <?php } ?>
                        </div>
                    </div><!-- /entry-content -->
                
                </article><!-- /post-<?php the_ID(); ?> -->
                
				<?php endwhile; ?>
            
			<?php endif; ?>
			</div>
			</div>
<!-- /page content -->
		</div>
<div class="clear"></div>
<!-- /primary -->
</div>
<!-- /page / start footer -->

<?php get_footer(); ?>
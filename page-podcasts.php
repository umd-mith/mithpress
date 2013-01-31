<?php
/*
Template Name: Podcasts
* display list of most recent podcasts
*/
?>
<?php get_header(); ?>
<div id="page-container">

	<div id="primary" class="width-limit">

	<?php get_sidebar('left'); ?>

		<div id="content" role="main" class="span-16 last">
			
		<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
            
        	<div id="articles">
            
			<?php global $wp_query;
			
				query_posts( 
					array(
						'post_type' => array('podcast' ),
						'posts_per_page' => '10',
						'paged' => get_query_var('paged')
						)
					);
            ?>            
			
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'podcasts'); ?>

				<?php endwhile; ?>

                    <nav id="nav-page" class="span-narrow">
                
                        <h3 class="assistive-text"><?php _e( 'Page navigation', 'mithpress' ); ?></h3>
    
					<?php if (function_exists('wp_pagenavi')) : wp_pagenavi();
                    elseif (get_option('paging_mode') == 'default') : ?>
                        
                        <span class="nav-previous"><span class="meta-nav"></span><?php next_posts_link(__('Older'), 0); ?></span>
                        <span class="nav-next"><span class="meta-nav"></span><?php previous_posts_link(__('Newer'), 0); ?></span>
                    
                    </nav>                    
					<?php else : ?>
                    
                        <span class="nav-next"><span class="meta-nav"></span><?php next_posts_link(__('LOAD MORE')); ?></span>
                    
                    </nav>

					<?php endif; ?>	
                    <!-- /nav -->
                			
			<?php endif; ?>
        	</div>
            <!-- /articles -->
		
        <?php get_sidebar('ddialogue'); ?>
        <!-- /sidebar -->
                    
        </div>
		<!-- /content -->

    </div>
    <!-- /primary/post -->    

    <div class="clear"></div>
    
</div>
<!-- /page  -->

<?php get_footer(); ?>
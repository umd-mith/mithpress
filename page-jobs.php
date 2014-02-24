<?php
/*
Display Jobs list
*/
?>
<?php get_header(); ?>

<div id="page-container">

    <div id="primary" class="width-limit">

    <?php get_sidebar('left'); ?>
    <!-- /subnav sidebar -->

        <div id="content" role="main" class="span-16 wide last">

			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>

            <?php the_post(); ?>
            
            <?php get_template_part( 'content', 'page' ); 
			wp_reset_query(); 
			wp_reset_postdata(); ?>
			
			<?php 		
			$current_date = date('Ymd');
			$args = array(
                'post_type' => 'job',
                'posts_per_page' => -1,
				'meta_query' => array(
					array(
						'key' => 'expiration_date',
						'compare' => '>=',
						'value' => $current_date,
						'type' => 'numeric'
					)
				)
            );
            $query = new WP_Query( $args ); 
            if ( $query -> have_posts() ) : 
			?>

            <header class="entry-header prepend-top">

                <h1 class="entry-title append-bottom prepend-top">Current Openings</a></h1>

            </header>
            <!-- /article-header -->
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('span-narrow'); ?>>
    
            <?php while ( $query -> have_posts() ) : $query->the_post(); ?>				

				<h4 class="append-bottom"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
                
			<?php endwhile; ?>
        
            </article>
            <!-- /post-<?php the_ID(); ?> -->
        
			<?php else : ?>                          

            <article id="post-none" class="span-narrow">
        
                <p id="no-jobs"><?php _e( 'We\'re eager to hear from those who may be interested in future positions as they become available. Feel free to share your CV with us, <a href="mailto:mith@umd.edu" target="_blank">mith@umd.edu.</a>', 'mithpress' ); ?></p>
        
            </article>
            <!-- /entry-content -->
            <?php endif; // end else 
			wp_reset_query(); ?>                
			    
    </div>
	<!-- /content -->

</div>
<!-- /primary/post -->    

<div class="clear"></div>
</div>
<!-- /container -->

<?php get_footer(); ?>
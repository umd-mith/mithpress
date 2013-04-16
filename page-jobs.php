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
			$args = array(
                'post_type' => 'job',
                'posts_per_page' => -1,
            );
            $query = new WP_Query( $args ); 
            if ( $query -> have_posts() ) : 
 
 			echo '<!--' ;
			print_r($query);
			echo '-->';       
			$cur_date = date('Ymd');
			echo '<!--' . $cur_date . '-->';
			?>

            <header class="entry-header prepend-top">

                <h1 class="entry-title append-bottom prepend-top">Current Openings</a></h1>

            </header>
            <!-- /article-header -->
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('span-narrow'); ?>>
    
            <?php while ( $query -> have_posts() ) : $query->the_post(); 
				

			$exp_date_raw = get_post_meta($post->ID, 'date-expire', true);
			if ($exp_date_raw != '') {
				$exp_date = date('Ymd', strtotime($exp_date_raw));
			} else {
				$exp_date = '30005050'; //MAKE UN-EXPIRING POSTS ALWAYS SHOW UP;
			}
			if ( $exp_date >= $cur_date) : // if not expired, show post ?>

				<h4 class="append-bottom date-<?php echo $exp_date ?>"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
    			<?php else : ?>                          

                <div class="entry-content" >
            
                    <p id="no-jobs"><?php _e( 'We\'re eager to hear from those who may be interested in future positions as they become available. Feel free to share your CV with us, <a href="mailto:mith@umd.edu" target="_blank">mith@umd.edu.</a>', 'mithpress' ); ?></p>
            
                </div>
                <!-- /entry-content -->
                <?php endif; // end else ?>                
                
			<?php endwhile; ?>
        
            </article>
            <!-- /post-<?php the_ID(); ?> -->
        
			<?php endif; ?>
                
    </div>
	<!-- /content -->

</div>
<!-- /primary/post -->    

<div class="clear"></div>
</div>
<!-- /container -->

<?php get_footer(); ?>
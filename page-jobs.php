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
            
            <?php get_template_part( 'content', 'page' ); ?>

			<?php 
            
			$args = array(
                'post_type' => 'job',
                'posts_per_page' => -1,
            );
        
            $query = new WP_Query( $args ); 
                        
            if ( $query -> have_posts() ) : 
            
			?>

            <header class="entry-header prepend-top">

                <h1 class="entry-title append-bottom prepend-top">Current Openings</a></h1>

            </header>
            <!-- /article-header -->
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('span-narrow'); ?>>
    
            <?php while ( $query -> have_posts() ) : $query->the_post(); 
				
				//to check against expiration date;
				$currentdate = date("Ymd");
				$expirationdate = get_post_custom_values('date');
				if (is_null($expirationdate)) {
					$expirestring = '30005050'; //MAKE UN-EXPIRING POSTS ALWAYS SHOW UP;
				} else {
					if (is_array($expirationdate)) {
						$expirestringarray = implode($expirationdate);
					}
					$expirestring = str_replace("/","",$expirestringarray);
				} //else
				if ( $expirestring >= $currentdate ) { // post loop contents ?>
	
                    <h4 class="append-bottom"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
	
    			<?php } ?>                          
                
			<?php endwhile; ?>
        
            </article>
            <!-- /post-<?php the_ID(); ?> -->
        
			<?php else : ?>

            <header class="entry-header prepend-top">

                <h1 class="entry-title append-bottom prepend-top">Current Openings</a></h1>

            </header>
            <!-- /article-header -->

            <article id="post-0" class="post no-results not-found">

                <div class="entry-content">
            
                    <p><?php _e( 'MITH does not currently have any openings. However, we\'re eager to hear from those who may be interested in future positions as they become available. Feel free to share your CV with us, <a href="mailto:mith@umd.edu" target="_blank">mith@umd.edu.</a>', 'mithpress' ); ?></p>
            
                </div>
                <!-- /entry-content -->

            </article>
            <!-- /post-0 -->

			<?php endif; ?>
                
    </div>
	<!-- /content -->

</div>
<!-- /primary/post -->    

<div class="clear"></div>
</div>
<!-- /container -->

<?php get_footer(); ?>
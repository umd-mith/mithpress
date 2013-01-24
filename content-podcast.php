<?php
/**
 * The template for displaying content for single podcasts on the main blog
 *
**/
    global $podcast_mb;
	$podcast_mb->the_meta();
	$twitter = $podcast_mb->get_the_value('twitter');
	$stitle = $podcast_mb->get_the_value('speakertitle');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
    
		<h1 class="entry-title append-bottom"><?php the_title(); ?></h1>
	
    </header>
    <!-- /entry-header-->

	<div class="entry-content">
	
    	<div id="podcast-info" class="append-bottom prepend-top clear<?php if (!has_post_thumbnail() ) echo ' no-thumb'; ?>">
	
    		<?php the_post_thumbnail( 'med-thumbnail' ); ?>
	
    		<span class="pods-speaker">
				<?php $podcast_mb->the_value('speaker'); if ($stitle != null) { ?>, <span class="pods-stitle"><?php echo $stitle; ?></span><?php } ?>
            </span> 
        	
            <span class="pods-affiliation"><?php $podcast_mb->the_value('affiliation'); ?></span>
            
            <!--<span class="pods-date"><?php $podcast_mb->the_value('talk-date'); ?></span>-->

			<?php if ( $twitter != '') { ?>
            <span class="pods-twitter"><a href="http://www.twitter.com/#!/<?php echo $twitter ?>" rel="nofollow" target="_blank">@<?php echo $twitter ?></a></span>
            <?php } ?>
    
	        <?php echo do_shortcode('[gigpress_related_shows]'); ?>
    
        </div>
        <!-- /podcast-info -->
        
        
        <div id="abstract">
	
    		<?php the_content(); ?>
    
        </div>
        <!-- /abstract -->
    	
    </div>
    <!-- /entry-content -->

    <?php get_template_part('sharing', 'post'); ?>
    
    <br clear="all" />
	
	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>

    <nav id="nav-single" class="span-narrow">
    
        <h3 class="assistive-text"><?php _e( 'Post navigation', 'mithpress' ); ?></h3>
        <span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav"></span> Previous', 'mithpress' ) ); ?></span>
        <span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav"></span>', 'mithpress' ) ); ?></span>
    
    </nav>
    <!-- /nav-single -->

</article>
<!-- /post-<?php the_ID(); ?> -->
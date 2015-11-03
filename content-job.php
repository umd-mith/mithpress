<?php
/**
 * The template for displaying content in the single-job.php template ONLY 
 *
**/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( ! has_post_thumbnail() ) { // show title if no image assigned ?>

	<header class="entry-header">
	
    	<h1 class="entry-title append-bottom"><?php the_title(); ?></h1>
	
    </header>
	
	<?php } ?>
    
	<div class="entry-content">

	    <div class="job-desc">
	    <?php 
		$current_date = date('Ymd');
		$exp_date = get_field('expiration_date');
		
		if ( $exp_date < $current_date) : ?>
            <div class="job-expire"><?php _e('Job Closed: ', 'mithpress'); ?><?php $date = DateTime::createFromFormat('Ymd', get_field('expiration_date'));
echo $date->format('F j, Y'); ?></div>
            <?php endif; ?>
            
            <?php the_content(); ?>
            
                </div>
		<!-- /job-desc -->
        
    	<?php get_template_part('sharing', 'post'); ?>

	</div>
    <!-- /entry-content -->
    
    <br clear="all" />

	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>

</article>
<!-- /post-<?php the_ID(); ?> -->
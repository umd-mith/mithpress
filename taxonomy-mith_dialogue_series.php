<?php get_header(); ?>

	<div id="content" class="" style="float:right;">
        <div class="post-content">
            <?php //the_content(); ?>
            <?php get_template_part( 'templates/dialogue', 'series' ); ?>
        </div>
	</div>
	<?php wp_reset_query(); ?>
	
	<?php get_template_part('templates/sidebar', 'dialogues');  ?>
    
<?php get_footer(); ?>
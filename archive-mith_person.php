<?php get_header(); 
	$page_id = get_the_ID();
	?>
	<div id="content" class="" style="float:right;">
		<?php if( category_description() ): ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class( 'fusion-archive-description' ); ?>>
			<div class="post-content">
				<?php echo category_description(); ?>
			</div>
		</div>
		<?php endif; ?>	
		
		<?php get_template_part( 'templates/persons', 'layout' ); ?>
	</div>
	<?php wp_reset_query(); ?>
	
	<?php get_template_part('templates/sidebar', 'person');  ?>
    
<?php get_footer(); ?>
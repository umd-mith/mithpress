<?php get_header(); ?>
	<?php
	$content_css = 'float:right;';
	$sidebar_css = 'float:left;';
	$sidebar_exists = true;
	$sidebar_left = 1;
	$double_sidebars = false;

	$sidebar_1 = 'Persons Menu';
	$sidebar_2 = get_post_meta( $post->ID, 'sbg_selected_sidebar_2_replacement', true );

	$page_id = get_the_ID();
	?>
	<div id="content" class="<?php echo $content_css; ?>" style="<?php echo $content_css; ?>">
		<?php if( category_description() ): ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class( 'fusion-archive-description' ); ?>>
			<div class="post-content">
				<?php echo category_description(); ?>
			</div>
		</div>
		<?php endif; ?>	
		
		<?php get_template_part( 'templates/persons', 'layout' ); ?>
	</div>
	<?php //wp_reset_query(); ?>
	<div id="sidebar" class="sidebar" style="<?php echo $sidebar_css; ?>">
		<?php generated_dynamic_sidebar('Persons Menu'); ?>
	</div>
    
<?php get_footer(); ?>
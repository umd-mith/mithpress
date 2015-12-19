<?php get_header(); ?>
	<?php
	$container_class = '';
	$timeline_icon_class = '';	
	$post_class = '';
	$content_class = '';
	$sidebar_left = '';

	$sidebar_1 = 'Dialogues Menu';
	$sidebar_2 = 'Digital Dialogues';
	
	$double_sidebars = true;
	$sidebar_exists = true;
	$content_css = 'float:left;';
	$sidebar_css = 'float:left;';
	$sidebar_2_css = 'float:left;';

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
		
		<?php get_template_part( 'templates/dialogues', 'layout' ); ?>
	</div>
	<?php wp_reset_query(); ?>
	<div id="sidebar" class="sidebar" style="<?php echo $sidebar_css; ?>">
		<?php generated_dynamic_sidebar('Dialogues Menu'); ?>
	</div>
    
	<div id="sidebar-2" class="sidebar" style="<?php echo $sidebar_2_css; ?>">
		<?php generated_dynamic_sidebar_2('Digital Dialogues'); ?>
	</div>

<?php get_footer(); ?>
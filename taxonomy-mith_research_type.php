<?php
	get_header();
	$content_css = 'width:100%';
	$sidebar_css = 'display:none';
	$content_class = '';
	$sidebar_exists = false;
	$sidebar_left = '';
	$double_sidebars = false;
	
	?>
    
<div id="content" class="fusion-portfolio fusion-portfolio-three research-portfolio" style="<?php echo $content_css; ?>">

	<?php get_template_part( 'templates/research-archive', 'timeline-layout' ); ?>

</div>

	<?php if( $sidebar_exists == true ): ?>
	<?php wp_reset_query(); ?>
	<div id="sidebar" class="sidebar" style="<?php echo $sidebar_css; ?>">
		<?php
		if($sidebar_left == 1) {
			generated_dynamic_sidebar($sidebar_1);
		}
		if($sidebar_left == 2) {
			generated_dynamic_sidebar_2($sidebar_2);
		}
		?>
	</div>
	<?php endif; ?>
<?php get_footer(); ?>
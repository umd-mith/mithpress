<?php get_header(); ?>
	<?php
	$sidebar_exists = true;
	$sidebar_left = '1';
	$double_sidebars = false;
	$content_class = '';
	
	$sidebar_css = 'float:left;';
	$content_css = 'float:right;';
	
	$page = get_page_by_title( 'Current Schedule', OBJECT, 'page' );
	$page_id = $page->ID; 
?>

	<div id="content" class="<?php echo $content_class; ?>" style="<?php echo $content_css; ?>">
        <div class="post-content">
            <?php //the_content(); ?>
            <?php get_template_part( 'templates/dialogue', 'series' ); ?>
            <?php avada_link_pages(); ?>
        </div>
    </div>

	<div id="sidebar" class="sidebar <?php echo $sidebar_class; ?>" style="<?php echo $sidebar_css; ?>">
		<?php
		if( $sidebar_exists == true ) {
			if($sidebar_left == 1) {
				echo mith_display_sidenav( $page_id );
				generated_dynamic_sidebar($sidebar_1);
			}
			if($sidebar_left == 2) {
				generated_dynamic_sidebar_2($sidebar_2);
			}
		}
		?>
	</div>
	<?php if( $sidebar_exists && $double_sidebars ): ?>
	<div id="sidebar-2" class="sidebar <?php echo $sidebar_class; ?>" style="<?php echo $sidebar_2_css; ?>">
		<?php
		if($sidebar_left == 1) {
			generated_dynamic_sidebar_2($sidebar_2);
		}
		if($sidebar_left == 2) {
			echo avada_display_sidenav( $page_id );
			generated_dynamic_sidebar($sidebar_1);
		}
		?>
	</div>
	<?php endif; ?>
<?php get_footer();

// Omit closing PHP tag to avoid "Headers already sent" issues.
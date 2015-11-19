<?php get_header(); ?>
	<?php
	$sidebar_exists = true;
	$sidebar_left = '1';
	$double_sidebars = false;
	$content_class = '';
	
	$sidebar_css = 'float:left;';
	$content_css = 'float:right;';
	
	$page = get_page_by_title( 'Current Schedule', OBJECT, 'page' );
	$pageid = $page->ID; 

/*
$sidebar_1 = Avada()->settings->get( 'portfolio_archive_sidebar' );
$sidebar_2 = Avada()->settings->get( 'portfolio_archive_sidebar_2' );
if( $sidebar_1 != 'None' && $sidebar_2 != 'None' ) {
	$double_sidebars = true;
}

if( $sidebar_1 != 'None' ) {
	$sidebar_exists = true;
} else {
	$sidebar_exists = false;
}

if( ! $sidebar_exists ) {
	$content_css = 'width:100%';
	$sidebar_css = 'display:none';
	$content_class = 'full-width';
	$sidebar_exists = false;
} elseif(Avada()->settings->get( 'portfolio_sidebar_position' ) == 'Left') {
	$content_css = 'float:right;';
	$sidebar_css = 'float:left;';
	$sidebar_left = 1;
} elseif(Avada()->settings->get( 'portfolio_sidebar_position' ) == 'Right') {
	$content_css = 'float:left;';
	$sidebar_css = 'float:right;';
	$sidebar_left = 2;
}

if($double_sidebars == true) {
	$content_css = 'float:left;';
	$sidebar_css = 'float:left;';
	$sidebar_2_css = 'float:left;';
} else {
	$sidebar_left = 1;
} */
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
				echo avada_display_sidenav( $pageid );
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
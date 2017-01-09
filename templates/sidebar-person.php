<?php $page = get_page_by_title( 'People', OBJECT, 'page' );
$page_id = $page->ID; ?>

<div id="sidebar" <?php Avada()->layout->add_class( 'sidebar_1_class' ); ?> style="float: right; float: left;">
	<?php if ( is_tax('mith_staff_group') || is_post_type_archive('mith_person') ) : 
	generated_dynamic_sidebar('People Menu');
	//echo mith_display_sidenav( $page_id ); 
	else :
	generated_dynamic_sidebar('People Grid'); 
	endif; ?>
</div>
<?php if ( is_singular('mith_person') ) : ?>
<div id="sidebar-2" <?php Avada()->layout->add_class( 'sidebar_2_class' ); ?> style="float: left;">
    <?php echo mith_display_blog_posts();  ?>
</div>
<?php endif; ?>
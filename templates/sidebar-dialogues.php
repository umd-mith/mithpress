<?php $page = get_page_by_title( 'Digital Dialogues', OBJECT, 'page' );
$page_id = $page->ID; ?>

<div id="sidebar" <?php Avada()->layout->add_class( 'sidebar_1_class' ); ?> style="float: right; float: left;">
	<?php echo mith_display_sidenav( $page_id ); ?>
</div>
<?php if ( is_post_type_archive('mith_dialogue') ) : ?>
<div id="sidebar-2" <?php Avada()->layout->add_class( 'sidebar_2_class' ); ?> style="float: left;">
	<?php generated_dynamic_sidebar('Digital Dialogues'); ?>
</div>
<?php endif; ?>
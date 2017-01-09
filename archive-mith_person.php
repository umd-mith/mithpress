<?php get_header(); 
$page_id = get_the_ID();
?>
	<div id="content" class="" style="float:right;">
    
		<?php get_template_part( 'templates/persons', 'layout' ); ?>
	
    </div>
	<?php wp_reset_query(); ?>
	
	<?php get_template_part('templates/sidebar', 'person');  ?>
    
<?php get_footer(); ?>

// Omit closing PHP tag to avoid "Headers already sent" issues.

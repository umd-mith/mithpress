<?php global $wp_query;
	  global $people_mb; 
	  $people_mb->the_meta(); 

	query_posts( array(
		'post_type' => 'people',
		'posts_per_page' => '-1',
		'meta_key' => $people_mb->get_the_name('lname'),
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'tax_query' => array(
		'relation' => 'AND',
			array(
				'taxonomy' => 'staffgroup',
				'field' => 'slug',
				'terms' => array( 'people-past-resident-fellows')
			),
			array(
				'taxonomy' => 'staffgroup',
				'field' => 'slug',
				'terms' => array( 'people-current' ),
				'operator' => 'NOT IN'
			)
		)
	) );
?>				  
				  
<?php 
    $i = 0; // set up a counter
    if ( have_posts() ) : ?>

	<header class="page-header">
		<h1 class="page-title append-bottom prepend-top">Resident Fellows</h1>
	</header>

    <div class="article-row clearfix">
    
    <?php while ( have_posts() ) : the_post(); ?>
    
        <?php get_template_part( 'content', 'people-archive'); ?>

	<?php 
        $i++; // increment the counter
        if( $i % 3 != 0) { 
            echo '';
        } else { ?>
            </div><div class="article-row clearfix">
        <?php // we've reached the end of a row; close & start new 
		} 
	?>

	<?php endwhile; ?>
    </div><!--/rows -->
    
<?php endif; ?>
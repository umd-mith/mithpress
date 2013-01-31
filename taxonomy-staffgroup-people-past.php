<?php
/**
 * The template for displaying People Archive page.
*/

get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">

        <?php get_sidebar('left'); ?>

			<div id="content" role="main" class="archive span-16 last">
			
			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
			<?php 
			$parent_term = get_term_by( 'slug', 'people-past', 'staffgroup' ); 
			$parent = $parent_term->term_id;
			?>
			<?php 
            $cat_terms = get_terms( 'staffgroup', array(
				'parent' => $parent, 
				'orderby' => 'custom_sort',
				'order' => 'ASC'
				) 
			);
			
			$count = count($cat_terms); 
	
            foreach ($cat_terms as $cat) : // start cycling through each category 
		
				$args = array(
					'tax_query' => array(
						array(
							'taxonomy' => 'staffgroup',
							'field' => 'slug',
							'terms' => $cat->slug,
						)
					),
					'post_type' => 'people',
					'posts_per_page' => '-1',
				    'meta_key' => $people_mb->get_the_name('lname'),
					'orderby' => 'custmo_sort menu_order meta_value',
					'order' => 'ASC',
				);
				
				$new_query = new WP_Query( $args ); ?>
                
				<?php 
				if ( $new_query->have_posts() ) : 
				
				$i = 0; // set up a counter ?>
                
				<div id=" <?php echo $cat->slug; ?>" class="article-row group row-<?php echo $cat->term_id; ?>">
				
                    <header class="page-header">
                        <h1 class="page-title append-bottom prepend-top"><?php echo $cat->name; ?></h1>
                    </header>
                    
                    <?php while ( $new_query->have_posts() ) : $new_query->the_post(); ?>
                    
					<?php global $people_mb; $people_mb->the_meta(); ?>
                
                    <?php get_template_part( 'content', 'people-archive'); ?>
					                    
					<?php $i++; // increment the counter 

                    if ($i % 3 != 0 ) { 
                        $endclass = ''; 
                    } else {  echo '<br clear="all" />'; }  
                    // if article is multiple of 3, set class to "last" ?>            
                                
                    <?php endwhile; ?>

                </div><!--/rows for <?php echo $cat->name; ?> -->
				
			<?php endif; ?>            
			
			<?php endforeach; //endforeach  ?>
        
        <p style="border-top: 1px dotted #DDD; padding-top: 15px; margin-top:15px; clear:both; ">Are we missing someone or do you see an error above? Please let us know by filling out <a href="https://docs.google.com/spreadsheet/viewform?formkey=dHJkMnoyV0ZDdndGSTNSbFpwa0RZYWc6MQ#gid=0" target="_blank">this form</a>. Thanks!</p>
        </div>
        <!-- /content -->
	</div>
    <!--/primary/post -->    
<div class="clear"></div>
</div>
<!-- /page / start footer -->

<?php get_footer(); ?>
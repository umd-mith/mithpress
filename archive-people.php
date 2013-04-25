<?php
/**
 * The template for displaying People page.
*/

get_header(); ?>

<div id="page-container">
		<div id="primary" class="width-limit">

        <?php get_sidebar('left'); ?>

			<div id="content" role="main" class="archive span-16 last">
			
			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
			<?php 
			$parent_term = get_term_by( 'slug', 'people-current', 'staffgroup' ); 
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
				$i = 0; // set up a counter 
				?>
				<div id=" <?php echo $cat->slug; ?>" class="article-row group row-<?php echo $cat->term_id; ?>">
				<header class="page-header">
					<h1 class="page-title append-bottom prepend-top"><?php echo $cat->name; ?></h1>
				</header>
				
				<?php while ( $new_query->have_posts() ) : $new_query->the_post(); ?>
                <?php 
				global $people_mb; 
				$people_mb->the_meta(); 
				
				if ($i % 3 != 0 ) { 
					$endclass = ''; 
				} else { 
					$endclass = 'last'; }  
				// if article is multiple of 3, set class to "last" ?>
			
				<article id="post-<?php the_ID(); ?>" <?php post_class($endclass); ?>>
                	
					<div class="entry-content">
			
						<div id="person" class="append-bottom prepend-top">                        	

						<a href="<?php the_permalink(); ?>" rel="alternate" title="Permanent Link to <?php the_title_attribute(); ?>">
			
							<?php the_post_thumbnail( 'mini-thumbnail' ); ?>
				
							<div class="person-info">
								<span class="info-name"><?php the_title(); ?></span>                            
								<span class="info-title"><?php $people_mb->the_value('stafftitle'); ?></span>
							</div>
							
						</a>
			
						</div><!-- /person-->
						
					</div><!-- /entry-content -->
				
				</article>
				<?php $i++; // increment the counter ?>
							
				<?php endwhile; ?>

                </div><!--/rows for <?php echo $cat->name; ?> -->
				
			<?php endif; ?>            
			<?php endforeach; //endforeach  ?>
        </div>
        <!-- /content -->
	</div>
<div class="clear"></div>
<!-- /primary -->
</div>
<!-- /page / start footer -->

<?php get_footer(); ?>
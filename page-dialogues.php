<?php
/*
Template Name: Dialogues
* display dialogues information and brief list of most recent dialogues
*/
?>

<?php get_header(); ?>

<div id="page-container">

    <div id="primary" class="width-limit">

    <?php get_sidebar('left'); ?>

        <div id="content" role="main" class="span-16 last">
    
		<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
    
            <div id="articles">
                        
            <?php the_post(); ?>
            
            <?php if ( has_post_thumbnail() ) { ?>
            	
                <div class="entry-image"><?php the_post_thumbnail(); ?></div>
			
			<?php } ?>
            
                <article id="post-<?php the_ID(); ?>" <?php post_class('span-narrow'); ?>>
                
                    <div class="entry-content">
                
                        <?php the_content(); ?>
                
                    </div>
                
                </article>
                <!-- /post-<?php the_ID(); ?> -->
            
 				<?php global $wp_query;
				
					$current_date = date('Ymd');
                
					query_posts( array(
						'post_type' => 'podcast',
						'posts_per_page' => '3',
						'meta_query' => array(
						   array(
							   'key' => 'podcast_date',
							   'value' => $current_date,
							   'compare' => '<=',
						   )
					   ),
					));
                
                ?>
                <?php if ( have_posts() ) : ?>
                <header class="entry-header prepend-top">
        
                    <h1 class="entry-title append-bottom prepend-top">Recent Dialogues</a></h1>
        
                </header>
                <!-- /entry-header-->
        
                <article id="post-<?php the_ID(); ?>" <?php post_class('span-narrow'); ?>>

                    <div class="dialogues-wrap widget widget_recent_cpt">
                
                    <ul id="recent-dialogues" class="no-bullets">
        
                    <?php while ( have_posts() ) : the_post(); ?>
                		<li>
						<?php $talk_title = get_post_meta( get_the_ID(), 'podcast_title', TRUE ); ?>
                        <span class="post-title"><a href="<?php the_permalink(); ?>" title="<?php echo $talk_title; ?>"><?php if ($talk_title) { echo $talk_title; } else { the_title(); } ?></a></span>
                        <?php echo podcast_info_snippet(); ?>
        				</li>
                    <?php endwhile; //while_posts ?>
                    
                    </ul>
                    
                    </div>

                </article>
                <!-- /post-<?php the_ID(); ?> -->
        
                <?php endif; //have_posts ?>
    
        
            </div>
            <!-- /articles -->
    
        <?php get_sidebar('ddialogue'); ?>
        <!-- /sidebar -->
                    
        </div>
		<!-- /content -->

    </div>
    <!-- /primary/post -->    

    <div class="clear"></div>
    
</div>
<!-- /page  -->

<?php get_footer(); ?>
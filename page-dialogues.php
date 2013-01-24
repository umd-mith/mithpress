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
                
					query_posts( array(
						'post_type' => 'podcast',
						'posts_per_page' => '3',
					));
                
                ?>
            
                <?php if ( have_posts() ) : ?>
        
                <header class="entry-header prepend-top">
        
                    <h1 class="entry-title append-bottom prepend-top">Recent Dialogues</a></h1>
        
                </header>
                <!-- /entry-header-->
        
                <article id="post-<?php the_ID(); ?>" <?php post_class('span-narrow'); ?>>
                
                    <ul id="recent-dialogues" class="no-bullets">
        
                    <?php while ( have_posts() ) : the_post(); ?>
                    
                    <?php 
					
                    global $podcast_mb; 
                    $podcast_mb->the_meta(); 
                    $stitle = $podcast_mb->get_the_value('speakertitle'); 
					$talk_date = $podcast_mb->get_the_value('talk-date');
					$talk_title = $podcast_mb->get_the_value('talk-title');
					?>
        
                        <li><a href="<?php the_permalink(); ?>" >
                            <span class="pods-date"><?php if ($talk_date != '') { 
								echo $talk_date;
								} else { the_date( 'F j, Y' ); 
							} ?></span>
                            <span class="pods-speaker"><?php $podcast_mb->the_value('speaker'); if ( $stitle != '') { ?>, <span class="pods-stitle"><?php echo $stitle ?></span><?php } ?></span> 
                            <span class="pods-title"><?php if ( $talk_title != '') { 
								echo $talk_title; 
								} else { the_title(); 
							} ?></span>
                        </a></li>    
        
                    <?php endwhile; //while_posts ?>
                    
                    </ul>
        
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
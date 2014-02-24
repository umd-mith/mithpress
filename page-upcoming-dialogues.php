<?php
/*
Template Name: Upcoming Dialogues
* display dialogues information and brief list of upcoming dialogues
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
            
				<?php 
                
                $terms = get_terms("podcast_series", array(
                    'orderby'    => 'slug',
                    'order' 	 => 'DESC',
                    'hide_empty' => false
                 ) );
                
                $first_value = reset($terms); // First Element's Value
                $first_slug = $first_value->slug;
                
                $args = array(
                    'post_type' => 'podcast',
                    'post_status' => array( 'pending', 'future', 'publish' ),
                );
                    
                $podcasts = new WP_Query($args);
                //reverse the order of the posts, latest last
                $array_rev = array_reverse($podcasts->posts);
                //reassign the reversed posts array to the $podcasts object
                $podcasts->posts = $array_rev;
                
                if ( $podcasts->have_posts() ) : ?>
                
                <header class="entry-header prepend-top">
        
                    <h1 class="entry-title append-bottom prepend-top"><?php echo _e('Upcoming Dialogues'); ?></h1>
        
                </header>
                <!-- /entry-header-->
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('span-narrow'); ?>>
                
                    <div class="dialogues-wrap widget widget_recent_cpt">
                        <ul class="no-bullets">
    
                        <?php while ( $podcasts->have_posts() ) : $podcasts->the_post(); ?>
                        <?php $id = $podcasts->post->ID;
                        $post_terms = get_the_terms($id, 'podcast_series');
    
                        foreach ( $post_terms as $post_term ) : 
                            if ( $post_term->slug == $first_slug ) : // make sure post is within current series
                            $current_date = date('Ymd');
                            $date_raw = get_post_meta( get_the_ID(), 'podcast_date', TRUE); 
                            $time = get_post_meta( get_the_ID(), 'podcast_time', TRUE);
    
                            if ($current_date <= $date_raw ) : // only show posts that are in the future from today's date
                    
                            if ($date_raw != '') { $date = date('l, F j, Y', strtotime($date_raw)); }
                            $talk_title = get_post_meta( get_the_ID(), 'podcast_title', TRUE );	?>
                            <li><span class="post-date"><?php echo $date; ?></span>
                                <span class="post-time"><?php echo $time; ?></span>
                                <span class="post-title"><a href="<?php the_permalink(); ?>" title="<?php echo $talk_title; ?>"><?php echo $talk_title; ?></a></span>
                                <?php $podcast_speakers = get_field('podcast_speakers');
                                    if( get_field('podcast_speakers') ) :			
                                    $count = $podcast_speakers;
                                    while(has_sub_field('podcast_speakers') && $count > 0 ) :
                                        $speaker_name = get_sub_field('podcast_speaker_name');
                                        $speaker_title = get_sub_field('podcast_speaker_title');
                                        $speaker_affiliation = get_sub_field('podcast_speaker_affiliation'); ?>
                                    <span class="post-speaker"><?php echo $speaker_name; ?></span><?php if ( $speaker_title != '') : ?><span class="post-stitle">, <?php echo $speaker_title; ?></span><?php endif; if ( $speaker_affiliation != '' ) : ?><span class="post-affiliation">, <?php echo $speaker_affiliation; ?></span><?php endif; ?>
                                <?php 	
                                    endwhile;
                                    endif;
                                ?>
                            </li>
                            <?php endif; //end date check ?>
                        
                        <?php endif; // end current series check
                        endforeach; ?>
                        
                        <?php endwhile; ?>
                        </ul>
                    </div>  

                </article>
                
				<?php else : ?>
                
                <article id="no-posts" <?php post_class('span-narrow'); ?>>
                
                    <?php echo _e('No Upcoming Dialogues. Past Digital Dialogues may be viewed using the navigation to the left.'); ?>
                
                </article>
                
                <?php endif;
				/* Restore original Post Data */
				wp_reset_postdata(); wp_reset_query(); ?>
    
            </div>
            <!-- /articles -->
    
        <?php get_sidebar('podcast'); ?>
        <!-- /sidebar -->
                    
        </div>
		<!-- /content -->

    </div>
    <!-- /primary/post -->    

    <div class="clear"></div>
    
</div>
<!-- /page  -->

<?php get_footer(); ?>
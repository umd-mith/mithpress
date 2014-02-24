<?php
get_header(); ?>
<?php /*
$now = current_time('mysql');
$future_posts = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_status = 'future' || post_status = 'publish' ORDER BY post_date ASC");

if($future_posts) : foreach($future_posts as $post) : setup_postdata($post);
*/
?>
<div id="page-container" class="podcasts-archive">

    <div id="primary" class="width-limit">

		<?php get_sidebar('left'); ?>

		<div id="content" role="main" class="span-16 wide last">
        
			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>

            <div id="podcasts-archive">
			
            <?php
			$current_cat = get_query_var($wp_query->query_vars['taxonomy']);
			$current_cat_posts = get_term_by('slug', $current_cat, 'podcast_series');
			$current_cat_count = $current_cat_posts->count;
			?>
            <header class="page-header">
                <h1 class="page-title append-bottom prepend-top"><?php _e( 'Past Dialogue Schedules', 'mithpress' ); ?></h1>
            </header><!-- /entry-header -->
		  
            <h2 class="podcasts-header"><span><?php single_cat_title(); _e( ' Digital Dialogues', 'mithpress' ); ?></span>

            <form action="<?php bloginfo('url'); ?>/" method="get">
            <div class="podcast_series">
			<?php restrict_listings_by_series(); ?>
			<input type="submit" name="submit" value="view" />
            </div></form>
            
            </h2>
                      
		  <?php if ( have_posts() ) : ?>
            <ul class="podcasts-list">

			  <?php while ( have_posts() ) : the_post(); ?>
              <?php 
				$date_raw = get_post_meta( get_the_ID(), 'podcast_date', TRUE);
				$time = get_post_meta( get_the_ID(), 'podcast_time', TRUE);
				$location = get_post_meta( get_the_ID(), 'podcast_location', TRUE); 
				$talk_title = get_post_meta( get_the_ID(), 'podcast_title', TRUE );
				$sponsor = get_post_meta( get_the_ID(), 'podcast_sponsors', TRUE );
				?>
                <li class="archive-podcast append-bottom prepend-top clear">
                       	<span class="info-dates"><?php 
                                    if ($date_raw != '') { $date = date('F j, Y', strtotime($date_raw)); echo $date; } 
                                    elseif ( get_post_meta(get_the_ID(), 'talk-date', TRUE) != '') { echo get_post_meta(get_the_ID(), 'talk-date', TRUE); } 
                                    else { echo the_date( 'F j, Y' ); } ?></span>
            		<div id="podcast-info" >
	
   					  <?php $podcast_speakers = get_field('podcast_speakers');
                        
                            if( get_field('podcast_speakers') ) :
                                
                                $i = 0;
                                $count = $podcast_speakers;
                                            
                            while(has_sub_field('podcast_speakers')) :
                                $speaker_name = get_sub_field('podcast_speaker_name');
                                $speaker_title = get_sub_field('podcast_speaker_title');
                                $speaker_affiliation = get_sub_field('podcast_speaker_affiliation');
                                $speaker_twitter = get_sub_field('twitter_handle');
                                ?>
                    
                        <span class="post-speaker">
                            <?php echo $speaker_name; if ($speaker_title != '') { ?>, <span class="post-stitle"><?php echo $speaker_title; ?></span><?php } if ($speaker_affiliation != '') { ?>, <span class="post-affiliation"><?php echo $speaker_affiliation; ?></span><?php } ?>
                        </span>
                        
							<?php $i++; endwhile; endif; ?>

                    	   <h3 class="talk-title"><?php if ($talk_title) { echo $talk_title; } else { the_title(); } ?></h3>

                             <?php if ($time != '') echo '<span class="info-times"><strong>Time:</strong> ' . $time . '</span>'; ?>     
                                 
    
                             <span class="info-location"><strong>Location: </strong><?php if ($location != '') { echo $location; } else { echo 'MITH Conference Room'; } ?></span>      
                            
                             <?php if ($sponsor != '') : ?>
                             <span class="post-sponsor"><?php echo $sponsor; ?></span>
                             <?php endif; ?>
                            
                            <span class="talk-link post-link">
                               	<a href="<?php the_permalink(); ?>" title="Link to: <?php if ($talk_title) { echo $talk_title; } else { the_title(); } ?>">Related Podcast</a>
                            </span>
                  </div>
              </li>

			  <?php endwhile; ?>
            </ul>

		  <?php endif; ?>
          </div>
          <!-- /podcasts-archive -->
                    
		</div>
        <!-- /content -->
        
	</div>
    <!--/primary -->
        
	<div class="clear"></div>

</div>
<!-- /page / start footer -->

<?php get_footer(); ?>
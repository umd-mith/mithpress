<?php
/**
 * The template for displaying content for single podcasts on the main blog
 *
**/
	$date_raw = get_post_meta( get_the_ID(), 'podcast_date', TRUE);
	$time = get_post_meta( get_the_ID(), 'podcast_time', TRUE);
	$location = get_post_meta( get_the_ID(), 'podcast_location', TRUE); 
	$talk_title = get_post_meta( get_the_ID(), 'podcast_title', TRUE );
	$sponsor = get_post_meta( get_the_ID(), 'podcast_sponsors', TRUE );
	
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
    
		<h1 class="entry-title append-bottom"><?php if ($talk_title) { echo $talk_title; } else { the_title(); } ?></h1>
	
    </header>
    <!-- /entry-header-->

	<div class="entry-content">
        <div id="podcast-info" class="append-bottom prepend-top clear<?php if (!has_post_thumbnail()) echo ' no-thumb'; ?>">
			<?php the_post_thumbnail( 'med-thumbnail' ); ?>
	<?php 
        $podcast_speakers = get_field('podcast_speakers');

			if( get_field('podcast_speakers') ) :
			
			$i = 0;
			$count = $podcast_speakers;
						
			while(has_sub_field('podcast_speakers')) :
				$speaker_name = get_sub_field('podcast_speaker_name');
				$speaker_title = get_sub_field('podcast_speaker_title');
				$speaker_affiliation = get_sub_field('podcast_speaker_affiliation');
				$speaker_bio = get_sub_field('podcast_speaker_bio');
				$speaker_website = get_sub_field('speaker_website');
				$speaker_twitter = get_sub_field('twitter_handle');
			?>
	
    		<span class="post-speaker">
				<?php echo $speaker_name; if ($speaker_title != null) { ?>, <span class="post-stitle"><?php echo $speaker_title; ?></span><?php } ?>
            </span> 
        	
            <span class="post-affiliation"><?php echo $speaker_affiliation; ?></span>
           
			<?php if ( $speaker_twitter != '') : ?>
            <span class="post-twitter"><a href="http://www.twitter.com/<?php echo $speaker_twitter ?>" rel="nofollow" target="_blank">@<?php echo $speaker_twitter ?></a></span>
            <?php endif; ?>

			<?php if ( $speaker_website != '') : ?>
            <span class="post-website"><a href="<?php echo 'http://' . $speaker_website ?>" rel="nofollow" target="_blank"><?php echo $speaker_website ?></a></span>
            <?php endif; ?>
 			
 			<?php $i++;
			endwhile; 
			endif; ?>
            <section class="podcast-details">        
            <span class="info-location"><?php if ($location != '') { echo $location; } else { echo 'MITH Conference Room'; } ?></span>      

            <span class="info-dates"><?php 
				if ($date_raw != '') { $date = date('l, F j, Y', strtotime($date_raw)); echo $date; } 
				elseif ( get_post_meta(get_the_ID(), 'talk-date', TRUE) != '') { echo get_post_meta(get_the_ID(), 'talk-date', TRUE); } 
				else { echo the_date( 'l, F j, Y' ); } ?></span>
			<?php if ($time != '') echo '<span class="info-times">' . $time . '</span>'; ?>      
    		<?php if ($sponsor != '') : ?>
            <span class="post-sponsor"><?php echo $sponsor; ?></span>
        	<?php endif; ?>
            </section>
        </div>
        <!-- /podcast-info -->
        
        
        <div id="abstract" class="post-abstract">
	
    		<?php the_content(); ?>
            
            <?php 
			$vimeo = get_post_meta( $post->ID, 'podcast_vimeo_embed', TRUE); 
			if ($vimeo != '' ) : ?>
            <div class="podcast_files-video">
            <?php //$shortcode = apply_filters('the_content', '[embed width="410"]'. $vimeo .'[/embed]');
			global $wp_embed; 
			$video_embed = $wp_embed->run_shortcode('[embed width="410"]'. $vimeo .'[/embed]');
			echo $video_embed;
			?>
            </div>
            <?php endif; ?>
                        
            <?php $podcast_speakers = get_field('podcast_speakers');

			if( get_field('podcast_speakers') ) : ?>
			<?php while(has_sub_field('podcast_speakers')) : ?>
            
			<?php if (get_sub_field('podcast_speaker_bio') != '') : ?>
    		<span class="pod-bio"><?php echo get_sub_field('podcast_speaker_bio'); ?></span>
            <?php endif; ?>
            
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <!-- /abstract -->
        
 		<div id="dd-info">
 		  <p>A continuously updated schedule of talks is also available on the Digital Dialogues webpage.</p>
 		  <p>Unable to attend the events in person?
 		    
 		    Archived podcasts can be found on the MITH website, and you can follow our Digital Dialogues Twitter account @digdialog as well as the Twitter hashtag #mithdd to keep up with live tweets from our sessions. Viewers can watch the live stream as well.</p>
 		  <p>All talks free and open to the public. Attendees are welcome to bring their own lunches.</p>
 		  <p>Contact: MITH (http://mith.umd.edu, mith@umd.edu, 301-405-8927). </p>
 		</div>
    	
  </div>
    <!-- /entry-content -->

    <?php get_template_part('sharing', 'post'); ?>
    
    <br clear="all" />
	
	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>

    <nav id="nav-single" class="span-narrow">
    
        <h3 class="assistive-text"><?php _e( 'Post navigation', 'mithpress' ); ?></h3>
        <span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav"></span> Previous', 'mithpress' ) ); ?></span>
        <span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav"></span>', 'mithpress' ) ); ?></span>
    
    </nav>
    <!-- /nav-single -->

</article>
<!-- /post-<?php the_ID(); ?> -->
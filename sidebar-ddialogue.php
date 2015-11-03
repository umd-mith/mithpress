<div id="sidebar" class="ddialogue widget-area span-5 prepend-1 append-bottom last" role="complementary">

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
<div id="upcoming-dialogues" class="dialogues-wrap widget widget_recent_cpt">
	<h3><?php echo _e('Upcoming Dialogues'); ?></h3>
	<aside class="widget-body">
    <ul class="upcoming-dialogues">
    <?php $i = 0; ?>
	<?php while ( $podcasts->have_posts() ) : $podcasts->the_post(); ?>
    <?php $id = $podcasts->post->ID;
	$post_terms = get_the_terms($id, 'podcast_series');

	foreach ( $post_terms as $post_term ) : 
		if ( $post_term->slug == $first_slug ) : // make sure post is within most recent (current) series
		$current_date = date('Ymd');
		$date_raw = get_post_meta( get_the_ID(), 'podcast_date', TRUE); 
		
		if (($current_date <= $date_raw) && $i < 4) : // only show posts that are in the future from today's date (aka Scheduled)

		if ($date_raw != '') { $date = date('M j, Y', strtotime($date_raw)); }
		$talk_title = get_post_meta( get_the_ID(), 'podcast_title', TRUE );	?>
        <li><span class="post-date"><?php echo $date; ?></span>
            <span class="post-title"><a href="<?php the_permalink(); ?>" title="<?php echo $talk_title; ?>"><?php echo $talk_title; ?></a></span>
            <?php $podcast_speakers = get_field('podcast_speakers');
                if( get_field('podcast_speakers') ) :			
                $count = $podcast_speakers;
                while(has_sub_field('podcast_speakers') && $count > 0 ) :
                    $speaker_name = get_sub_field('podcast_speaker_name');
                    $speaker_title = get_sub_field('podcast_speaker_title');
                    $speaker_affiliation = get_sub_field('podcast_speaker_affiliation'); ?>
                <span class="post-speaker speaker speaker-name"><?php echo $speaker_name; ?></span><?php if ( $speaker_title != '') : ?><span class="post-stitle speaker speaker-title">, <?php echo $speaker_title; ?></span><?php endif; if ( $speaker_affiliation != '' ) : ?><span class="post-affiliation speaker speaker-affiliation">, <?php echo $speaker_affiliation; ?></span><?php endif; ?>
            <?php endwhile; endif; // end podcast_speakers ?>
        </li>
        <?php $i++; 
		endif; //end date check ?>
        
    <?php endif; // end current series check
	endforeach; ?>
    <?php endwhile; ?>
    </ul>
    </aside>
</div>
<?php else : ?>
    <?php echo _e('No Upcoming Dialogues.'); ?>
<?php endif;
/* Restore original Post Data */
wp_reset_postdata();
?>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ddialogues') ); ?>
        
</div>
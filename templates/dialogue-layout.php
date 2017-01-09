<?php dialogue_info_snippet(); ?>
<div class="abstract">
<?php 
$video_id = '';
$vimeo_code = get_post_meta( $post->ID, 'dialogue_vimeo_embed', TRUE); 
$vimeo_id = get_post_meta( $post->ID, 'dialogue_vimeo_id', TRUE); 
if ($vimeo_id) : 
	$video_id = $vimeo_id; 
elseif ($vimeo_code) :
	$video_id = str_replace("https://vimeo.com/", "", $vimeo_code);
endif;


ob_start();
the_content();
$content = ob_get_clean();
echo $content; 
if ($video_id) :
echo do_shortcode('[vimeo id="' . $video_id .'" width="" height="" autoplay="no" api_params="" class=""]');
endif; ?>

<?php $dialogue_speakers = get_field('dialogue_speakers');
if( get_field('dialogue_speakers') ) : ?>
	<?php while(has_sub_field('dialogue_speakers')) : ?>
	
		<?php if (get_sub_field('dialogue_speaker_bio') != '') : 
		echo do_shortcode('[separator style_type="single|dashed" top_margin="10" bottom_margin="20" sep_color="#d4d4d4" border_size="1px" icon="" icon_circle="" icon_circle_color="" width="" alignment="left" class="" id=""]'); ?>
		<div class="speaker-bio"><?php echo get_sub_field('dialogue_speaker_bio'); ?></div>
		<?php endif; ?>
	
	<?php endwhile; ?>
<?php endif; ?>
</div>

<?php $dd_info = get_post_meta( $post->ID, 'dialogue_info_blurb', TRUE); 
if ( $dd_info  == '') {
	$dd_info = '<p>A continuously updated schedule of talks is also available on the Digital Dialogues webpage.</p>
<p>Unable to attend the events in person? Archived podcasts can be found on the MITH website, and you can follow our Digital Dialogues Twitter account @digdialog as well as the Twitter hashtag #mithdd to keep up with live tweets from our sessions. Viewers can watch the live stream as well.</p>
<p>All talks free and open to the public. Attendees are welcome to bring their own lunches.</p>
<p>Contact: MITH (<a href="http://mith.umd.edu">mith.umd.edu</a>, <a href="mailto:mith@umd.edu">mith@umd.edu</a>, 301.405.8927). </p>';
}
echo do_shortcode('[tagline_box backgroundcolor="#f9f9f9" shadow="no" shadowopacity="1" border="3px" bordercolor="#f6f6f6" highlightposition="top" content_alignment="left" link="" linktarget="" modal="" button_size="" button_shape="" button_type="" buttoncolor="" button="" title="" description="" margin_top="25px" margin_bottom="" animation_type="" animation_direction="" animation_speed="" class="dd-info" id=""]' . $dd_info . '[/tagline_box]'); ?>

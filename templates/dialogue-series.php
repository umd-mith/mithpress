<?php 
$current_cat = get_query_var($wp_query->query_vars['taxonomy']);
$current_cat_posts = get_term_by('slug', $current_cat, 'mith_dialogue_series');
$current_cat_count = $current_cat_posts->count; 
?>

<h2 class="post-title dialogues-series-title dialogues-header"><?php single_cat_title(); _e( ' Digital Dialogues Schedule', 'Avada' ); ?></h2>
    
<form id="dialogue_series_form" action="<?php esc_url( home_url( '/' ) ); ?>/" method="get">
    <div class="dialogue-series-form">
        <?php restrict_dialogues_by_series(); ?>
        <input type="submit" name="submit" value="view" />
    </div>
</form>
              
<?php if ( have_posts() ) : 
echo do_shortcode('[separator style_type="double" top_margin="20" bottom_margin="20" sep_color="#BBBBBB" border_size="" width="" alignment="" class="" id=""]'); ?>
<div class="dialogue-series">

<?php while ( have_posts() ) : the_post(); 

    $dialogue_date_raw = get_post_meta( get_the_ID(), 'dialogue_date', TRUE);
    if ($dialogue_date_raw != '') { $dialogue_date = date('F j, Y', strtotime($dialogue_date_raw)); } 
    elseif ( get_post_meta(get_the_ID(), 'talk-date', TRUE) != '') { $dialogue_date = get_post_meta(get_the_ID(), 'talk-date', TRUE); } 
    else { $dialogue_date = the_date( 'F j, Y' ); }
    $dialogue_time = get_post_meta( get_the_ID(), 'dialogue_time', TRUE);
    $dialogue_location = get_post_meta( get_the_ID(), 'dialogue_location', TRUE); 
    if (!$location) $dialogue_location = 'MITH Conference Room';
    $dialogue_title = get_post_meta( get_the_ID(), 'dialogue_title', TRUE );
    if (!$dialogue_title) $dialogue_title = the_title();
    $dialogue_sponsor = get_post_meta( get_the_ID(), 'dialogue_sponsors', TRUE );
    $dialogue_meta = ''; ?>
    
    <div class="dialogue-series-item">
        <?php echo do_shortcode('[one_sixth last="no" class="dialogue-date"]' . $dialogue_date . '[/one_sixth]'); 
		$dialogue_meta .= do_shortcode('[button link="' . get_permalink() . '" color="custom" size="small" type="flat" shape="square" target="" title="Link to: ' . $dialogue_title . '" gradient_colors="#ffffff|#ffffff" gradient_hover_colors="#fafafa|#fafafa" accent_color="#20558A" accent_hover_color="#2E7BC6" bevel_color="" border_width="1px" shadow="no" icon="" icon_divider="" icon_position="" modal="" animation_type="" animation_direction="" animation_speed="" alignment="right" class="dialogue-link post-link" id=""]' . __('Details', 'Avada') . '[/button]');
		
		$dialogue_speakers = get_field('dialogue_speakers');
            if( $dialogue_speakers ) :
                $i = 0;
                $count = $dialogue_speakers;
                while(has_sub_field('dialogue_speakers')) :
                    $speaker_name = get_sub_field('dialogue_speaker_name');
                    $speaker_title = get_sub_field('dialogue_speaker_title');
                    $speaker_affiliation = get_sub_field('dialogue_speaker_affiliation');
                    $speaker_twitter = get_sub_field('twitter_handle');
                    
                    $dialogue_speaker = '
                    <span class="dialogue-speaker">' . $speaker_name . '</span>';
                        if ($speaker_title != '') { $dialogue_speaker .= ', <span class="dialogue-speaker-title">' . $speaker_title . '</span>'; } 
                        if ($speaker_affiliation != '') { $dialogue_speaker .= ', <span class="dialogue-affiliation">' . $speaker_affiliation . '</span>'; }
                    $dialogue_meta .= $dialogue_speaker;
                $i++; endwhile; 
            endif; // end speakers 
            $dialogue_meta .= '<h4 class="dialogue-title"><a href="' . get_permalink() . '" title="Link to: ' . $dialogue_title . '">' . $dialogue_title . '</a></h4>';
            if ($dialogue_time != '') $dialogue_meta .= '<span class="dialogue-time"><strong>' . __('Time', 'Avada') . ': </strong> ' . $dialogue_time . '</span>';
            $dialogue_meta .= '<span class="dialogue-location"><strong>' . __('Location', 'Avada') . ': </strong>' . $dialogue_location . '</span>';
            if ($dialogue_sponsor != '') $dialogue_meta .= '<span class="dialogue-sponsor">' . $dialogue_sponsor . '</span>';
			
			echo do_shortcode('[five_sixth last="yes" class="dialogue-info"]' . $dialogue_meta . '[/five_sixth]'); ?>
    </div>
    <?php echo do_shortcode('[separator style_type="solid" top_margin="0" bottom_margin="10" sep_color="#BBBBBB" width="" alignment="" class="" id=""]'); ?>
	<?php endwhile; // while have posts ?>
</div>
<?php endif; ?>
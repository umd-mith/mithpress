<div id="sidebar" <?php Avada()->layout->add_class( 'sidebar_1_class' ); ?> style="float: right;">
<?php 
$dialogue_files = get_field('dialogue_files');
$video_url = '';
$vimeo_embed = get_post_meta( $post->ID, 'dialogue_vimeo_embed', TRUE); 
$vimeo_id = get_post_meta( $post->ID, 'dialogue_vimeo_id', TRUE); 

if ($vimeo_embed) : 
	$video_url = $vimeo_embed;
elseif ($vimeo_id) :
	$video_url = 'https://vimeo.com/' . $vimeo_id; 
endif;	

if( $dialogue_files || $video_url ) : ?>
	
	<div id="dialogue_files" class="widget mith_dd_files-widget">
		<?php if( $video_url ) : // video button at top
			echo do_shortcode('[button link="' . $video_url . '" color="custom" size="medium" type="flat" shape="square" target="_blank" title="View Video" gradient_colors="#1ab7ea|#1ab7ea" gradient_hover_colors="#31bcea|#31bcea" accent_color="#ffffff" accent_hover_color="#ffffff" bevel_color="" border_width="0px" icon="fa-play-circle" icon_position="left" icon_divider="no" modal="" animation_type="0" animation_direction="left" animation_speed="1" alignment="" class="" id=""]' . __('View Dialogue Video', 'Avada') . '[/button]');
			echo do_shortcode( '[separator style_type="none" top_margin="5" bottom_margin="5" sep_color="" border_size="" icon="" icon_circle="" icon_circle_color="" width="" alignment="" class="" id=""]' );
		endif; ?>	
							
		<?php if ( $dialogue_files ) : ?>
		<div class="heading"><h3><?php _e( 'Resources', 'Avada' ); ?></h3></div>

		<?php $files_list = '[checklist icon="file-o" iconcolor="#e23a18" circle="no" circlecolor="#ffffff" size="small" class="dialogue-files" id=""]';
		
		foreach($dialogue_files as $file) : 
			$file_obj = $file['dialogue_file_obj'];
			$file_title = $file['dialogue_file_name'];
			
			if ( !$file_title ) $file_title = __('Download File');					
			$file_type = $file['dialogue_file_type']; // slug	
			$file_icon = $file['dialogue_file_icon'];
			$file_url = $file['dialogue_file_url'];
			
			if ( $file_obj != '' ) { $file_link = $file_obj; }
			elseif ( $file_url != '' ) { $file_link = $file_url; }
			else { $file_link = '#'; }
			
			$file_item = '[li_item icon="' . $file_icon . '"]<a href="' . $file_link .'" title="' . $file_title . '">' . $file_title . '</a>[/li_item]';
			$files_list .= $file_item;
		endforeach;
		$files_list .= '[/checklist]';                
		echo do_shortcode( $files_list ); 
		endif; ?>                
	</div>
<?php endif; ?>

<?php $topics_list = get_the_term_list( $post->ID, 'mith_topic', '<li>', '</li><li>', '</li>' );
if ($topics_list) : ?> 
	<div id="mith_topics" class="widget mith_dd_topics-widget">
		<div class="heading"><h3><?php _e( 'Related Topics', 'Avada'); ?></h3></div>
		<ul class="topics-list"><?php echo $topics_list; ?></ul>
	</div>
<?php endif; ?>
</div>
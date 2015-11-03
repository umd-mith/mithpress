<?php if ( is_post_type_archive('podcast') || 'podcast' == get_post_type() || is_page_template( 'page-upcoming-dialogues.php' ) ) { ?>
	<div id="sidebar" class="podcast widget-area span-5 prepend-1 append-bottom last" role="complementary">

	<?php if ( is_singular('podcast') ) { // single podcast page ?>
    
        <?php $podcast_files = get_field('podcast_files');
		
		if($podcast_files) : ?>
			<aside id="podcast-downloads" class="widget widget_downloads">
					
				<h3 class="column-title"><?php _e( 'Available Downloads', 'mithpress' ); ?></h3>
			
				<ul class="podcast-files">
			 
				<?php foreach($podcast_files as $file) : 
					$type = $file['podcast_file_type']; // slug		
					$url = $file['podcast_file_url'];
					
					$file_icon = $file['dialogue_file_icon'];
					
					if ($type == 'podcast_vid' ) : $icon = 'fa-play'; $label = 'Video'; //label
					elseif ($type == 'fa-file-audio-o' ) : $icon = $type; $label = 'Keynote';
					elseif ($type == 'fa-file-powerpoint-o' ) : $icon = $type; $label = 'Powerpoint Presentation';
					elseif ($type == 'fa-file-pdf-o' ) : $icon = $type; $label = 'View PDF';
					elseif ($type == 'fa-clone' ) : $icon = $type; $label = 'Slides / Presentation';
					elseif ($type == 'fa-headphones' ) : $icon = $type; $label = 'Listen to the Audio';
					elseif ($type == 'fa-image' ) : $icon = $type ; $label = 'View Image';
					elseif ($type == 'fa-file-text-o' ) : $icon = $type; $label = 'View Document';
					elseif ($type == 'fa-play-circle' ) : $icon = $type; $label = 'Watch the Video';
					else : $label = 'Download File'; $icon = $type = 'fa-file-o';
					endif;

					if ( ! $file_icon ) $file_icon = $icon; 
					
					$file_title = $file['dialogue_file_name'];
					if ( ! $file_title ) $file_title = $label;
				?>
					<li><a href="<?php echo $url; ?>" rel="nofollow" class="type-<?php echo $type; ?>"><i class="fa <?php echo $file_icon; ?> fa-pull-left"></i> <?php echo $file_title; ?></a></li>
				<?php endforeach; ?>
				</ul>
        	</aside>
		<?php endif; ?>
        <?php
	} // end check for single podcast ?>

        
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('podcast') ); 
	// do nothing
} else { ?>
<div id="sidebar" class="widget-area span-5 prepend-1 append-bottom last" role="complementary">
<?php  } ?>

</div>
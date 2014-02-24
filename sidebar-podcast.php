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
					
					if ($type == 'podcast_vid' ) : $label = 'Video'; //label
					elseif ($type == 'podcast_key' ) : $label = 'Keynote';
					elseif ($type == 'podcast_ppt' ) : $label = 'Powerpoint';
					elseif ($type == 'podcast_slides' ) : $label = 'Slides-Only';
					elseif ($type == 'podcast_aud' ) : $label = 'Audio-Only';
					endif;
				?>
					<li><a href="<?php echo $url; ?>" rel="nofollow" class="<?php echo $type; ?>"><?php echo $label; ?></a></li>
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
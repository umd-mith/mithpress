<?php if ( is_post_type_archive('podcast') || 'podcast' == get_post_type() ) { ?>
	
    <div id="sidebar" class="podcast widget-area span-5 prepend-1 append-bottom last" role="complementary">

	<?php 
	
	if ( is_singular('podcast') ) { // single podcast page 
        
		global $podcast2_mb;
        $podcast2_mb->the_meta(); 
		
		$video = $podcast2_mb->get_the_value('vidurl');
		$ppt = $podcast2_mb->get_the_value('ppturl');
		$keynote = $podcast2_mb->get_the_value('keyurl');
		$slides = $podcast2_mb->get_the_value('slideurl');
		$audio = $podcast2_mb->get_the_value('audurl');
		
			// check for files
			if ( $video == '' && $ppt == '' && $keynote == '' && $slides == '' && $audio == '' ) {
			
			// if all fields are empty do nothing
			} else { // show files

	?>
    
        <aside id="podcast-downloads" class="widget widget_downloads">
        
            <h3><?php _e( 'Available Downloads', 'mithpress' ); ?></h3>
        
            <ul class="podcast-files">
                
                <?php if ( $video != '') { ?>
                <li><a href="<?php echo $video ?>" rel="nofollow" class="pod-vid">Video</a></li>
    
                <?php } if ( $ppt != '') { ?>
                <li><a href="<?php echo $ppt ?>" rel="nofollow" class="pod-ppt">Powerpoint</a></li>
    
                <?php } if ( $keynote != '') { ?>
                <li><a href="<?php echo $keynote ?>" rel="nofollow" class="pod-key">Keynote</a></li>
    
                <?php } if ( $slides != '') { ?>
                <li><a href="<?php echo $slides ?>" rel="nofollow" class="pod-sld">Slides Only</a></li>
                
                <?php } if ( $audio != '') { ?>
                <li><a href="<?php echo $audio ?>" rel="nofollow" class="pod-aud">Audio Only</a></li>
                <?php } ?>
                
            </ul>
            
        </aside>
	
	<?php } // end file check
	
	get_template_part('sharing', 'sidebar'); 
	
	} // end check for single podcast ?>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('podcast') ); 
	
} else { //blank placeholder ?>

    <div id="sidebar" class="widget-area span-5 prepend-1 append-bottom last" role="complementary">

<?php  } ?>

	</div>
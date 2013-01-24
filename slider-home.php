<div class="slider-wrapper theme-default">
    
    <div id="slider" class="nivoSlider">
           
        <!-- Slides -->
	<?php   
    /* get the slider array */
    $slides = ot_get_option( 'home_slides', array() );
    
	if ( ! empty( $slides ) ) {
		foreach( $slides as $slide ) {
			$image_src = $slide['slide_img'];
			$postid_img  = $wpdb->get_var(
					"SELECT ID FROM $wpdb->posts 
					 WHERE guid = '$image_src' 
					 AND post_type='attachment' LIMIT 1");
			echo '<img src="' . $slide['slide_img'] . '" alt="' . $slide['title'] . '" title="#' . $postid_img .'" />';
		}
	}
    ?>
        
    </div>
    <!--/#slider -->
            
    <!-- Captions -->
	<?php 
    $slides = ot_get_option( 'home_slides', array() );
    
	if ( ! empty( $slides ) ) {
		foreach( $slides as $slide ) {
		$image_src = $slide['slide_img'];
		$postid_img  = $wpdb->get_var(
				"SELECT ID FROM $wpdb->posts 
				 WHERE guid = '$image_src' 
				 AND post_type='attachment' LIMIT 1");
		echo '
		  <div class="nivo-html-caption" id="' . $postid_img . '">
		  	<h2>' . $slide['title'] . '</h2>
			<span class="slide_txt">' . $slide['slide_desc'] . '</span>
			<span class="readmore"><a href="' . $slide['slide_link'] . '">More</a></span>
		  </div>';
		}
	}
	?>	
            
</div>
<!--/.slider-wrapper-->
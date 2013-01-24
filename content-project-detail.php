<?php
/**
 * The template for displaying content in the single-project.php template ONLY (not page-research.php) 
 *
**/
    global $project_mb;
	$project_mb->the_meta();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( ! has_post_thumbnail() ) { ?>
	
    <header class="entry-header">
	
    	<h1 class="entry-title append-bottom"><?php the_title(); ?></h1>
	
    </header>
	
	<?php } ?>
    
	<div class="entry-content">

		<div class="project-desc">
    
        	<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'full', array('class' => 'append-bottom') ); endif; ?>
    
            <?php the_content(); ?>
    
        </div>
		<!-- /project-desc -->
            
		<?php 
		global $projectfiles_mb;
		$projectfiles_mb->the_meta();
		
        $i = 0;
		
		while ($projectfiles_mb->have_fields('images')) { 
		
			if ($i == 0) { ?>
        
            <div class="project-gallery prepend-top">
            
            <h2 class="column-title">Gallery</h2>
            
                <ul id="project-images">
            
            <?php } // endif ?>
            
				<?php  // loop a set of field groups
				
                $img = $projectfiles_mb->get_the_value('imgurl'); 
                $alt = $projectfiles_mb->get_the_value('imgalt'); 
                $img_id = get_attachment_id_from_src($img);
                $img_thumb = wp_get_attachment_image_src( $img_id, "medium");
        
                $i++; 
				
				?>
                
                    <li <?php if( $i%4 == 0 ) { ?> class="last" <?php } ?>>
                    
                        <a href="<?php echo $img ?>" rel="lightbox" class="thickbox"><img class="project-image <?php echo $img_id; ?>" src="<?php echo $img_thumb[0] ?>" alt="<?php echo $alt ?>" /></a>
                        
                    </li>
            
		<?php } // End while loop
    
            if ($i > 0) { ?>
    
                </ul>
    
            </div>
    
            <?php } // endif ?>
            <!-- /project-gallery -->
		
        <?php 
        global $project_mb;
        $project_mb->the_meta(); 
		
		$i = 0;
		
		while($project_mb->have_fields('people') ) {  
		
		if ($i == 0) { ?>
        
        <div id="info-staff" class="column left prepend-top">
        
        <h2 class="column-title">Participating People</h2>
        
            <ul>
		
		<?php } // endif ?>
            
			<?php // loop through current staff
            $staffname = $project_mb->get_the_value('project_people'); 
            
            if ($project_mb->get_the_value('checkbox_past') ) { ?>

                <li><?php echo get_the_title($staffname); ?></li>
                    
			<?php } else { ?>

                <li><a href="<?php echo get_permalink($staffname); ?>"><?php echo get_the_title($staffname); ?></a></li>
                
            <?php } 
		
		$i++; } // end while loop 
                
		if ($i > 0) { // if posts, loop through nonstaff too ?>
        
			<?php while($project_mb->have_fields('nonstaff') ) { ?>
                <li><?php $project_mb->the_value('project_people'); ?></li>            
	        <?php } // endwhile ?>        

            </ul>

        </div>
        
		<?php } // endif 
		
		else { // else loop through nonstaff only
		
		$n = 0;

		while($project_mb->have_fields('nonstaff') ) { 
		
			if ($n == 0 ) { ?>
			
			<div id="info-staff" class="column left prepend-top">
			
			<h2 class="column-title">Participating People</h2>
			
				<ul>
			<?php 
			
			} // endif ?>
	
					<li><?php $project_mb->the_value('project_people'); ?></li>
			
			<?php 
		
		$n++; } // end while loop 

    if ($n > 0) { // if posts, close div ?>		
        
                </ul>
            
            </div>
        
		<?php } //endif 
		
		} // end "else" ?>
        <!-- /project-staff -->


		
	<?php 
	global $projectlinks_mb;
	$projectlinks_mb->the_meta();
    
	$i = 0;
	
	while($projectlinks_mb->have_fields('links')) {
	
	if ($i == 0) { ?>
		<div id="info-links" class="column right prepend-top">
            
            <h2 class="column-title">Links</h2>

                <ul>
        	<?php } // endif ?>
            
                <?php  // loop a set of field groups
                
				$url = $projectlinks_mb->get_the_value('url');
                $title = $projectlinks_mb->get_the_value('title');
                    echo '<li><a href="' . $url . '" target="_blank" rel="nofollow">';
                    echo $title . '</a></li>';
            
			$i++; } // end while loop 
            
			if ($i > 0) { ?>
                
                </ul>
            
            </div>
        <?php } ?>
        <!-- /info-links -->          
    	
    	<?php get_template_part('sharing', 'column'); ?>            
	
    </div>
    <!-- /entry-content -->
    
    <br clear="all" />

	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>

</article>
<!-- /post-<?php the_ID(); ?> -->
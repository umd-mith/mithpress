<?php
/**
 * The template for displaying content in the single-project.php template ONLY (not page-research.php) 
 *
**/
?>
<?php 
	if ( get_post_meta( $post->ID, 'project_start_date', true ) ) :
	$start_date = new DateTime(get_post_meta( $post->ID, 'project_start_date', true ) );
		
	//if ( !$start_date ) $start_date = get_post_meta( $post->ID, 'launchdate', true );
        if( $start_date ) : 
            $start_date_mth = $start_date->format('m');
            $start_date_yr = $start_date->format('Y'); 
        endif;
	endif;
        
	if (get_post_meta( $post->ID, 'project_end_date', true ) ) :
        $end_date = new DateTime( get_post_meta( $post->ID, 'project_end_date', true ) );
        if ( $end_date ) : 
            $end_date_mth = $end_date->format('m');
            $end_date_yr = $end_date->format('Y');
        endif; 	
	endif;
        
        /*if ( ! add_post_meta( $post->ID, 'research_start_yr', $start_date_yr, true ) ) { 
            update_post_meta ( $post->ID, 'research_start_yr', $start_date_yr );
        }
        if ( ! add_post_meta( $post->ID, 'research_start_mth', $start_date_mth, true ) ) { 
            update_post_meta ( $post->ID, 'research_start_mth', $start_date_mth );
        }
        if ( ! add_post_meta( $post->ID, 'research_end_yr', $end_date_yr, true ) ) { 
            update_post_meta ( $post->ID, 'research_end_yr', $end_date_yr );
        }
        if ( ! add_post_meta( $post->ID, 'research_end_mth', $end_date_mth, true ) ) { 
            update_post_meta ( $post->ID, 'research_end_mth', $end_date_mth );
        }*/
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
			$project_people_int = get_field('project_people_int', $post->ID);
			$project_people_ext = get_field('project_people_ext', $post->ID);
			if ($project_people_int > '0' || $project_people_ext > '0' ) :
			$i = 0;
			$count = 0;
			
			while(has_sub_field('project_people_int')):
				$internal_person = get_sub_field('project_person');
				$status = $internal_person->post_status; 
				if ( $status == "publish") : 
				$count++;
				endif;
			endwhile;

			while(has_sub_field('project_people_ext')):
				$external_person = get_sub_field('project_person_name');
				if ( $external_person != "") : 
				$count++;
				endif;
			endwhile;
		
			if ( $count != 0 ) { // have one or more staff ?>
			<div id="info-staff" class="column left prepend-top">
					
				<h2 class="column-title">Participating People</h2>
			
				<ul>				
			<?php } ?>

			<?php while(has_sub_field('project_people_int')):
				$internal_person = get_sub_field('project_person'); 
				$id = $internal_person->ID; 
				$status = $internal_person->post_status; 
				$meta_values = wp_get_object_terms($id, 'staffgroup');;
				$terms = array('people-past','people-past-directors','people-past-finance-administration','people-past-staff','people-past-research-associates','people-past-resident-fellows');
				
			    if ( $status == "publish") { // display person ?>
                <li>
                <?php if ( !has_term( $terms, 'staffgroup', $id) ) : ?>
                <a href="<?php echo get_permalink($id); ?>"><?php echo get_the_title($id); ?></a>
                <?php else : ?>
                <?php echo get_the_title($id); ?>
                <?php endif; ?>
                </li>
                            
				<?php 
                $i++; } // end published person display
            endwhile; // end linked internal person 
			?>

			<?php while(has_sub_field('project_people_ext')):
				$ext_name = get_sub_field('project_person_name'); 
				$ext_title = get_sub_field('project_person_title'); 
				$ext_dept = get_sub_field('project_person_department'); 
				$ext_aff = get_sub_field('project_person_affiliation'); ?>
                <li>
				<?php echo $ext_name; 
                if ( $ext_title ) { echo ', <span class="ext-person-title">' . $ext_title . '</span>'; } 
                if ( $ext_dept ) { echo ', <span class="ext-person-dept">' . $ext_dept. '</span>'; } 
                if ( $ext_aff ) { echo ', <span class="ext-person-aff">' . $ext_aff. '</span>'; } 
                ?>
                </li>
				
			<?php $i++;
			endwhile; // end linked external person 	
        
            if ( $count > 0 ) { // have one or more staff ?>
            	</ul>
            </div>
            <?php } ?>
        
        <?php endif; // end linked posts 
		//wp_reset_postdata(); ?>
        <!-- /project people -->

        <?php 
		$project_file_links = get_field('project_file_links');

			if( get_field('project_file_links') ) :
			
			$i = 0;
			$count = $project_file_links;
					
			if ( $count != 0 ) { // have one or more ?>
            <div id="info-files" class="column right prepend-top">
                
                <h2 class="column-title">Files</h2>
    
                    <ul>
			<?php } ?>

			<?php while(has_sub_field('project_file_links')) :
				$file_id = get_sub_field('project_file_link'); 
				$file_url = wp_get_attachment_url( $file_id );
				$file_name = get_sub_field('project_file_display_name'); 
				$file_img = get_sub_field('project_file_display_image');  ?>
                <li>
				<?php 
                if ( $file_img != '') { 		
					$img_size = 'horiz-thumbnail';	
					$image = wp_get_attachment_image_src( $file_img, $img_size);
				}
				?>
                <a href="<?php echo $file_url; ?>" target="_blank">
				<?php if ( $file_img ) : ?>
					<img src="<?php echo $image[0]; ?>" alt="<?php echo $file_name; ?>" />
                <?php else : echo $file_name; endif; ?>
                </a>
                </li>
				
			<?php $i++;
			endwhile; // end linked file	
            if ( $count > 0 ) { // have one or more files, so close the list ?>
            	</ul>
            </div>
            <?php } ?>
        
        <!-- /info-files -->          
        <?php endif; // end files ?>
		
        <?php 
		$project_links = get_field('project_links_ext', $post->ID);
			if( get_field('project_links_ext') ) :
			
			$i = 0;
			$count = $project_links;
					
			if ( $count != 0 ) { // have one or more staff ?>
            <div id="info-links" class="column right prepend-top">
                
                <h2 class="column-title">Links</h2>
    
                    <ul>
			<?php } ?>

			<?php while(has_sub_field('project_links_ext')):
				$linky = get_sub_field('project_link_url'); 
				$linky_title = get_sub_field('project_link_title');
				?>
                <li>
                <a href="<?php echo $linky; ?>"><?php if ($linky_title != '') { echo $linky_title; } else { echo $linky; } ?></a>
                </li>
				
			<?php $i++;
			endwhile; // end link
        
            if ( $count > 0 ) { // have one or more links, so close the list ?>
            	</ul>
            </div>
            <?php } ?>
        
        <!-- /info-links -->          
        <?php endif; // end links ?>
    	
    	<?php get_template_part('sharing', 'column'); ?>            
	
    </div>
    <!-- /entry-content -->
    
    <br clear="all" />

	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>

</article>
<!-- /post-<?php the_ID(); ?> -->
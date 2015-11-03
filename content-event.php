<?php
/**
 * The template for displaying content in the single-event.php template ONLY 
 *
**/

$twitter = get_field('event_twitter_account'); 
$hashtag = get_field('event_twitter_hashtag');

$date_start_string = get_field('date_start');
$date_end_string = get_field('date_end');

$time_start = get_field('time_start');
$time_end = get_field('time_end');

$location = get_field('event_location');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( ! has_post_thumbnail() ) { // show title if no image assigned ?>

	<header class="entry-header">
	
    	<h1 class="entry-title append-bottom"><?php the_title(); ?></h1>
	
    </header>
	
	<?php } ?>
    
	<div class="entry-content">

		<div class="event-desc">
        
        	<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'full', array('class' => 'append-bottom') ); endif; ?>

            <p class="event-info">
            
                <?php if ($location != null ) { // check if there's a location ?>
                <span class="info-location">
            
                	<strong>Where: </strong>
					<?php echo $location; ?>
            
                </span>
				
				<?php } 
				if ($date_start_string) { // check if there's a start date 
				$date_start = date('l, F j, Y', strtotime($date_start_string)); ?>                
                <span class="info-dates">
                	<strong>When: </strong>
					<?php echo $date_start; ?>
                
					<?php // check if there's an ending date
					if ($date_end_string != '') { 
						$date_end = date('l, F j, Y', strtotime($date_end_string));
					 ?> &ndash; <?php echo $date_end; ?>
                    
                </span>
                <?php } else {?>
                </span>
                <?php } 
                
                } 
				
				if ($time_start != null && $time_end != null ) { // if there's a start and end time ?>
                <span class="info-times">
                	<strong>Times:</strong>
                    <?php echo $time_start; ?> &ndash; <?php echo $time_end; ?>
                </span>
                 
                <?php } 
				
				elseif ( $time_start != null && $time_end == null ) { // if there's only a start time ?>
                	<strong>Time:</strong>
                	<?php echo $time_start; ?>
                </span>
                <?php } ?>	
                		
				<?php if ( $twitter != null || $hashtag != null ) { ?>
				<span class="info-twitter">
            
                	<strong>Twitter: </strong>
                    
                    <?php if ($twitter != null) : ?>
                    <a href="http://www.twitter.com/<?php echo $twitter; ?>" target="_blank">@<?php echo $twitter; ?></a>
                    
					<?php elseif ($hashtag != null) : ?>
                    <a href="http://www.twitter.com/search/%23<?php echo $hashtag; ?>" target="_blank">#<?php echo $hashtag; ?></a>
                    
					<?php endif ?>
                    
                </span>
            
                <?php } ?>
            
            </p>    
    
            <?php the_content(); ?>
            
        </div>
		<!-- /event-desc -->
        
        <?php 
			$event_people_int = get_field('event_participating_staff', $post->ID);
			$event_people_ext = get_field('event_participating_people', $post->ID);
			if ($event_people_int > '0' || $event_people_ext > '0' ) :
			$i = 0;
			$count = 0;
			
			while(has_sub_field('event_participating_staff')):
				$internal_person = get_sub_field('staff_names');
				$status = $internal_person->post_status; 
				if ( $status == "publish") : 
				$count++;
				endif;
			endwhile;

			while(has_sub_field('event_participating_people')):
				$external_person = get_sub_field('event_person_name');
				if ( $external_person != "") : 
				$count++;
				endif;
			endwhile;
		
			if ( $count != 0 ) { // have one or more staff ?>
			<div id="info-staff" class="column left prepend-top">
					
				<h2 class="column-title">Participating People</h2>
			
				<ul>				
			<?php } ?>

		<?php 
			while(has_sub_field('event_participating_staff')):
				$event_people_int = get_sub_field('staff_names'); 
		
				$id = $event_people_int->ID; 
				$status = $event_people_int->post_status; 
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
                
            endwhile; // end linked person ?>

			<?php while(has_sub_field('event_participating_people')):
				$ext_name = get_sub_field('event_person_name'); 
				$ext_title = get_sub_field('event_person_title'); 
				$ext_dept = get_sub_field('event_person_department'); 
				$ext_aff = get_sub_field('event_person_affiliation'); ?>
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
        
        <?php endif; // end linked posts ?>
        <!-- /event-staff -->
	        
    	<?php get_template_part('sharing', 'column'); ?>

	</div>
    <!-- /entry-content -->
    
    <br clear="all" />

	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>

</article>
<!-- /post-<?php the_ID(); ?> -->
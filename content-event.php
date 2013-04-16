<?php
/**
 * The template for displaying content in the single-event.php template ONLY 
 *
**/

global $event_mb;
$event_mb->the_meta();
$twitter = $event_mb->get_the_value('twitter'); 
$hashtag = $event_mb->get_the_value('hashtag');

$date_start_string = $event_mb->get_the_value('date-start');
$date_end_string = $event_mb->get_the_value('date-end');

$time_start = $event_mb->get_the_value('time-start');
$time_end = $event_mb->get_the_value('time-end');
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
            
                <?php if ($event_mb->get_the_value('location') != null ) { // check if there's a location ?>
                <span class="info-location">
            
                	<strong>Where: </strong>
					<?php $event_mb->the_value('location'); ?>
            
                </span>
				
				<?php } 
				if (!is_null($date_start_string)) { // check if there's a start date 
				$date_start = date('l, F j, Y', strtotime($date_start_string)); ?>                
                <span class="info-dates">
                	<strong>When: </strong>
					<?php echo $date_start; ?>
                
					<?php // check if there's an ending date
					if (!is_null($date_end_string)) { 
						$date_end = date('l, F j, Y', strtotime($date_end_string));
					 ?> &ndash; <?php echo $date_end; ?>
                    
                </span>
                <?php } else {?>
                </span>
                <?php } 
                
                } if ($time_start != null && $time_end != null ) { // if there's a start and end time ?>
                <span class="info-times">
                	<strong>Times:</strong>
                    <?php echo $time_start; ?> &ndash; <?php echo $time_end; ?>
                </span>
                 
                <?php } elseif ( $time_start != null && $time_end == null ) { // if there's only a start time ?>
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
		
		$i = 0;
		
		while($event_mb->have_fields('event_staff') ) {  
		
		if ($i == 0) { ?>
        
        <div id="info-staff" class="column left prepend-top">
        
            <h2 class="column-title">Participating MITH Staff</h2>
        
            <ul>
		
		<?php } // endif ?>
            
			<?php // loop through current staff
            
			$staffname = $event_mb->get_the_value('staff'); 
            
            if ($event_mb->get_the_value('cb_past') ) { ?>

                <li><?php echo get_the_title($staffname); ?></li>
                    
			<?php } else { ?>

                <li><a href="<?php echo get_permalink($staffname); ?>"><?php echo get_the_title($staffname); ?></a></li>
                
            <?php } 
		
		$i++; } // end while loop 
                
		if ($i > 0) { ?>

            </ul>

        </div>
        <!-- /event-staff -->
		
		<?php } ?>
        
    	<?php get_template_part('sharing', 'column'); ?>

	</div>
    <!-- /entry-content -->
    
    <br clear="all" />

	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>

</article>
<!-- /post-<?php the_ID(); ?> -->
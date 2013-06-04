<div class="my_meta_control">
	<label>Date</label>
    <p>            
        <label for="from" class="inline">From</label>
        <?php $mb->the_field('date-start');?>
        <input type="text" id="from" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />

        <label for="to" class="inline">to</label>
        <?php $mb->the_field('date-end');?>
        <input type="text" id="to" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
    
    </p>

	<label>Time <span>(for single-day events, include start/end times here)</span></label>
	<p>
    	<?php $mb->the_field('time-start');?>
        <input class="timepicker" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
    	<?php $mb->the_field('time-end');?>
        <input class="timepicker" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
    </p> 

	<label>Location</label>
	<p>
    	<?php $mb->the_field('location');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>Where will the main event be held?</span>
    </p> 
	

	<label>Website</label>
	<p>
    	<?php $mb->the_field('website');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>Enter official website/blog for event (if applicable). Format: <strong>without</strong> "http://"</span>
    </p> 
    
	<label>Contact Info</label>
	<p>
    	<?php $mb->the_field('contactname');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>Name</span>
    </p>
    
    <p>
    	<?php $mb->the_field('contactemail');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>Email Address</span>
    </p>

	<label>Twitter Account <span>(optional)</span></label>
	<p>
    	<?php $mb->the_field('twitter');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Enter twitter handle if project has its own Twitter account.</span>
    </p>

	<label>Twitter Hashtag <span>(optional)</span></label>
	<p>
    	<?php $mb->the_field('hashtag');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Enter hashtag for project (optional).</span>
    </p>
    <br clear="all" /> 
</div>

<!-- CURRENT EVENT STAFF -->
<div class="my_meta_control">
 
	<a style="float:right; margin:0 10px;" href="#" class="dodelete-event_staff button remove-all">Remove All</a>
	 
	<label>Event Staff<span>(current staff associated with the project)</span></label>	

	<p>Add staff to project by selecting them from the dropdown. Add addtional staff by clicking the "Add Staff" button. <strong>Be sure to check box on past staff members</strong></p> 

	<?php
	global $post;
	$current_post = $post;

		$people_query_args = array(
			'post_type' => 'people',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
		);
	
		//$people_posts = new WP_Query( $people_query_args );
	
		$staff_arr = array();
	
		$people_posts = get_posts( $people_query_args );
	
		foreach( $people_posts as $post ) :	setup_postdata($post); 
	
				array_push( $staff_arr, array( 'id' => $post->ID , 'title' => $post->post_title, 'url' => get_permalink($post->ID) ) );
	
		endforeach; 
	?>

	<?php while($mb->have_fields_and_multi('event_staff')): ?>
	<?php $mb->the_group_open(); ?>
	 	
        <div class="handle"></div>
		<?php $mb->the_field( 'staff' ); ?>
		<select name="<?php $mb->the_name(); ?>">
			<option value="">Select...</option>
			<?php foreach( $staff_arr as $staff ) { ?>
				<option value="<?php echo $staff['id']; ?>"<?php $mb->the_select_state($staff['id']); ?> name="<?php echo $staff['title']; ?>"><?php echo $staff['title']; ?></option>
			<?php } ?>
		</select>

 		<?php $mb->the_field('cb_past', WPALCHEMY_FIELD_HINT_CHECKBOX_MULTI); ?>
	    <input type="checkbox" name="<?php $mb->the_name(); ?>" value="1"<?php if ($mb->get_the_value()) echo ' checked="checked"'; ?>/> Past

		<p class="remove-button"><a href="#" class="dodelete button remove">Remove Staff</a></p>

		<br clear="all" />  
		
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
    <p class="add-another-link"><a href="#" class="docopy-event_staff button add-another">Add Staff</a></p>


  <label>Participating non-MITH People</label>	

    <div class="remove-all-button"><a href="#" class="dodelete-nonstaff button remove-all">Remove All</a></div>
     
    <p>Add non-MITH people by entering their names here. Add additional people by clicking the "Add Person" button.</p>
     
    <?php while($mb->have_fields_and_multi('nonstaff')): ?>
    <?php $mb->the_group_open(); ?>
     
        <?php $mb->the_field('event_people'); ?>
        <p><input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
     
		<div class="remove-button"><a href="#" class="dodelete button remove">Remove Person</a></div>
    
        <br clear="all" />                 
    
    <?php $mb->the_group_close(); ?>
    <?php endwhile; ?>
     
    <div class="add-another-link"><a href="#" class="docopy-nonstaff button add-another">Add Person</a></div>
    
    <br clear="all" />
    
</div>
<?php $post = $current_post; ?>
<div class="my_meta_control side">
 
	<label>Status <span>Select the current status of the project:</span></label>

	<?php $statuses = array('Active','Archive','In Development','Unknown'); ?>

	<?php foreach ($statuses as $i => $status): ?>
		<?php $mb->the_field('r_ex2'); ?>
		<input type="radio" name="<?php $mb->the_name(); ?>" value="<?php echo $status; ?>"<?php $mb->the_radio_state($status); ?>/> <?php echo $status; ?><br/>
	<?php endforeach; ?>

</div>

<div class="my_meta_control side"> 

	<label>Type <span>Select all that apply. Workshops and events will show up under Community page.</span></label>
	
	<?php $types = array('Project', 'Workshop', 'Event'); ?>

	<?php while ($mb->have_fields('cb_type', count($types))): ?>
	
		<?php $type = $types[$mb->get_the_index()]; ?>

		<input type="checkbox" name="<?php $mb->the_name(); ?>" value="<?php echo $type; ?>"<?php $mb->the_checkbox_state($type); ?>/> <?php echo $type; ?><br/>

	<?php endwhile; ?>


</div>
<?php 

// the name of the instantiated class object
global $wpalchemy_media_access;

?>

<div class="my_meta_control">
<!-- PROJECT IMAGES -->

    <div class="remove-all-button"><a href="#" class="dodelete-images button remove-all">Remove All</a></div>
     
    <label>Images <span>Add screenshots or other project images here.</span></label>

	<?php while($mb->have_fields_and_multi('images')): ?>
	<?php $mb->the_group_open(); ?>
  
		<?php $mb->the_field('imgurl'); ?>
		<?php $wpalchemy_media_access->setGroupName('img-n'. $mb->get_the_index())->setInsertButtonLabel('Add')->setTab('type'); ?>
 
		<p>
			<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
			<?php echo $wpalchemy_media_access->getButton(array('label' => 'Add Image')); ?>
		</p>
		
		<?php $mb->the_field('imgalt');?>
 		<label for="<?php $mb->the_name(); ?>">Alt Text</label>
 		<p><input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>

		<div class="remove-button"><a href="#" class="dodelete button remove">Remove Image</a></div>
    
        <br clear="all" />                 

	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
    <div class="add-another-link"><a href="#" class="docopy-images button add-another">Add Image</a></div>
    
    <br clear="all" />

</div>
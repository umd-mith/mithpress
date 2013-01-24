<div class="my_meta_control">
  
	<label>Talk Date</label> 
	<p>

        <?php $mb->the_field('talk-date');?>
        <input type="text" id="talk-date" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
        <span>Date of talk</span>
	</p>
    <p>
        <?php $mb->the_field('talk-time');?>
		<input class="timepicker" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
        <span>Time of talk</span>
        
    </p>

	<label>Talk Title</label> 
	<p>
    	<?php $mb->the_field('talk-title');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
		<span>Title of the talk (without speaker's name)</span>
    </p>

	<label>Speaker</label> 
	<p>
		<input type="text" name="<?php $mb->the_name('speaker'); ?>" value="<?php $mb->the_value('speaker'); ?>"/>
		<span>Speaker's full name</span>
    </p>
	
	<label>Speaker Title</label> 
	<p>
		<input type="text" name="<?php $mb->the_name('speakertitle'); ?>" value="<?php $mb->the_value('speakertitle'); ?>"/>
		<span>Enter speaker's title (i.e. PhD, Associate Director, etc.)</span>
	</p>

	<label>Affiliation</label> 
	<p>
		<?php $mb->the_field('affiliation'); ?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Enter speaker's affiliation (i.e. University of Maryland, Library of Congress, etc.)</span>
	</p>

	<label>Twitter Handle</label>
	<p>
    	<?php $mb->the_field('twitter');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>(optional) will show up next to speaker photo below date on single podcast page</span>
    </p>
 
</div>

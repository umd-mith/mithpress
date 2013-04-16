<div class="my_meta_control">
<!-- JOB INFO -->
	<label>Expiration Date <span>Enter the date you wish to have the job expire. It will automatically be removed from the website after that date.</span></label>
    <p>            
        <?php $mb->the_field('date-expire');?>
        <input type="text" id="date-expire" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
    </p>


    <br clear="all" /> 
</div>
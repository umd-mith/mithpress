<?php
/**
 * The template for displaying People Archive page.
*/

get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">

        <?php get_sidebar('left'); ?>
        <!-- /subnav sidebar -->

        <div id="content" role="main" class="archive span-16 last">
        
			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>

            <div class="people-section"><?php include('people/past-directors.php'); ?></div>
			<div class="people-section"><?php include('people/past-finance.php'); ?></div>
			<div class="people-section"><?php include('people/past-staff.php'); ?></div>
			<div class="people-section"><?php include('people/past-rassoc.php'); ?></div>
			<div class="people-section"><?php include('people/past-fellows.php'); ?></div>

			<?php wp_reset_query(); ?>
            
            <p style="border-top: 1px dotted #DDD; padding-top: 15px; margin-top:15px; ">Are we missing someone or do you see an error above? Please let us know by filling out <a href="https://docs.google.com/spreadsheet/viewform?formkey=dHJkMnoyV0ZDdndGSTNSbFpwa0RZYWc6MQ#gid=0" target="_blank">this form</a>. Thanks!</p>
                    
		</div>
        <!-- /content -->
	</div>
    <!--/primary/post -->    
<div class="clear"></div>
</div>
<!-- /page / start footer -->

<?php get_footer(); ?>
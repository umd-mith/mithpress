<?php
/**
 * The template for displaying 404 pages (Not Found).
**/

get_header(); ?>
<div id="page-container">

    <div id="primary" class="width-limit">

    <?php get_sidebar('left'); ?>
    <!-- /subnav sidebar -->

        <div id="content" role="main" class="span-16 wide last">
 
            <article id="post-0" class="post error404 not-found">
                <header class="entry-header">
                    <h1 class="entry-title append-bottom"><?php _e( 'Page Not Found: Error 404', 'mithpress' ); ?></h1>
                </header><!-- /entry-header -->
                
                <div class="entry-content">
                    <p><?php _e( 'The page you requested was not found. Try using the links below to find what you were looking for, or return to our <a href="http://mith.umd.edu/">homepage</a>.', 'mithpress' ); ?></p>
                    <?php wp_nav_menu( array('menu' => 'Sitemap' )); ?>
                    <?php //get_search_form(); ?>
				</div><!-- /entry-content -->
                
			</article>
            <!-- /post-0 -->

        </div>
        <!-- /page content-->
    </div>
    <!-- /primary -->
</div>
<!-- /page -->

<?php get_footer(); ?>
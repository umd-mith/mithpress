<?php
/**
 * The template for displaying the sitemap.
**/

get_header(); ?>
<div id="page-container">

    <div id="primary" class="width-limit">

    <?php get_sidebar('left'); ?>
    <!-- /subnav sidebar -->

        <div id="content" role="main" class="span-16 wide last">
 
            <article id="post-sitemap" class="post sitemap">
                <header class="entry-header">
                    <h1 class="entry-title append-bottom"><?php _e( 'Sitemap' ); ?></h1>
                </header><!-- /entry-header -->
                
                <div class="entry-content">
                    <?php wp_nav_menu( array('menu' => 'Sitemap' )); ?>
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
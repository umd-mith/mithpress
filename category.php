<?php
/**
 * The template for displaying Category Archive pages.

*/

get_header(); ?>

<div id="page-container">
		<div id="primary" class="width-limit">
			<div id="content" role="main" class="category span-24 last">

			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>

            <div id="posts">
            
			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title append-bottom prepend-top"><span><?php echo single_cat_title( '', false ) ?></span><?php
						printf( __( ' Category Archive', 'mithpress' ));
					?></h1>

				</header>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>

				<?php endwhile; ?>
                
				<?php if (get_option('paging_mode') == 'default') : ?>
                    <nav id="nav-page" class="span-wide">
                    <h3 class="assistive-text"><?php _e( 'Page navigation', 'mithpress' ); ?></h3>
                        <span class="nav-previous"><span class="meta-nav"></span><?php next_posts_link(__('Older'), 0); ?></span>
                        <span class="nav-next"><span class="meta-nav"></span><?php previous_posts_link(__('Newer'), 0); ?></span>
                    <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?>
                    </nav>
                    <?php else : ?>
                    <nav id="nav-page" class="span-wide">
                    <h3 class="assistive-text"><?php _e( 'Page navigation', 'mithpress' ); ?></h3>
                        <span class="nav-next"><span class="meta-nav"></span><?php next_posts_link(__('LOAD MORE')); ?></span>
                    </nav>
                <?php endif; ?>				

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="page-title append-bottom prepend-top"><?php _e( 'Nothing Found', 'mithpress' ); ?></h1>
					</header><!-- /entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'mithpress' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- /entry-content -->
				</article><!-- /post-0 -->

			<?php endif; ?>
            </div>
            <!-- /posts -->
		<?php get_sidebar('category'); ?>
		<!-- /sidebar -->
                    
		</div>
        <!-- /content -->
	</div>
    <!--/primary/post -->    
<div class="clear"></div>
</div>
<!-- /page / start footer -->

<?php get_footer(); ?>
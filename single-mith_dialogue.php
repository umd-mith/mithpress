<?php get_header(); ?>
	<div id="content" style="float: left;">
		<?php if( ( ! Avada()->settings->get( 'blog_pn_nav' ) && get_post_meta($post->ID, 'pyre_post_pagination', true) != 'no' ) ||
				  ( Avada()->settings->get( 'blog_pn_nav' ) && get_post_meta($post->ID, 'pyre_post_pagination', true) == 'yes' ) ): ?>
		<div class="single-navigation clearfix" style="display:none;">
			<?php previous_post_link('%link', __('Previous', 'Avada')); ?>
			<?php next_post_link('%link', __('Next', 'Avada')); ?>
		</div>
		<?php endif; ?>
		<?php while( have_posts() ): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('post dialogue-post'); ?>>
			<div class="post-content dialogue-content">            	
				<?php get_template_part('templates/dialogue-layout'); ?>
			</div>
            <!-- /post-content /dialogue-content -->
            
			<?php if( ! post_password_required($post->ID) ): ?>
			<?php avada_render_social_sharing(); ?>
			<?php endif; ?>
		</div>
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
	</div>
	<?php //do_action( 'fusion_after_content' ); ?>
	<?php get_template_part( 'templates/sidebar', 'dialogue' ); ?>
<?php get_footer();

// Omit closing PHP tag to avoid "Headers already sent" issues.
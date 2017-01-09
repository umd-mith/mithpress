<?php get_header(); ?>
	<div id="content" <?php Avada()->layout->add_style( 'content_style' ); ?>>
		<?php while( have_posts() ): the_post(); ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class('post person-post'); ?>>
			<span class="entry-title" style="display: none;"><?php the_title(); ?></span>
			<div class="post-content">
				<?php echo person_info_snippet(); ?>
				<div class="person-bio">
                <?php the_content(); ?> 
				</div>
			</div>
			<?php if( ! post_password_required($post->ID) ): ?>
			<?php //avada_render_social_sharing(); ?>
			<?php endif; ?>
		</div>

		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
	</div>
	<?php get_template_part('templates/sidebar', 'person');  ?>
<?php get_footer();

// Omit closing PHP tag to avoid "Headers already sent" issues.
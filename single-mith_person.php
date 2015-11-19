<?php get_header(); ?>
	<?php
	$content_css = 'width:100%';
	$sidebar_css = 'display:none';
	$content_class = '';
	$sidebar_left = '';
	
	$double_sidebars = true;
	$sidebar_exists = true;
	$content_css = 'float:left;';
	$sidebar_css = 'float:left;';
	$sidebar_2_css = 'float:left;';

	$sidebar_1 = get_post_meta( $post->ID, 'sbg_selected_sidebar_replacement', true );
	$sidebar_2 = get_post_meta( $post->ID, 'sbg_selected_sidebar_2_replacement', true );
	
	?>
	<div id="content" class="<?php echo $content_class; ?>" style="<?php echo $content_css; ?>">
		<?php if(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('post person-post'); ?>>
			<span class="entry-title" style="display: none;"><?php the_title(); ?></span>
			<div class="post-content">
				<?php echo person_info_snippet(); ?>
				<div class="person-bio">
                <?php the_content(); ?> 
				</div>
			</div>
			<?php if( ! post_password_required($post->ID) ): ?>
			<?php //echo avada_render_post_metadata( 'single' ); ?>
			<?php if( ( $smof_data['social_sharing_box'] && get_post_meta($post->ID, 'pyre_share_box', true) != 'no' ) || 
					  ( ! $smof_data['social_sharing_box'] && get_post_meta($post->ID, 'pyre_share_box', true) == 'yes' ) ):
				$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				$sharingbox_soical_icon_options = array (
					'sharingbox'		=> 'yes',
					'icon_colors' 		=> $smof_data['sharing_social_links_icon_color'],
					'box_colors' 		=> $smof_data['sharing_social_links_box_color'],
					'icon_boxed' 		=> $smof_data['sharing_social_links_boxed'],
					'icon_boxed_radius' => $smof_data['sharing_social_links_boxed_radius'],
					'tooltip_placement'	=> $smof_data['sharing_social_links_tooltip_placement'],
                	'linktarget'        => $smof_data['social_icons_new'],
					'title'				=> wp_strip_all_tags(get_the_title( $post->ID ), true),
					'description'		=> wp_strip_all_tags(get_the_title( $post->ID ), true),
					'link'				=> get_permalink( $post->ID ),
					'pinterest_image'	=> ($full_image) ? $full_image[0] : '',
				);
				?>
				<div class="fusion-sharing-box share-box">
					<h4><?php echo __('Share This Page', 'Avada'); ?></h4>
					<?php echo $social_icons->render_social_icons( $sharingbox_soical_icon_options ); ?>
				</div>
			<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
	<?php if( $sidebar_exists == true ): ?>
	<?php wp_reset_query(); ?>
	<div id="sidebar" class="sidebar" style="<?php echo $sidebar_css; ?>">
		<div id="staff_current" class="widget mith_staff_current-widget">
        	<div class="heading"><h3><?php _e( "Current Staff", "Avada" ); ?></h3></div>
			<div class="recent-works-items clearfix">
			<?php $args = array(
                'post_type' => 'mith_person',
                'meta_key' => 'last_name',
                'orderby' => 'meta_value',
                'order' => 'ASC',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'mith_staff_group',
                        'field' => 'slug',
                        'terms' => array('people-past','people-past-directors','people-past-finance-administration','people-past-staff','people-past-research-associates','people-past-resident-fellows'),
						'include_children' => true,
                        'operator' => 'NOT IN',
                    )
                ),
            );
            query_posts( $args );
            if (have_posts()) : while (have_posts()) : the_post(); ?>
                <a href="<?php the_permalink(); ?>" rel="alternate" title="Profile of <?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'recent-works-thumbnail' ); ?></a>
            <?php endwhile; endif; ?>
            </div>
        </div>
	<?php wp_reset_query(); ?>
    </div>
	<?php if( $double_sidebars == true ): ?>
	<div id="sidebar-2" class="sidebar" style="<?php echo $sidebar_2_css; ?>">
		<?php echo mith_display_blog_posts(); 
		
        $twitter = get_post_meta($post->ID, 'person_twitter_handle', true);
        $twitter_id = get_post_meta($post->ID, 'person_twitter_id', true);
        $twitter_code = get_post_meta($post->ID, 'person_twitter_widget_code', true);
		
		if ( ($twitter != '' && $twitter_id != '') || $twitter_code != '' ) : ?>
        <div id="recent_tweets" class="widget widget_recent_tweets">
            <div class="heading"><h3><?php _e('Recent Tweets', 'Avada'); ?></h3></div>
            <?php if ($twitter_code != '') :
                echo $twitter_code;
            elseif ($twitter != '' && $twitter_id != '') : ?>
                <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/<?php echo $twitter; ?>" data-widget-id="<?php echo $twitter_id; ?>" data-chrome="nofooter noheader transparent" border-color="#ffffff" data-link-color="#2e7cc6">Tweets by @<?php echo $twitter; ?></a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			<?php endif; ?>

			<?php if ($twitter != '') : ?>
	            <a href="https://twitter.com/<?php echo $twitter; ?>" class="twitter-follow-button" data-show-count="false" data-dnt="true">Follow @<?php echo $twitter ?></a>
    		    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>     
            <?php endif; ?> 
        </div>
        <?php endif; ?>
    </div>
	<?php endif; ?>
	<?php endif; ?>
<?php get_footer(); ?>
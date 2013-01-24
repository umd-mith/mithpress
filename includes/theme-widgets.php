<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Basic Sidebar Widgets
- Recent Posts Widget

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Basic Sidebar Widgets */
/*-----------------------------------------------------------------------------------*/

if ( function_exists('register_sidebars') )
    register_sidebar(array(
        'name' => 'Blog Sidebar',
		'id' => 'blog',
		'description' => 'Sidebar displayed on blog pages',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><aside class="widget-body clear">'
    ));
    register_sidebar(array(
        'name' => 'Podcast Sidebar',
		'id' => 'podcast',
		'description' => 'Sidebar displayed on individual podcast page',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><aside class="widget-body clear">'
    ));
    register_sidebar(array(
        'name' => 'Digital Dialogues Sidebar',
		'id' => 'ddialogues',
		'description' => 'Sidebar displayed on main DD page',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><aside class="widget-body clear">'
    ));
    register_sidebar(array(
        'name' => 'Footer Widget Area',
		'id' => 'footerwidgets',
		'description' => 'footer area widgets',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><aside class="widget-body clear">'
    ));


/*-----------------------------------------------------------------------------------*/
/* Recent Posts Widgets */
/*-----------------------------------------------------------------------------------*/

class Recentposts_thumbnail extends WP_Widget {

    function Recentposts_thumbnail() {
        parent::WP_Widget(false, $name = 'Recent Posts Widget');
    }

    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        ?>
            <?php echo $before_widget; ?>
            <?php if ( $title ) { 
				echo $before_title . '<a href="';
				echo ( get_option('feedburner_url') )? get_option('feedburner_url') : get_bloginfo('rss2_url');
				echo '" class="rss">&nbsp;</a>' . $title . $after_title; 
			} else echo '<div class="widget-body clear">'; ?>

            <?php
                global $post;
                if (get_option('rpost_qty')) $rpost_qty = get_option('rpost_qty'); else $rpost_qty = 5;
                $q_args = array(
                    'numberposts' => $rpost_qty,
					'post_type' => array('post','podcast')
                );
                $rpost_posts = get_posts($q_args);
				echo '<ul id="blog-feed">';
                foreach ( $rpost_posts as $post ) :
                    setup_postdata($post); ?>
                <li>
                <a href="<?php the_permalink(); ?>" class="rpost clear">
                    <?php if ( has_post_thumbnail() && !get_option('rpost_thumb') ) {
                        the_post_thumbnail('mini-thumbnail');
                    }
                    ?>
                    <span class="rpost-title"><?php the_title(); ?></span>
                    <span class="rpost-date"><?php the_time(__('M j, Y')) ?></span>
                </a>
                </li>
            <?php endforeach; ?>
            </ul>

            <?php echo $after_widget; ?>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        update_option('rpost_qty', $_POST['rpost_qty']);
        update_option('rpost_thumb', $_POST['rpost_thumb']);
        return $instance;
    }

    function form($instance) {
        $title = esc_attr($instance['title']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="rpost_qty">Number of posts:  </label><input type="text" name="rpost_qty" id="rpost_qty" size="2" value="<?php echo get_option('rpost_qty'); ?>"/></p>
            <p><label for="rpost_thumb">Hide thumbnails:  </label><input type="checkbox" name="rpost_thumb" id="rpost_thumb" <?php echo (get_option('rpost_thumb'))? 'checked="checked"' : ''; ?>/></p>
        <?php
    }

}
add_action('widgets_init', create_function('', 'return register_widget("Recentposts_thumbnail");'));


/*-----------------------------------------------------------------------------------*/
/* Recent Custom Posts Widgets */
/*-----------------------------------------------------------------------------------*/

function n2wp_latest_cpt_init() {
	if ( !function_exists( 'register_sidebar_widget' ))
		return;

function n2wp_latest_cpt($args) {
		global $post;

		extract($args);
		// These are our own options
		$options = get_option( 'n2wp_latest_cpt' );
		$title 	 = $options['title']; // Widget title
		$ptype 	 = $options['ptype']; // Post type
		$pshow 	 = $options['pshow']; // Number of Tweets

        $beforetitle = '<h3>';
        $aftertitle = '</h3><aside class="widget-body clear">';
        // Output

		echo $before_widget;
			if ($title) echo $beforetitle . $title . $aftertitle;
			$pq = new WP_Query(array( 
				'post_type' => $ptype, 
				'showposts' => $pshow 
				)
			);
			
			if( $pq->have_posts() ) : ?>
            
			<ul id="latest_cpt_list">
				<?php while($pq->have_posts()) : $pq->the_post(); ?>
				
				<?php 
				global $podcast_mb;
				$podcast_mb->the_meta();
				$tdate = $podcast_mb->get_the_value('talk-date'); 
				$ttitle = $podcast_mb->get_the_value('talk-title');
				?>
				
                		<li>
                    	<a href="<?php the_permalink(); ?>" rel="bookmark" class="rpost clear">
						<span class="rpost-title">
							<?php if ($ttitle != '' ) {
								echo $ttitle; 
							} else { the_title(); } ?>
                        </span>
	                    <span class="rpost-date">
							<?php if ($tdate != '') {
								echo $tdate; 
							} else { the_time(__('M j, Y')); } ?>
                        </span>
                        </a>
                    </li>	
				<?php wp_reset_query();
				endwhile; ?>

			</ul>
			<?php endif; ?>
		<?php
		// echo widget closing tag
		echo $after_widget;
	}
	/**
	 * Widget settings form function
	 */
	function n2wp_latest_cpt_control() {
		// Get options
		$options = get_option( 'n2wp_latest_cpt' );
		// options exist? if not set defaults
		if ( !is_array( $options ))
			$options = array(
				'title' => 'Latest Posts',
				//'phead' => 'h2',
				'ptype' => 'post',
				'pshow' => '5'
			);
			// form posted?
			if ( $_POST['latest-cpt-submit'] ) {
				$options['title'] = strip_tags( $_POST['latest-cpt-title'] );
				//$options['phead'] = $_POST['latest-cpt-phead'];
				$options['ptype'] = $_POST['latest-cpt-ptype'];
				$options['pshow'] = $_POST['latest-cpt-pshow'];
				update_option( 'n2wp_latest_cpt', $options );
			}
			// Get options for form fields to show
			$title = $options['title'];
			//$phead = $options['phead'];
			$ptype = $options['ptype'];
			$pshow = $options['pshow'];
			// The widget form fields
			?>
			<p>
			<label for="latest-cpt-title"><?php echo __( 'Widget Title' ); ?><br />
				<input id="latest-cpt-title" name="latest-cpt-title" type="text" value="<?php echo $title; ?>" size="30" />
			</label>
			</p>
			<!--
            <p>
			<label for="latest-cpt-phead"><?php /* echo __( 'Widget Heading Format' ); ?><br />
			<select name="latest-cpt-phead">
				<option value="h2" <?php if ($phead == 'h2') { echo 'selected="selected"'; } ?>>H2 - <h2></h2></option>
				<option value="h3" <?php if ($phead == 'h3') { echo 'selected="selected"'; } ?>>H3 - <h3></h3></option>
				<option value="h4" <?php if ($phead == 'h4') { echo 'selected="selected"'; } ?>>H4 - <h4></h4></option>
				<option value="strong" <?php if ($phead == 'strong') { echo 'selected="selected"'; } */ ?>>Bold - <strong></strong></option>
			</select>
			</label>
			</p>
            -->
			<p>
			<label for="latest-cpt-ptype">
			<select name="latest-cpt-ptype">
				<option value=""> - <?php echo __( 'Select Post Type' ); ?> - </option>
				<?php $args = array( 'public' => true );
				$post_types = get_post_types( $args, 'names' );
				foreach ($post_types as $post_type ) { ?>
					<option value="<?php echo $post_type; ?>" <?php if( $options['ptype'] == $post_type) { echo 'selected="selected"'; } ?>><?php echo $post_type;?></option>
				<?php }	?>
			</select>
			</label>
			</p>
			<p>
			<label for="latest-cpt-pshow"><?php echo __( 'Number of posts to show' ); ?>
				<input id="latest-cpt-pshow" name="latest-cpt-pshow" type="text" value="<?php echo $pshow; ?>" size="2" />
			</label>
			</p>
			<input type="hidden" id="latest-cpt-submit" name="latest-cpt-submit" value="1" />
	<?php
	}
	wp_register_sidebar_widget( 'widget_latest_cpt', __('Latest Custom Posts'), 'n2wp_latest_cpt' );
	wp_register_widget_control( 'widget_latest_cpt', __('Latest Custom Posts'), 'n2wp_latest_cpt_control', 300, 200 );
}

add_action( 'widgets_init', 'n2wp_latest_cpt_init' );
?>
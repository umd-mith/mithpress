<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Basic Sidebar Widgets
- Recent Posts Widget
- Search

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
        'name' => 'People Sidebar',
		'id' => 'people',
		'description' => 'Sidebar displayed on single people pages',
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
        'name' => 'Digital Dialogues Widget Area',
		'id' => 'ddialogues-page',
		'description' => 'Widget area displayed on main DD page, below content',
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
    register_sidebar(array(
        'name' => 'Homepage Widget Area',
		'id' => 'home-center-widgets',
		'description' => 'displays below the slider on the homepage',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><aside class="widget-body clear">'
    ));


/*-----------------------------------------------------------------------------------*/
/* Recent Posts/Podcasts Widgets */
/*-----------------------------------------------------------------------------------*/
class WP_Widget_Recent_Posts_Podcasts extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_recent_entries_pp', 'description' => __( "The most recent posts and podcasts on your site") );
		parent::__construct('recent-posts-podcasts', __('Recent Posts + Podcasts'), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries_pp';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_recent_posts_podcasts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 3;
		if ( ! $number )
 			$number = 3;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$r = new WP_Query( apply_filters( 
			'widget_posts_args', array( 
				'post_type' => array('post','podcast'),
				'posts_per_page' => $number, 
				'no_found_rows' => true, 
				'post_status' => 'publish', 
				'ignore_sticky_posts' => true ) 
			) );
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
			<?php if ( $show_date ) : ?>
				<span class="post-date"><?php the_time(__('M j, Y')); ?></span>
			<?php endif; ?>
				<span class="post-title"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></span>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts_podcasts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries_pp']) )
			delete_option('widget_recent_entries_pp');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts_podcasts', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Recent Custom Posts Widgets */
/*-----------------------------------------------------------------------------------*/

class WP_Widget_Recent_Custom_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_recent_cpt', 'description' => __( "Display the most recent custom posts") );
		parent::__construct('recent-custom-posts', __('Recent Custom Posts'), $widget_ops);
		$this->alt_option_name = 'widget_recent_cpt';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_recent_custom_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$post_num = ( ! empty( $instance['post_num'] ) ) ? absint( $instance['post_num'] ) : 3;
		if ( ! $post_num )
 			$post_num = 3;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$post_type = ( ! empty( $instance['post_type'] ) ) ? $instance['post_type'] : '';

		$cpt_args = array( 
			'post_type' =>  $post_type,
			'posts_per_page' => $post_num, 
			'no_found_rows' => true, 
			'post_status' => 'publish', 
			'ignore_sticky_posts' => true 
		);	
				
		$current_date = date('Ymd');
		if( $post_type == 'podcast' ){
				$cpt_args['meta_query'][] = array(
					'key' => 'podcast_date',
					'value' => $current_date,
					'compare' => '<=',
				);
			}

		$cpt = new WP_Query( apply_filters( 'widget_posts_args', $cpt_args ) );

		if ($cpt->have_posts()) : ?>

		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="cpt-list <?php echo $post_type; ?>-posts">
		<?php while ( $cpt->have_posts() ) : $cpt->the_post(); ?>

			<?php
            if ( $post_type == 'podcast' ) : 
		
				$date_raw = get_post_meta( get_the_ID(), 'podcast_date', TRUE);
				if ($date_raw != '') { $date = date('M j, Y', strtotime($date_raw)); }
				elseif ( get_post_meta(get_the_ID(), 'talk-date', TRUE) != '') {
					$date = get_post_meta(get_the_ID(), 'talk-date', TRUE); }
				else { $date = get_the_date( 'M j, Y' ); }								
				$title = get_post_meta( get_the_ID(), 'podcast_title', TRUE );
			
			elseif ( $post_type == 'post' ) : 
				$date = the_time(__('M j, Y')); 
				$title = get_the_title() ? the_title() : the_ID();
			
			endif; ?>
            
			<li>
			<?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo $date; ?></span>
			<?php endif; ?>
				<span class="post-title"><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></span>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_custom_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_num'] = (int) $new_instance['post_num'];
		$instance['post_type'] = $new_instance['post_type'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_cpt']) )
			delete_option('widget_recent_cpt');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_custom_posts', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$post_num    = isset( $instance['post_num'] ) ? absint( $instance['post_num'] ) : 5;
		$post_type    = isset( $instance['post_type'] ) ? esc_attr( $instance['post_type'] ) : '';
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'post_num' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'post_num' ); ?>" name="<?php echo $this->get_field_name( 'post_num' ); ?>" type="text" value="<?php echo $post_num; ?>" size="3" /></p>

		<p><label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Select post type to show:' ); ?></label>			
            <select name="<?php echo $this->get_field_name( 'post_type' ); ?>">
				<?php $args = array( 'public' => true );
				$post_types = get_post_types( $args, 'names' );
				$current_post_type = ( ! empty( $instance['post_type'] ) ) ? $instance['post_type'] : '';

				foreach ($post_types as $post_type ) { 
					echo '<option value='. $post_type, $current_post_type == $post_type ? ' selected="selected"' : '','>'; ?>
					<?php echo $post_type;?></option>
				<?php }	?>
			</select>        
        
        </p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
<?php
	}
}
function mithpress_register_widgets() {
	register_widget('WP_Widget_Recent_Posts_Podcasts');
	register_widget('WP_Widget_Recent_Custom_Posts');
}
add_action('widgets_init', 'mithpress_register_widgets');


?>
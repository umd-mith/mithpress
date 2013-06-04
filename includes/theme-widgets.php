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


/*-----------------------------------------------------------------------------------*/
/* Custom Post Type Calendar Widget */
/*-----------------------------------------------------------------------------------*/

class mithpress_cpt_calendar extends WP_Widget {


    /** constructor */
    function mithpress_cpt_calendar() {
        parent::WP_Widget(false, $name = 'CPT Calendar');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {	
        extract( $args );
        $title 			= apply_filters('widget_title', $instance['title']);
		$posttype_enabled = $instance['posttype_enabled'];
        $posttype 		= $instance['posttype'];
        ?>
			<?php echo $before_widget; ?>
				<?php if ( $title )
					echo $before_title . $title . $after_title; ?>
					<div class="widget_calendar">
						<div id="calendar_wrap">
							<?php if($posttype_enabled == true) {
								ucc_get_calendar(array($posttype));
							} else {
								ucc_get_calendar();
							} ?>
						</div>
					</div>
			<?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['posttype_enabled'] = $new_instance['posttype_enabled'];
		$instance['posttype'] = $new_instance['posttype'];
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {	

		$posttypes = get_post_types('', 'objects');
	
        $title = esc_attr($instance['title']);
		$posttype_enabled	= esc_attr($instance['posttype_enabled']);
		$posttype	= esc_attr($instance['posttype']);
        ?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('posttype_enabled'); ?>" name="<?php echo $this->get_field_name('posttype_enabled'); ?>" type="checkbox" value="1" <?php checked( '1', $posttype_enabled ); ?>/>
          <label for="<?php echo $this->get_field_id('posttype_enabled'); ?>"><?php _e('Show only one post type?'); ?></label> 
        </p>
		<p>	
			<label for="<?php echo $this->get_field_id('posttype'); ?>"><?php _e('Choose the Post Type to display'); ?></label> 
			<select name="<?php echo $this->get_field_name('posttype'); ?>" id="<?php echo $this->get_field_id('posttype'); ?>" class="widefat">
				<?php
				foreach ($posttypes as $option) {
					echo '<option value="' . $option->name . '" id="' . $option->name . '"', $posttype == $option->name ? ' selected="selected"' : '', '>', $option->name, '</option>';
				}
				?>
			</select>		
		</p>
        <?php 
    }


} // 
// register CPT Calendar widget
add_action('widgets_init', create_function('', 'return register_widget("mithpress_cpt_calendar");'));



/* ucc_get_calendar() :: Extends get_calendar() by including custom post types.
 * Derived from get_calendar() code in /wp-includes/general-template.php.
 */

function ucc_get_calendar( $post_types = '' , $initial = true , $echo = true ) {
  global $wpdb, $m, $monthnum, $year, $wp_locale, $posts;

  if ( empty( $post_types ) || !is_array( $post_types ) ) {
    $args = array(
      'public' => true ,
      '_builtin' => false
    );
    $output = 'names';
    $operator = 'and';

    $post_types = get_post_types( $args , $output , $operator );
    $post_types = array_merge( $post_types , array( 'post' ) );
  } else {
    /* Trust but verify. */
    $my_post_types = array();
    foreach ( $post_types as $post_type ) {
      if ( post_type_exists( $post_type ) )
        $my_post_types[] = $post_type;
    }
    $post_types = $my_post_types;
  }
  $post_types_key = implode( '' , $post_types );
  $post_types = "'" . implode( "' , '" , $post_types ) . "'";

  $cache = array();
  $key = md5( $m . $monthnum . $year . $post_types_key );
  if ( $cache = wp_cache_get( 'get_calendar' , 'calendar' ) ) {
    if ( is_array( $cache ) && isset( $cache[$key] ) ) {
      remove_filter( 'get_calendar' , 'ucc_get_calendar_filter' );
      $output = apply_filters( 'get_calendar',  $cache[$key] );
      add_filter( 'get_calendar' , 'ucc_get_calendar_filter' );
      if ( $echo ) {
        echo $output;
        return;
      } else {
        return $output;
      }
    }
  }

  if ( !is_array( $cache ) )
    $cache = array();

  // Quick check. If we have no posts at all, abort!
  if ( !$posts ) {
    $sql = "SELECT 1 as test FROM $wpdb->posts WHERE post_type IN ( $post_types ) AND post_status = 'publish' LIMIT 1";
    $gotsome = $wpdb->get_var( $sql );
    if ( !$gotsome ) {
      $cache[$key] = '';
      wp_cache_set( 'get_calendar' , $cache , 'calendar' );
      return;
    }
  }

  if ( isset( $_GET['w'] ) )
    $w = '' . intval( $_GET['w'] );

  // week_begins = 0 stands for Sunday
  $week_begins = intval( get_option( 'start_of_week' ) );

  // Let's figure out when we are
  if ( !empty( $monthnum ) && !empty( $year ) ) {
    $thismonth = '' . zeroise( intval( $monthnum ) , 2 );
    $thisyear = ''.intval($year);
  } elseif ( !empty( $w ) ) {
    // We need to get the month from MySQL
    $thisyear = '' . intval( substr( $m , 0 , 4 ) );
    $d = ( ( $w - 1 ) * 7 ) + 6; //it seems MySQL's weeks disagree with PHP's
    $thismonth = $wpdb->get_var( "SELECT DATE_FORMAT( ( DATE_ADD( '${thisyear}0101' , INTERVAL $d DAY ) ) , '%m' ) " );
  } elseif ( !empty( $m ) ) {
    $thisyear = '' . intval( substr( $m , 0 , 4 ) );
    if ( strlen( $m ) < 6 )
        $thismonth = '01';
    else
        $thismonth = '' . zeroise( intval( substr( $m , 4 , 2 ) ) , 2 );
  } else {
    $thisyear = gmdate( 'Y' , current_time( 'timestamp' ) );
    $thismonth = gmdate( 'm' , current_time( 'timestamp' ) );
  }

  $unixmonth = mktime( 0 , 0 , 0 , $thismonth , 1 , $thisyear);

  // Get the next and previous month and year with at least one post
  $previous = $wpdb->get_row( "SELECT DISTINCT MONTH( post_date ) AS month , YEAR( post_date ) AS year
    FROM $wpdb->posts
    WHERE post_date < '$thisyear-$thismonth-01'
    AND post_type IN ( $post_types ) AND post_status = 'publish'
      ORDER BY post_date DESC
      LIMIT 1" );
  $next = $wpdb->get_row( "SELECT DISTINCT MONTH( post_date ) AS month, YEAR( post_date ) AS year
    FROM $wpdb->posts
    WHERE post_date > '$thisyear-$thismonth-01'
    AND MONTH( post_date ) != MONTH( '$thisyear-$thismonth-01' )
    AND post_type IN ( $post_types ) AND post_status = 'publish'
      ORDER  BY post_date ASC
      LIMIT 1" );

  /* translators: Calendar caption: 1: month name, 2: 4-digit year */
  $calendar_caption = _x( '%1$s %2$s' , 'calendar caption' );
  $calendar_output = '<table id="wp-calendar" summary="' . esc_attr__( 'Calendar' ) . '">
  <caption>' . sprintf( $calendar_caption , $wp_locale->get_month( $thismonth ) , date( 'Y' , $unixmonth ) ) . '</caption>
  <thead>
  <tr>';

  $myweek = array();

  for ( $wdcount = 0 ; $wdcount <= 6 ; $wdcount++ ) {
    $myweek[] = $wp_locale->get_weekday( ( $wdcount + $week_begins ) % 7 );
  }

  foreach ( $myweek as $wd ) {
    $day_name = ( true == $initial ) ? $wp_locale->get_weekday_initial( $wd ) : $wp_locale->get_weekday_abbrev( $wd );
    $wd = esc_attr( $wd );
    $calendar_output .= "\n\t\t<th scope=\"col\" title=\"$wd\">$day_name</th>";
  }

  $calendar_output .= '
  </tr>
  </thead>

  <tfoot>
  <tr>';

  if ( $previous ) {    $calendar_output .= "\n\t\t" . '<td colspan="3" id="prev"><a href="' . get_month_link( $previous->year , $previous->month ) . '" title="' . sprintf( __( 'View posts for %1$s %2$s' ) , $wp_locale->get_month( $previous->month ) , date( 'Y' , mktime( 0 , 0 , 0 , $previous->month , 1 , $previous->year ) ) ) . '">&laquo; ' . $wp_locale->get_month_abbrev( $wp_locale->get_month( $previous->month ) ) . '</a></td>';
  } else {
    $calendar_output .= "\n\t\t" . '<td colspan="3" id="prev" class="pad">&nbsp;</td>';
  }

  $calendar_output .= "\n\t\t" . '<td class="pad">&nbsp;</td>';

  if ( $next ) {    $calendar_output .= "\n\t\t" . '<td colspan="3" id="next"><a href="' . get_month_link( $next->year , $next->month ) . '" title="' . esc_attr( sprintf( __( 'View posts for %1$s %2$s' ) , $wp_locale->get_month( $next->month ) , date( 'Y' , mktime( 0 , 0 , 0 , $next->month , 1 , $next->year ) ) ) ) . '">' . $wp_locale->get_month_abbrev( $wp_locale->get_month( $next->month ) ) . ' &raquo;</a></td>';
  } else {
    $calendar_output .= "\n\t\t" . '<td colspan="3" id="next" class="pad">&nbsp;</td>';
  }

  $calendar_output .= '
  </tr>
  </tfoot>

  <tbody>
  <tr>';

  // Get days with posts
  $dayswithposts = $wpdb->get_results( "SELECT DISTINCT DAYOFMONTH( post_date )
    FROM $wpdb->posts WHERE MONTH( post_date ) = '$thismonth'
    AND YEAR( post_date ) = '$thisyear'
    AND post_type IN ( $post_types ) AND post_status = 'publish'
    AND post_date < '" . current_time( 'mysql' ) . '\'', ARRAY_N );
  if ( $dayswithposts ) {
    foreach ( (array) $dayswithposts as $daywith ) {
      $daywithpost[] = $daywith[0];
    }
  } else {
    $daywithpost = array();
  }

  if ( strpos( $_SERVER['HTTP_USER_AGENT'] , 'MSIE' ) !== false || stripos( $_SERVER['HTTP_USER_AGENT'] , 'camino' ) !== false || stripos( $_SERVER['HTTP_USER_AGENT'] , 'safari' ) !== false )
    $ak_title_separator = "\n";
  else
    $ak_title_separator = ', ';

  $ak_titles_for_day = array();
  $ak_post_titles = $wpdb->get_results( "SELECT ID, post_title, DAYOFMONTH( post_date ) as dom "
    . "FROM $wpdb->posts "
    . "WHERE YEAR( post_date ) = '$thisyear' "
    . "AND MONTH( post_date ) = '$thismonth' "
    . "AND post_date < '" . current_time( 'mysql' ) . "' "
    . "AND post_type IN ( $post_types ) AND post_status = 'publish'"
  );
  if ( $ak_post_titles ) {
    foreach ( (array) $ak_post_titles as $ak_post_title ) {

        $post_title = esc_attr( apply_filters( 'the_title' , $ak_post_title->post_title , $ak_post_title->ID ) );

        if ( empty( $ak_titles_for_day['day_' . $ak_post_title->dom] ) )
          $ak_titles_for_day['day_'.$ak_post_title->dom] = '';
        if ( empty( $ak_titles_for_day["$ak_post_title->dom"] ) ) // first one
          $ak_titles_for_day["$ak_post_title->dom"] = $post_title;
        else
          $ak_titles_for_day["$ak_post_title->dom"] .= $ak_title_separator . $post_title;
    }
  }

  // See how much we should pad in the beginning
  $pad = calendar_week_mod( date( 'w' , $unixmonth ) - $week_begins );
  if ( 0 != $pad )
    $calendar_output .= "\n\t\t" . '<td colspan="' . esc_attr( $pad ) . '" class="pad">&nbsp;</td>';

  $daysinmonth = intval( date( 't' , $unixmonth ) );
  for ( $day = 1 ; $day <= $daysinmonth ; ++$day ) {
    if ( isset( $newrow ) && $newrow )
      $calendar_output .= "\n\t</tr>\n\t<tr>\n\t\t";
    $newrow = false;

    if ( $day == gmdate( 'j' , current_time( 'timestamp' ) ) && $thismonth == gmdate( 'm' , current_time( 'timestamp' ) ) && $thisyear == gmdate( 'Y' , current_time( 'timestamp' ) ) )
      $calendar_output .= '<td id="today">';
    else
      $calendar_output .= '<td>';

    if ( in_array( $day , $daywithpost ) ) // any posts today?
        $calendar_output .= '<a href="' . get_day_link( $thisyear , $thismonth , $day ) . "\" title=\"" . esc_attr( $ak_titles_for_day[$day] ) . "\">$day</a>";
    else
      $calendar_output .= $day;
    $calendar_output .= '</td>';

    if ( 6 == calendar_week_mod( date( 'w' , mktime( 0 , 0 , 0 , $thismonth , $day , $thisyear ) ) - $week_begins ) )
      $newrow = true;
  }

  $pad = 7 - calendar_week_mod( date( 'w' , mktime( 0 , 0 , 0 , $thismonth , $day , $thisyear ) ) - $week_begins );
  if ( $pad != 0 && $pad != 7 )
    $calendar_output .= "\n\t\t" . '<td class="pad" colspan="' . esc_attr( $pad ) . '">&nbsp;</td>';

  $calendar_output .= "\n\t</tr>\n\t</tbody>\n\t</table>";

  $cache[$key] = $calendar_output;
  wp_cache_set( 'get_calendar' , $cache, 'calendar' );

  remove_filter( 'get_calendar' , 'ucc_get_calendar_filter' );
  $output = apply_filters( 'get_calendar',  $calendar_output );
  add_filter( 'get_calendar' , 'ucc_get_calendar_filter' );

  if ( $echo )
    echo $output;
  else
    return $output;
}

function ucc_get_calendar_filter( $content ) {
  $output = ucc_get_calendar( '' , '' , false );
  return $output;
}
add_filter( 'get_calendar' , 'ucc_get_calendar_filter' , 10 , 2 );
?>
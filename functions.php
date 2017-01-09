<?php 

/*
  STYLES	-----------------------------------------------------------------
*/
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 51);

/*
  SCRIPTS	---------------------------------------------------------------------
*/
if ( ! function_exists( 'load_mith_child_scripts' ) ) {
	
	function load_mith_child_scripts() {
		wp_enqueue_script('umd_header_js', '//s3.amazonaws.com/umdheader.umd.edu/app/js/main.min.js', '', '', false);
		wp_enqueue_script('mith_child_js', get_stylesheet_directory_uri() . '/js/scripts.js', array('umd_header_js'), '', false);	
		if ( is_singular('mith_research') ) {
			wp_enqueue_script('jquery_ate', get_stylesheet_directory_uri() . '/js/jquery.ate-1.6.0.js', array('jquery'), '', false);		
		}
		if ( is_post_type_archive('mith_research') ) {
		wp_enqueue_script('mith_mre_js', get_stylesheet_directory_uri() . '/js/mre.min.js', array('jquery'), '', false);		
		}
	}
}
add_action('wp_enqueue_scripts', 'load_mith_child_scripts', 50);

function load_mith_child_js() { ?>
	<script>
	  umdHeader.init({ news: false });
	</script>
<?php }
add_action('wp_head', 'load_mith_child_js',51);


/*
  ADMIN	--------------------------------------------------------
*/

add_action('admin_head', 'mith_admin_styles');

function mith_admin_styles() {
	global $typenow; 
	if ($typenow=="mith_person") {
		echo '<style id="mith_person_css" type="text/css">
		.column-featured_thumbnail { width: 125px; }
		.column-featured_thumbnail img { height: 50px; width: 111px; }
		.column-person_thumbnail { width: 65px; }
		</style>';
	}
	
if ($typenow == "mith_research") {
		echo '<style id="mith_research_css" type="text/css">
		#acf-research_twitter_account, #acf-research_twitter_hashtag, #acf-research_contact_name, #acf-research_contact_email { display: inline-block; width: 47%; } 
		</style>';
	} 
}

/*
  CUSTOM POSTS & TAXONOMIES	--------------------------------------------------------
*/
get_template_part('includes/posts', 'taxonomies');

/* Filter Dropdowns */
/*-----------------------------------------------------------------------------------*/
class MITHF_walker extends Walker_CategoryDropdown {
    public $tree_type = 'category';
    public $db_fields = array(
        'parent' => 'parent',
        'id'     => 'term_id',
    );
    public $tax_name;

    public function start_el( &$output, $term, $depth, $args, $id = 0 )
    {
        $pad = str_repeat( '&nbsp;', $depth * 3 );
        $cat_name = apply_filters( 'list_cats', $term->name, $term );
        $output .= sprintf(
            '<option class="level-%s" value="%s" %s>%s%s</option>',
            $depth,
            $term->slug,
            selected(
                $args['selected'],
                $term->slug,
                false
            ),
            $pad.$cat_name,
            $args['show_count']
                ? "&nbsp;&nbsp;({$term->count})"
                : ''
        );
    }
}

add_action( 'plugins_loaded', array( 'MITH_Admin_PT_List_Tax_Filter', 'init' ) );

class MITH_Admin_PT_List_Tax_Filter
{
    private static $instance;
    public $post_type;
    public $taxonomies;

    static function init() {
        null === self::$instance AND self::$instance = new self;
        return self::$instance;
    }

    public function __construct() {
        add_action( 'load-edit.php', array( $this, 'setup' ) );
    }

    public function setup() {
        add_action( current_filter(), array( $this, 'setup_vars' ), 20 );
        add_action( 'restrict_manage_posts', array( $this, 'get_select' ) );
        add_filter( "manage_taxonomies_for_{$this->post_type}_columns", array( $this, 'add_columns' ) );
    }

    public function setup_vars() {
        $this->post_type  = get_current_screen()->post_type;
        $this->taxonomies = array_diff(
            get_object_taxonomies( $this->post_type ),
            get_taxonomies( array( 'show_admin_column' => 'false' ) )
        );
    }

    public function add_columns( $taxonomies ) {
        return array_merge( taxonomies, $this->taxonomies );
    }

    public function get_select() {
        $walker = new MITHF_walker;
        foreach ( $this->taxonomies as $tax )
        {
            wp_dropdown_categories( array(
                'taxonomy'        => $tax,
                'hide_if_empty'   => true,
                'show_option_all' => sprintf(
                    get_taxonomy( $tax )->labels->all_items
                ),
                'hide_empty'      => true,
                'hierarchical'    => is_taxonomy_hierarchical( $tax ),
                'show_count'      => true,
                'orderby'         => 'name',
                'selected'        => '0' !== get_query_var( $tax )
                    ? get_query_var( $tax )
                    : false,
                'name'            => $tax,
                'id'              => $tax,
                'walker'          => $walker,
            ) );
        }
    }
} 

/*
  SIDEBARS & WIDGETS	------------------------------------------------------------
*/
function mith_display_sidenav( $page_id ) {

	$html = '<ul class="side-nav">';

	$post_ancestors = get_ancestors( $page_id, 'page' );
	$post_parent    = end( $post_ancestors );

	$html .= ( is_page( $post_parent ) ) ? '<li class="current_page_item">' : '<li>';

	if ( $post_parent ) {
		$html .= sprintf( '<a href="%s" title="%s">%s</a></li>', get_permalink( $post_parent ), __( 'Back to Parent Page', 'Avada' ), get_the_title( $post_parent ) );
		$children = wp_list_pages( sprintf( 'title_li=&child_of=%s&echo=0', $post_parent ) );
	} else {
		$html .= sprintf( '<a href="%s" title="%s">%s</a></li>', get_permalink( $page_id ), __( 'Back to Parent Page', 'Avada' ), get_the_title( $page_id ) );
		$children = wp_list_pages( sprintf( 'title_li=&child_of=%s&echo=0', $page_id ) );
	}

	if ( $children ) {
		$html .= $children;
	}		

	$html .= '</ul>';

	return $html;
}

/*
  IMAGES	------------------------------------------------------------------------
*/

if ( function_exists( 'add_image_size' ) ) {
	add_image_size('medium-square', 200, 200, true);
}
	add_filter('image_size_names_choose', 'my_image_sizes');
	function my_image_sizes($sizes) {
	$addsizes = array(
		'medium-square' => __( 'Medium Square' ),
		'blog-large' => __( 'Blog Large' ),
		'blog-medium' => __( 'Blog Medium' ),
		'tabs-img' => __( 'Tabs Image' ),
		'related-img' => __( 'Related Image' ),
		'portfolio-full' => __( 'Portfolio Full' ),
		'portfolio-one' => __( 'Portfolio One' ),
		'portfolio-two' => __( 'Portfolio Two' ),
		'portfolio-three' => __( 'Portfolio Three' ),
		'portfolio-four' => __( 'Portfolio Four' ),
		'portfolio-five' => __( 'Portfolio Five' ),
		'portfolio-six' => __( 'Portfolio Six' ),
		'recent-posts' => __( 'Recent Posts' ),
		'recent-works-thumbnail' => __( 'Recent Works Thumbnail' )
	);
	$newsizes = array_merge($sizes, $addsizes);
	return $newsizes;
}

/*
  BODY CLASSES	---------------------------------------------------------------------
*/

function add_body_classes( $classes ){
	global $post;
	if( is_singular() ) {
		if ($parents = get_post_ancestors($post->ID)) {
            foreach ((array)$parents as $parent) {
				if ($page = get_page($parent)) {
                    // Add the current ancestor to the body class array
                    $classes[] = "{$page->post_type}-ancestor-{$page->post_name}";
                }
            }
		$parents_array = array_reverse(get_post_ancestors($post->ID));
		$first_parent = get_page($parents_array[0]);
		$classes[] = "{$post->post_type}-parent-{$first_parent->post_name}";
        }
		$classes[] = "{$post->post_type}-{$post->post_name}";
	}
	if ( is_singular( array('mith_person') ) ) {
		$classes[] = 'has-sidebar';
		$classes[] = 'double-sidebars';	
	}
	if ( is_singular( array('mith_research', 'project') ) ) {
		$classes[] = 'single-post';
		$classes[] = 'has-sidebar';
		if (get_the_post_thumbnail($post->ID) != '') $classes[] = 'has-thumbnail';
	}
	if ( is_post_type_archive('mith_dialogue') ) {
		$classes[] = 'has-sidebar';
		$classes[] = 'double-sidebars';
	}
	if ( is_post_type_archive('mith_dialogue') || is_tax('mith_dialogue_series') || is_page('schedule') ) {
		$classes[] = 'dd-archive';
	}
return $classes;
}
add_filter( 'body_class', 'add_body_classes' );

/* 
  PROJECTS -------------------------------------------------------------------------
*/

function save_research_meta( $post_id, $post, $update ) {

	if ('mith_research' != $post->post_type) { 
		return;
	}
	
	$research_start_mth = get_post_meta($post_id,'research_start_mth', true);
	$research_start_yr = get_post_meta($post_id,'research_start_yr', true);
	$research_end_mth = get_post_meta($post_id,'research_end_mth', true);
	$research_end_yr = get_post_meta($post_id,'research_end_yr', true);
	if ( $research_start_yr ) { 
		$research_start = $research_start_yr;
		if ( $research_start_mth && $research_start_mth != 'null' ) { 
			$research_start .= '-' . $research_start_mth;
			if ( isset( $_REQUEST['research_start_yyyymm'] ) ) {
			update_post_meta( $post_id, 'research_start_yyyymm', sanitize_text_field( $_REQUEST[$research_start] ) );
			}
		}
	}
	if ( $research_end_yr) { 
		$research_end = $research_end_yr; 
		if ( $research_end_mth && $research_end_mth != 'null' ) { 
			$research_end .= '-' . $research_end_mth;
			if ( isset( $_REQUEST['research_end_yyyymm'] ) ) {
			update_post_meta($post->ID,'research_end_yyyymm', sanitize_text_field( $_REQUEST[$research_end] ) );
			}
		}
	}
	
	
}
add_action( 'save_post', 'save_research_meta', 10, 3 );

function mith_research_event_date() { 
	global $post;
	if ( has_term( array('mith-event', 'event-conference', 'event-symposium', 'event-training-institute', 'event-workshop'), 'mith_research_type') ) :
		$event_start_date_raw = get_post_meta( $post->ID, 'event_date_start', true);
		if ($event_start_date_raw ) $event_start_date = date('D, M j, Y', strtotime($event_start_date_raw)); 
		$event_end_date_raw = get_post_meta( $post->ID, 'event_date_end', true);
		if ($event_end_date_raw ) $event_end_date = date('D, M j, Y', strtotime($event_end_date_raw));
	endif;

	if ( $event_start_date_raw ) : 
		$event_date = '<span>' . $event_start_date;
		if ( $event_end_date ) $event_date .= '<span class="dates-sep"> &ndash; </span><br />' . $event_end_date;
		$event_date .= '</span>';
	endif;
	
	return $event_date;
}

function mith_research_event_time() {
	global $post;
	if ( has_term( array('mith-event', 'event-conference', 'event-symposium', 'event-training-institute', 'event-workshop'), 'mith_research_type') ) :
		$event_start_time_raw = get_post_meta( $post->ID, 'event_time_start', true);
		if ($event_start_time_raw) $event_start_time = date('g:i a', $event_start_time_raw);
		$event_end_time_raw = get_post_meta( $post->ID, 'event_time_end', true);
		if ($event_end_time_raw) $event_end_time = date('g:i a', $event_end_time_raw);
	endif;
	
	if ($event_start_time) :
		$event_times = $event_start_time;
		if ( $event_end_time ) $event_times .= '<span class="dates-sep"> &ndash; </span>' . $event_end_time;
	endif;	
	
	return $event_times;
}


function save_research_sponsor_meta( $post_id, $post, $update ) { 

	$type = 'mith_research';
	if ( $type != $post->post_type ) {
        return;
    }
	$research_sponsors = get_post_meta($post->ID, 'research_sponsors', true);
	if ( $research_sponsors > 0) :
		$int_sponsors = $ext_sponsors = array();
		$count = $research_sponsors;
		$research_sponsor = array();
		while(has_sub_field('research_sponsors')):
		$sponsor_name = get_sub_field('research_sponsor_name');
		$sponsor_url = get_sub_field('research_sponsor_web');
		$sponsor_type = get_sub_field('research_sponsor_type');
		$sponsors[] = $sponsor_name;
		endwhile;
		foreach ($sponsors as $sponsor) :
		if ( ! add_post_meta( $post_id, 'research_sponsor', $sponsor, false) )
			add_post_meta( $post_id, 'research_sponsor', $sponsor);
		endforeach;

	endif;
}
add_action( 'save_post', 'save_research_sponsor_meta', 10, 3 ); 

/* Display tagged posts in sidebar */
/*-----------------------------------------------------------------------------------*/

function mith_display_tagged_posts() {
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {  
		$tag_ids = array();
			foreach( $tags as $tag) $tag_ids[] = $tag->term_id;
	
		$args = array(
			'tag__in' => $tag_ids,
			'posts_per_page' => '4',
		);
		$tagged = new WP_Query( $args );
		if( $tagged->have_posts() ) : ?>					
		<div id="project_posts" class="widget mith_recent_posts-widget widget_recent_entries">
			<div class="heading"><h4><?php _e('Related Blog Posts', 'Avada'); ?></h4></div>
				<ul>    
				<?php while ( $tagged->have_posts() ) : $tagged->the_post(); ?>
					<li><a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a><span class="post-date" style="display: none;"><?php the_time(__('M j, Y')) ?></span></li>
				<?php endwhile; ?>
				</ul>

		</div>   
		<?php endif; wp_reset_query();
	}
}

/**
 * Change Posts Per Page for Research Archive 
*/
add_action( 'pre_get_posts', 'mith_change_research_posts_per_page' );
function mith_change_research_posts_per_page( $query ) {
	
	if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'mith_research' ) ) {
		$query->set( 'meta_key', 'research_start_yr');
		$query->set( 'orderby', 'meta_value_num');
		$query->set( 'order', 'DESC' );
		//$query->set( 'meta_value_num', '0');
		//$query->set( 'meta_compare', '>');		
		/*$query->set( 'meta_query', array(
				array(
					'key'     => 'research_start_yr',
					'value'   => '0',
					'compare' => '>',
				)
			));
		*/
	}
}

/*
  DIALOGUES	---------------------------------------------------------------------
*/
get_template_part('includes/dialogue', 'info-snippet');

/* Show future posts */
/*-----------------------------------------------------------------------------------*/
function show_future_posts($posts)
{
   global $wp_query, $wpdb;
   if( is_single() && $wp_query->post_count == 0 )
   {
      $posts = $wpdb->get_results($wp_query->request);
   }
   return $posts;
}
add_filter('the_posts', 'show_future_posts');

/* Show future posts on the DD Series Taxonomy page
/*-----------------------------------------------------------------------------------*/
function show_future_dialogues_tax_page( $query ) {
	if( is_tax( 'mith_dialogue_series') ) {
	$query->set( 'post_status', array('future','publish'));
	$query->set( 'order', 'ASC');
	}
}
add_action( 'pre_get_posts', 'show_future_dialogues_tax_page' );

/* List Recent or Future Dialogues Shortcode */
/*-----------------------------------------------------------------------------------*/

function mith_dialogues_shortcode($atts) {
	extract( shortcode_atts( array(
		'post_type' => 'mith_dialogue',
		'total' 	=> '-1',
		'order' 	=> 'DESC',
		'orderby' 	=> 'date',
		'size' => 'full',
		'term' => 'future',
		'current' => 'no',
	), $atts ));
	$html  = '';

	$cats = get_terms('mith_dialogue_series', array(
		'orderby'    => 'slug',
		'order' 	 => 'DESC',
		'hide_empty' => true
	) );
	$first_cat_value = reset($cats);
	$first_cat_slug = $first_cat_value->slug;
	$current_date = date('Ymd');

	$args = array( 
		'order' 				=> $order,
		'orderby' 			=> $orderby,
		'post_type' 			=> $post_type,
		//'post_status' 		=> $post_status,
		'posts_per_page'	=> $total,
	);
	if ( $term === 'recent' ) :
		$args['post_status'] = 'publish';
		$args['meta_query'][] = array(
				'key'		=> 'dialogue_date',
				'value' 		=> $current_date,
				'compare'	=> '<=',	// posts before or equal to todays date
				'type'		=> 'numeric' 
		);
	endif;
	if ( $term === 'future' ) :
		$args['post_status'] = array( 'publish', 'future');
		$args['meta_query'][] = array(
				'key'		=> 'dialogue_date',
				'value' 		=> $current_date,
				'compare'	=> '>',	// posts after todays date
				'type'		=> 'numeric',
		);
	endif;
	if ( $current === 'yes' ) : // limit to show posts in current series
	$args['tax_query'][] = array(
			'taxonomy' 	=> 'mith_dialogue_series',
			'field'		=> 'slug',
			'terms'		=> $first_cat_slug, // only posts in current series
	);
	endif;
			
	$query = new WP_Query( $args );
	
	if( $query->have_posts() ):
	
		if ( $post_status = 'future' ) : 
			$status_css = 'upcoming'; 
		elseif ($post_status = 'publish') : 
			$status_css = 'recent';
		endif;
		
		$html .= '<div class="dialogues-list ' . $status_css . '-dialogues layout-' . $size . '">';
			while( $query->have_posts()) : $query->the_post();
				$img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium-square' );
				$img_src = sprintf( '<img alt="%s" src="%s" />', get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true), $img_url[0]);
				$image = do_shortcode('[imageframe lightbox="no" lightbox_image="no" style_type="glow" bordercolor="#ffffff" bordersize="4px" borderradius="" stylecolor="" align="left" link="' .  get_permalink() . '" linktarget="" animation_type="" animation_direction="" animation_speed="" class="" id=""]' . $img_src . '[/imageframe]');
				
				/* TITLE */
				$talk_title = get_post_meta( get_the_ID(), 'dialogue_title', TRUE );
				if ( $talk_title ) $the_title = $talk_title;
				else $the_title = get_the_title(); 
				$title = sprintf( '<div class="entry-title"><a href="%1$s">%2$s</a></div>', get_permalink(), $the_title );	
				
				/* INFO */
				ob_start();
				dialogue_info_snippet($size = $size, $col = 'one_full' );
				$info = ob_get_clean();
				
				$html .= $image . $title . $info;
			endwhile;
		$html .= '</div>';
	else : 
	$archive = sprintf( '<a href="%s" title="%s">%s</a>', esc_url( home_url('digital-dialogues') ), __('Dialogues Archive Page', 'Avada'), __('Dialogues Archive', 'Avada') );
	$html .= '<div class="no-upcoming-dialogues">' . __('The current semester of Digital Dialogues has ended. We will add information on the upcoming semester as it becomes available. In the meantime, please check out our recent dialogues by visiting our ' . $archive . ' page.', 'Avada') . '</div>';
	endif;
	return $html;
}
add_shortcode( 'mith_dialogues', 'mith_dialogues_shortcode' );


/* Dialogue Series Dropdown */
/*-----------------------------------------------------------------------------------*/
class SH_Walker_DialogueTaxDropdown extends Walker_CategoryDropdown { 
	function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
		$pad = str_repeat('&nbsp;', $depth * 3);
		$cat_name = apply_filters('list_cats', $category->name, $category);
	
		if( !isset($args['value']) ){
			$args['value'] = ( $category->taxonomy != 'category' ? 'slug' : 'id' );
		}
	
		$value = ($args['value']=='slug' ? $category->slug : $category->term_id );
	
		$output .= "\t<option class=\"level-$depth\" value=\"".$value."\"";
		if ( $value === (string) $args['selected'] ){ 
			$output .= ' selected="selected"';
		}
		$output .= '>';
		$output .= $pad.$cat_name;
		if ( $args['show_count'] )
			$output .= '&nbsp;&nbsp;('. $category->count .')';
	
		$output .= '</option><i class="fa fa-sort sort-asc" aria-hidden="true"></i>';
		$output .= "\n";
	}
}

function restrict_dialogues_by_series() {
    global $typenow;
    global $wp_query;
    $taxonomy = 'mith_dialogue_series';
	$tax_args = array(
		'taxonomy' => 'mith_dialogue_series',
		'orderby' => 'slug',
		'order' => 'ASC',
	);
    $terms_first = get_categories($tax_args);
	$terms = array_reverse($terms_first, true);
	$newest_tax = end($terms);
	$selected_tax = $wp_query->query[$taxonomy];
	
	if ($selected_tax == '') { $selected_tax = $newest_tax->slug; } 
    wp_dropdown_categories(
        array(
            'walker'		  => new SH_Walker_DialogueTaxDropdown(),
            'value'			  =>'slug',
            //'show_option_all' =>  __("Show All {$current_taxonomy->label}"),
            'taxonomy'        =>  $taxonomy,
            'name'            =>  'mith_dialogue_series',
            'orderby'         =>  'slug',
			'order'			  =>  'DESC',
            'selected'        =>  $selected_tax,
            'hierarchical'    =>  true,
            'depth'           =>  3,
            'show_count'      =>  true, // Show # series in parents
            'hide_empty'      =>  true, // Don't show series w/o listings
            )
	);
}



/* Change post_per_page for Dialogue Series Page */
/*-----------------------------------------------------------------------------------*/
add_action( 'pre_get_posts', 'mith_change_dd_posts_query' );

function mith_change_dd_posts_query( $query ) {
	
	if( $query->is_main_query() && !is_admin() && is_tax( 'mith_dialogue_series' ) ) {
		$meta_query = array(
                    array( 
                        'key' => 'dialogue_date',
                        'value' =>  date('Ymd'),
                        'compare' => '<=',
                        'type' => 'numeric' 
                    )
                );
		$query->set( 'meta_query', $meta_query );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'meta_key', 'dialogue_date' );
		$query->set( 'order', 'DESC' );
		$query->set( 'posts_per_page', '-1' );
	}
}
/*
  PEOPLE    ---------------------------------------------------------------------
*/
get_template_part('includes/person', 'info-snippet');

function mith_people_shortcode() {
	$html = '';
	$args = array(
		'post_type'			=> 'mith_person',
		'meta_key'			=> 'last_name',
		'orderby'			=> 'meta_value',
		'order'				=> 'ASC',
		'posts_per_page'	=> -1,
		'tax_query' => array(
			array(
				'taxonomy'	=> 'mith_staff_group',
				'field'		=> 'slug',
				'terms'		=> array( 'people-past' ),
				'operator'	=> 'NOT IN'
			)
		)
	);
	$query = new WP_Query( $args );
	if( $query->have_posts() ) :
	$html .= '<div id="img-links" class="recent-works-items clearfix">';
		while( $query->have_posts()) : $query->the_post();
			$html .= '<a href="' . get_permalink() . '" rel="alternate" title="Profile of ' . the_title_attribute( array('echo' => 0) ) . '">' . get_the_post_thumbnail( get_the_ID(), 'recent-works-thumbnail' ) . '</a>';
		endwhile;
	$html .= '</div>';
	endif; 
	wp_reset_query(); 
	return $html;
}
add_shortcode( 'mith_people', 'mith_people_shortcode' );

/* Display tagged posts in sidebar */
/*-----------------------------------------------------------------------------------*/

function mith_display_blog_posts() {
	global $post;
	$post_slug = $post->post_name;
	$person_username = str_replace('-', '', $post_slug);
	
	if ( is_singular('mith_person') ) $number = '5';
	else ( $number = '10');
	
	$args = array( 
		'posts_per_page' => $number,
		'author_name' => $person_username,
	);
	
	$post_query = new WP_Query( $args );
		if ( $post_query->have_posts() ) : ?>
		<div id="person_posts" class="widget mith_recent_posts-widget widget_recent_entries person-<?php echo $post_slug; ?>">
			<div class="heading"><h4><?php _e('Blog Posts', 'Avada'); ?></h4></div>
            <ul>
            <?php while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
                <li><a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a><span class="post-date" style="display: none;"><?php the_time(__('M j, Y')) ?></span></li>
            <?php endwhile; ?>
            </ul>
		</div>   
		<?php endif; wp_reset_query();
}

/*
  BLOG    ---------------------------------------------------------------------
*/

function validate_gravatar($email) {
	// Craft a potential url and test its headers
	$hash = md5(strtolower(trim($email)));
	$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
	$headers = @get_headers($uri);
	if (!preg_match("|200|", $headers[0])) {
		$has_valid_avatar = FALSE;
	} else {
		$has_valid_avatar = TRUE;
	}
	return $has_valid_avatar;
}

if ( ! function_exists( 'avada_render_blog_post_gravatar' ) ) {
	function avada_render_blog_post_gravatar() { 
	?>
		<div class="fusion-gravatar-box">
        	<?php 
			$author             = get_user_by( 'id', get_query_var( 'author' ) );
			$author_id          = $author->ID;
			$author_name        = get_the_author_meta( 'display_name', $author_id );
			$author_avatar      = get_avatar( get_the_author_meta( 'email', $author_id ), '82' );
			$author_email 		= get_the_author_email(); 
            $author_imgid		= get_field('user_photo', 'user_'. $author_id ); // image field, return type = "ID" 
            $author_img			= wp_get_attachment_image_src( $author_imgid, 'thumbnail' );
            $author_show_img 	= get_field('show_user_photo', 'user_'. $author_id );
			
			if ( function_exists('get_avatar') ) {
                if ( validate_gravatar( $author_email ) ) {
                    echo $author_avatar;
                } elseif ( $author_imgid > 0 ) { ?>
                <img src="<?php echo $author_img['0']; ?>" alt="<?php echo $author_name; ?>" width="82" height="82" />
                <?php } else { 
                //echo get_avatar( $author_email, 82, get_template_directory_uri() .'/images/no-avatar.png' ); 
                }
            }
		?>
		</div>
		<?php
	}
}
add_action( 'avada_blog_post_date_and_format', 'avada_render_blog_post_gravatar', 20 );

/* ADJUST BLOG QUERIES */
/*-----------------------------------------------------------------------------------*/
function mith_post_queries( $query ) {
  // not an admin page and is the main query
  if (!is_admin() && $query->is_main_query()){
    // query the home page
    if(is_home() ) {
      $query->set('post_type', array('post','mith_dialogue'));
    }
  }
}
add_action( 'pre_get_posts', 'mith_post_queries' );


if ( ! function_exists( 'avada_render_dialogue_post_content' ) ) {
	function avada_render_dialogue_post_content() {
		global $post;
		if ( is_home() && $post->post_type == 'mith_dialogue' ) : 		
		echo dialogue_info_snippet('excerpt', 'one_full', 'show');
		endif;
	}
}
add_action( 'avada_blog_post_content', 'avada_render_dialogue_post_content', 5 );

/* RSS Feeds */
/*-----------------------------------------------------------------------------------*/

function mith_feed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'mith_dialogue');
	return $qv;
}
add_filter('request', 'mith_feed_request');

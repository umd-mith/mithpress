<?php 
function mithpress_breadcrumbs() {
 
  $delimiter = '<span class="bc_delimiter">&gt;</span>';
  $home = '<span class="bc_home"><i>Home</i></span>'; // text for the 'Home' link
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
  
// HOME LINK
	if ( !is_home() && !is_front_page() || is_paged() ) {
		echo '<div id="crumbs">'; 
		global $post;
		$homeLink = get_bloginfo('url');
		$blogLink = home_url('/blog/');
		echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
// CATEGORY 
	if ( is_category() ) {
		global $wp_query;
		$cat_obj = $wp_query->get_queried_object();
		$thisCat = $cat_obj->term_id;
		$thisCat = get_category($thisCat);
		$parentCat = get_category($thisCat->parent);
		echo $before . '<a href="' . $blogLink . '">Blog</a> ' . $delimiter;
			if ($thisCat->parent != 0) 
			echo ( get_category_parents( $parentCat, TRUE, ' ' . $delimiter . ' ') );
		echo single_cat_title('', false) . ' Category Archive' . $after;

 // BLOG PAGED
	} elseif ( is_paged() && is_home()) { 
		echo $before . '<a href="' . $blogLink . '">Blog</a> ';

 // CUSTOM POST TYPE ARCHIVE PAGES 
	} elseif ( is_post_type_archive() ) {
    	echo $before . post_type_archive_title() . $after;
	
	} elseif (is_tax('staffgroup') ) { // past staff page
		global $wp_query;
		$term = $wp_query->get_queried_object();
		$title = $term->name;
		//$post_type = get_post_type_object(get_post_type() );
		echo '<a href="' . $homeLink . '/people/">People</a> ' . $delimiter . ' ';
		echo $before . $title . $after;
		
	} elseif( is_tax('projecttype') ) {
		global $wp_query;
		$term = $wp_query->get_queried_object();
		$title = $term->name;
		echo '<a href="' . $homeLink . '/research">Research</a>' . $delimiter . ' ';
		echo $before . $title . $after;

/* 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
*/

// SINGLE POSTS (not attachments)
    } elseif ( is_single() && !is_attachment() ) {
		
		// Project Posts
		if ( 'project' == get_post_type() ) {
			$post_type = get_post_type_object(get_post_type());
			echo '<a href="' . $homeLink . '/research/">' . $post_type->labels->name . '</a> ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} // People Posts
		elseif ( 'people' == get_post_type() ) {
			$post_type = get_post_type_object( get_post_type() );
			echo '<a href="' . $homeLink . '/people/">' . $post_type->labels->name . '</a> ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} // Podcasts
		elseif ( 'podcast' == get_post_type() ) {
			$post_type = get_post_type_object( get_post_type() );
			echo '<a href="' . $homelink . '/digitaldialogues/">Digital Dialogues</a> ' . $delimiter . ' ';
			echo '<a href="' . $homeLink . '/podcasts/">' . $post_type->labels->name . '</a> ' . $delimiter . ' ';
			$ptitle = get_the_title();
			echo $before . truncateWords($ptitle, 14, " . . .") . $after;
		} // Events
		elseif ( 'event' == get_post_type() ) {
			$post_type = get_post_type_object( get_post_type() ); ?>
            <a href="<?php echo $homeLink; ?>/community/">Community</a>
            <?php echo $delimiter; ?> 
            <a href="<?php $homeLink; ?>/community/dh-events/">DH Events</a>
            <?php echo $delimiter . ' ';
			echo $before . get_the_title() . $after;
			
		} // Non-blog Posts 
		elseif ( get_post_type() != 'post' ) {
			$post_type = get_post_type_object( get_post_type() );
			$slug = $post_type->rewrite;
			echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->name . '</a> ' . $delimiter . ' ';
			$nbtitle = get_the_title();
			echo $before . truncateWords($nbtitle, 13, " . . .") . $after;
		} // Blog Posts 
		else {
			echo '<a href="' . $blogLink . '">Blog</a> ' . $delimiter . ' ';
			/*$cat = get_the_category(); $cat = $cat[0];
			echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' '); */
			$btitle = get_the_title();
			echo $before . truncateWords($btitle, 15, " . . .") . $after;
}
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() && !is_search()) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
	} elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;

    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;

    } elseif ( is_search() ) {
      echo $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Articles posted by ' . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
    }
 
    if ( get_query_var('paged') ) {
      echo __(' (Page') . ' ' . get_query_var('paged') . ')';
    }
 
    echo '</div>';
 
  }
  elseif ( is_home() ) {  
	echo '<div id="crumbs">';
	echo '<a href="' . get_bloginfo('url') . '">' . $home . '</a> ' . $delimiter . ' Blog';
	echo '</div>';
  }

	  
} // end mithpress_breadcrumbs()
?>
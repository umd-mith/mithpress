<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Post Navigation
- Custom Post Type Support
- Reading and Excerpts
- Remove empty paragraph tags
- Preserve Post formatting in Excerpt 
- Conditional Tags for Custom Taxonomy Pages
- Sidebar Posts for specific Tag
- Search Functions

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Post Navigation */
/*-----------------------------------------------------------------------------------*/
function mithpress_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) { ?>
    
		<nav id="<?php echo $nav_id; ?>" class="post-navigation clear">
	
    		<h3 class="assistive-text"><?php _e( 'Post navigation', 'mithpress' ); ?></h3>
			<?php
                $prev_post = get_adjacent_post(false, '', true);
                $next_post = get_adjacent_post(false, '', false); ?>

                <?php if ($prev_post) : $prev_post_url = get_permalink($prev_post->ID); $prev_post_title = $prev_post->post_title; ?>
                    <a class="post-prev" href="<?php echo $prev_post_url; ?>"><em>Previous post</em><span><?php echo $prev_post_title; ?></span></a>
                <?php endif; ?>

                <?php if ($next_post) : $next_post_url = get_permalink($next_post->ID); $next_post_title = $next_post->post_title; ?>
                    <a class="post-next" href="<?php echo $next_post_url; ?>"><em>Next post</em><span><?php echo $next_post_title; ?></span></a>
                <?php endif; ?>

                <div class="line"></div>

            </div>
            
		</nav>

	<?php } 
}


/*-----------------------------------------------------------------------------------*/
/* Custom Post Type Support */
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'post-formats', array( 'aside', 'podcast', 'project', 'people', 'event' ) );


/* Custom Post Type Navigation Classes */
/*-----------------------------------------------------------------------------------*/

function remove_parent($var)
{
	// check for current page values, return false if they exist.
	if ($var == 'current_page_item' || $var == 'current_page_parent' || $var == 'current_page_ancestor'  || $var == 'current-menu-item') { return false; }

	return true;
}

function current_type_nav_class($classes, $item)
{
    $post_type = get_query_var('post_type');

	// your custom post type name
	if ( !is_home() ) { 
		if (get_post_type() == 'people' || get_post_type() == 'project' || get_post_type() == 'podcast' || get_post_type() == 'event' || get_post_type() == 'job' || is_tax('projecttype') || is_tax('staffgroup') || is_tax('event_type') || is_post_type_archive('people') ||  is_post_type_archive('event') ) {
			// we're viewing a custom post type, so remove the 'current_page_xxx and current-menu-item' from all menu items.
			$classes = array_filter($classes, "remove_parent");
	
			// add the current page class to items labeled with post-type in "relationship" field.
			if ($item->xfn != '' && $item->xfn == $post_type) {
				array_push($classes, 'current-menu-item');
			}
		}
	}

	return $classes;
}

add_filter('nav_menu_css_class', 'current_type_nav_class', 10, 2 );



/* Meta Box Title Changes */
/*-------------------------------------------------------------------------------------------*/

add_filter('gettext', 'admin_custom_rewrites', 10, 4);

function admin_custom_rewrites($translation, $text, $domain) {
	global $post;
        if ( ! isset( $post->post_type ) ) {
            return $translation;
        }
	$translations = &get_translations_for_domain($domain);
	$translation_array = array();
 
	switch ($post->post_type) {
		case 'people': 
			$translation_array = array(
				'Enter title here' => 'Enter full name here',
				'Featured Image' => 'Bio Picture',
				'Set featured image' => 'Assign image'
			);
			break;
		case 'podcast': 
			$translation_array = array(
				'Enter title here' => 'Enter talk title here',
				'Featured Image' => 'Speaker Photo',
				'Set featured image' => 'Assign image'
			);
			break;
		case 'project': 
			$translation_array = array(
				'Enter title here' => 'Enter project title here',
				'Featured Image' => 'Project Thumbnail',
				'Set featured image' => 'Assign image'
			);
			break;
		case 'event': 
			$translation_array = array(
				'Enter title here' => 'Enter event title here',
				'Featured Image' => 'Event Thumbnail',
				'Set featured image' => 'Assign image'
			);
			break;
		case 'job': 
			$translation_array = array(
				'Enter title here' => 'Enter job title here',
			);
			break;
	}
 
	if (array_key_exists($text, $translation_array)) {
		return $translations->translate($translation_array[$text]);
	}
	return $translation;
}

/*-----------------------------------------------------------------------------------*/
/* Reading & Excerpts */
/*-----------------------------------------------------------------------------------*/

/* Remove empty paragraph tags from the_content */
/*-----------------------------------------------------------------------------------*/
function removeEmptyParagraphs($content) {

    /*$pattern = "/<p[^>]*><\\/p[^>]*>/";   
    $content = preg_replace($pattern, '', $content);*/
    $content = str_replace("<p></p>","",$content);
    return $content;
}

add_filter('the_content', 'removeEmptyParagraphs', 7);


/* Automatically Generated Excerpt */
/* -------------------------------------------------------------------------
1. Option to generate a variable Length Excerpt.
2. Option to generate a fixed Length Excerpt. Complete the sentence in the Excerpt.
3. Option to add a 'Continue Reading' link to the text (Excerpt ending).
4. Option to add an unlinked Ellipsis to the text (Excerpt ending).
5. Option to preserve ALL, SOME, or NONE of the HTML formatting in the Excerpt.
6. The Code counts 'real words'. Does not count the HTML tags or their content.
7. Advantage of step 6: No opened HTML tags in the Excerpt.
8. Code Ignores Manual Excerpts and use the auto-generated one instead.
*  @Tested on: WordPress version 3.3.2
/* -------------------------------------------------------------------------*/
 
function mithpress_variable_length_excerpt($text, $length, $finish_sentence){
	global $post;
	//Word length of the excerpt. This is exact or NOT depending on your '$finish_sentence' variable.
	if (is_home() && !is_page_template('content-home-right') ) : $length = 180;
	elseif (is_page_template('content-home-right') || is_search()) : $length = 75;
	elseif (is_page_template('content-podcasts') ) : $length = 30;
	else : $length = 55; /* Change the Length of the excerpt as you wish. The Length is in words. */
	endif;
	
	//1 if you want to finish the sentence of the excerpt (No weird cuts).
	$finish_sentence = 1; // Put 0 if you do NOT want to finish the sentence.
	
	$tokens = array();
	$out = '';
	$word = 0;
	
	//Divide the string into tokens; HTML tags, or words, followed by any whitespace.
	$regex = '/(<[^>]+>|[^<>\s]+)\s*/u';
	preg_match_all($regex, $text, $tokens);
	foreach ($tokens[0] as $t){
		//Parse each token
		if ($word >= $length && !$finish_sentence){
			//Limit reached
			break;
		}
		if ($t[0] != '<'){
			//Token is not a tag.
			//Regular expression that checks for the end of the sentence: '.', '?' or '!'
			$regex1 = '/[\?\.\!]\s*$/uS';
			if ($word >= $length && $finish_sentence && preg_match($regex1, $t) == 1){
				//Limit reached, continue until ? . or ! occur to reach the end of the sentence.
				$out .= trim($t);
				break;
			}
			$word++;
		}
		//Append what's left of the token.
		$out .= $t;
	}
	$out = preg_replace("/<img(.*?)>/si", "", $out);
	
	//Add the excerpt ending as a link.
	$excerpt_end = ' . . . <a href="'. get_permalink($post->ID) . '" class="readmore">'  . __( 'Continue Reading', 'mithpress' ) . '</a>';
	
	//Add the excerpt ending as a non-linked ellipsis with brackets.
	//$excerpt_end = ' [&hellip;]';
	
	//Append the excerpt ending to the token.
	$out .= $excerpt_end;
	
	return trim(force_balance_tags($out));
}
 
function mithpress_excerpt_filter($text){
    //Get the full content and filter it.
    $text = get_the_content('');
    $text = strip_shortcodes( $text );
    $text = apply_filters('the_content', $text);

    $text = str_replace(']]>', ']]&gt;', $text);
 
    /**By default the code allows all HTML tags in the excerpt**/
    //Control what HTML tags to allow: If you want to allow ALL HTML tags in the excerpt, then do NOT touch.
 
    //If you want to Allow SOME tags: THEN Uncomment the next line + Line 80.
    $allowed_tags = '<p>,<em>,<i>,<b>,<strong>,<a>,<ul>,<li>,<ol>,<blockquote>,<code>,<span>'; /* Separate tags by comma. */
 
    //If you want to Disallow ALL HTML tags: THEN Uncomment the next line + Line 80,
    //$allowed_tags = ''; /* To disallow all HTML tags, keep it empty. The Excerpt will be unformated but newlines are preserved. */
    //$text = strip_tags($text, $allowed_tags); /* Line 80 */
 
	//Word length of the excerpt. This is exact or NOT depending on your '$finish_sentence' variable.
	$finish_sentence = 1;
	if (is_home() && !is_page_template('content-home-right') ) : $length = 180;
	elseif (is_page_template('content-home-right') ) : $length = 75;
	elseif (is_page_template('content-podcasts') ) : $length = 30;
	else : $length = 55; /* Change the Length of the excerpt as you wish. The Length is in words. */
	endif;

	//Create the excerpt.
    $text = mithpress_variable_length_excerpt($text, $length, $finish_sentence);
    return $text;
}
// Hooks the 'mithpress_excerpt_filter' function to a specific (get_the_excerpt) filter action.

add_filter('get_the_excerpt','mithpress_excerpt_filter',5);


/*-----------------------------------------------------------------------------------*/
/* Truncate long strings */
/*-----------------------------------------------------------------------------------*/
function truncateWords($input, $numwords, $padding="")
{
	$output = strtok($input, " \n");
	while(--$numwords > 0) $output .= " " . strtok(" \n");
	if($output != $input) $output .= $padding;
	return $output;
}


/*-----------------------------------------------------------------------------------*/
/* DISPLAY TAGGED POSTS IN SIDEBAR */
/*-----------------------------------------------------------------------------------*/

function mithpress_display_tagged_posts() {
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
    <div id="project_posts" class="widget widget_recent_posts">
    
    	<h3>Related Blog Posts</h3>
    
        <aside class="widget-body clear">
    
            <ul id="blog-feed">
    
            <?php while ( $tagged->have_posts() ) : $tagged->the_post(); ?>
    
                <li>
                	<a href="<?php echo get_permalink(); ?>" class="rpost clear">
                        <span class="rpost-title"><?php echo get_the_title(); ?></span>
                        <span class="rpost-date"><?php the_time(__('M j, Y')) ?></span>
                    </a>
                </li>
    
            <?php endwhile; ?>
    
            </ul>
   
        </aside>
   
    </div>
   
    <?php endif; wp_reset_query();
	
	}
}

/*-----------------------------------------------------------------------------------*/
/* RSS FEEDS */
/*-----------------------------------------------------------------------------------

*/
/*-----------------------------------------------------------------------------------*/
/* Search */
/*-----------------------------------------------------------------------------------*/

function search_content_highlight() {
	$content = get_the_content();
	$keys = implode('|', explode(' ', get_search_query()));
	$content = preg_replace('/(' . $keys .')/iu', '<strong class="search-highlight">\0</strong>', $content);

	echo '<p>' . $content . '</p>';
}

function search_title_highlight() {
    $title = get_the_title();
    $keys = implode('|', explode(' ', get_search_query()));
    $title = preg_replace('/(' . $keys .')/iu', '<strong class="search-highlight">\0</strong>', $title);

    echo $title;
}
function search_excerpt_highlight() {
    $excerpt = get_the_excerpt();
    $keys = implode('|', explode(' ', get_search_query()));
    $excerpt = preg_replace('/(' . $keys .')/iu', '<strong class="search-highlight">\0</strong>', $excerpt);

    echo '<p>' . $excerpt . '</p>';
}
?>
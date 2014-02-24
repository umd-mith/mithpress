<?php 
/**
 * The template for displaying content in the single-people.php templates
 *
**/
?>
<?php 

$title = get_post_meta($post->ID, 'person_title', true);
$email = get_post_meta($post->ID, 'person_email', true);
$twitter = get_post_meta($post->ID, 'person_twitter_handle', true);
$phone = get_post_meta($post->ID, 'person_phone', true);
$website = get_post_meta($post->ID, 'person_website', true);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">

        <div id="personal-info" class="append-bottom clear">
        
			<?php the_post_thumbnail( 'med-thumbnail' ); ?>
        
        	<h1 class="entry-title"><?php the_title(); ?></h1>
            
            <h2 class="info-title"><?php echo $title ?></h2>
            
			<?php if ( $email != '') { ?>
            <span class="info-email"><a href="mailto:<?php echo $email; ?>" rel="nofollow"><?php echo $email; ?></a></span>
            
			<?php } if ( $twitter != '') { ?>
            <span class="info-twitter"><a href="http://www.twitter.com/<?php echo $twitter ?>" rel="nofollow" target="_blank">@<?php echo $twitter ?></a></span>	
            
			<?php } if ( $phone != '') { ?>
            <span class="info-phone"><?php echo $phone ?></span>
            
			<?php } if ( $website != '') { ?>
            <span class="info-website"><a href="http://<?php echo $website ?>" rel="nofollow" target="_blank">my website</a></span>
            <?php } ?>

        </div>
        <!-- /personal-info -->
        
        <div id="bio">
        
            <?php the_content(); ?>
        
        </div>
        <!-- /bio -->
    
        <?php 
		$person_links = get_field('person_links', $post->ID);
			if( get_field('person_links') ) :
			
			$i = 0;
			$count = $person_links;
					
			if ( $count != 0 ) { // have one or more link ?>
            <div id="info-links" class="column right prepend-top">
                
                <h2 class="column-title">Links</h2>
    
                    <ul>
			<?php } ?>

			<?php while(has_sub_field('person_links')):
				$linky = get_sub_field('person_link_url'); 
				$linky_title = get_sub_field('person_link_title');
				?>
                <li>
                <a href="<?php echo $linky; ?>"><?php if ($linky_title != '') { echo $linky_title; } else { echo $linky; } ?></a>
                </li>
				
			<?php $i++;
			endwhile; // end link
        
            if ( $count > 0 ) { // have one or more links, so close the list ?>
            	</ul>
            </div>
            <?php } ?>
        
        <!-- /info-links -->          
        <?php endif; // end links ?>    	
        
	<?php 

	$blogrss = get_post_meta($post->ID, 'person_blog_rss_feed', true);
		
	if ( $blogrss != '') { ?>
        
        <div id="personal-blog-feed" class="column right prepend-top">
        
            <h2 class="column-title"><?php _e('Personal Blog Posts'); ?></h2>
            
			<?php // Get RSS Feed(s)
            
			include_once(ABSPATH . WPINC . '/feed.php');
            
            // Get a SimplePie feed object from the specified feed source.
			$blogrss = get_post_meta($post->ID, 'person_blog_rss_feed', true);
            $rss = fetch_feed( $blogrss );
            
			if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
            
				// Figure out how many total items there are, but limit it to 5. 
                $maxitems = $rss->get_item_quantity(5); 
            
                // Build an array of all the items, starting with element 0 (first element).
                $rss_items = $rss->get_items(0, $maxitems); 
            
			endif;
            
			?>
            
            <ul id="blog-feed">
                <?php if ($maxitems == 0) echo '<li>No recent posts.</li>';
                else
				// Loop through each feed item and display each item as a hyperlink.
                
				foreach ( $rss_items as $item ) : ?>
                
                <li>
                	<a href="<?php echo esc_url( $item->get_permalink() ); ?>" title="Permanent Link to <?php echo esc_html( $item->get_title() ); ?>" class="rpost clear" target="_blank">
                        <span class="rpost-title"><?php echo esc_html( $item->get_title() ); ?></span>
                        <span class="rpost-date"><?php echo $item->get_date('M j, Y'); ?></span>
					</a>
                </li>
                
				<?php endforeach; ?>
            
            </ul>
            
            <div id="blog-more">
        
            	<?php $blogcat = get_post_meta($post->ID, 'person_blog_url', true); ?>
        
                <a href="<?php echo $blogcat ?>" target="_blank" class="readmore">More Posts</a>
                <a href="<?php echo $blogrss ?>" target="_blank" class="rss">Subscribe</a>
            
            </div>
        
        </div>
        <!-- /blog-feed --> 
        
		<?php } ?>
        
	</div>
    <!-- /entry-content -->
    
    <br clear="all" />
	
	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); wp_reset_query(); ?>

</article>
<!-- /post-<?php the_ID(); ?> -->
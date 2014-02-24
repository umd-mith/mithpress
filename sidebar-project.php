<div id="sidebar" class="project widget-area span-5 prepend-1 append-bottom last" role="complementary">

<?php

$website = get_field('project_website_url', $post->ID);
$contact = get_field('project_contact_name', $post->ID);
$email = get_field('project_contact_email', $post->ID); 
$twit = get_field('project_twitter_account', $post->ID);
$hash = get_field('project_twitter_hashtag', $post->ID);
$twitcode = get_field('project_twitter_code', $post->ID); 

?>
	
    <!-- Project Website -->
    <?php if ( $website != '') { ?>
    
    <div id="project-website" class="widget widget_pwebsite">
    
        <h3><?php _e( 'Project Website', 'mithpress' ); ?></h3>
    
        <aside class="widget-body clear">
            <p>View the website associated with this project
            <a href="http://<?php echo $website ?>" rel="nofollow" target="_blank" class="launch">Launch Website</a>
            </p>
        </aside>
    
    </div>
    <?php } ?>
    
    <!-- Project Contact -->
    <?php if ( $contact != '' && $email != '') { ?>
	
    <div id="project-contact" class="widget widget_pcontact">
    
        <h3><?php _e( 'Project Contact', 'mithpress' ); ?></h3>
    
        <aside class="widget-body clear">
            <p>
            <a href="mailto:<?php echo $email; ?>" rel="nofollow" target="_blank" class="proj-contact"><?php echo $contact ?></a>
            </p>
        </aside>
    
    </div>
    <?php } ?>

    
    <!-- Project Posts -->
	<?php mithpress_display_tagged_posts(); ?>


	<!-- Project Tweets -->
	<?php if ( $twitcode != '') { ?>
    
    <div id="recent_tweets" class="widget widget_recent_tweets">
        <h3>Recent Tweets</h3>
        <aside class="widget-body clear">
            <?php echo $twitcode; ?>
            
            <?php if ($twit != '' || $hash != '') { ?> 
            <div class="twitter-more">
            	<?php if ($twit != '') { ?>
                <a href="http://www.twitter.com/<?php echo $twit ?>" rel="nofollow" target="_blank" class="follow">Follow @<?php echo $twit; ?></a>
                <?php } elseif ($hash != '') { ?>
                <a href="http://www.twitter.com/search?q=%23<?php echo $hash ?>" rel="nofollow" target="_blank" class="follow">Follow #<?php echo $hash; ?></a>
                <?php } ?>
            </div>
            <?php } ?>
        </aside>
    </div>
    
    <?php } ?>
    <!-- /recent_tweets -->

</div>
<!-- #secondary .widget-area -->
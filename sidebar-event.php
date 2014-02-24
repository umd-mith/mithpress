<div id="sidebar" class="event widget-area span-5 prepend-1 append-bottom last" role="complementary">

<?php

$event_website = get_field('event_website');
$event_contact = get_field('event_contact_name'); 
$event_email = get_field('event_contact_email');

$event_twit = get_field('event_twitter_account'); 
$event_hash = get_field('event_twitter_hashtag');
    
?>
    <!-- Event Website -->
	<?php if ( $event_website != null ) { ?>
 
    <div id="event-website" class="widget widget_ewebsite">
 
        <h3><?php _e( 'Website', 'mithpress' ); ?></h3>
 
        <aside class="widget-body clear">
            <p><a href="http://<?php echo $event_website; ?>" rel="nofollow" target="_blank" class="launch">Launch Website</a></p>
        </aside>
 
    </div>
 
    <?php } ?>
    
    <!-- Event Contact -->
	<?php if ($event_contact != null && $event_email != null ) { ?>
    
	<div id="event-contact" class="widget widget_econtact">
    
        <h3><?php _e( 'Contact', 'mithpress' ); ?></h3>
    
        <aside class="widget-body clear">
            <p><a href="mailto:<?php echo $event_email; ?>" rel="nofollow" target="_blank" class="event-contact"><?php echo $event_contact; ?></a></p>
        </aside>
    
    </div>
    
	<?php } ?>
    
    
	<?php if ( $event_twit != '' || $event_hash != '') { ?>
	<!-- Event Connect -->
    
    <div id="event-connect" class="widget widget_connect">
        <h3>Connect</h3>
        <aside class="widget-body clear">
			<?php if ( $event_twit ) : ?>
			<a href="https://twitter.com/<?php echo $event_twit; ?>" class="event-twitter" target="_blank">Follow @<?php echo $event_twit; ?></a><br />
            <?php endif; ?>
            <?php if ( $event_hash ) : ?>
			<a href="https://twitter.com/search?q=%23<?php echo $event_hash ?>" class="event-hashtag" target="_blank">See #<?php echo $event_hash; ?> Tweets</a>
            <?php endif; ?>
		</aside>
    </div>
    <!-- /projct-connect-->
    
    <?php } ?>

    <!-- Event Posts -->
	<?php mithpress_display_tagged_posts(); ?>



</div>
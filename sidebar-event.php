<div id="sidebar" class="event widget-area span-5 prepend-1 append-bottom last" role="complementary">

<?php

global $event_mb;
$event_mb->the_meta();
$website = $event_mb->get_the_value('website'); 
$name = $event_mb->get_the_value('contactname');
$email = $event_mb->get_the_value('contactemail'); 
$twit = $event_mb->get_the_value('twitter');
$hash = $event_mb->get_the_value('hashtag');
    
?>
    <!-- Event Website -->
	<?php if ( $website != null ) { ?>
 
    <div id="event-website" class="widget widget_ewebsite">
 
        <h3><?php _e( 'Website', 'mithpress' ); ?></h3>
 
        <aside class="widget-body clear">
            <p><a href="http://<?php echo $website; ?>" rel="nofollow" target="_blank" class="launch">Launch Website</a></p>
        </aside>
 
    </div>
 
    <?php } ?>
    
    <!-- Event Contact -->
	<?php if ($name != null && $email != null ) { ?>
    
	<div id="event-contact" class="widget widget_econtact">
    
        <h3><?php _e( 'Contact', 'mithpress' ); ?></h3>
    
        <aside class="widget-body clear">
            <p><a href="mailto:<?php echo $email; ?>" rel="nofollow" target="_blank" class="event-contact"><?php echo $name; ?></a></p>
        </aside>
    
    </div>
    
	<?php } ?>
    
    
    <!-- Event Posts -->
	<?php mithpress_display_tagged_posts(); ?>


	<!-- Event Tweets -->
<?php if ( !has_term('past-event', 'event_type') ) { 
	
	if ( $twit != '' ){ ?>
    
    <div id="recent_tweets" class="widget widget_recent_tweets">
        <h3>Recent Tweets</h3>
        <aside class="widget-body clear">
            <script src="http://widgets.twimg.com/j/2/widget.js"></script>
            <script>
            new TWTR.Widget({
              version: 2,
              type: 'profile',
              rpp: 10,
              interval: 8000,
              width: 190,
              height: 300,
              theme: {
                shell: {
                  background: '#ffffff',
                  color: '#ffffff'
                },
                tweets: {
                  background: '#ffffff',
                  color: '#242424',
                  links: '#2e7cc6'
                }
              },
              features: {
                scrollbar: false,
                loop: true,
                live: true,
                behavior: 'default'
              }
            }).render().setUser('<?php echo $twit; ?>').start();
            </script>
            <div class="twitter-more">
                <a href="http://www.twitter.com/#!/<?php echo $twit ?>" rel="nofollow" target="_blank" class="follow">Follow</a>
            </div>
        </aside>
    </div>
    <?php }
	
	if ($hash != '') {?>
    <div id="recent_tweets" class="widget widget_recent_tweets">
        <h3>Recent Tweets</h3>
        <aside class="widget-body clear">
			<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
            <script>
            new TWTR.Widget({
              version: 2,
              type: 'search',
              search: '<?php echo $hash ?>',
              interval: 8000,
              title: '',
              subject: '',
              width: 190,
              height: 300,
              theme: {
                shell: {
				  background: '#ffffff',
                  color: '#ffffff'
                },
                tweets: {
				  background: '#ffffff',
				  color: '#242424',
				  links: '#2e7cc6'
                }
              },
              features: {
                scrollbar: false,
                loop: true,
                live: true,
                behavior: 'default'
              }
            }).render().start();
            </script>
		</aside>
    </div>
    
    <?php } // end twitter 
} // end past event check ?>


</div>
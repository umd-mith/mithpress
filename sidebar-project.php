<div id="sidebar" class="project widget-area span-5 prepend-1 append-bottom last" role="complementary">

<?php
global $project_mb;
$project_mb->the_meta();
$website = $project_mb->get_the_value('website');
$contact = $project_mb->get_the_value('contactname');
$twit = $project_mb->get_the_value('twitter');
$hash = $project_mb->get_the_value('hashtag');

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
    <?php if ( $contact != '') { ?>
	
    <div id="project-contact" class="widget widget_pcontact">
    
        <h3><?php _e( 'Project Contact', 'mithpress' ); ?></h3>
    
        <aside class="widget-body clear">
            <p>
            <a href="mailto:<?php $project_mb->the_value('contactemail'); ?>" rel="nofollow" target="_blank" class="proj-contact"><?php echo $contact ?></a>
            </p>
        </aside>
    
    </div>
    <?php } ?>

    
    <!-- Project Posts -->
	<?php mithpress_display_tagged_posts(); ?>


	<!-- Project Tweets -->
	<?php if ( $twit != '') { ?>
    
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
    <!-- /recent_tweets -->
    
    <?php } ?>

</div>
<!-- #secondary .widget-area -->
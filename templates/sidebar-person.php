<div id="sidebar" <?php Avada()->layout->add_class( 'sidebar_1_class' ); ?> style="float: right; float: left;">
	<?php generated_dynamic_sidebar('People Grid'); ?>
</div>
<?php if ( is_singular('mith_person') ) : ?>
<div id="sidebar-2" <?php Avada()->layout->add_class( 'sidebar_2_class' ); ?> style="float: left;">
    <?php echo mith_display_blog_posts(); 
    /*
    $twitter = get_post_meta($post->ID, 'person_twitter_handle', true);
    $twitter_id = get_post_meta($post->ID, 'person_twitter_id', true);
    $twitter_code = get_post_meta($post->ID, 'person_twitter_widget_code', true);
    
    if ( ($twitter != '' && $twitter_id != '') || $twitter_code != '' ) : ?>
    <div id="recent_tweets" class="widget widget_recent_tweets">
        <div class="heading"><h3><?php _e('Recent Tweets', 'Avada'); ?></h3></div>
        <?php if ($twitter_code != '') :
            echo $twitter_code;
        elseif ($twitter != '' && $twitter_id != '') : ?>
            <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/<?php echo $twitter; ?>" data-widget-id="<?php echo $twitter_id; ?>" data-chrome="nofooter noheader transparent" border-color="#ffffff" data-link-color="#2e7cc6">Tweets by @<?php echo $twitter; ?></a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        <?php endif; ?>

        <?php if ($twitter != '') : ?>
            <a href="https://twitter.com/<?php echo $twitter; ?>" class="twitter-follow-button" data-show-count="false" data-dnt="true">Follow @<?php echo $twitter ?></a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>     
        <?php endif; ?> 
    </div>
    <?php endif; */ ?>
</div>
<?php endif; ?>
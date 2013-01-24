<?php if ( is_single() ) { ?>
<div id="sidebar" class="blog widget-area span-5 prepend-top-2 append-bottom last" role="complementary">

<?php } else { ?>
<div id="sidebar" class="blog widget-area span-5 append-bottom last" role="complementary">

<?php } ?>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Blog Sidebar') ); ?>

<div id="recent_tweets" class="widget widget_recent_tweets">
        <h3><!--<a href="http://www.twitter.com/#!/digdialog" rel="nofollow" target="_blank" class="follow">&nbsp;</a>-->Recent Tweets</h3>
        <aside class="widget-body clear">
    
			<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
            <script>
            new TWTR.Widget({
              version: 2,
              type: 'search',
              search: 'umd_mith',
              interval: 10000,
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
    <a href="https://twitter.com/umd_mith" class="twitter-follow-button" data-show-count="true">Follow @umd_mith</a>
    
	<script>
	!function(d,s,id){
		var js,fjs=d.getElementsByTagName(s)[0];
		if(!d.getElementById(id)) {
			js=d.createElement(s);
			js.id=id;
			js.src="//platform.twitter.com/widgets.js";
			fjs.parentNode.insertBefore(js,fjs);
		}
	} (document,"script","twitter-wjs");
    </script>                
    </div>
    
</div>
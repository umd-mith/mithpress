<div id="sidebar" class="ddialogue widget-area span-5 prepend-1 append-bottom last" role="complementary">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ddialogues') ); ?>

    <div id="recent_tweets" class="widget widget_recent_tweets">
        
        <h3>Recent Tweets</h3>
        
        <aside class="widget-body clear">
    
                <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
                <script>
                new TWTR.Widget({
                  version: 2,
                  type: 'search',
                  search: 'mithdd OR digdialog from:digdialog',
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
                    loop: false,
                    live: true,
                    behavior: 'default'
                  }
                }).render().start();
                </script>

        </aside>
        
    </div>
    
    <a href="https://twitter.com/digdialog" class="twitter-follow-button" data-show-count="true">Follow @digdialog</a>
    
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
    <!-- /recent_tweets -->
    
</div>
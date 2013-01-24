		<div id="sharing" class="column-sharing column right prepend-top">
        
        	<h2 class="column-title">Share</h2>

            <div class="tw-link share-button">
                <a href="https://twitter.com/share" class="twitter-share-button" data-via="UMD_MITH" data-text="<?php the_title(); ?>" data-url="<?php the_permalink(); ?>">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];
                if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";
                fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div>
    
            <div class="fb-like share-button" data-href="http://mith.umd.edu/" href="<?php echo get_permalink($post->ID); ?>" data-send="true" data-layout="button_count" data-width="120" data-show-faces="false" data-font="arial"></div>
			
            <div class="g-plus1 share-button">
                <div class="g-plusone" data-size="medium"></div>
            </div>

            <div class="addthis_toolbox addthis_default_style ">  
                <div class="addthis_item at_email"><a class="addthis_button_email">Email</a></div>
                <div class="addthis_item at_print"><a class="addthis_button_print">Print</a></div>
                <div class="addthis_item at_share"><a class="addthis_button_compact">Share</a></div>
            </div>
            <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4fe3704f562980c7"></script>

        </div>

        <script type="text/javascript">
          (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
          })();
        </script>
        <!-- /sharing -->

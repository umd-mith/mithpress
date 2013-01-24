<footer>
<div id="footer">
<div id="footer-top">
	<div class="width-limit">
    	<?php /*wp_nav_menu( array( 
			'theme_location' => 'footer', 
			'container' => 'false'
		) ); */ ?>
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footerwidgets') ); ?>
        <!--/quicklinks-->
		
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('contact') ); ?>
        <!--/contact-->
        <div class="clear"></div>
    </div>
</div>
<!--/#footer-top-->
    
<div id="footer-bottom">
	<div class="width-limit">
    	<div class="left">
        	<a class="footer_link_img" href="http://www.arhu.umd.edu/" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/logo_arhu.png" alt="College of Arts and Humanities" /></a>
		</div>
        <!--/left-->
        
        <div class="right">
            <a class="footer_link_img" href="http://mith.umd.edu" target="_top"><img src="<?php bloginfo('template_directory'); ?>/images/logo_mith_bug_skinny.png" alt="MITH: Maryland Institute for Technology in the Humanities" /></a>
			<div class="copyright">Copyright &copy; 2011-<?php echo date('Y'); ?>, Maryland Institute for Technology in the Humanities</div>
			<?php wp_nav_menu( array(
				'theme_location' => 'footer-textlinks',
				'container' => 'false'
            ) ); ?>
            <a href="<?php bloginfo('rss2_url'); ?>" target="_blank" class="footer-subscribe">Subscribe to MITH (RSS)</a>
            </div>
        </div>
        <!--/right-->
        <div class="clear"></div>
	</div>
</div>
<!--/#footer-bottom-->
</div>
</footer>
<?php wp_footer(); ?>
<!-- /footer -->

<div id="fb-root"></div>

<!-- facebook and google plus scripts -->

<script type="text/javascript">
  (function() {
	var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	po.src = 'https://apis.google.com/js/plusone.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

</body>
</html>

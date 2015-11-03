<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
<!--<![endif]-->

<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    
    <title><?php
    /* Print the <title> tag based on what is being viewed.*/
    global $page, $paged;
    wp_title('');
    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
        echo ' | ' . sprintf( __( 'Page %s', 'mithpress' ), max( $paged, $page ) );
    ?></title>
    
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" />
	<link rel="stylesheet" href="http://www.umd.edu/wrapper/css/xhtml-960px.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/screen.css" type="text/css" media="screen, projection, print" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	 <!--<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="/feed.xml">-->
	<?php if (is_front_page() ) { ?> 
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/slider.css" type="text/css" media="screen, projection, print" />
	<?php } ?>      
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php if ((is_single() && 'people' == get_post_type()) && has_term( array( 'people-past-directors', 'people-past-staff', 'people-past-research-associates', 'people-past-finance-administration', 'people-past-resident-fellows' ), 'staffgroup' ) ) : ?>
	<meta name="robots" content="noindex,nofollow"/>
    <?php endif; ?>    
    <?php if ( is_singular() && get_option( 'thread_comments' ) )
            wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_head(); ?>
    
	<?php if (is_single() && 'post' == get_post_type() ) { ?>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<?php } ?>

	<?php if (is_front_page() ) { ?> 
	<script>jQuery.noConflict();</script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.nivo.slider.pack.js"></script>

    <script type="text/javascript">
    jQuery(window).load(function() {
        jQuery('#slider').nivoSlider({
         effect: 'fade',
         animSpeed: 700,
         pauseTime: 5000,
         controlNav: false,
         captionOpacity: 0.9,
         randomStart: true
        });
    });
    </script>
    <?php } ?> 
	<?php if (is_search()) { ?>
	<script type="text/javascript">
    jQuery(document).ready(function() { 
        <?php $searchkeys = implode('|', explode(' ', get_search_query())); ?>
		<?php foreach(explode(" ",$searchkeys) as $searchTerm ) : ?>
		jQuery('#posts').highlight('<?php echo $searchTerm ?>');
		<?php endforeach;?>
	});
	</script>
	<?php } ?>
    
</head>

<body <?php body_class(); ?>>

<div id="umd-wrapper">
    <div id="umd-frame">
        <div id="umd-frame-header">
            <a href="http://www.umd.edu/"><img src="http://www.umd.edu/wrapper/images/header-um-logo.gif" alt="University of Maryland" id="umd-frame-logo" /></a>
            <div id="umd-frame-header-end"></div>
        </div>
    </div>
</div>
<!-- /umd wrapper -->

<div id="top-container">
    <header id="branding" role="banner">
        <hgroup>
        	<div class="width-limit">
            <a href="<?php echo get_option('home'); ?>/" class="logo-wrap left"><img src="<?php echo get_template_directory_uri(); ?>/images/logo_mith_skinny.png" alt="MITH :: University of Maryland" /></a>
            <div class="search-wrap right"><?php get_search_form(); ?></div>
            </div>
        </hgroup>
    </header>
    <!-- /header -->
    <nav id="access" role="navigation" class="navigation">
        <div class="width-limit">
            <h3 class="assistive-text"><?php _e( 'Main menu', 'mithpress' ); ?></h3>
            <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff. */ ?>
            <div class="skip-link"><a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'mithpress' ); ?>"><?php _e( 'Skip to primary content', 'mithpress' ); ?></a></div>
            <div class="skip-link"><a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'mithpress' ); ?>"><?php _e( 'Skip to secondary content', 'mithpress' ); ?></a></div>
            <?php wp_nav_menu( array( 
                'theme_location' => 'main-menu', 
                'container_id' => 'primary-links',
                'menu_class' => 'links sf-menu', 
                'link_before' => '<span class="icon"></span><span class="label">',
                'link_after' => '</span>'
            ) ); ?>
        </div>
    </nav>
    <!-- /nav (and #access) -->
</div>
<!-- /top-container -->
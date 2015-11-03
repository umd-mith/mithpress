<nav id="subnav" class="span-5 append-1">

    <h3 class="assistive-text"><?php _e( 'Secondary menu', 'mithpress' ); ?></h3>
	
    <h1 class="append-bottom">
    
        <?php $post_type = get_post_type( $post->ID );
			$obj = get_post_type_object( $post->post_type);
			$post_terms = wp_get_object_terms( $post->ID, 'projecttype', array( 'fields' => 'names' ) );

		if ('people' == get_post_type() || 'event' == get_post_type() || 'job' == get_post_type() ) { 
			echo $obj->labels->name; 
		
		} elseif ('podcast' == get_post_type() ) {
			_e('Digital Dialogues', 'mithpress');
			
		} elseif( !is_wp_error( $post_terms ) && ( !empty( $post_terms ) ) && 'project' == get_post_type() ) {		
			if ( in_array( 'Project', $post_terms ) ) 
				// project page title
				_e('Research', 'mithpress'); 
			if( in_array( 'Workshop', $post_terms ) ) 
				// workshop page title
				_e('Workshops', 'mithpress'); 
		
		} elseif (is_tax('projecttype') ) {
			_e('Research', 'mithpress'); 
		
		} elseif (is_post_type_archive( 'people' ) || is_tax('staffgroup', 'people-past')) {
			_e('People', 'mithpress'); 
			
		} else { 
			// echo default title
			$parent_title = get_the_title($post->post_parent);
			echo $parent_title;
		} ?>

    </h1>
	<!--/subnav title-->

    <?php if (is_tree('10886') || get_post_type() == 'job' ) {
		// about page menu
        wp_nav_menu( array( 
            'theme_location' => 'about-menu', 
            'container_id' => 'sub-links',
            'menu_class' => 'links',
            'depth' => '1'
        ) ); 
		
    } elseif (get_post_type() == 'project' || is_singular('project') ) {
		$post_terms = wp_get_object_terms( $post->ID, 'projecttype', array( 'fields' => 'names' ) );
			if( !is_wp_error( $post_terms ) && ( !empty( $post_terms ) ) ) {		
				echo '<!--post is a workshop-->';
				if( in_array( 'Workshop', $post_terms ) ) { 
					echo '<ul id="sub-links">';
					wp_list_pages('title_li=&child_of=3735&depth=1');
					echo '</ul>';
				}
				// post is a project	
				if ( in_array( 'Project', $post_terms ) ) { 
				    wp_nav_menu( array( 
						'theme_location' => 'research-menu', 
						'container_id' => 'sub-links',
						'menu_class' => 'links',
						'depth' => '1'
					) ); 
				}
			}
	
    } elseif (get_post_type() == 'event' || is_singular('event') || is_page('dh-events') || is_tree('6594') ) {
		// events page (or subpage) 
				    wp_nav_menu( array( 
						'menu' => 'events', 
						'container_id' => 'sub-links',
						'menu_class' => 'links',
						'depth' => '1'
					) ); 

	} elseif (is_tree('54') || is_tax('projecttype') ) {
		// projects page (or subpage) 
        wp_nav_menu( array( 
            'theme_location' => 'research-menu', 
            'container_id' => 'sub-links',
            'menu_class' => 'links',
            'depth' => '1'
        ) ); 
		
	} elseif (is_tree('127') || 'podcast' == get_post_type() || is_singular('podcast')) {
		// podcast page (or subpage)
		wp_nav_menu( array( 
			'theme_location' => 'digital-dialogues-menu', 
			'container_id' => 'sub-links',
			'menu_class' => 'links'
		) ); 
		
	} elseif (is_post_type_archive( 'people' ) || is_tax( 'staffgroup', 'people-past') ) { 
		// people page, subpage or archive page
		wp_nav_menu( array( 
			'theme_location' => 'staff-menu', 
			'container_id' => 'sub-links',
			'menu_class' => 'links'
		) ); 
	} elseif (is_404() ) {
		echo '<ul id="sub-links"></ul>';
		
	} else  {
		?>
	<!-- default sidebar -->
	<?php // default sidebar 
	global $post; $thispage = $post->ID; // grabs the current post id from global and then assigns it to thispage ?>
		<?php $pagekids = get_pages("depth=1&child_of=".$thispage."&sort_column=menu_order"); 
		// gets a list of page that are sub pages of the current page and assigns then to pagekids ?>
		
		<?php if ($pagekids) { // if there are any values stored in pagekids and therefore the current page has subpages ?>
			<ul id="sub-links" class="sub-pages">
				<?php wp_list_pages("depth=1&title_li=&sort_column=menu_order&child_of=".$thispage); 
				// display the sub pages of the current page only ?>
			</ul>
		<?php } elseif ( $post->post_parent ) {
			$children = wp_list_pages("depth=1&title_li=&child_of=" . $post->post_parent . "&echo=0"); 
			if ( $children != '' ) { // if there are no sub pages for the current page ?>
				<ul id="sub-links"><?php echo $children; ?></ul>
            <?php } ?>
		<?php } 
	} ?>

</nav>
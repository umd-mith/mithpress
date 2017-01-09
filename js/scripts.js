jQuery(window).load(function() {
	
	var d = document.getElementById("umh-cont");
	d.className = d.className + " collapsed";
	
	//var e = document.getElementById("umh-main");
	//e.css("display") == "none";
	jQuery('#umh-main').css('display','none');
	jQuery('body').css("padding-top", '30px');
	
	
});

var selectedBox = null;

jQuery(document).ready(function() {
    jQuery('.filter_input').click(function() {
        selectedBox = this.id;

        jQuery('.filter_input').each(function() {
            if ( this.id === selectedBox )
            {
                this.checked = true;
            }
            else
            {
                this.checked = false;
            }       
        });
		
        jQuery('#gform_2').submit();
        
    });    
});

// Handle the portfolio filter clicks
	jQuery('.fusion-portfolio .fusion-filters a').click( function( e ) {
		e.preventDefault();

		// Relayout isotope based on filter selection
		var $filter_active = jQuery( this ).data( 'filter' ),
			$lightbox_instances = [];
		jQuery( this ).parents( '.fusion-portfolio' ).find( '.fusion-portfolio-wrapper' ).isotope( { filter: $filter_active } );

		// Remove active filter class from old filter item and add it to new
		jQuery( this ).parents( '.fusion-filters' ).find( '.fusion-filter' ).removeClass( 'fusion-active' );
		jQuery( this ).parent().addClass( 'fusion-active' );

		jQuery( this ).parents( '.fusion-portfolio' ).find( '.fusion-portfolio-wrapper' ).find( '.fusion-portfolio-post' ).each( function() {
			var $post_id = '';

			// For individual per post galleries set the post id
			if ( js_local_vars.lightbox_behavior == 'individual' && jQuery( this ).find( '.fusion-rollover-gallery' ).length ) {
				$post_id = jQuery( this ).find( '.fusion-rollover-gallery' ).data( 'id' );
			}

			if ( $filter_active.length ) {
				var $filter_selector = $filter_active.substr(1),
					$lightbox_string = 'iLightbox[' + $filter_selector + $post_id + ']';
			} else {
				var $filter_selector = 'fusion-portfolio-post',
					$lightbox_string = 'iLightbox[gallery' + $post_id + ']';
			}

			if ( jQuery( this ).hasClass( $filter_selector ) ) {
				if ( $filter_active.length ) {
					$lightbox_instances.push( $filter_selector + $post_id );
				}

				jQuery( this ).find( '.fusion-rollover-gallery' ).attr( 'data-rel', $lightbox_string );
				jQuery( this ).find( '.fusion-portfolio-gallery-hidden a' ).attr( 'data-rel', $lightbox_string );
			}
		});

		// Check if we need to create a new gallery
		if ( jQuery( this ).data( 'lightbox' ) != 'created' ) {

			// Create new lightbox instance for the new galleries
			jQuery.each( $lightbox_instances, function( $key, $value ) {
				$il_instances.push( jQuery( '[data-rel="iLightbox[' + $value + ']"], [rel="iLightbox[' + $value + ']"]' ).iLightBox( $avada_lightbox.prepare_options( 'iLightbox[' + $value + ']' ) ) );
			});

			// Refresh the lightbox
			$avada_lightbox.refresh_lightbox();

			// Set filter to lightbox created
			jQuery( this ).data( 'lightbox', 'created' );
		}
	});

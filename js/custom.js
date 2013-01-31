/*
 * ---------------------------------------------------------------- 
 *  
 *  Custom jQuery scripts.
 *  
 * ----------------------------------------------------------------  
 */


jQuery(document).ready(function(){	
		

/*
 * ---------------------------------------------------------------- 
 *  Image hover effect
 * ----------------------------------------------------------------  
 */
 	
	// Over field
	
	/*
	jQuery('.over').stop().animate({ "opacity": 0 }, 0);
 	function over() {
		jQuery('.over').hover(function() {
			jQuery(this).stop().animate({ "opacity": .9 }, 250);
		}, function() {
			jQuery(this).stop().animate({ "opacity": 0 }, 250);
		});	
	}
	
	over();
	
	*/
	
	// Firefox fix
	
	if (window.addEventListener) { 
        window.addEventListener('unload', function() {}, false); 
	} 
	
	
	// Opacity change on hover
	
	function hover_opacity() {
		jQuery('#menu-people a img, #project-info a').hover(function() {
			jQuery(this).stop().animate({ "opacity": .8 }, 250);
		}, function() {
			jQuery(this).stop().animate({ "opacity": 1 }, 250);
		});
	}
	
	hover_opacity();
		
	
/*
 * ---------------------------------------------------------------- 
 *  Simple codes
 * ----------------------------------------------------------------  
 */
	
	// Tabs
	
	jQuery(".tabs").tabs();
	
	
	// Toggles	

	jQuery('.toggle-container').click(function () {
		var text = jQuery(this).children('.toggle-content');
		
		if (text.is(':hidden')) {
			text.slideDown('fast');
			jQuery(this).children('h6').addClass('active');		
		} else {
			text.slideUp('fast');
			jQuery(this).children('h6').removeClass('active');		
		}		
	});


/*
 * ---------------------------------------------------------------- 
 *  Clear input field
 * ----------------------------------------------------------------  
 */
	function clearInput(field_id, term_to_clear) {
		
		// Clear input if it matches default value
		if (document.getElementById(field_id).value == term_to_clear ) {
			document.getElementById(field_id).value = '';
		}
		
		// If the value is blank, then put back term
		else if (document.getElementById(field_id).value == '' ) {
			document.getElementById(field_id).value = term_to_clear;
		}
	} // end clearInput()



});
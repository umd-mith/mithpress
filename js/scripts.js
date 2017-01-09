jQuery(window).load(function() {
	
	var d = document.getElementById("umh-cont");
	d.className = d.className + " collapsed";
	
	jQuery('#umh-main').css('display','none');
	jQuery('body').css("padding-top", '30px');
	
	jQuery('body.dd-archive #sidebar.fusion-widget-area').each(function() {
		jQuery(this).addClass('side-nav-left');
	});
	jQuery('body.tax-mith_dialogue_series #sidebar.fusion-widget-area a:contains(Past)').each(function() {
		jQuery(this).parent().addClass('current-page-item');
	});
	jQuery('body.tax-mith_dialogue_series #sidebar.fusion-widget-area ul li:first-child').each(function() {
		jQuery(this).removeClass('current-page-item'); /*remove class from first item*/
	});
	jQuery('body.post-type-archive-mith_dialogue #sidebar.fusion-widget-area a:contains(Dialogues Archive)').each(function() {
		jQuery(this).parent().addClass('current-page-item');
	});
	jQuery('body.post-type-archive-mith_dialogue #sidebar.fusion-widget-area ul li:first-child').each(function() {
		jQuery(this).removeClass('current-page-item'); /*remove class from first item*/
	});
	jQuery('body.tax-mith_dialogue_series #sidebar.fusion-widget-area').each(function() {
		jQuery(this).addClass('side-nav-left');
	});
	
});

var selectedBox = null;

jQuery(document).ready(function($) {
	
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
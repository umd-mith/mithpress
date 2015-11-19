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
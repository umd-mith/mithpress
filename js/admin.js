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
 *  Date Picker
 * ----------------------------------------------------------------  
 */
 	function pickDate() {
        var dates = jQuery( "#from, #to" ).datepicker({
            defaultDate: "+1w",
			dateFormat: "DD, MM d, yy",
            changeMonth: true,
            numberOfMonths: 2,
            onSelect: function( selectedDate ) {
                var option = this.id == "from" ? "minDate" : "maxDate",
                    instance = jQuery( this ).data( "datepicker" ),
                    date = jQuery.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        jQuery.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
	}
	pickDate();

 	function pickDateAbr() {
        var dates = jQuery( "#talk-date" ).datepicker({
            defaultDate: "+1w",
			dateFormat: "M d, yy",
            changeMonth: true,
            numberOfMonths: 2,
            onSelect: function( selectedDate ) {
                var option = this.id == "from" ? "minDate" : "maxDate",
                    instance = jQuery( this ).data( "datepicker" ),
                    date = jQuery.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        jQuery.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
	}
	pickDateAbr();

	jQuery('.timepicker').timepicker({
		ampm: true
	});
/*
 * ---------------------------------------------------------------- 
 */

 	function pickDateCond() {
        var dates = jQuery( "#expire" ).datepicker({
            defaultDate: "+1w",
			dateFormat: "c",
            changeMonth: true,
            numberOfMonths: 2,
            onSelect: function( selectedDate ) {
                var option = this.id == "expire" ? "minDate" : "maxDate",
                    instance = jQuery( this ).data( "datepicker" ),
                    date = jQuery.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        jQuery.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
	}
	pickDateCond();

/*
 * ---------------------------------------------------------------- 
 *  Clear input field
 * ----------------------------------------------------------------  
 */

});
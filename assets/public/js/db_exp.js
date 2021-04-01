/**
 * 
 */
/**
 * Created by Eric Beda on 2/24/2016.
 */

$(document).ready(function() {

	$(document).on(
			'click',
			'.db_exp_date',
			function(event) {
				$(this).datepicker({
					  dateFormat: "yy-mm-dd"
				});
			});
	
});
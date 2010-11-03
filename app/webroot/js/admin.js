$(document).ready( function()
{
	$(".make_button").button();
	
	$(".date_input").datepicker({
		onClose: function() { $(this).blur(); $(this).valid() }
		});
	
});

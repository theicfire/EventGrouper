$(document).ready( function()
{
	$(".make_button").button();
	
	$(".table_tiny_buttons .ui-button-text").css("padding", "2px");
	
	$(".date_input").datepicker({
		onClose: function() { $(this).blur(); $(this).valid() }
		});
	
});

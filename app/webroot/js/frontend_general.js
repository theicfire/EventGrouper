function scheduleToggle() {
	$(".scheduletoggle").click(function() {
	if ($('#loggedIn').length != 0) {
		$( "#dialog-form" ).dialog( "open" );
		return false;
	}
	var eventBlock = $(this).parent(); 
	var id = eventBlock.attr('id').split("-")[1];
	var textEl = $(this);
	if (eventBlock.hasClass('onCalendar')) {
		$.ajax({url: phpVars.root+"/events/removeFromCalendar/"+id,
		success: function() {
			eventBlock.removeClass('onCalendar');
			eventBlock.addClass('offCalendar');
			
			textEl.siblings('.addToSchedule').show();
			textEl.hide();
		}
		});
	} else {
		$.ajax({url: phpVars.root+"/events/addToCalendar/"+id,
		success: function() {
			eventBlock.removeClass('offCalendar');
			eventBlock.addClass('onCalendar');
			textEl.hide();
			textEl.siblings('.removeFromSchedule').show();				
			}
			});
	
			
		}
		return false;
	});
}
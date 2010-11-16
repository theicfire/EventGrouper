function addtoschedule( a_id )
{
	alert("add " + a_id + " to schedule");
}

function update_time()
{
	currentTime = new Date();
	var currentHours = currentTime.getHours ( );
	var currentMinutes = currentTime.getMinutes ( );
	var currentSeconds = currentTime.getSeconds ( );
	
	currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
	currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
	
	var timeOfDay = ( currentHours < 12 ) ? "am" : "pm";
	currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
	currentHours = ( currentHours == 0 ) ? 12 : currentHours;
	
	var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
	
	$("#curr_time").html(currentTimeString);
	
	var m_names = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	var curr_date = currentTime.getDate();
	var curr_month = currentTime.getMonth();
	var curr_year = currentTime.getFullYear();
	currentDateString = m_names[curr_month] + " " + curr_date + ", " + curr_year;
	
	$("#curr_date").html(currentDateString);
}

var floating = false;

function scroll_handler(event)
{
	//this will scroll the timeline. (sashko)
}
function giveEventsJs() {
//	$( ".timeline_cell" ).find(".event_block").draggable({ revert: "invalid", helper: "clone", opacity: .7, zIndex: 1000 });
//	$( ".timeline_cell" ).find(".event_block").css("cursor", "move");
//	
//	$( ".mys_cell" ).droppable({hoverClass: "mys_hover", activeClass: "mys_acceptor",
//		
//	drop: function(event, ui)
//	{
//		var hiddenid = $(ui.draggable).attr("hiddenid");
//		addtoschedule(hiddenid);
//		$(ui.draggable).fadeTo(1, .5);
//
//		$.ajax({url: "<?=$this->base?>/events/addToCalendar/"+hiddenid,
//			success: function() {
//				alert('added');
//			}
//		});
//	}
//		
//	});

	if ($("#viewType").val() == 'calendar' || $("#viewType").val() == '' )
	{

		$(".scheduletoggle").click(function() {
			var eventBlock = $(this).parent().parent(); 
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
		$('.tagLink').click(function() {
			$('#searchBox').val($(this).html());
			refreshEvents();
			return false;
		});
	}
	else if ($("#viewType").val() == 'map')
	{
	}

	$(".make_button").button();
}
function getEvents(date, search, time_start, viewType) {
	$("#eventHolder").html('');
	$('#loadingimage').show();
	var loc = 'ajaxListEvents';
	if (viewType == 'map') {
		loc = 'map_view';
	}
	$.get(phpVars.root+"/event_groups/"+loc+"/"+phpVars.currentEventGroupId, { date_start: date, search: search, time_start:time_start, viewType:viewType},
   function(data){
     $("#eventHolder").html(data);
     $('#loadingimage').hide();
     giveEventsJs();
   });
}
function refreshEvents() {
	getEvents($("#datestart").val(), $("#searchBox").val(), $("#time_start").val(), $("#viewType").val());
	setHashFromPage();
}
function setHashFromPage(){
	var paramArr = [];
//	paramArr['id'] = $("#quizletId").val();
//	paramArr['transferSpeed'] = $("#moveToStackSpeed").val();
	$(".putInHash").each(function(){
		if(this.type!="checkbox"){
			paramArr[this.id]=$(this).val();
		}
		else{
			paramArr[this.id]=this.checked;
		}
	});
	var urlStrArr = [];
	for (var key in paramArr) {
		urlStrArr.push(key+"="+paramArr[key]);
	}	
	location.hash = urlStrArr.join("&");
	
}
function setPageFromHash(){
	if (location.hash){
		hash =location.hash.substring(1);
		urlStrArr = hash.split("&");
		for (var key in urlStrArr) {
			var params = urlStrArr[key].split("=");
			if($("#"+params[0]).attr('type')!="checkbox"){
				$("#"+params[0]).val(params[1]);
			}
			else{
				$("#"+params[0]).attr('checked',params[1]=="true");
			}
		}
	}
}

$(document).ready( function(){
	
	$("#datestart").datepicker();
	$("#filter_submit").click(function() {
		refreshEvents();
		return false;
	});
	$("#gotoall").click(function() {
		$("#gotoall").addClass('active');
		$("#gotoschedule").removeClass('active');
		$("#gotomap").removeClass('active');
		$("#viewType").val('');
		refreshEvents();
		return false;
	});
	$("#gotoschedule").click(function() {
		$("#gotoschedule").addClass('active');
		$("#gotoall").removeClass('active');
		$("#gotomap").removeClass('active');
		$("#viewType").val('calendar');
		refreshEvents();
		return false;
	});
	$("#gotomap").click(function() {
		$("#gotomap").addClass('active');
		$("#gotoall").removeClass('active');
		$("#gotoschedule").removeClass('active');
		$("#viewType").val('map');
		refreshEvents();
		return false;
	});
	$(".previous_events_button").button();
	$("#filter_submit").button();
	
	$(".make_button").button();
	

	
//	$("#filter_submit").hide();
	
	$(window).scroll( scroll_handler );
	$(window).resize( scroll_handler );
	
	setInterval( "update_time()", 1000 );

	setPageFromHash();
	if ($("#viewType").val() == 'calendar') $("#gotoschedule").trigger('click');
	if ($("#viewType").val() == 'map') $("#gotomap").trigger('click');
	else $("#filter_submit").trigger('click');

	
	
});

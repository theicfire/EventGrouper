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
		if ($("#top_locator").length == 0)
			return false;
		/*console.log($(document).height()-($(document).scrollTop()+$(window).height()));*/
		if($("#top_locator").offset().top - $(document).scrollTop() < 10 )
		{
			left_distance = $("#top_locator").offset().left - $(document).scrollLeft();
			$("#right_floater").addClass("floating_box");
			$("#right_floater").css("left", left_distance);
		}
		else if($("#top_locator").offset().top - $(document).scrollTop() > 10 )
		{
			$("#right_floater").removeClass("floating_box");
		}
		
		if($("#which_day_container_locator").offset().top - $(document).scrollTop() < 10 )
		{
			left_distance = $("#which_day_container_locator").offset().left - $(document).scrollLeft() - 6;
			$("#which_day_container").addClass("day_floating_box");
			$("#which_day_container").css("left", left_distance);
			
			$("#which_day_container_locator").addClass("which_day_spacer");
		}
		else if($("#which_day_container_locator").offset().top - $(document).scrollTop() > 10 )
		{
			$("#which_day_container").removeClass("day_floating_box");
			$("#which_day_container_locator").removeClass("which_day_spacer");
		}
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
	

	$(".make_button").button();
}
function getEvents(date, search, time_start, isCalendar) {
	$("#eventHolder").html('');
	$('#loadingimage').show();
	$.get(phpVars.root+"/event_groups/ajaxListEvents/"+phpVars.currentEventGroupId, { date_start: date, search: search, time_start:time_start, isCalendar:isCalendar},
   function(data){
     $("#eventHolder").html(data);
     $('#loadingimage').hide();
     giveEventsJs();
   });
}
function refreshEvents() {
	getEvents($("#datestart").val(), $("#searchBox").val(), $("#time_start").val(), $("#isCalendar").is(':checked'));
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
		$("#isCalendar").attr('checked', false);
		refreshEvents();
		return false;
	});
	$("#gotoschedule").click(function() {
		$("#gotoschedule").addClass('active');
		$("#gotoall").removeClass('active');
		$("#isCalendar").attr('checked', true);
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
	if ($("#isCalendar").is(':checked')) $("#gotoschedule").trigger('click');
	else $("#filter_submit").trigger('click');

	
	
});
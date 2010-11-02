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
		var eventBlock = $(this).parent().parent().parent(); 
		var id = eventBlock.attr('id').split("-")[1];
		var textEl = $(this);
		if (eventBlock.hasClass('onCalendar')) {
			$.ajax({url: phpVars.root+"/events/removeFromCalendar/"+id,
			success: function() {
				eventBlock.removeClass('onCalendar');
				eventBlock.addClass('offCalendar');
				textEl.html('add to schedule');				
			}
			});
		} else {
			$.ajax({url: phpVars.root+"/events/addToCalendar/"+id,
			success: function() {
				eventBlock.removeClass('offCalendar');
				eventBlock.addClass('onCalendar');
				textEl.html('remove from schedule');				
			}
			});

			
		}
		return false;
	});

	$(".categoryLink").click(function() {
		var id = $(this).attr('hiddenclass').split("-")[1];
		$(".categorycheckbox").each(function() {
			if ($(this).val() == id)
				$(this).attr('checked', true);
			else
				$(this).attr('checked', false);
		});
		refreshEvents();
		return false;
	});
	$(".make_button").button();
}
function getEvents(date, search, categoryChoices, time_start) {
	$.get(phpVars.root+"/event_groups/ajaxListEvents/"+phpVars.currentEventGroupId, { date_start: date, search: search, 'categories[]': categoryChoices, time_start:time_start},
   function(data){
     $("#eventHolder").html(data);
     giveEventsJs();
     
   });
}
function refreshEvents() {
	var categoryChoices = new Array();//need this so that if no categories are checked, nothing comes up
	$(".categorycheckbox:checked").each(function() {
		categoryChoices.push($(this).val());
	});
	
	getEvents($("#datestart").val(), $("#searchBox").val(), categoryChoices, $("#time_start").val());
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
	$("#filterForm").submit(function() {
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
	$("#filterForm").trigger('submit');

	
	
});
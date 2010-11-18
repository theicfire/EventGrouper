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

var map_data = new Array();

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
		initialize_desktop_map();
		
		//$("#conference_header").hide( "blind", null, 1000 );
	}

	$(".make_button").button();
}

function initialize_desktop_map()
{
	var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 16,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("desktop_map_container"),
        myOptions);
    
    map_data = eval($("#json_map_data").html());
    
    if( map_data.length > 0 )
    {
		//if there are events, it sets the center of the map to the first event returned as a result.  far from optimal - it should take some sort of weighted average of the lat and longs
		
		latlng = new google.maps.LatLng(map_data[0]['Event']['latitude'], map_data[0]['Event']['longitude']);
		map.panTo(latlng);
    }
    
    var put_in_sidebar = "";
    
	for (i = 0; i < map_data.length; i++) {
		var event = map_data[i];
		
		var event_id = event['Event']['id'];
		
		map_data[i].myLatlng = new google.maps.LatLng(event['Event']['latitude'],event['Event']['longitude']);
		
		var map_icon;
		
		switch ( i ){
			case 0: 
			map_icon = "a.png";
			break;
			case 1: 
			map_icon = "b.png";
			break;
			case 2: 
			map_icon = "c.png";
			break;
			case 3: 
			map_icon = "d.png";
			break;
			case 4: 
			map_icon = "e.png";
			break;
			case 5: 
			map_icon = "f.png";
			break;
			case 6: 
			map_icon = "g.png";
			break;
			case 7: 
			map_icon = "h.png";
			break;
			case 8: 
			map_icon = "i.png";
			break;
			case 9: 
			map_icon = "j.png";
			break;
			default: 
			map_icon = "rest.png";
			break;
		}
		
		map_icon = phpVars.root + "/img/maps/" + map_icon;
		
		switch ( i ){
			case 0: 
			list_icon = "a_ns.png";
			break;
			case 1: 
			list_icon = "b_ns.png";
			break;
			case 2: 
			list_icon = "c_ns.png";
			break;
			case 3: 
			list_icon = "d_ns.png";
			break;
			case 4: 
			list_icon = "e_ns.png";
			break;
			case 5: 
			list_icon = "f_ns.png";
			break;
			case 6: 
			list_icon = "g_ns.png";
			break;
			case 7: 
			list_icon = "h_ns.png";
			break;
			case 8: 
			list_icon = "i_ns.png";
			break;
			case 9: 
			list_icon = "j_ns.png";
			break;
			default: 
			list_icon = "rest.png";
			break;
		}
		
		list_icon = phpVars.root + "/img/maps/" + list_icon;
		
		map_data[i].marker = new google.maps.Marker({
			  position: map_data[i].myLatlng, 
			  map: map, 
			  title:event['Event']['title'],
			  icon: map_icon
		  });   
		
		map_data[i].marker.id = i;
		
		put_in_sidebar += "<div class='map_search_result'>";
		put_in_sidebar += "<img class='msr_icon' src='" + list_icon + "' />";
		put_in_sidebar += "<h3 class='msr_title'>" + event['Event']['title'] + "</h3>";
		if( event['Event']['latitude'] == null )
		{
			put_in_sidebar += "<p>" + "no location" + "</p>";
		}
		put_in_sidebar += "</div>";
		
		var text_in_infowindow = "";
		
		text_in_infowindow = "hey the name if this event is " + event['Event']['title'];
		
		map_data[i].infowindow = new google.maps.InfoWindow({
			content: text_in_infowindow
		});
		
		bindInfoWindow(map_data[i].marker, map, map_data[i].infowindow, text_in_infowindow)
		
	}
	
	if( map_data.length == 0)
	{
		put_in_sidebar = "<div class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> There are no events that match your set of options.</div>"
	}
	
	$("#map_search_result_list").html( put_in_sidebar );
	
	 /* var marker = new google.maps.Marker({
		  position: myLatlng, 
		  map: map, 
		  title:"Hello World!"
	  });   */
}

function bindInfoWindow(marker, map, infoWindow, html) {
  google.maps.event.addListener(marker, 'click', function() {
    infoWindow.setContent(html);
    
    for (i = 0; i < map_data.length; i++) {
		map_data[i].infowindow.close();
	}
    infoWindow.open(map, marker);
  });
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

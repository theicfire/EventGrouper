var currentHash;
var map_data = new Array();
var floating = false;
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



function scroll_handler(event)
{
	if( !floating && $("#scroll_locator").offset().top <= $(window).scrollTop() )
	{
		$("#scroll").addClass("yes_scroll");
		
		$("#spacer").height($("#scroll").outerHeight());
		
		floating = true;
	}
	else if( floating && $("#scroll_locator").offset().top > $(window).scrollTop())
	{
		$("#scroll").removeClass("yes_scroll");
		$("#spacer").height(0);
		
		floating = false;
	}
}


function map_init(latitude, longitude) {
	var map;
	var default_zoom_level = 16;
	if (GBrowserIsCompatible()) {
	  
	  
	map = new GMap2(document.getElementById("event_map_container"));
	map.setCenter(new GLatLng(latitude, longitude), default_zoom_level);
	map.setUIToDefault();
	
	map.setZoom(  default_zoom_level );
	
	map.enableContinuousZoom();
	
	map.addOverlay( new GMarker( new GLatLng(latitude, longitude) ) );

  }
}
function giveEventsJs() {

	if ($("#viewType").val() == 'calendar' || $("#viewType").val() == '' )
	{
		scheduleToggle();
		$('.tagLink').click(function() {
			$('#searchBox').val($(this).html());
			refreshEvents();
			return false;
		});
		$(".event_title a").click(function() {
			
			openEventPopup($(this));
			
			return false;
		});
	}
	else if ($("#viewType").val() == 'map')
	{
		initialize_desktop_map();
		
		//$("#conference_header").hide( "blind", null, 1000 );
	}
	var locString = addToHash(location.hash, 'viewType', '');
	$('.pathLinks a, .groupLinks a').each(function() {//make it so that all the path links have the current hash
		$(this).attr('href', $(this).attr('href').split('#')[0] + locString);
	});
	
	
	$(".make_button").button();
}
function openEventPopup(ob) {
	var id = ob.parent().parent().parent().attr('id').split('-')[1];
	$('#eventloadingimage').show();
	$( "#event-content" ).hide();
	$( "#event-popup" ).dialog( "open" );
	var latitude = ob.parent().parent().children('#latitude').html();
	var longitude = ob.parent().parent().children('#longitude').html();
	$.get(phpVars.root + "/events/view/"+ id, function(data){
		$( "#event-content" ).html(data);
		$( "#event-content" ).show();
		if (latitude.length != 0) 
			map_init(latitude, longitude);
		$('#eventloadingimage').hide();
		
		
	});
	changeHash(addToHash(location.hash, 'viewId', id));
	$('#viewId').val(id);
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
		
		map_data[i].time_start = new Date(event['Event']['time_start']);
		
//		put_in_sidebar += "<div class='map_search_result'>";
//		put_in_sidebar += "<img class='msr_icon' src='" + list_icon + "' />";
//		put_in_sidebar += "<h3 class='msr_title'>" + event['Event']['title'] + "</h3>";
//		if( event['Event']['latitude'] == null )
//		{
//			put_in_sidebar += "<p>" + "no location" + "</p>";
//		}
//		put_in_sidebar += "<p>" + map_data[i].time_start.getHours() + ":" + map_data[i].time_start.getMinutes() + "</p>";
//		put_in_sidebar += "</div>";
		
		var text_in_infowindow = "";
		
		text_in_infowindow = "<div class='gmaps_in_infowindow'>";
		text_in_infowindow += "<h3>" + event['Event']['title'] + "</h3>";
		
		
		text_in_infowindow += "</div>";
		
		map_data[i].infowindow = new google.maps.InfoWindow({
			content: text_in_infowindow
		});
		
		bindInfoWindow(map_data[i].marker, map, map_data[i].infowindow, text_in_infowindow)
		
	}
	
	if( map_data.length == 0)
	{
		put_in_sidebar = "<div class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> There are no events that match your set of options.</div>"
	}
	
//	$("#map_search_result_list").html( put_in_sidebar );//bad programming!
	
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
     if (getFromHash('viewId') != '') {
    	 openEventPopup($('#event-'+getFromHash('viewId')).find('.event_title a'));
     }
   });
}
function refreshEvents(isCalendar) {
	if (!validate()) return false;
	if (isCalendar)
		getEvents('01/01/1970', '', '0', $("#viewType").val());
	else
		getEvents($("#datestart").val(), $("#searchBox").val(), $("#time_start").val(), $("#viewType").val());
	setHashFromPage();
}
function validate() {
	if ($('#searchBox').val().length > 0 && $('#searchBox').val().length < 4) {
		$('#text_tip_large').hide();
		$('#searcherr').show();
		return false;
	}
	$('#text_tip_large').show();
	$('#searcherr').hide();
	return true;
}
function resetFields() {
	$("#datestart").val($("#date_start_default").val());
	$("#searchBox").val('');
	$("#time_start").val(0);
}
function resetDate() {
	$("#datestart").val($("#date_start_default").val());
}
function addToHash(hash, key, val) {
	hash = hash.substring(1);
	var locArr = hash.split('&');
	var locArrNew = new Array();
	for (var part in locArr) {
		var sides = locArr[part].split('=');
		if (sides[0] == key)
			continue;
		locArrNew.push(sides[0] + '=' + sides[1]);
	}
	locArrNew.push(key+'='+val);
	return '#' + locArrNew.join('&');
}
function removeFromHash(hash, key) {
	hash = hash.substring(1);
	var locArr = hash.split('&');
	var locArrNew = new Array();
	for (var part in locArr) {
		var sides = locArr[part].split('=');
		if (sides[0] == key)
			continue;
		locArrNew.push(sides[0] + '=' + sides[1]);
	}
	return '#' + locArrNew.join('&');
}
function getFromHash(key) {
	hash = location.hash.substring(1);
	var locArr = hash.split('&');
	for (var part in locArr) {
		var sides = locArr[part].split('=');
		if (sides[0] == key)
			return sides[1];
	}
	return false;
}
function changeHash(hash) {
	location.hash = hash;
	currentHash = hash;
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
	changeHash('#' + urlStrArr.join("&"));
	
	
}
function setPageFromHash(){
	if (location.hash){
		currentHash = location.hash;
		hash =location.hash.substring(1);
		urlStrArr = hash.split("&");
		for (var key in urlStrArr) {
			var params = urlStrArr[key].split("=");
			if ($("#"+params[0]).length != 0){ 
				if ($("#"+params[0]).attr('type')!="checkbox"){
					$("#"+params[0]).val(params[1]);
				}
				else{
					$("#"+params[0]).attr('checked',params[1]=="true");
				}
			}
		}
		
	}
}
function checkAndRunHash() {
	if (location.hash.length != 0 && currentHash != location.hash) {
		loadPage();
	}
		
}
function loadPage() {
	setPageFromHash();
	if ($("#viewType").val() == 'calendar') $("#gotoschedule").trigger('click');
	else if ($("#viewType").val() == 'map') $("#gotomap").trigger('click');
	else if ($("#viewType").val() == '') $("#gotoall").trigger('click');
	
}

$(document).ready( function(){
	setInterval(checkAndRunHash, 250);
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
		$("#r_main_ribbon_container").show();
		refreshEvents(false);
		return false;
	});
	$("#gotoschedule").click(function() {
		if ($('#loggedIn').length != 0) {
			$( "#dialog-form" ).dialog( "open" );
			return false;
		}
		$("#gotoschedule").addClass('active');
		$("#gotoall").removeClass('active');
		$("#gotomap").removeClass('active');
		$("#viewType").val('calendar');
		refreshEvents(true);
		$("#r_main_ribbon_container").hide();
		return false;
	});
	$("#gotomap").click(function() {
		$("#gotomap").addClass('active');
		$("#gotoall").removeClass('active');
		$("#gotoschedule").removeClass('active');
		$("#viewType").val('map');
		$("#r_main_ribbon_container").show();
		refreshEvents(false);
		return false;
	});
	$("#filter_reset").click(function() {
		resetFields();
		refreshEvents(false);
		return false;
	});
	$("#filter_reset_date").click(function() {
		resetDate();
		refreshEvents(false);
		return false;
	});
	$(".previous_events_button").button();
	$("#filter_submit").button();
	$( "#event-popup" ).dialog({
		autoOpen: false,
		modal: true,
		minWidth: 960,
		close: function(){
			changeHash(addToHash(location.hash, 'viewId', ''));
			$('#viewId').val('');
		}
	});
	
	$(".make_button").button();
	

	
//	$("#filter_submit").hide();
	
	$(window).scroll( scroll_handler );
	$(window).resize( scroll_handler );
	
	setInterval( "update_time()", 1000 );

	loadPage();
	
	
	
});


var currentHash;
var map_data = new Array();
var floating = false;
var map;

function scroll_handler(event) // used to determine when the toolbar should scroll
{
	if( !floating && $("#scroll_locator").offset().top <= $(window).scrollTop() )
	{
		$("#scroll").addClass("yes_scroll");
		$("#spacer").height($("#scroll").outerHeight());
		floating = true;
	} else if( floating && $("#scroll_locator").offset().top > $(window).scrollTop()) {
		$("#scroll").removeClass("yes_scroll");
		$("#spacer").height(0);
		floating = false;
	}
}

function map_init(latitude, longitude, goto_num) //initialize map in event popup
{
	
	var latlng = new google.maps.LatLng(latitude, longitude);
    var myOptions = {
      zoom: 16,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("event_map_container"),
        myOptions);
        
    var marker = new google.maps.Marker({
      position: latlng, 
      map: map
	});  
	
	google.maps.event.addListener(marker, 'click', function(){ goto_on_map( goto_num) });
}

function toggle_top() //shows and hides description
{
	$("#top_stuff_toggle").slideToggle("fast", function () {
		$(window).trigger("resize");
	});
	
	$("#minimize_link").toggle();
	$("#maximize_link").toggle();
}

function giveEventsJs() //goes through most of the page adding JS stuff.. could have used a more descriptive name though
{
	var locString;
	if ($("#viewType").val().indexOf('map') == -1)
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
		$(".locLink").click(function() {
			var id = $(this).parent().parent().parent().attr('id').split('-')[1];
			goto_on_map(id);
			return false;
		});
		
		$("#eventHolder").removeClass( "map_container_div" );
		
	} else {
		scheduleToggle();
		initialize_desktop_map();
		
		$("#eventHolder").addClass( "map_container_div" );
		
	}
	
	givePopupsAndEventsJs();
	$(".make_button").button();
}
function givePopupsAndEventsJs() {
	$('.pathLinks a, .groupLinks a').each(function() {//make it so that all the path links have the current hash
		var changedHash = setInHash('viewId', '');
		changedHash = setCustHash(changedHash, 'p', '1');
		$(this).attr('href', $(this).attr('href').split('#')[0] + changedHash);
	});
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
			map_init(latitude, longitude, id);
		givePopupsAndEventsJs();
		$('#eventloadingimage').hide();
		
		
	});
	changeHash(setInHash('viewId', id));
	$('#viewId').val(id);
}

function goto_on_map( id )
{
	$( "#event-popup" ).dialog( "close" );
	var newHash = setInHash('mapViewId', id);
	if (getFromHash('viewType').indexOf('calendar') != -1) {
		location.hash = setCustHash(newHash, 'viewType', 'calendarmap');
	} else {
		location.hash = setCustHash(newHash, 'viewType', 'map');
	}
}

function getEvents(date, search, time_start, viewType, p) //loads events into #eventHolder
{
	$("#eventHolder").html('');
	$('#loadingimage').show();
	var loc = 'ajaxListEvents';
	if (viewType.indexOf('map') != -1) {
		loc = 'map_view';
	}
	$.get(phpVars.root+"/event_groups/"+loc+"/"+phpVars.currentEventGroupId, { date_start: date, search: search, time_start:time_start, viewType:viewType, p:p},
   function(data){
     $("#eventHolder").html(data);
     $('#loadingimage').hide();
     giveEventsJs();
     if (viewType.indexOf('map') == -1 && getFromHash('viewId') != '') {
    	 openEventPopup($('#event-'+getFromHash('viewId')).find('.event_title a'));
     }
     else if (viewType.indexOf('map') != -1 && getFromHash('mapViewId') != '') {
		 map_open_by_id( getFromHash('mapViewId') );
	 }
     //pages.. todo this won't work if there are exactly 100 events
     if ($('#eventCount').val() != 10) {
    	 $('#nextpage').hide();
     } else {
    	 $('#nextpage').show();
     }
     if ($('#p').val() == 1) {
    	 $('#prevpage').hide();
     } else {
    	 $('#prevpage').show();
     }
   });
}

function refreshEvents(isCalendar, keepPage) {
	if (!validate()) return false;
	if (!keepPage) {
		$('#p').val(1);
	}
	if (isCalendar)
		getEvents('01/01/1970', '', '0', $("#viewType").val(), 1);
	else
		getEvents($("#datestart").val(), $("#searchBox").val(), $("#time_start").val(), $("#viewType").val(), $("#p").val());
	$(window).scrollTop(0);
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

function searchErrHide() {
	$('#searcherr').hide();
}

function resetFields() {
	$("#datestart").val($("#date_start_default").val());
	$("#searchBox").val('');
	$("#time_start").val(0);
}

function resetDate() {
	$("#datestart").val($("#date_start_default").val());
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
function setInHash(key, value) {
	return setCustHash(location.hash, key, value);
}
function setCustHash(hash, key, value) {
	hash = hash.substring(1);
	var locArr = hash.split('&');
	var locArrNew = new Array();
	for (var part in locArr) {
		var sides = locArr[part].split('=');
		if (sides[0] == key)
			locArrNew.push(sides[0] + '=' + value);
		else
			locArrNew.push(sides[0] + '=' + sides[1]);
	}
	return '#' + locArrNew.join('&');
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
	if (getFromHash('viewType') != '' && getFromHash('viewType').indexOf('map') != -1) {
		$(".viewMap").css("display", "none");
		$(".viewList").css("display", "inline-block");
		$(".viewDrop").val(["map"]);
		$("label[for=radio2]").addClass("ui-state-active");
	} else {
		$(".viewMap").css("display", "inline-block");
		$(".viewList").css("display", "none");
		$(".viewDrop").val(["list"]);
		$("label[for=radio1]").addClass("ui-state-active");
	}
}

function checkAndRunHash() {
	if (location.hash.length != 0 && currentHash != location.hash) {
		loadPage();
	}
		
}

function loadPage() {
	setPageFromHash();
	if ($("#viewType").val().indexOf('calendar') != -1) viewSchedule();
	else viewAll();
	
}
function viewAll() {
	$("#gotoall").addClass('active');
	$("#gotoschedule").removeClass('active');
	$("#timelineOnly").show();
	$("#favoritesOnly").hide();
	$("#conference_info").show();
	
	refreshEvents(false, true);
}
function viewSchedule() {
	if ($('#loggedIn').length != 0) {
		$( "#dialog-form" ).dialog( "open" );
		return false;
	}
	$("#gotoschedule").addClass('active');
	$("#gotoall").removeClass('active');
	refreshEvents(true);
	$("#timelineOnly").hide();
	$("#favoritesOnly").show();
	
	$("#conference_info").hide();
	return true;
}
$(document).ready( function(){
	setInterval(checkAndRunHash, 250);
	$("#datestart").datepicker();
	$("#filter_submit").click(function() {
		refreshEvents();
		return false;
	});
	$("#searchBox").keydown( function(event){
		if (event.keyCode == '13') {
			event.preventDefault();
			refreshEvents();
		}
	})
	$("#gotoall").click(function() {
		location.hash = setInHash('viewType', '');
		return false;
	});
	$("#gotoschedule").click(function() {
		if (viewSchedule()) {
			changeHash(setInHash('viewType', 'calendar'));
		}
		return false;
	});
	$(".viewDrop").change(function(){
			if($(".viewDrop:checked").val() == "map"){
				$(".viewMap").click();
			} else {
				$(".viewList").click();
			}
		});
	$("#datestart").change(function(){
			refreshEvents();
		return false;
		});
	$("#time_start").change(function(){
			refreshEvents();
		return false;
		});
	$(".viewMap").click(function() {
		$(".viewMap").hide();
		$(".viewList").show();
		var curView = getFromHash('viewType');
		if (curView.indexOf('map') == -1) {
			location.hash = setInHash('viewType', curView+"map");
		}
		return false;
	});
	$(".viewList").click(function() {
		$(".viewMap").show();
		$(".viewList").hide();
		var curView = getFromHash('viewType');
		if (curView.indexOf('map') != -1) {
			if (curView.indexOf('calendar') != -1) {
				location.hash = setInHash('viewType', 'calendar');
			} else {
				location.hash = setInHash('viewType', '');	
			}
		}
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
	/*$("#nextpage").click(function() {
		$('#p').val($('#p').val()*1.0 + 1);
		refreshEvents(false, true);
		return false;
	});
	$("#prevpage").click(function() {
		$('#p').val($('#p').val()*1.0 - 1);
		refreshEvents(false, true);
		return false;
	}); */
	$(".previous_events_button").button();
	$(".viewDrop").button();
	$("#filter_submit").button();
	$( "#event-popup" ).dialog({
		autoOpen: false,
		modal: true,
		width: 900,
		minWidth: 900,
		position: [ 30, 100 ],
		close: function(){
			changeHash(setInHash('viewId',''));
			$('#viewId').val('');
		}
	});
	
	$(".make_button").button();
	
	$(window).scroll( scroll_handler );
	$(window).resize( scroll_handler );

	loadPage();
});

function get_current_page()
{
	return $('#p').val()*1.0;
}
function go_to_page( page_number )
{
	$('#p').val( page_number );
	refreshEvents(false, true);
}
function next_page()
{
	go_to_page( get_current_page() + 1 );
}
function prev_page()
{
	go_to_page( get_current_page() - 1 );
}

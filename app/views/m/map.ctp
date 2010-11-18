<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" 
      xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Mobile EventGrouper | '); ?>
		<?php echo $title_for_layout; ?>
	</title>
    
	<?php
		echo $this->Html->meta('icon');
		echo $html->css(array('mobile.css')); 
		if (!isset($phpVars))
			$phpVars = array();
		$phpVars['root'] = $this->base;
		echo $this->Html->scriptBlock('var phpVars = '.$javascript->object($phpVars).';');
	?>
	
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	
	<script type="text/javascript">
	
	window.onload = initialize_mobile_map;
	
		function initialize_mobile_map()
{
	var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 16,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("m_map_container"),
        myOptions);

    map_data = eval(document.getElementById("json_map_data").innerHTML);
    
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
		
		put_in_sidebar += "<div class='map_search_result'>";
		put_in_sidebar += "<img class='msr_icon' src='" + list_icon + "' />";
		put_in_sidebar += "<h3 class='msr_title'>" + event['Event']['title'] + "</h3>";
		if( event['Event']['latitude'] == null )
		{
			put_in_sidebar += "<p>" + "no location" + "</p>";
		}
		put_in_sidebar += "<p>" + map_data[i].time_start.getHours() + ":" + map_data[i].time_start.getMinutes() + "</p>";
		put_in_sidebar += "</div>";
		
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
	
	//$("#map_search_result_list").html( put_in_sidebar );


	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
		  initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
		  map.setCenter(initialLocation);
		  alert("location!");
		}, function() {
		});
	  // Try Google Gears Geolocation
	  }

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
	
	</script>
	
	
</head>

<body>

<div id="m_map_top_bar">
<?php
$getarr = $_GET;
unset($getarr['url']);
$getstr = "?";
foreach ($getarr as $key=>$value) {
	$getstr .= $key."=".$value."&"; 
}
echo $html->link('Schedule', "/mob/view/".$id."?".$getstr);
if ($session->check('userid'))
	echo " ".$html->link('Favorites', "/mob/view/".$id."?".$getstr."viewType=calendar");
echo " Map";
 ?>
 </div>
 
 <div id="m_map_container"></div>
 
 
 <div id="m_map_bottom_bar"></div>
 <?php

echo "<span id='json_map_data' style='display: none'>";
						echo json_encode($eventsUnderGroup);
						echo "</span>";

?>
</body>

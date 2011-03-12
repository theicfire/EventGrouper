<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" 
      xmlns:fb="http://www.facebook.com/2008/fbml">
<head>

<meta name="viewport" content="width=device-width, user-scalable=no" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" /> 
<meta name="apple-mobile-web-app-capable" content="yes" /> 
 


	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Mobile EventGrouper'); ?>
		<?php // echo $title_for_layout; ?>
	</title>
    
	<?php
		echo $this->Html->meta('icon');
		echo $html->css(array('mobile.css')); 
		if (!isset($phpVars))
			$phpVars = array();
		$phpVars['root'] = $this->base;
		echo $this->Html->scriptBlock('var phpVars = '.$javascript->object($phpVars).';');
		echo $javascript->link(array('jquery-1.4.2.min.js'));
		
		
	?>
	
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	
	<script type="text/javascript">
	
	window.onload = initialize_mobile_map;

	
	var map, map_data;
	map_data = Array();
	
	function pan_and_close(rel_id)
	{
		$("#list_of_events").hide();
		open_info(rel_id);
	}
	
		function initialize_mobile_map()
{
	
	$("#map_button").click( function(event){ 
		event.preventDefault();
		$("#list_of_events").hide();
	});
	$("#back_to_event_list").click( function(event){ 
		event.preventDefault();
		$("#list_of_events").show();
	});
	$("#my_location").click( function(event){ 
		event.preventDefault();
		centerMapOnLocation();
	});
	
	
	
	var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 16,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("m_map_container"),
        myOptions);
    
    <?php //if there are events, center on the first result
    if(count($eventsUnderGroup) > 0) { ?>
			 latlng = new google.maps.LatLng(<?=$eventsUnderGroup[0]['Event']['latitude']?>, <?=$eventsUnderGroup[0]['Event']['longitude']?>);
		map.panTo(latlng);
		
		<?php } ?>	 
    
    <?php $imageArr = array('a_ns', 'b_ns', 'c_ns', 'd_ns', 'e_ns', 'f_ns', 'g_ns', 'h_ns', 'i_ns', 'j_ns', 'rest'); ?>
    <?php
	$i = 0;
	
		 foreach ($eventsUnderGroup as $event) { ?>
		
		map_data[<?=$i?>] = Array();
		
		map_data[<?=$i?>]["myLatlng"] = new google.maps.LatLng(<?=$event['Event']['latitude']?>,<?=$event['Event']['longitude']?>);
		
		<?php if($i<10){
			$map_icon_url = $html->url('/') . "img/maps/" . $imageArr[$i] . ".png";

			} else {
				$map_icon_url = $html->url('/') . "img/maps/rest.png";

			} ?>
		
		map_icon = "<?=$map_icon_url?>";
		
		map_data[<?=$i?>]["marker"] = new google.maps.Marker({
			  position: map_data[<?=$i?>].myLatlng, 
			  map: map, 
			  title: "<?=$event['Event']['title']?>",
			  icon: map_icon,
			  zIndex: 1000-<?=$i?>
		  });   
		
		map_data[<?=$i?>]["marker"].id = <?=$i?>;	

		
		<?php
			
				$info_text = "";
			
				$info_text = "<div class='gmaps_in_infowindow'>";
				$info_text .= "<h3>" . $event['Event']['title'] . "</h3>";
				$info_text .= "<p>" . $event['Event']['nice_time_start'] . "</p>";
				
				if( $event['Event']['location'] != "" )
				$info_text .= "<p>" . $event['Event']['location'] . "</p>";
				else
				$info_text .= "<p>" .  "</p>";
				
				if( $event['Event']['description'] != "" )
				$info_text .= "<p>" . $event['Event']['description'] . "</p>";
				else
				$info_text .= "<p>" . "No description" . "</p>";
				$info_text .= "</div>";
				
			?>
				
				map_data[<?=$i?>]["text_in_infowindow"] = "<?=$info_text?>";
		
		map_data[<?=$i?>]["infowindow"] = new google.maps.InfoWindow({
			content: map_data[<?=$i?>]["text_in_infowindow"]
		});
		
		bindInfoWindow(map_data[<?=$i?>]["marker"], map, map_data[<?=$i?>]["infowindow"], map_data[<?=$i?>]["text_in_infowindow"])
		
	<?php $i++; } ?> 
	
	$("#show_event").change( handle_select );
	
	if( map_data.length == 0)
	{
		put_in_sidebar = "<div class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> There are no events that match your set of options.</div>"
	}
	
	var controlDiv = $("#m_map_control").get(0);

	// We don't really need to set an index value here, but
	// this would be how you do it. Note that we set this
	// value as a property of the DIV itself.
	controlDiv.index = 1;

	// Add the control to the map at a designated control position
	// by pushing it on the position's array. This code will
	// implicitly add the control to the DOM, through the Map
	// object. You should not attach the control manually.
	map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
	
	var controlDiv2 = $("#m_mylocation_control").get(0);

	// We don't really need to set an index value here, but
	// this would be how you do it. Note that we set this
	// value as a property of the DIV itself.
	controlDiv2.index = 1;

	// Add the control to the map at a designated control position
	// by pushing it on the position's array. This code will
	// implicitly add the control to the DOM, through the Map
	// object. You should not attach the control manually.
	map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv2);
	
	//end initialize mobile map
	}
	
	function centerMapOnLocation()
	{
		if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
		  initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
		  map.setCenter(initialLocation);
		  
		  me_marker = new google.maps.Marker({
			  position: initialLocation, 
			  map: map, 
			  title: "You are here.",
			  icon: phpVars.root + "/img/maps/" + "man_ns.png"
		  });  
		  
		}, function() {
		});
	  }
	}
	
	function handle_select()
	{
		var number = $("#show_event").val();
		
		open_info(number);
	}
	
	function open_info(rel_id)
	{
		var m = map_data[rel_id]["marker"];
		var i = map_data[rel_id]["infowindow"];
		var t = map_data[rel_id]["text_in_infowindow"];
		i.setContent(t);
		for (j = 0; j < map_data.length; j++) {
			map_data[j]["infowindow"].close();
		}
		i.open(map, m);
	}
	
	function bindInfoWindow(marker, map, infoWindow, html) {
	  google.maps.event.addListener(marker, 'click', function() {
		infoWindow.setContent(html);
		
		for (i = 0; i < map_data.length; i++) {
			map_data[i]["infowindow"].close();
		}
		infoWindow.open(map, marker);
	  });
	}
	
	</script>
	
	
</head>

<body>
<div id="size_box">

 <div id="m_map_container"></div>
 
 <div id="list_of_events" style="background: #fff; display: none; position: absolute; top: 0; left: 0; right: 0; z-index: 90000000; border: 1px solid #777; border-radius: 5px;">
 
 
 
<h1><?=$currenteventGroup['EventGroup']['name'];?></h1>
<div class="m_nav_bar">
<?php 
$getarr = $_GET;
unset($getarr['url']);
if (isset($getarr['viewType'])) unset($getarr['viewType']);
$getstr = "?";
foreach ($getarr as $key=>$value) {
	$getstr .= $key."=".$value."&"; 
}
if (!isset($_GET['viewType']))
	echo "<span class='nav_item'>List</span>";
else
	echo " ".$html->link('List', "/mob/view/".$id.$getstr, array('class' => 'nav_item' ));
if ($session->check('userid') && isset($_GET['viewType']) && $_GET['viewType'] == 'calendar')
	echo "<span class='nav_item'>Favorites</span>";
elseif ($session->check('userid'))
	echo " ".$html->link('Favorites', "/mob/view/".$id.$getstr."viewType=calendar", array('class' => 'nav_item' ));
echo " ".$html->link('Map', "/mob/map/".$id.$getstr, array('class' => 'nav_item', 'id' => 'map_button' ));
 ?>
 <div class="clear"></div>
</div>


<?php

if( count( $eventsUnderGroup )>0 )
{
	$i=0;
	foreach ($eventsUnderGroup as $event) {
		echo "<div class='m_event_block'>";
		printf('<a href="javascript:pan_and_close(%s)" class="m_event_title">%s</a><div class="m_event_time">%s</div>at %s posted by %s<br/>', $i, $event['Event']['title'], 
		date('g:i a \o\n n/d/y', strtotime($event['Event']['time_start']))." to ".date('g:i a \o\n n/d/y', strtotime($event['Event']['time_start'])+$event['Event']['duration']*60),
		$event['Event']['location'], 'path');
		echo $event['Event']['description'];
		echo "</div>";
		$i++;
	}
}
else
{
	?>
	
	<div class="m_event_block">No events match this set of filters.</div>
	
	<?php
}



?>

<div class="m_search">
	<h1>Search Again</h1>
	<form name="filter" id="filter" method="GET" action="<?php echo $html->url("/mob/view/".$id); ?>">
	<table>
		<tr>
			<th>Keywords</th><td><input type="text" name="search" id="search"></td>
		</tr>
		<tr>
			<th>Time Start</th><td><select name="time_start" id="time_start">
						<option value="0">midnight</option>
						<option value="1">1:00 am</option>
						<option value="2">2:00 am</option>
						<option value="3">3:00 am</option>
						
						<option value="4">4:00 am</option>
						<option value="5">5:00 am</option>
						<option value="6">6:00 am</option>
						<option value="7">7:00 am</option>
						
						<option value="8">8:00 am</option>
						<option value="9">9:00 am</option>
						<option value="10">10:00 am</option>
						<option value="11">11:00 am</option>
						
						<option value="12">noon</option>
						<option value="13">1:00 pm</option>
						<option value="14">2:00 pm</option>
						<option value="15">3:00 pm</option>
						
						<option value="16">4:00 pm</option>
						<option value="17">5:00 pm</option>
						<option value="18">6:00 pm</option>
						<option value="19">7:00 pm</option>
						
						<option value="20">8:00 pm</option>
						<option value="21">9:00 pm</option>
						<option value="22">10:00 pm</option>
						<option value="23">11:00 pm</option>
					</select></td>
		</tr>
		<tr>
			<th>Date Start</th><td><select name="date_start" id="date_start">
						
						<option value="04/07/2010">Thursday, Apr 7, 2011</option>
						<option value="04/08/2010">Friday, Apr 8, 2011</option>
						<option value="04/09/2010">Saturday, Apr 9, 2011</option>
						<option value="04/10/2010">Sunday, Apr 10, 2011</option>
					
					</select></td>
		</tr>
	</table>
	<div style="padding: 5px;"><input type="submit" value="go!"></div>
	</form>
</div>
 
 
 </div>
 
 <div id="m_mylocation_control" style="border: 1px solid #777; background: url(<?php echo $html->url("/css/smoothness/images/ui-bg_highlight-soft_75_cccccc_1x100.png")?>) center; margin: 5px; border-radius: 4px;" >
	<a href="javascript:alert('hey!')" id="my_location" style="color: #000; text-decoration: none; font-weight: bold; padding: 5px; display: block; float: left;" >My Location</a>
	<div style="clear: both"></div>
</div>
 
<div id="m_map_control" style="border: 1px solid #777; background: url(<?php echo $html->url("/css/smoothness/images/ui-bg_highlight-soft_75_cccccc_1x100.png")?>) center; margin: 5px; border-radius: 4px;" >
	<a href="javascript:alert('hey!')" id="back_to_event_list" style="color: #000; text-decoration: none; font-weight: bold; padding: 5px; display: block; float: left;" >Pick Event</a>
	<a href="<?=$html->url('/m/view/'.$id.$getstr)?>" style="color: #000; text-decoration: none; font-weight: bold; border-left: 1px #777 solid; padding: 5px; display: block; float: left;" >Back to List</a>
	<div style="clear: both"></div>
</div>

</div>
</body>

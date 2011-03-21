
function map_sizing() //handles resizing the map to fill the screen
{
	total_height = $(window).height();
	
	//first, measures how much the bars at the top take up
	if($("#desktop_map_window")) {
		top_bit = $("#desktop_map_window").offset().top;
	} else {
		top_bit = 0;
	}
	//then, resizes map accordingly
	$("#desktop_map_window").height(total_height - top_bit);
}

function initialize_desktop_map()
{
	//set the map resizer to activate when the page resizes
	map_sizing();
	$(window).resize( map_sizing );
	
	var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 15,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("desktop_map_container"),
        myOptions);
    
    map_data = eval($("#json_map_data").html());
    
    if( map_data.length > 0 )
    {
		//if there are events, it sets the center of the map to the first event returned as a result.
		//far from optimal - it should take some sort of weighted average of the lat and longs
		//location for possible upgrade
		
		latlng = new google.maps.LatLng(map_data[0]['Event']['latitude'], map_data[0]['Event']['longitude']);
		map.panTo(latlng);
    }
    else
    {
		//shows map of world if no results
		latlng = new google.maps.LatLng(0, 0);
		map.panTo(latlng);
		map.setZoom(2);
	}
    
	for (i = 0; i < map_data.length; i++) {
		//get the current event
		var event = map_data[i];
		
		var event_id = event['Event']['id'];
		map_data[i].myLatlng = new google.maps.LatLng(event['Event']['latitude'],event['Event']['longitude']);
		
		//getting the icons for the map markers
		var map_icon;
		var shadow_array = new Array( "a.png", "b.png", "c.png",
							"d.png", "e.png", "f.png", "g.png",
							"h.png", "i.png", "j.png" );
		
		//check if there is an icon for it; if not, use the generic one				
		if( i < shadow_array.length ) {
			map_icon = shadow_array[i];
		} else {
			map_icon = "rest.png";
		}

		map_icon = phpVars.root + "/img/maps/" + map_icon;
		
		map_data[i].marker = new google.maps.Marker({
			  position: map_data[i].myLatlng, 
			  map: map, 
			  title:event['Event']['title'],
			  icon: map_icon,
			  zIndex: 1000-i //so the icons appear in reverse order
		  });

		map_data[i].marker.id = i;
		map_data[i].time_start = new Date(event['Event']['time_start']);
		
		//building content for InfoWindow
		map_data[i].text_in_infowindow = $("#" + i + "_infowindow").html();
		map_data[i].infowindow = new google.maps.InfoWindow({
			content: map_data[i].text_in_infowindow
		});
		
		bindInfoWindow(map_data[i].marker, map, map_data[i].infowindow, map_data[i].text_in_infowindow);
	}
}

function open_window_by_i( number ) //open the window associated with that 'i'
{
	var m = map_data[number].marker;
	var i = map_data[number].infowindow;
	var t = map_data[number].text_in_infowindow;
	i.setContent(t);
	for (j = 0; j < map_data.length; j++) {
		map_data[j].infowindow.close();
	}
	i.open(map, m);
	
}

function bindInfoWindow(marker, map, infoWindow, html) //binds opening the infowindow to clicking on the marker
{
  google.maps.event.addListener(marker, 'click', function() {
    infoWindow.setContent(html);
    
    for (i = 0; i < map_data.length; i++) {
		map_data[i].infowindow.close();
	}
    infoWindow.open(map, marker);
  });
  
  google.maps.event.addListener(infoWindow, 'closeclick', function() {
    $("#mapViewId").val('');
    changeHash(removeFromHash(location.hash, 'mapViewId'));
  });
}

function map_open_by_id( id ) //open an infowindow based on the id of the event
{
	if( $("#event_id_" + id ).length == 1 )	{
		open_window_by_i( $("#event_id_" + id ).html() );
		changeHash(setInHash('mapViewId', id));
		$('#mapViewId').val(id);
	} else {
		changeHash(setInHash('mapViewId', ''));
		$('#mapViewId').val('');
	}
}

<div class="form_section">
<h2>Default Location</h2>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAA7y3UIBfi1OwkPnNUDew4MhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxTdgodaUd_SdFl6FS-YLDeZ4gdhpA&sensor=false"
            type="text/javascript"></script>
            <script src="http://www.google.com/uds/solutions/localsearch/gmlocalsearch.js" type="text/javascript"></script>

<style type="text/css">
      @import url("http://www.google.com/uds/css/gsearch.css");
      @import url("http://www.google.com/uds/solutions/localsearch/gmlocalsearch.css");
</style>

            
    <script type="text/javascript">

var myGoogleBar;
var map;
    function map_init() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map_container"));
        map.setCenter(new GLatLng(37.4419, -122.1419), 13);
        map.setUIToDefault();
        
        mySearchControl = new google.maps.LocalSearch();
        map.addControl( mySearchControl );
        
        
        mySearchControl.execute("Massachusetts Institute of Technology");
        
        GEvent.addListener(map, 'click', map_click_handler);
      }
    }

	var click_location = "no location";

	function map_click_handler( overlay, latlng )
	{
		map.openInfoWindow(latlng, "hello!");
	}
	
	$(document).ready( page_stuff );
	
	function page_stuff()
	{
		$("#map_open_button").click( open_map );
	
		$("#map_reopen_button").click( reopen_map );
	}
	
	function open_map( event )
	{ 
		event.preventDefault();
		
		$("#map_overlay").show();
		
		map_init();
	}

	function reopen_map( event )
	{ 
		event.preventDefault();
		
		$("#map_overlay").show();
	}

	function close_map()
	{
		$("#map_overlay").hide();
	}

	function save_location( event )
	{
		event.preventDefault();
		
		if(click_location == "no location")
		{
			alert("Please click a location on the map.");
		}
		else
		{
			$("#location_not_entered_block").hide();
			
			$("#map_lat_long").show();
			
			$("[name=lat]").val(click_location.lat());
			$("[name=long]").val(click_location.lng());
			
			close_map();
		}
	}

	function map_cancel()
	{
		event.preventDefault();
		
		close_map();
	}
	
	

    </script>
    
    <style type="text/css">
    .gmls-results-list {
	  opacity : 1;
	  -moz-opacity : 1;
	  filter:alpha(opacity=100);
	}

    
    </style>
    
    <div class="form_section">
        <h2>Location</h2>
        
        <label>Location Name</label>
        <input class="textfield" name="loc_name" type="text" />
        <p class="form_tip">Enter the name of the location as it should appear in the schedule.</p>
        
        <label>Location</label>
        
        <div id="location_not_entered_block">
            <p class="form_tip">Click the button below to select the location from a map:</p>
            
            <a href="#" class="make_button" id="map_open_button"><img src="rinoa/zoom.png" class="rinoa_small_inline" /> Find location on map</a>
            
            <p class="form_tip">or enter the exact address below:</p>
            
            <table><tr><td>Street Address</td><td>City</td><td>State</td></tr>
            <tr><td><input class="textfield" name="street_address" type="text" /></td><td><input class="textfield" name="city" type="text" value="Cambridge" /></td><td><input class="textfield" name="state" type="text" value="MA" style="width: 50px" /></td>
            </tr>
            </table>
        </div>
        
        <div id="map_lat_long" style="display: none;">
        	
           <p class="form_tip">Data from map:</p>
            
            <table><tr><td>Latitude</td><td>Longitude</td></tr>
            <tr><td><input class="textfield" name="lat" type="text" /></td><td><input class="textfield" name="long" type="text" /></td>
            </tr>
            </table>
            
             <p class="form_tip">Click the button below to select a different location:</p>
            
            <a href="#" class="make_button" id="map_reopen_button"><img src="rinoa/zoom.png" class="rinoa_small_inline" /> Change location</a>
        	
        </div>
        
        <p class="form_tip">Please provide an accurate location so that potential atendees can easily find your event.</p>
        
    </div>

	<div id="map_overlay">
		<div class="form_section">
		<h2>Click Location on Map</h2>
			<div id="map_wrapper">
				<div id="map_container">
			
			</div>
			</div>
			
			<div id="below_map">
				<div id="bm_right">
					<a href="#" class="make_button" onclick="save_location(event)">Save location</a>
					<a href="#" class="make_button" onclick="map_cancel(event)">Cancel</a>
				
				</div>
				
				<div id="bm_left">
					<p>Click a location to place the location marker. Drag the map to move it.</p>
				
				</div>
			
			
			</div>
		
		</div>
    
    </div>
<!--

<?php echo $form->input('location', array('type' => 'text', 'class' => 'textfield'));?> <a href="#" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png" class="rinoa_small_inline" /> Search within MIT</a> <a href="#" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png" class="<?php echo $html->url('/'); ?>css/rinoa_small_inline" /> Search Google Maps</a>
<p>As you start typing, a list of potential names will come up. We will search for this name in our database, and try to find it on a map.</p>

<iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=mit&amp;sll=37.0625,-95.677068&amp;sspn=59.467068,51.064453&amp;ie=UTF8&amp;hq=Massachusetts+Institute+of+Technology&amp;hnear=Massachusetts+Institute+of+Technology,+Boston,+Suffolk,+Massachusetts+02139&amp;ll=42.360538,-71.090074&amp;spn=0.019788,0.038418&amp;output=embed"></iframe>
    
    -->
        
</div>

<div class="form_section">

<h2>
<?php
if( isset( $whichForm ) )
{
	if( $whichForm == "toplevel" || $whichForm == "subgroup" )
	{
		echo "Default Location";
	}
}
else {
	
	echo "Location";
	
} ?>
</h2>

<?php if( isset( $whichForm ) && $whichForm == "toplevel" )
{
	echo "<p class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> This will be the default location for all events and subgroups in this [conference].  It should be a general area, such as a conference center, university, or city, rather than a specific street address or room.</p>";
}
else if( isset( $whichForm ) && $whichForm == "subgroup" )
{
	echo "<p class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> This will be the default location for all events and subgroups in this group.  It should be the specific building or street address where this group will have most of their events.</p>";
}
 ?>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $MAPS_API_KEY;?>&sensor=false"
            type="text/javascript"></script>
            <script src="http://www.google.com/uds/api?file=uds.js&v=1.0&key=<?php echo $MAPS_API_KEY;?>" type="text/javascript"></script>

            <script src="http://www.google.com/uds/solutions/localsearch/gmlocalsearch.js" type="text/javascript"></script>

<style type="text/css">
      @import url("http://www.google.com/uds/css/gsearch.css");
      @import url("http://www.google.com/uds/solutions/localsearch/gmlocalsearch.css");
</style>

            
    <script type="text/javascript">

var mySearchControl;
var map;
var default_zoom_level = 16;
var hasBeenInit = false;

    function map_init() {
      if (GBrowserIsCompatible()) {
		  
		var myMapOptions = {
			googleBarOptions: {
				onGenerateMarkerHtmlCallback: html_rewriter,
				
			}
		};
		  
		  
        map = new GMap2(document.getElementById("map_container"), myMapOptions);
        map.setCenter(new GLatLng(<?php echo $centerLat;?>, <?php echo $centerLong;?>), 13);
        map.setUIToDefault();
        
        /*mySearchControl = new google.maps.LocalSearch();
        map.addControl( mySearchControl );

        mySearchControl.execute("Massachusetts Institute of Technology");*/
        
        map.enableGoogleBar();
        
        map.setZoom(  default_zoom_level );
        
        GEvent.addListener(map, 'click', map_click_handler);
        
        map.enableContinuousZoom();
        hasBeenInit = true;

      }
    }

	var click_location = "no location";

	function html_rewriter( marker, prev_html, search_result)
	{
		latlng = marker.getLatLng();
		
		message = generate_info_window( search_result.title, latlng.lat(), latlng.lng() );
		
		map.setZoom(  default_zoom_level );
		
		return message;
		
	}
	
	function generate_info_window( title, lat, lng )
	{
		message = "<div class='gmaps_popup_message'><strong>You have selected the following location:</strong>";
		
		if( title != "" )
		{
			message += "<br />"+ title;
		}
		message += "<br />" + lat + ", " + lng;
		
		message += "<div class='gpm_buttons'><a href='javascript:save_lat_lng(" + lat +", " + lng + ")' class='make_button'>Save this location</a> <a href='javascript:close_info_window()' class='make_button'>Close popup</a></div></div>";
		
		return message;
	}
	
	function save_lat_lng( lat, lng )
	{
		$("#location_not_entered_block").hide();
			
		$("#map_lat_long").show();
		
		$("#latInput").val(lat);
		$("#longInput").val(lng);
		
		$("#staticmap").attr("src", "http://maps.google.com/maps/api/staticmap?center=" + lat + "," + lng + "&zoom=18&size=400x300&maptype=roadmap&markers=color:red|label:A|" + lat + "," + lng + "&sensor=false");
		$("#staticmap_out").attr("src", "http://maps.google.com/maps/api/staticmap?center=" + lat + "," + lng + "&zoom=16&size=200x300&maptype=roadmap&markers=color:red|label:A|" + lat + "," + lng + "&sensor=false");
		$("#staticmap_in").attr("src", "http://maps.google.com/maps/api/staticmap?center=" + lat + "," + lng + "&zoom=12&size=200x300&maptype=roadmap&markers=color:red|label:A|" + lat + "," + lng + "&sensor=false");
		
		close_map();
	}
	
	function close_info_window()
	{
		map.getInfoWindow().hide();
	}

	function map_click_handler( overlay, latlng )
	{
		if (latlng != null) {
			message = generate_info_window( "", latlng.lat(), latlng.lng() );
			
			map.openInfoWindow(latlng, message);
			
			click_location = latlng;
			
			$("make_button").button();
		}
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
		$("#overlay").fadeIn("slow");
		
		map_init();
	}
	
	function reopen_no_event()
	{
		$("#map_overlay").show();
		$("#overlay").fadeIn("slow");
		if (!hasBeenInit) {
			map_init();
			var tmplatlng = new GLatLng('<?php echo $centerLat?>', '<?php echo $centerLong; ?>');
			message = generate_info_window( "", tmplatlng.lat(), tmplatlng.lng() );
			map.openInfoWindow(tmplatlng, message);
		}
	}

	function reopen_map( event )
	{ 
		event.preventDefault();
		
		$("#map_overlay").show();
		$("#overlay").fadeIn("slow");
		if (!hasBeenInit) {
			map_init();
			var tmplatlng = new GLatLng('<?php echo $centerLat?>', '<?php echo $centerLong; ?>');
			message = generate_info_window( "", tmplatlng.lat(), tmplatlng.lng() );
			map.openInfoWindow(tmplatlng, message);
		}
	}

	function close_map()
	{
		$("#map_overlay").hide();
		$("#overlay").fadeOut();
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

			$("#latInput").val(click_location.lat());
			$("#longInput").val(click_location.lng());
			
			close_map();
		}
	}

	function map_cancel( event )
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
	
	.gmls {
   width: 350px;
   display: block;
   padding-left: 100px;
 }
    
    </style>

        
        <label>Location Name</label>
<!--        <input class="textfield" name="data[<?=$type?>][location]" type="text" />-->
        <?php echo $form->text('location', array('class' => 'textfield'));?>
        <p class="form_tip">Enter the name of the location as it should appear in the schedule.</p>
        
        <label>Location on Map</label>
        

        <div id="location_not_entered_block" <?php if ($hasDefault) echo "style='display:none;'";?>>            
            <a href="#" class="make_button" id="map_open_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png" class="rinoa_small_inline" /> Find location on map</a>
            
            <p class="form_tip">Click the button above to place the location on a map.</p>
            <!--
            <p class="form_tip">or enter the exact address below:</p>
            
            <table><tr><td>Street Address</td><td>City</td><td>State</td></tr>
            <tr><td><input class="textfield" name="street_address" type="text" /></td><td><input class="textfield" name="city" type="text" value="Cambridge" /></td><td><input class="textfield" name="state" type="text" value="MA" style="width: 50px" /></td>
            </tr>
            </table>-->
        </div>
        
        <div id="map_lat_long"  <?php if (!$hasDefault) echo "style='display:none;'";?>>
            
            <a href="javascript:reopen_no_event()"><img id='staticmap' src="http://maps.google.com/maps/api/staticmap?center=<?php echo $centerLat; ?>,<?php echo $centerLong; ?>&zoom=16&size=400x300&maptype=roadmap&markers=color:red|label:A|<?php echo $centerLat; ?>,<?php echo $centerLong; ?>&sensor=false" />
            <img id='staticmap_out' src="http://maps.google.com/maps/api/staticmap?center=<?php echo $centerLat; ?>,<?php echo $centerLong; ?>&zoom=12&size=200x300&maptype=roadmap&markers=color:red|label:A|<?php echo $centerLat; ?>,<?php echo $centerLong; ?>&sensor=false" />
            <img id='staticmap_in' src="http://maps.google.com/maps/api/staticmap?center=<?php echo $centerLat; ?>,<?php echo $centerLong; ?>&zoom=18&size=200x300&maptype=roadmap&markers=color:red|label:A|<?php echo $centerLat; ?>,<?php echo $centerLong; ?>&sensor=false" /></a>
            
            <table style="display: none;"><tr><td>Latitude</td><td>Longitude</td></tr>
            <tr><td><input class="textfield" name="data[<?=$type?>][latitude]" id="latInput" type="text"  <?php if ($hasDefault) echo "value='".$centerLat."'";?> /></td>
            <td><input class="textfield" name="data[<?=$type?>][longitude]" id="longInput" type="text" <?php if ($hasDefault) echo "value='".$centerLong."'";?>/></td>
            </tr>
            </table>
            <div></div>
            <a href="#" class="make_button" id="map_reopen_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png" class="rinoa_small_inline" /> Change location</a>
        	
        </div>
        
    </div>
    
    <div class="ui-widget-overlay" id="overlay" style="width: 100%; height: 100%; z-index: 500; display: none; position: fixed;"></div>

	<div id="map_overlay">
		<div class="form_section">
		<h2>Click Location on Map</h2>
			<div id="map_wrapper">
				<div id="map_container">
			
			</div>
			</div>
			
			<div id="below_map">
				<div id="bm_right">
					<a href="javascript:close_map()" class="make_button">Cancel</a>
				
				</div>
				
				<div id="bm_left">
					<p class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> Use the search bar above to find places, or click on the map to select a location.</p>
				
				</div>
			
			
			</div>
		
		</div>

<!--

<?php echo $form->input('location', array('type' => 'text', 'class' => 'textfield'));?> <a href="#" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png" class="rinoa_small_inline" /> Search within MIT</a> <a href="#" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png" class="<?php echo $html->url('/'); ?>css/rinoa_small_inline" /> Search Google Maps</a>
<p>As you start typing, a list of potential names will come up. We will search for this name in our database, and try to find it on a map.</p>

<iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=mit&amp;sll=37.0625,-95.677068&amp;sspn=59.467068,51.064453&amp;ie=UTF8&amp;hq=Massachusetts+Institute+of+Technology&amp;hnear=Massachusetts+Institute+of+Technology,+Boston,+Suffolk,+Massachusetts+02139&amp;ll=42.360538,-71.090074&amp;spn=0.019788,0.038418&amp;output=embed"></iframe>
    
    -->
        
</div>

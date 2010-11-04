<?php echo $html->css('event_page', 'stylesheet', array('media'=>'all' ), false); ?>

<script>

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

$(document).ready( function(){

	setInterval( "update_time()", 1000 );
	
	$(".make_button").button();
	
});

</script>

    
    <div id="conference_header">
    
		
        
        <div id="ch_right">
        	<div class="curr_time_large">It's currently <span id="curr_time">7:55 pm</span> on <span id="curr_date">August 27, 2010</span></div>
        </div>
        
        <div class="clear"></div>
    </div>
    <div id="main_tabs">
    <ul id="mt_list">
    	<li class="mt_tab"><a href="#">Overview</a></li>
        <li class="mt_tab"><a class="active" href="#">Timeline</a></li>
        <li class="mt_tab"><a href="#">Map</a></li>
    </ul>
    <div class="clear"></div>
    </div>
    
    <div id="event_page_content">
    
    <a href="<?=$html->url('/').$groupPath[count($groupPath)-1]['EventGroup']['path']?>" class="make_button"><img class="small_icon_inline_button" src="<?php echo $html->url('/'); ?>css/rinoa/back.png" />Back to timeline</a>
    
    <div id="breadcrumb">
                <div class="nav_title">currently viewing</div>
                <?php 
				$linksArr = array($html->link(__('Home', true), array('action' => 'index')));
				foreach ($groupPath as $single) {
					$linksArr[] = $html->link($single['EventGroup']['name'], "/".$single['EventGroup']['path']);
				}
				echo implode($linksArr," > ");
				echo " > ".$event['Event']['title'];
				?>
    </div>
    
    <div class="hr"></div>
    
    <?php if(isset($event['Event']['latitude']))
    { ?>
    
    <div class="event_location_box">
        <h2>Location</h2>
        <div class="event_loc_name"><?=$event['Event']['location']?></div>
        <br />
        
        <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $MAPS_API_KEY;?>&sensor=false"
            type="text/javascript"></script>
            <script src="http://www.google.com/uds/api?file=uds.js&v=1.0&key=ABQIAAAA7y3UIBfi1OwkPnNUDew4MhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxTdgodaUd_SdFl6FS-YLDeZ4gdhpA" type="text/javascript"></script>


<style type="text/css">
      @import url("http://www.google.com/uds/css/gsearch.css");
</style>
        
        <script type="text/javascript">
        
		var map;
		var default_zoom_level = 16;

			function map_init() {
			  if (GBrowserIsCompatible()) {
				  
				  
				map = new GMap2(document.getElementById("event_map_container"));
				map.setCenter(new GLatLng(<?php echo $event['Event']['latitude'];?>, <?php echo $event['Event']['longitude']; ?>), default_zoom_level);
				map.setUIToDefault();
				
				map.setZoom(  default_zoom_level );
				
				map.enableContinuousZoom();
				
				map.addOverlay( new GMarker( new GLatLng(<?php echo $event['Event']['latitude'];?>, <?php echo $event['Event']['longitude']; ?>) ) );

			  }
			}
			
			$(document).ready( map_init );
        </script>
        
        <div id="event_map_container" style="width: 100%; height: 300px;"></div>
        
            <div class="map_links">
            <a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=mit+baker+house&amp;sll=37.0625,-95.677068&amp;sspn=59.467068,52.822266&amp;ie=UTF8&amp;hq=&amp;hnear=Baker+House,+Cambridge,+Middlesex,+Massachusetts+02139&amp;ll=42.356763,-71.095785&amp;spn=0.013764,0.012896&amp;z=14">Directions</a> |
            
            <a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=mit+baker+house&amp;sll=37.0625,-95.677068&amp;sspn=59.467068,52.822266&amp;ie=UTF8&amp;hq=&amp;hnear=Baker+House,+Cambridge,+Middlesex,+Massachusetts+02139&amp;ll=42.356763,-71.095785&amp;spn=0.013764,0.012896&amp;z=14">Other events at Baker Hall</a> |
            
            <a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=mit+baker+house&amp;sll=37.0625,-95.677068&amp;sspn=59.467068,52.822266&amp;ie=UTF8&amp;hq=&amp;hnear=Baker+House,+Cambridge,+Middlesex,+Massachusetts+02139&amp;ll=42.356763,-71.095785&amp;spn=0.013764,0.012896&amp;z=14">Larger map</a>
            </div>
        
        
        
        </div>
        
        <?php }
         else
        { ?>
        
        location not specified
        
        <?php
        
	}
        
        ?>
    
    <h1 class="event_name"><?=$event['Event']['title']?></h1>
    
    <?php if ($access->check('EventGroup',$event['Event']['event_group_id'], 'create')) {
			echo $html->link(__('Edit', true), array('controller' => 'events', 'action' => 'edit', $event['Event']['id'])); 
		}?>
		<?php if ($access->check('EventGroup',$event['Event']['event_group_id'], 'create')) {
			echo $html->link(__('Delete', true), array('controller' => 'events', 'action' => 'delete', $event['Event']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $event['Event']['id'])); 
		}?>
		
		<br />
    
    <a href="#" class="make_button"><img class="small_icon_inline_button" src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png" />Add to my schedule</a>
    <!--<a href="#" class="make_button"><img class="small_icon_inline_button" src="<?php echo $html->url('/'); ?>css/rinoa/group.png" />Share on Facebook</a>
    <a href="#" class="make_button"><img class="small_icon_inline_button" src="<?php echo $html->url('/'); ?>css/rinoa/email.png" />Invite friends by email</a>-->
    
    <div class="event_time"><?=date('g a', strtotime($event['Event']['time_start']))?> to <?=date('g a', strtotime($event['Event']['time_start'])+$event['Event']['duration']*60)?>, <?=date('F j, Y', strtotime($event['Event']['time_start']))?>
    
    <!--<br /><small><a href="#">view other events at this time</a></small> --></div>
  
        
    <h3>Description</h3>
    <p><?=$event['Event']['description']?></p>
    
    <h3>Tags</h3>
    <p>
    
    <?php 
    if (count($event['CategoryChoice'])>0) {
		$categoryLinks = array();
		foreach ($event['CategoryChoice'] as $category) { 
			$categoryLinks[] = "<a class=\"group_1 categoryLink\" hiddenclass='categoryLink-".$category['id']."' href=\"".$html->url('/').$groupPath[count($groupPath)-1]['EventGroup']['path']."#categorycheckbox-".$category['id']."=true\">".$category['name']."</a>";
		} 
		echo implode(", ",$categoryLinks);
	}?> 
	</p>
    
    </div>

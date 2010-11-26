<div id="event_page_content">
<?php if(isset($event['Event']['latitude'])) { ?>
	<div class="event_location_box">
		<h2>Location</h2>
		<div class="event_loc_name"><?=$event['Event']['location']?></div>
		<br />
		<div id="event_map_container" style="width: 100%; height: 300px;"></div>
		
		<div class="map_links">
<!--			<a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=mit+baker+house&amp;sll=37.0625,-95.677068&amp;sspn=59.467068,52.822266&amp;ie=UTF8&amp;hq=&amp;hnear=Baker+House,+Cambridge,+Middlesex,+Massachusetts+02139&amp;ll=42.356763,-71.095785&amp;spn=0.013764,0.012896&amp;z=14">Directions</a>-->
<!--			| <a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=mit+baker+house&amp;sll=37.0625,-95.677068&amp;sspn=59.467068,52.822266&amp;ie=UTF8&amp;hq=&amp;hnear=Baker+House,+Cambridge,+Middlesex,+Massachusetts+02139&amp;ll=42.356763,-71.095785&amp;spn=0.013764,0.012896&amp;z=14">Other events at Baker Hall</a> -->
<!--			| <a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=mit+baker+house&amp;sll=37.0625,-95.677068&amp;sspn=59.467068,52.822266&amp;ie=UTF8&amp;hq=&amp;hnear=Baker+House,+Cambridge,+Middlesex,+Massachusetts+02139&amp;ll=42.356763,-71.095785&amp;spn=0.013764,0.012896&amp;z=14">Larger map</a>-->
		</div>
	</div>

<?php 
}
?>

<h1 class="event_name"><?=$event['Event']['title']?></h1>
<?php
//$onUserCalendar = false;
//foreach ($event['User'] as $user) {
//	if ($user['email'] == $session->read('username')) {
//		$onUserCalendar = true;
//		break;
//	}
//}
?>
<div class="event_time">
	<b>From:</b> <?=date('m/d/Y g:i a', strtotime($event['Event']['time_start']))?><br />
	<b>To:</b> <?=date('m/d/Y g:i a', strtotime($event['Event']['time_start'])+$event['Event']['duration']*60)?>
</div>
<hr/>
<h3><b>Description</b></h3>

<p><?=$event['Event']['description']?></p>
</div>
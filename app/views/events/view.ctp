<div id="event_page_content">
<?php if(isset($event['Event']['latitude'])) { ?>
	<div class="event_location_box">
		<h2>Location: <?=$event['Event']['location']?></h2>
		<div class="map_links">
			<a href="#">View larger map</a> | <a href="#">Get directions</a>
		
		</div>
		<div id="event_map_container" style="width: 100%; height: 300px;"></div>
		
		
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

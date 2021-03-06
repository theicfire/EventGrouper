<div id="event_page_content">

<table>
	<tr>
		<td colspan="2"><h1 class="event_name"><?=$event['Event']['title']?></h1></td>
	</tr>
	<tr>
		<th>Time</th>
		<td><?=date('F j Y \a\t g:i a', strtotime($event['Event']['time_start']))?> - <?=date('F j Y \a\t g:i a', strtotime($event['Event']['time_start'])+$event['Event']['duration']*60)?></td>
	</tr>
	<tr>
		<th>Location</th><td><a href="javascript:goto_on_map(<?=$event['Event']['id']?>)"><?=$event['Event']['location']?></a></td>
	</tr>
	<tr>
		<th>Posted by</th><td><?= $this->element('grouppath', array('groupStr' => $event['EventGroup']['path'], 'highestName' => $event['EventGroup']['highest_name']))?></td>
	</tr>
	<tr>
		<th>Description</th><td><?=$event['Event']['description']?></td>
	</tr>
</table>

<a href="javascript:goto_on_map(<?=$event['Event']['id']?>)">View Larger Map</a> | <a href="http://maps.google.com/maps?hl=en&daddr=<?=$event['Event']['latitude']?>,<?=$event['Event']['longitude']?>">Get Directions</a>
<div id="event_map_container" style="width: 100%; height: 200px;"></div>
</div>

<!--
<?php if(isset($event['Event']['latitude'])) { ?>
	<div class="event_location_box">
		
		<div class="map_links">
			<a href="#">View larger map</a> | <a href="#">Get directions</a>
		
		</div>
		
		
		
	</div>

<?php 
}
?> -->

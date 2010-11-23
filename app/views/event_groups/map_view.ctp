<div id="desktop_map_window">
<div id="desktop_map_event_list">
<h2>Search Results</h2>

						<?php
						echo "<span id='json_map_data' style='display: none'>";
						echo json_encode($eventsUnderGroup);
						echo "</span>";
						?>
<div id="map_search_result_list">
<?php 
$i = 0;
$imageArr = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'rest');
foreach ($eventsUnderGroup as $event) {
	printf('<div class="map_search_result"><img src="/eventgrouper/img/maps/%s_ns.png" class="msr_icon"><h3 class="msr_title">%s</h3><p>%s</p></div>', 
	$imageArr[$i], $event['Event']['title'], date('n/j/y g:m:s', strtotime($event['Event']['title']['time_start'])));
	$i++;
	if ($i >= count($imageArr)) $i = count($imageArr)-1; 
}?>
</div>
</div>


<div id="desktop_map_container">


</div>
</div>

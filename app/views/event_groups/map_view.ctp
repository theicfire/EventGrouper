<!-- <?php print_r($eventsUnderGroup); ?> lol -->

<div id="desktop_map_window">
<div id="desktop_map_event_list">
<h2>Search Results</h2>

						<?php
						echo "<span id='json_map_data' style='display: none'>";
						echo json_encode($eventsUnderGroup);
						echo "</span>";
						?>
<div id="map_search_result_list"></div>
</div>


<div id="desktop_map_container">


</div>
</div>

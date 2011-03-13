
<?php 
if (isset($curPage)) {
	if ($curPage != 1) {
		echo '<a href="javascript:prev_page()" class="button_small" id="prevpage"><label class="button_label">Previous Page</label></a>';
	}
	if ($curPage-2 > 1) {
		echo "...";
	}
	for ($i = $curPage-2; $i <= $curPage+2; $i++) {
		if ($i > 0 && $i < $totalEventCount/$eventsPerPage){ // page is hardcoded
			$style = "";
			if ($i == $curPage) $style = "style='font-weight:bold'";
			echo "<a href=\"javascript:go_to_page(".$i.")\" class=\"button_small\" ".$style.">".$i."</a> ";
		}
	}
	
	if ($curPage < ($totalEventCount-1)/$eventsPerPage-1) {
		echo '<a href="javascript:next_page()" class="button_small" id="nextpage"><label class="button_label">Next Page</label></a>';
	}
}
?>

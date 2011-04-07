
<?php 
if (isset($curPage)) { ?>
<div>
<div class="paginate_box">

<?php

	$numPages = ceil($totalEventCount/$eventsPerPage);
	$firstPage = $curPage == 1;
	$lastPage = $curPage == $numPages;
	
	echo 'Displaying results ' . (($curPage-1)*$eventsPerPage+1) . ' to ' . min(($curPage)*$eventsPerPage, $totalEventCount) . ' out of ' . $totalEventCount . '. ';

	if (! $firstPage) {
		echo '<a href="javascript:prev_page()" id="prevpage"><label class="button_label">Previous Page</label></a>';
	}
	if ($curPage-2 > 1) {
		echo " ...";
	}
	
	if( $numPages > 1 ){
		for ($i = $curPage-2; $i <= $curPage+2; $i++) {
			if ($i > 0 && $i <= $numPages){ // page is hardcoded
				$style = "";
				if ($i == $curPage) $style = "class='p_active_page'";
				echo " <a href=\"javascript:go_to_page(".$i.")\" ".$style.">".$i."</a> ";
			}
		}
	}
	
	if ($curPage+2 < $numPages) {
		echo " ...";
	}
	
	if (! $lastPage) {
		echo ' <a href="javascript:next_page()" id="nextpage"><label class="button_label">Next Page</label></a>';
	}
	/*
	if( $numPages > 1){
		?>
		| go to page: 
		<input type="text" id="goToPageBox" style="width: 20px"  />
		<a href="javascript:go_to_typed_page(<?php echo $numPages; ?>);">go</a>
		<?php
	} */
	
	?>
	
	</div>
	
	<div class="clear"></div>
	</div>
	
	<?php
}
?>

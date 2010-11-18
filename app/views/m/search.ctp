<div class="m_search">
	<h1><h1>Search: <?=$currenteventGroup['EventGroup']['name'];?></h1></h1>
	<form name="filter" id="filter" method="GET" action="<?php echo $html->url("/mob/view/".$id); ?>">
	<table>
		<tr>
			<th>Keywords</th><td><input type="text" name="search" id="search"></td>
		</tr>
		<tr>
			<th>Time Start</th><td><input type="text" name="time_start" id="time_start"></td>
		</tr>
		<tr>
			<th>Date Start</th><td><input type="text" name="date_start" id="date_start"></td>
		</tr>
	</table>
	<div style="padding: 5px;"><input type="submit" value="go!"></div>
	</form>
</div>

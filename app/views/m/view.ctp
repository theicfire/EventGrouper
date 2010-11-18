
<h1><?=$currenteventGroup['EventGroup']['name'];?></h1>
<div class="m_nav_bar">
<?php 
$getarr = $_GET;
unset($getarr['url']);
if (isset($getarr['viewType'])) unset($getarr['viewType']);
$getstr = "?";
foreach ($getarr as $key=>$value) {
	$getstr .= $key."=".$value."&"; 
}
if (!isset($_GET['viewType']))
	echo "<span class='nav_item'>Schedule</span>";
else
	echo " ".$html->link('Schedule', "/mob/view/".$id.$getstr, array('class' => 'nav_item' ));
if ($session->check('userid') && isset($_GET['viewType']) && $_GET['viewType'] == 'calendar')
	echo "<span class='nav_item'>Favorites</span>";
elseif ($session->check('userid'))
	echo " ".$html->link('Favorites', "/mob/view/".$id.$getstr."viewType=calendar", array('class' => 'nav_item' ));
echo " ".$html->link('Map', "/mob/map/".$id.$getstr, array('class' => 'nav_item' ));
 ?>
 <div class="clear"></div>
</div>


<?php

if( count( $eventsUnderGroup )>0 )
{
	foreach ($eventsUnderGroup as $event) {
		echo "<div class='m_event_block'>";
		printf('<a href="#" class="m_event_title">%s</a><div class="m_event_time">%s</div>at %s posted by %s<br/>', $event['Event']['title'], 
		date('g:i a \o\n n/d/y', strtotime($event['Event']['time_start']))." to ".date('g:i a \o\n n/d/y', strtotime($event['Event']['time_start'])+$event['Event']['duration']*60),
		$event['Event']['location'], 'path');
		echo $event['Event']['description'];
		echo "</div>";
	}
}
else
{
	?>
	
	<div class="m_event_block">No events match this set of filters.</div>
	
	<?php
}



?>

<div class="m_search">
	<h1>Search Again</h1>
	<form name="filter" id="filter" method="GET" action="<?php echo $html->url("/mob/view/".$id); ?>">
	<table>
		<tr>
			<th>Keywords</th><td><input type="text" name="search" id="search" value="<?php echo $urlParams['search']?>"></td>
		</tr>
		<tr>
			<th>Time Start</th><td><input type="text" name="time_start" id="time_start" value="<?php echo $urlParams['time_start']?>"></td>
		</tr>
		<tr>
			<th>Date Start</th><td><input type="text" name="date_start" id="date_start" value="<?php echo $urlParams['date_start']?>"></td>
		</tr>
	</table>
	<div style="padding: 5px;"><input type="submit" value="go!"></div>
	</form>
</div>


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
	echo "<span class='nav_item'>List</span>";
else
	echo " ".$html->link('List', "/mob/view/".$id.$getstr, array('class' => 'nav_item' ));
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
			<th>Keywords</th><td><input type="text" name="search" id="search"></td>
		</tr>
		<tr>
			<th>Time Start</th><td><select name="time_start" id="time_start">
						<option value="0">midnight</option>
						<option value="1">1:00 am</option>
						<option value="2">2:00 am</option>
						<option value="3">3:00 am</option>
						
						<option value="4">4:00 am</option>
						<option value="5">5:00 am</option>
						<option value="6">6:00 am</option>
						<option value="7">7:00 am</option>
						
						<option value="8">8:00 am</option>
						<option value="9">9:00 am</option>
						<option value="10">10:00 am</option>
						<option value="11">11:00 am</option>
						
						<option value="12">noon</option>
						<option value="13">1:00 pm</option>
						<option value="14">2:00 pm</option>
						<option value="15">3:00 pm</option>
						
						<option value="16">4:00 pm</option>
						<option value="17">5:00 pm</option>
						<option value="18">6:00 pm</option>
						<option value="19">7:00 pm</option>
						
						<option value="20">8:00 pm</option>
						<option value="21">9:00 pm</option>
						<option value="22">10:00 pm</option>
						<option value="23">11:00 pm</option>
					</select></td>
		</tr>
		<tr>
			<th>Date Start</th><td><select name="date_start" id="date_start">
						
						<option value="04/07/2010">Thursday, Apr 7, 2011</option>
						<option value="04/08/2010">Friday, Apr 8, 2011</option>
						<option value="04/09/2010">Saturday, Apr 9, 2011</option>
						<option value="04/10/2010">Sunday, Apr 10, 2011</option>
					
					</select></td>
		</tr>
	</table>
	<div style="padding: 5px;"><input type="submit" value="go!"></div>
	</form>
</div>

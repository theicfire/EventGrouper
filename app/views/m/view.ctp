<?php 
$getarr = $_GET;
unset($getarr['url']);
if (isset($getarr['viewType'])) unset($getarr['viewType']);
$getstr = "?";
foreach ($getarr as $key=>$value) {
	$getstr .= $key."=".$value."&"; 
}
if (!isset($_GET['viewType']))
	echo "Normal View";
else
	echo " ".$html->link('Normal View', "/mob/view/".$id.$getstr);
if ($session->check('userid') && isset($_GET['viewType']) && $_GET['viewType'] == 'calendar')
	echo " Favorites ";
elseif ($session->check('userid'))
	echo " ".$html->link('Favorites', "/mob/view/".$id.$getstr."viewType=calendar");
echo " ".$html->link('Map', "/mob/map/".$id.$getstr);
 
echo "<br/>";



foreach ($eventsUnderGroup as $event) {
	echo "<div>";
	printf('<a href="#">%s</a> %s at %s posted by %s<br/>', $event['Event']['title'], 
	date('g:i a', strtotime($event['Event']['time_start']))." to ".date('g:i a', strtotime($event['Event']['time_start'])+$event['Event']['duration']*60),
	$event['Event']['location'], 'path');
	echo $event['Event']['description'];
	echo "</div><hr/>";
}?>
<?php
$getarr = $_GET;
unset($getarr['url']);
$getstr = "?";
foreach ($getarr as $key=>$value) {
	$getstr .= $key."=".$value."&"; 
}
echo $html->link('Normal View', "/mob/view/".$id."?".$getstr);
if ($session->check('userid'))
	echo " ".$html->link('Favorites', "/mob/view/".$id."?".$getstr."viewType=calendar");
echo " Map";
 
echo "<br/>";
print_r($eventsUnderGroup);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" 
      xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Mobile EventGrouper | '); ?>
		<?php echo $title_for_layout; ?>
	</title>
    
	<?php
		echo $this->Html->meta('icon');
		echo $scripts_for_layout;
		echo $html->css(array('mobile.css')); 
		
	?>
	
	
</head>

<body>

<div id="m_map_top_bar">
<?php
$getarr = $_GET;
unset($getarr['url']);
$getstr = "?";
foreach ($getarr as $key=>$value) {
	$getstr .= $key."=".$value."&"; 
}
echo $html->link('Schedule', "/mob/view/".$id."?".$getstr);
if ($session->check('userid'))
	echo " ".$html->link('Favorites', "/mob/view/".$id."?".$getstr."viewType=calendar");
echo " Map";
 ?>
 </div>
 
 <div id="m_map_container"></div>
 
 
 <div id="m_map_bottom_bar"></div>
 <?php
echo "<br/>";
print_r($eventsUnderGroup);

?>
</body>

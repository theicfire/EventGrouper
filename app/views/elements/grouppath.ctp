<?php 
$linksArr = array($html->link(__('Home', true), array('action' => 'index')));
if ($groupPath != null) {
	foreach ($groupPath as $single) {
		$linksArr[] = $html->link($single['EventGroup']['name'], "/".$single['EventGroup']['path']);
	}
}
echo implode($linksArr," > ");
?>
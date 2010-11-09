<?php 
$linksArr = array();
if ($groupPath != null) {
	foreach ($groupPath as $single) {
		if (isset($isAdmin)) {
			if ($access->check('EventGroup',$single['EventGroup']['id'], 'create')) {
				$linksArr[] = $html->link($single['EventGroup']['name'], "/event_groups/view_admin/".$single['EventGroup']['id']);
			} else {
				$linksArr[] = $single['EventGroup']['name'];
			}
		} else {
			$linksArr[] = $html->link($single['EventGroup']['name'], "/".$single['EventGroup']['path']);
		}
	}
}
echo implode($linksArr," > ");
?>
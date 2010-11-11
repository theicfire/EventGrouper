<?php 
$groupPath = array();
$pathArr = explode("/", $groupStr);
$curPath = "";
for ($i = 0; $i < count($pathArr); $i++) {
	$curPath .= "/".$pathArr[$i];
	$groupPath[$i]['EventGroup'] = array('name' => $pathArr[$i], 'path' => $curPath);
	
}
$linksArr = array();
if ($groupPath != null) {
	foreach ($groupPath as $single) {
		if (isset($isAdmin)) {
				$linksArr[] = $html->link(urldecodecustom($single['EventGroup']['name']), "/event_groups/view_admin/".$single['EventGroup']['path']);
		} else {
			$linksArr[] = $html->link(urldecodecustom($single['EventGroup']['name']), "/".$single['EventGroup']['path']);
		}
	}
}
echo implode($linksArr," > ");


?>
<?php 
$groupPath = array();
$pathArr = explode("/", $groupStr);
$curPath = "";
for ($i = 0; $i < count($pathArr); $i++) {
	$curPath .= "/".$pathArr[$i];
	$name = $pathArr[$i];
	if ($i == 0) {
		$name = $highestName;
	}
	$groupPath[$i]['EventGroup'] = array('name' => $name, 'path' => $curPath);
	
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
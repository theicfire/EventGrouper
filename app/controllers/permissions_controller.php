<?php
class PermissionsController extends AppController {

	var $name = 'Permissions';
	var $uses = array('EventGroup', 'User', 'UserAlias', 'Event', 'UserPerm');
	var $helpers = array('Html', 'Form', 'Javascript', 'Navigation');
	var $components = array('MyAcl', 'Email');


	function delete($groupId, $userId) {
		$this->autoRender = false;
		$children = $this->EventGroup->getAllEventGroupsUnderThis($groupId);
		$this->UserPerm->deletePerm($userId, $children);
		$this->Session->setFlash(__('Permission deleted', true));
		$newGroup = $this->EventGroup->findById($groupId);
		$this->redirect("/event_groups/view_admin/".$newGroup['EventGroup']['path']);
		
	}	
	function trash2() {
		$events = $this->Event->find('all');
		foreach ($events as $event) {
			$tags = $event['Event']['tags'];
			$tags = preg_replace('/,/', '', $tags);
			$event['Event']['tags'] = $tags;
			$this->Event->save($event);
		}
	}
	function trash() {
		$this->autoRender = false;
		
		
		
		$content = file_get_contents('http://localhost/eventgrouper/eventlist4.csv');
		$data = str_getcsv($content, "\n");
		array_shift($data); // delete first element which is just field names
		$num = 0;
		$prevId = 0;
		foreach ($data as $dat) {
			$num++;
			$row = str_getcsv($dat, ';', '"');
			$timeStart = date("Y-m-d H:i:s", strtotime($row[0]." ".$row[1]));
			//print_r($row);
			$timeEnd = date("Y-m-d H:i:s", strtotime($row[0]." ".$row[2]));
			$duration = (strtotime($timeEnd) - strtotime($timeStart))/60;
			if ($duration < 0) $duration += 24*60;
			if ($row[2] == "?") $duration = 60; // stupid case...
			
			$insertArr = array('Event' =>
				array(
					'title' => $row[4],
					'location' => $row[5],
					'description' => $row[6],
					'event_group_id' => 7,//important
	//				'time_start' => $timeStart,
					'duration' => $duration,
					'user_id' => 6,//important
					'tags' => $row[3],
					'status' => 'confirmed',
					'latitude' => $row[7],
					'longitude' => $row[8]
				),
				'Other' =>
				array(
					'date_start' => date('Y-m-d', strtotime($timeStart)),
					'time_start' => date('H:i:s', strtotime($timeStart)),
					'date_end' => date('Y-m-d', strtotime($timeStart)+$duration*60),
					'time_end' => date('H:i:s', strtotime($timeStart)+$duration*60)
				)
			);
			
			$tagList = array(
					'A' => 'Academic',
					'R' => 'Arts',
					'S' => 'Athletic',
					'T' => 'Tour',
					'C' => 'Class',
					'F' => 'fraternity sorority living',
					'*' => 'featured',
					'D' => 'Dormitory',
					'P' => 'Parents',
					'G' => 'Religious',
					'O' => 'Student Oraganization',
					'M' => 'minority',
					'U' => 'UROP',
					'L' => 'L',
					'E' => 'E',
					'V' => 'V',
					'N' => 'N',
					'Y' => 'Y',
				
				);
				$tagArr = array();
				for ($j = 0; $j < strlen($insertArr['Event']['tags']); $j++) {
					$tagArr[] = $tagList[strtoupper(substr($insertArr['Event']['tags'], $j, 1))];
				}
				$insertArr['Event']['tags'] = implode(' ', $tagArr);
				//pr($insertArr);
				$this->Event->create();
				$this->Event->save($insertArr);
				
				$eventId = $this->Event->getLastInsertId();
				if ($prevId+1 != $eventId) {
					pr($insertArr);
				}
				$prevId = $eventId;
				echo $eventId." ". $row[4] ."<br>";
		}
		echo $num;
		
		
		
	}

}
?>

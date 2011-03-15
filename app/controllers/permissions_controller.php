<?php
class PermissionsController extends AppController {

	var $name = 'Permissions';
	var $uses = array('EventGroup', 'User', 'UserAlias', 'Event');
	var $helpers = array('Html', 'Form', 'Javascript', 'Navigation', 'Access');
	var $components = array('Acl', 'MyAcl', 'Email');

	function view($groupId) {
		//check permissions
		//from now on, assume userid is set
		$this->MyAcl->runcheck('EventGroup',$groupId,'editperms');
		$currentGroup = $this->EventGroup->findById($groupId);
		$hasAlias = false;
		$unregistered = false;
		if (!empty($this->data)) {//adding a user
			$userRow = $this->User->findByEmail($this->data['email']);
			if (!empty($userRow) && $this->MyAcl->checkUser('EventGroup',$groupId,$userRow['User']['id'], 'create'))
				$this->Session->setFlash("This user already has permissions to this group");
			else {
				if (empty($userRow)) {
					$aliasRow = $this->UserAlias->findByAlias($this->data['email']);
					if (!empty($aliasRow)) {
						$userRow['User'] = $aliasRow['User'];
						$hasAlias = true;
					} else {
						echo "in here";
						//add this user to the database and email the user about it
						$this->User->create();
						$userData = array('email' => $this->data['email'], 'pass' => 'unregistered');
						$this->User->set($userData);
						$this->User->save();
						$userRow = $this->User->findById($this->User->getLastInsertId());
						$unregistered = true;
						
						$aroArr = array(
							'model' => 'User',
							'foreign_key' => $userRow['User']['id'],
							'parent_id' => 1//This is the designated guest id in aros
						);
						$this->Acl->Aro->create();
						$this->Acl->Aro->save($aroArr);
					}
				} 
				
				//add permissions
				$this->Acl->allow(array('model' => 'User', 'foreign_key' => $userRow['User']['id']), array('model' => 'EventGroup', 'foreign_key' => $groupId), 'create');
				if ($unregistered) {
					$alertText = "This user has not registered yet. He/she will be sent an email to sign up.";
					$emailText = sprintf("You have been granted permissions to %s. Go here to sign up: %s",
					FULL_BASE_URL.$this->webroot.$currentGroup['EventGroup']['path'],
					FULL_BASE_URL.$this->webroot."users/add/".$userRow['User']['id']);
				}
				elseif ($hasAlias) {
					$alertText = $userRow['User']['email']."(".$this->data['email'].") added";
					$emailText = sprintf("You have been granted permissions to %s.",
					FULL_BASE_URL.$this->webroot.$currentGroup['EventGroup']['path']);
				}
				else {
					$alertText = $userRow['User']['email']." added";
					$emailText = sprintf("You have been granted permissions to %s.",
					FULL_BASE_URL.$this->webroot.$currentGroup['EventGroup']['path']);
				}
				$this->Session->setFlash($alertText);
				
				echo $emailText;
				$this->Email->from    = 'RushRabbit <noreply@rushrabbit.com>';
				$this->Email->to      = sprintf('%s <%s>', $userRow['User']['email'], $userRow['User']['email']);
				$this->Email->subject = 'You\'ve been granted permissions on RushRabbit';
				$this->Email->send($emailText);
			}
						
			
		
		}
		$userPerms = $this->EventGroup->getAllPermissions($groupId, $this->Session->read('userid'));
		$currentEventGroup = $this->EventGroup->findById($groupId);
		$this->set(compact('userPerms', 'groupId', 'groupPath', 'currentEventGroup'));
		$this->set('isAdmin', true);
	}

	function delete($groupId, $aroId = null) {
		$this->autoRender = false;
		if (!$aroId) {
			$this->Session->setFlash(__('Invalid id for Permissions', true));
			$this->redirect(array('action'=>'index'));
		} else {
			$children = $this->EventGroup->getAllEventGroupsUnderThis($groupId);
			$query = "SELECT aros_acos.id FROM aros_acos LEFT JOIN (acos, event_groups) ON (aros_acos.aco_id = acos.id AND acos.foreign_key = event_groups.id) 
			WHERE acos.model = 'EventGroup' AND aros_acos.aro_id = ".$aroId." AND event_groups.id IN (".implode(",",$children).")";
			$idsToDelete = $this->Acl->Aco->query($query);
			foreach ($idsToDelete as $id) {
				$this->Acl->Aco->query("DELETE FROM aros_acos WHERE id = ".$id['aros_acos']['id']);
			}
			
			
			$this->Session->setFlash(__('Permission deleted', true));
			
			$newGroup = $this->EventGroup->findById($groupId);
			$this->redirect("/event_groups/view_admin/".$newGroup['EventGroup']['path']);
		}
		
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
		
		
		
		$content = file_get_contents('http://localhost/eventgrouper/xlsparser/trythis.csv');
		$data = str_getcsv($content, "\n");
		array_shift($data); // delete first element which is just field names
		
		foreach ($data as $dat) {
			$row = str_getcsv($dat, ';', '\'');
			$timeStart = date("Y-m-d H:i:s", strtotime($row[0]." ".$row[1]));
			print_r($row);
			$timeEnd = date("Y-m-d H:i:s", strtotime($row[0]." ".$row[2]));
			$duration = (strtotime($timeEnd) - strtotime($timeStart))/60;
			if ($duration < 0) $duration += 24*60;
			
			
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
					'O' => 'Student, Oraganization',
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
				pr($insertArr);
				$this->Event->create();
				$this->Event->save($insertArr);
				
				$eventId = $this->Event->getLastInsertId();
				$acoArr = array(
						'model' => 'Event',
						'parent_id' => 7,//important
						'foreign_key' => $eventId
					);
	//			print_r($acoArr);
				$this->Acl->Aco->create();
				$this->Acl->Aco->save($acoArr);
				//
		
		}
		
		
		
		
		
		
		/*
		$content = 
		<<<EOT

EOT;
	for ($i = 0; $i < 100; $i++) {
		preg_match_all("@<tr>.*<td>(.*)</td>.*<td>(.*)</td>.*<td>(.*)</td>.*<td>(.*)</td>.*<td>(.*)</td>.*</tr>@sU", $content, $matches);
		$events = array();
		for ($i = 0; $i < count($matches[1]); $i++) {
			$times = explode("-", $matches[1][$i]);
			$timeStart = date("Y-m-d H:i:s", strtotime("11 April 2010 ".$times[0]));//important
//			print_r($times);
			if (empty($times[1]))
				$duration = 60;
			else {
				$duration = (strtotime("11 April 2010 ".$times[1]) - strtotime("11 April 2010 ".$times[0]))/60;
				if ($duration < 0)
					$duration = (strtotime("12 April 2010 ".$times[1]) - strtotime("11 April 2010 ".$times[0]))/60;
			}
			
			$insertArr = array('Event' =>
				array(
					'title' => $matches[3][$i],
					'location' => $matches[4][$i],
					'description' => $matches[5][$i],
					'event_group_id' => 101,//important
//					'time_start' => $timeStart,
					'duration' => $duration,
					'user_id' => 37,//important
					'tags' => $matches[2][$i],
					'status' => 'confirmed'
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
				'F' => 'fraternity, sorority, living',
				'*' => 'featured',
				'D' => 'Dormitory',
				'P' => 'Parents',
				'G' => 'Religious',
				'O' => 'Student, Oraganization',
				'M' => 'minority',
				'U' => 'UROP'
			
			);
			$tagArr = array();
			for ($j = 0; $j < strlen($insertArr['Event']['tags']); $j++) {
				$tagArr[] = $tagList[substr($insertArr['Event']['tags'], $j, 1)];
			}
			$insertArr['Event']['tags'] = implode(' ', $tagArr);
//			pr($insertArr);
			$this->Event->create();
			$this->Event->save($insertArr);
			
			$eventId = $this->Event->getLastInsertId();
			$acoArr = array(
					'model' => 'Event',
					'parent_id' => 101,//important
					'foreign_key' => $eventId
				);
//			print_r($acoArr);
			$this->Acl->Aco->create();
			$this->Acl->Aco->save($acoArr);
		}
	}//*/
//		print_r($events);
//		print_r($matches);
//		echo date("Y-m-d H:i:s", strtotime("8 April 2010 11:00pm"));
//		echo "<br>";
//		echo (strtotime("8 April 2010 11:00pm") - strtotime("8 April 2010 10:00pm"))/60;
	}

}
?>

<?php
class EventGroup extends AppModel {

	var $name = 'EventGroup';
	var $actsAs = array('Tree');
//	var $validate = array(
//		'name' => array(
//			'rule' => '/^[-0-9a-zA-Z_+&.!, ]*$/',
//			'message' => 'Required. Letters, numbers, and spaces only!',
//			'allowEmpty' => false
//		),
//		'photo_url' => array(
//			'rule' => 'url',
//			'message' => "That's not a valid url",
//			'allowEmpty' => true
//		),
//		'path' => array(
//			'valid' => array ('rule' => '/^[-0-9a-zA-Z]*$/i', 'message' => 'Required. Letters numbers, and dashes only'),
//			'isUnique' => array('rule' => 'isUnique', 'message' => 'This url has already been taken'),
//			'allowEmpty' => true
//			
//		)
//	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'event_group_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

//	var $hasAndBelongsToMany = array(
//		'User' => array(
//			'className' => 'User',
//			'joinTable' => 'event_groups_users',
//			'foreignKey' => 'event_group_id',
//			'associationForeignKey' => 'user_id',
//			'unique' => true,
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'finderQuery' => '',
//			'deleteQuery' => '',
//			'insertQuery' => ''
//		)
//	);
	function getAllEventGroupsUnderThis($id) {
		$children = $this->children($id);
		$childrenArr = array();
		foreach ($children as $child)
			$childrenArr[] = $child['EventGroup']['id'];
		$childrenArr[] = $id;
		return $childrenArr;
		
	}
	function getAllEventGroupsAboveThis($id) {
		$parents = $this->getpath($id);
		$parentsArr = array();
		foreach ($parents as $parent)
			$parentsArr[] = $parent['EventGroup']['id'];
		return $parentsArr;
	}
	function getAllEventsUnderThis($id, $userId = null, $params = null, $limit = null, $justCalendar = false) {
		$childrenArr = $this->getAllEventGroupsUnderThis($id);
		$params['Event.event_group_id'] = $childrenArr;
				
		$events = $this->Event->find('all',array('limit' => $limit, 'conditions' => $params,
		'group' => 'Event.id',
		'order' => 'Event.time_start ASC'
		));
		
		if ($userId != null) {	
			$q = sprintf("SELECT * FROM events LEFT JOIN events_users ON (events_users.event_id = events.id)
			 WHERE event_group_id IN(%s) AND events_users.user_id = %d", implode(",", $childrenArr), $userId);
			$userEvents = $this->query($q);
			
			foreach ($userEvents as $userEvent) {
				for ($i = 0; $i < count($events); $i++) {
					if ($userEvent['events']['id'] == $events[$i]['Event']['id']) {
						$events[$i]['Event']['onUsersCalendar'] = 1;
					}
				}
			}
		}
		$eventsOnCal = array();
		if ($justCalendar) {
			foreach($events as &$event)
				if (isset($event['Event']['onUsersCalendar']))
					$eventsOnCal[] = $event;
			$events = $eventsOnCal;
		}
		return $events;
		
	}
	function getDirectChildren($id) {
		$children = $this->children($id);
		$directs = array();
		foreach ($children as $child) {
			if ($child['EventGroup']['parent_id'] == $id)
				$directs[] = $child;
		}
		return $directs;
	}
	function delete($id) {
		//$this->query("DELETE FROM events_users WHERE ")
		//$this->unbindModel(array('hasMany' => array('Event')));
		//return parent::delete($id);
		$children = $this->children($id);
		$childrenArr = array();
		foreach ($children as $child)
			$childrenArr[] = $child['EventGroup']['id'];
		$childrenArr[] = $id;
		$conditions = array("Event.event_group_id" => $childrenArr);//array('`Event`.`event_group_id` IN (1,2,3)');
		$events = $this->Event->find('all',compact('conditions'));
		$eventIds = array();
		foreach ($events as $event) {
			$eventIds[] = $event['Event']['id'];
		}
		$this->query("DELETE FROM event_groups WHERE id IN (".implode(',',$childrenArr).")");
		$this->query("DELETE FROM event_groups_users WHERE event_group_id IN (".implode(',',$childrenArr).")");
		$this->query("DELETE FROM events WHERE event_group_id IN (".implode(',',$childrenArr).")");
		if (!empty($eventIds)) {
			$this->query("DELETE FROM events_users WHERE event_id IN (".implode(',',$eventIds).")");
		}
		return true;
		
	}
	
	function save($data = null, $validate = true, $fieldList = array()) {
        $returnval = parent::save($data, $validate, $fieldList);
        if ($returnval && $data != null && array_key_exists('pathstart', $data)) {
        	if (empty($data['EventGroup']['path']))
				$data['EventGroup']['path'] = urlencodecustom($data['EventGroup']['name']);
        	$path = $data['pathstart']."/".$data['EventGroup']['path'];
        	if (empty($data['pathstart']))
        		$path = $data['EventGroup']['path'];
        	$this->set('path', $path);
        	$this->save(null, false);//no validation now
        }
        return $returnval;
    } 
    //get all permissions for a specific group (but not subgroups)
    function getAllPermissions($id, $userId) {
    	$parentArr = $this->getAllEventGroupsAboveThis($id);
    	$childrenArr = $this->getAllEventGroupsUnderThis($id);
    	$aco = $this->query("select users.id, aros_acos.id, aros_acos.aro_id, email, aros_acos._create, aros_acos._read, aros_acos._update, aros_acos._delete, aros_acos._editperms from acos 
    	LEFT JOIN (aros_acos, aros, users) ON (acos.id = aros_acos.aco_id AND aros_acos.aro_id = aros.id AND aros.foreign_key = users.id) 
    	WHERE acos.foreign_key IN(".implode(',',$childrenArr).") AND email != 'Guest' AND users.id != ".$userId." GROUP BY aros.foreign_key");
    	
    	foreach($aco as &$user) {
	    	$userEventGroups = $this->query("SELECT EventGroup.* FROM `aros` 
			LEFT JOIN (aros_acos, acos, event_groups AS EventGroup) 
			ON (aros.id = aros_acos.aro_id AND aros_acos.aco_id = acos.id AND acos.foreign_key = EventGroup.id) 
			WHERE aros.foreign_key = ".$user['users']['id']." AND acos.foreign_key IN(".implode(',',$childrenArr).") AND acos.model = 'EventGroup';");
			$ids = array();
			foreach ($userEventGroups as $single) {
				$ids[] = $single['EventGroup']['id'];
			}
			foreach ($userEventGroups as $key=>$value) {
				if (in_array($value['EventGroup']['parent_id'], $ids))
					unset($userEventGroups[$key]);
			}
			$user['userEventGroups'] = $userEventGroups;
    	}
		
		
    	return $aco;
    }
    

}
?>

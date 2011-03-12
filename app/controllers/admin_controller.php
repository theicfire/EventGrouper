<?php
class AdminController extends AppController {

	var $name = 'Admin';
	var $uses = array('EventGroup', 'Event', 'User');
	var $helpers = array('Html', 'Form', 'Javascript', 'Navigation', 'Access');
	var $components = array('Acl', 'MyAcl');

	function requests($groupId) {
		$this->MyAcl->runcheck('EventGroup',$groupId,'bigOwner');
		$eventsUnderGroup = $this->EventGroup->getAllEventsUnderThis($groupId, null, array('status' => 'unconfirmed'));
		
		$this->set(compact('eventsUnderGroup'));
		$this->set('phpVars', array('currentEventGroupId'=> $groupId));	
		$this->set('isAdmin', true);	
	}
	
	function changeEventStatus($eventId, $status) {
		$this->autoRender = false;
		$curData = $this->Event->findById($eventId);
		if ($status != 'hidden' || ($status=='hidden' && $curData['Event']['status'] == 'confirmed')) {
			$data = array('Event' => array(
			'id' => $eventId,
			'status' => $status
			));
			$this->Event->save($data);
			echo "Changed";
		} else {
			echo "Unchanged";
		}
	}

}
?>
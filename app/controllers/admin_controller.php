<?php
class AdminController extends AppController {

	var $name = 'Admin';
	var $uses = array('EventGroup', 'Event', 'User', 'CategoryChoice');
	var $helpers = array('Html', 'Form', 'Javascript', 'Navigation', 'Access');
	var $components = array('Acl', 'MyAcl', 'Facebook');

	function requests($groupId) {
		$this->MyAcl->runcheck('EventGroup',$groupId,'confirm');
		$eventsUnderGroup = $this->EventGroup->getAllEventsUnderThis($groupId, null, array('status' => 'unconfirmed'));
		
		$this->set(compact('eventsUnderGroup'));
		$this->set('phpVars', array('currentEventGroupId'=> $groupId));	
		$this->set('isAdmin', true);	
	}
	
	function changeEventStatus($eventId, $status) {
		$this->MyAcl->runcheck('EventGroup',$groupId,'confirm');
		$this->render(false);
		$data = array('Event' => array(
		'id' => $eventId,
		'status' => $status
		));
		$this->Event->save($data);
	}

}
?>
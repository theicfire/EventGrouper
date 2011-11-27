<?php
class MyAclComponent extends Object {
	var $components = array('Session');
	var $uses = array('EventGroup', 'Event', 'UserPerm');
    
	//called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->controller =& $controller;
		// todo make all model inits up here
		$this->allUserPerms = array();
		App::import('Component', 'Session');
		$session = new SessionComponent();
		if ($session->check('userid')) {
			$userid = $session->read('userid');
			App::import('Model', 'UserPerm');
			$userPerm = new UserPerm();
			$this->allUserPerms = $userPerm->getAllUserPerms($userid);
		}
	}
	function runcheck($type, $id, $action = '*') {
		$permission = $this->check($type, $id, $action);
    	if (!$permission) {
    		$this->Session->setFlash('You do not have permissions to go there');
    		$this->controller->redirect('/');
    	}
    }
    
    /*
     * Checks the current user
     */
    function check($type, $id, $action = '*') {
		App::import('Component', 'Session');
		$session = new SessionComponent();
		$userid = 5;//guest
		if ($session->check('userid'))
			$userid = $session->read('userid');
		return $this->checkUser($type, $id, $userid, $action);
    }
    function hasPerm($groupId, $userId) {
    	App::import('Component', 'Session');
		$session = new SessionComponent();
		if ($session->check('userid')) {
			if ($userId == $session->read('userid'))
				return array_key_exists($groupId, $this->allUserPerms);		
		}
		App::import('Model', 'UserPerm');
		$userPerm = new UserPerm();
    	return $userPerm->hasPerms($userId, $groupId);
    }
	function checkUser($type, $id, $userid, $action = '*') {
		if ($action == 'editperms') $action = 'create'; // because create implies editperms
		if ($action == 'read') return true; // temporary fix; instead users should be inheriting read priveliges by extending guest
    	if ($id == null)
    		return false;
    	if ($id == 0 && $action == 'create')
			return true;//todo necessary??
		App::import('Model', 'EventGroup');
		$eventGroup = new EventGroup();
		$groupPath = $eventGroup->getPath($id);
    	if ($action == 'bigOwner') {
    		//return $userPerm->hasPerms($userid, $groupPath[0]['EventGroup']['id']);
    		return $this->hasPerm($groupPath[0]['EventGroup']['id'], $userid);
    	}
    	// if you are an event, then we should look for the permissions of the event's group
    	if ($type == 'Event') {
    		App::import('Model', 'Event');
			$event = new Event();
			$parentNode = $event->findById($id);
			$id = $parentNode['Event']['event_group_id'];
    	}
    	return $this->hasPerm($id, $userid) || 
    		$this->hasPerm($groupPath[0]['EventGroup']['id'], $userid); // if you have permissions to you or your parent
    }
}
?>

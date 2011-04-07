<?php
class MyAclComponent extends Object {
	var $components = array('Session');
	var $uses = array('EventGroup', 'Event');
    
	//called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->controller =& $controller;
	}
	function runcheck($type, $id, $action = '*') {
		$permission = $this->check($type, $id, $action);
    	if (!$permission) {
    		$this->Session->setFlash('You do not have permissions to go there');
    		$this->controller->redirect('/');
    	}
    }
    
    
	function check($type, $id, $action = '*') {
		//if ($action = 'read') return true; // temporary fix; instead users should be inheriting read priveliges by extending guest
		$permission = false;
		App::import('Component', 'Session');
		$session = new SessionComponent();
    	$userid = 5;//guest
    	if ($session->check('userid'))
  			$userid = $session->read('userid');
		$permission = $this->checkUser($type, $id, $userid, $action);
    	return $permission;
    }
    
	function checkUser($type, $id, $userid, $action = '*') {
		if ($id == null)
			return false;
		$permission = false;
		if ($id == 0 && $action = 'create')
			return true;//todo this is bad programming!
		App::import('Component', 'Acl');
    	$acl = new AclComponent();
    	App::import('Model', 'EventGroup');
		$eventGroup = new EventGroup();
		if ($action == 'bigOwner') {
			//check if this user has permissions for the highest level group
			$groupPath = $eventGroup->getPath($id);
			$permission = $acl->check(array('model' => 'User', 'foreign_key' => $userid), 
			array('model' => 'EventGroup', 'foreign_key' => $groupPath[0]['EventGroup']['id']), 'delete');
		} else {
			//if you can create above this group, you can do anything (so we don't care about the action)
			if ($type == 'EventGroup') {
				$parentNode = $eventGroup->getparentnode($id);
				$parentId = $parentNode['EventGroup']['id'];
			}
			else {//type = 'Event'
				App::import('Model', 'Event');
				$event = new Event();
				$parentNode = $event->findById($id);
				$parentId = $parentNode['Event']['event_group_id'];
			}
			if ($parentNode != null)
				$permission = $acl->check(array('model' => 'User', 'foreign_key' => $userid), array('model' => 'EventGroup', 'foreign_key' => $parentId), 'create');
			if (!$permission)
    			$permission = $acl->check(array('model' => 'User', 'foreign_key' => $userid), array('model' => $type, 'foreign_key' => $id), $action);
		}
//		printf('type: %s id: %s userid: %s action: %s => %s', $type, $id, $userid, $action, $permission);
    	return $permission;
    }
}
?>

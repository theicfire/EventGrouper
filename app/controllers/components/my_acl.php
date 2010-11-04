<?php
class MyAclComponent extends Object {
	var $components = array('Session');
    
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
		$permission = false;
		if ($id == 0 && $action = 'create' && $this->Session->check('userid'))
			return true;//todo this is bad programming!
		App::import('Component', 'Acl');
		App::import('Component', 'Session');
		$session = new SessionComponent();
    	$acl = new AclComponent();
    	$userid = 5;//guest
    	if ($session->check('userid'))
  			$userid = $session->read('userid');
		if ($action == 'confirm') {
			//check if this user has permissions for the highest level group
			App::import('Model', 'EventGroup');
			$eventGroup = new EventGroup();
			$groupPath = $eventGroup->getPath($id);
			$permission = $acl->check(array('model' => 'User', 'foreign_key' => $userid), 
			array('model' => 'EventGroup', 'foreign_key' => $groupPath[0]['EventGroup']['id']), 'delete');
		} else {
    		$permission = $acl->check(array('model' => 'User', 'foreign_key' => $userid), array('model' => $type, 'foreign_key' => $id), $action);
		}
    	return $permission;
    }
}
?>

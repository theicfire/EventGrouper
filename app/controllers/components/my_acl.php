<?php
class MyAclComponent extends Object {
	var $components = array('Session');
	
    
	//called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->controller =& $controller;
	}
	function runcheck($type, $id, $action = '*') {
		if ($id == 0 && $action = 'create' && $this->Session->check('userid'))
			return true;//todo this is bad programming!
    	App::import('Component', 'Acl');
    	$acl = new AclComponent();
    	$userid = 5;//guest
    	if ($this->Session->check('userid'))
  			$userid = $this->Session->read('userid');
    	if (!$acl->check(array('model' => 'User', 'foreign_key' => $userid), array('model' => $type, 'foreign_key' => $id), $action))
    		$this->controller->render('/errors/nopermissions');
    }
}
?>

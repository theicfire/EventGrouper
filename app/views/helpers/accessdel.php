<?php
/* /app/views/helpers/link.php (using other helpers) */
class AccessHelper extends AppHelper {
    var $helpers = array('Html', 'Session');
    var $uses = array('User');
	/*
	 * $type is either Event or EventGroup
	 * $id is the id of the above
	 * action can be *, create, delete, update, r
	 */
    function check($type, $id, $action = '*') {
    	App::import('Component', 'MyAcl');
    	$Acl = new MyAclComponent();
    	$userid = 5;//guest
    	if ($this->Session->read('userid'))
  			$userid = $this->Session->read('userid');
    	return $Acl->check($type, $id, $action);
    }
}
?>

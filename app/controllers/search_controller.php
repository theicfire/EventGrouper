<?php
class SearchController extends AppController {

	var $name = 'Search';
	var $uses = array('EventGroup', 'User', 'UserAlias');
	var $helpers = array('Html', 'Form', 'Javascript', 'Navigation', 'Access');
	var $components = array('Acl', 'MyAcl', 'Facebook', 'Email');

	function index() {
		$eventGroups = array();
		if (!empty($this->params['url']['q'])) {
			$params= array('conditions' => array(
			'parent_id' => 0,
			sprintf('MATCH(EventGroup.name) AGAINST("%s" IN BOOLEAN MODE)',  $this->params['url']['q'])));
			$eventGroups = $this->EventGroup->find('all',$params);
		}
		$this->set(compact('eventGroups'));
	}
}
?>

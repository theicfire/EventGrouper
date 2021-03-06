<?php
class SearchController extends AppController {

	var $name = 'Search';
	var $uses = array('EventGroup', 'User', 'UserAlias');
	var $helpers = array('Html', 'Form', 'Javascript', 'Navigation', 'Access');
	var $components = array('Acl', 'MyAcl', 'Email');

	function index() {
		$eventGroups = array();
		if (isset($this->params['url']['q'])) {
			$params= array('conditions' => array(
			'parent_id' => 0));
			if (!empty($this->params['url']['q'])) {
				$params['conditions'][] = sprintf('MATCH(EventGroup.name) AGAINST("%s" IN BOOLEAN MODE)',  $this->params['url']['q']);
			}
			$eventGroups = $this->EventGroup->find('all',$params);
		}
		$this->set(compact('eventGroups'));
	}
}
?>

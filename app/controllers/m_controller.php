<?php
class MController extends AppController {

	var $name = 'M';
	var $uses = array('EventGroup', 'User');
	var $helpers = array('Html', 'Form', 'Javascript', 'Navigation', 'Access');
	var $components = array('Acl', 'MyAcl', 'Facebook');

	function beforeFilter() {
		$this->layout = 'mobile';
	}
	function index() {
		$this->Session->write('testses', 'stuffinhere');
		$this->EventGroup->unbindModel(
			array('hasMany' => array('Event'),
			'hasAndBelongsToMany' => array('User')	
			)
		);
		$eventGroups = $this->EventGroup->find('all',array(
			'conditions' => array("EventGroup.parent_id" => 0),
			'fields' => array("EventGroup.*")
		));
		if ($this->Session->check('userid'))
			$this->set('watchlist', $this->EventGroup->getWatchlist($this->Session->read('userid')));
		$this->set('eventGroups', $eventGroups);
		
	}
	function search() {
		$url = explode("/", $this->params['url']['url']);
		array_shift($url);
		$url = implode("/", $url);
		$currenteventGroup = $this->EventGroup->find('first', array('conditions' => array(
		'path' => $url)));
		$id = $currenteventGroup['EventGroup']['id'];
		if ($this->Session->check('userid') && $currenteventGroup['EventGroup']['parent_id'] == 0)
			$this->User->addEventGroupToUser($this->Session->read('userid'), $id);//add to watchlist
		$this->set(compact('id', 'currenteventGroup'));		
	}
	function view($id) {
		$this->sharedList($id);
	}
	function map($id) {
		$this->layout = '';
		$this->sharedList($id);
	}
	function sharedList($id) {
		
		$currenteventGroup = $this->EventGroup->find('first', array('conditions' => array(
		'id' => $id)));
		
		$userStuff = null;
		if ($this->Session->check('username')) {
			$userStuff = $this->User->find('first', array('conditions' => array('email' => $this->Session->read('username'))));
			$eventsOnCalendar = $userStuff['EventsOnCalendar'];
			//print_r($eventsOnCalendar);
			$this->set(compact('eventsOnCalendar'));
		}
//		$this->MyAcl->runcheck('EventGroup',$id,'read');
		
		$this->EventGroup->unbindModel(
			array('hasMany' => array('Event'),
			'hasAndBelongsToMany' => array('User')	
			)
		); 
		
		$eventGroups = $this->EventGroup->children($id);
		$params = array();
		if (array_key_exists('search', $this->params['url'])) {//has been searched
			if (!empty($this->params['url']['search'])){
				$params= array(
				sprintf('MATCH(`Event.description`, `Event.title`, `Event.tags`)
				AGAINST("%s" IN BOOLEAN MODE)', $this->params['url']['search']));
			}
			$timeStart = date("Y-m-d H:i:s", strtotime($this->params['url']['date_start']) + $this->params['url']['time_start']*3600);
			$params[] = sprintf('time_start >= \'%s\'', $timeStart); 
		}
		$params['status'] = array('confirmed', 'hidden');
		$groupPath = $this->EventGroup->getPath($id);
		$treeList = $this->EventGroup->generateTreeList();
		if (isset($this->params['url']['viewType']) && $this->params['url']['viewType'] == 'calendar') {
			if ($this->Session->check('userid'))
				$eventsUnderGroup = $this->EventGroup->getFavorites($this->Session->read('userid'));
			else
				$eventsUnderGroup = array();
		} else {
			$eventsUnderGroup = $this->EventGroup->getAllEventsUnderThis($id, $this->Session->read('userid'), $params, null);
		}
		
		$urlParams = $this->params['url'];
		
		$this->set(compact('groupPath', 'eventsUnderGroup', 'treeList', 'eventGroups', 'aclNum', 'userStuff', 'viewCalendar', 'id', 'currenteventGroup', 'urlParams'));
	}
	function login() {
		if (!empty($_POST['email'])) {
			$userData = $this->User->find('first', array('conditions' => array('email' => $_POST['email']), 'recursive' => -1));
			if (!empty($_POST['pass']) && !empty($_POST['email']) && sha1($_POST['pass']) == $userData['User']['pass']) {
				$this->Session->write('username', $_POST['email']);//todo is this secure?
				$this->Session->write('userid', $userData['User']['id']);//todo is this secure?
				$this->redirect('/mob/index');
			} else {
				$this->Session->write('username', null);
				$this->Session->write('userid', null);
				$this->Session->setFlash('Wrong username and email combination');
			}
		}
	}
	function logout() {
		$this->autoRender = false;
		$this->Session->destroy();
		$this->redirect('/mob/index');
	}
	
	

}
?>

<?php
class EventGroupsController extends AppController {

	var $name = 'EventGroups';
	var $uses = array('EventGroup', 'User');
	var $helpers = array('Html', 'Form', 'Javascript', 'Navigation', 'Access');
	var $components = array('Acl', 'MyAcl', 'Facebook');

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

	function view() {
		$currenteventGroup = $this->EventGroup->find('first', array('conditions' => array(
		'path' => $this->params['url']['url'])));
		$id = $currenteventGroup['EventGroup']['id'];
		if (!$id) {
			$this->Session->setFlash(__('Invalid EventGroup.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->MyAcl->runcheck('EventGroup',$id,'read');
		
		$this->EventGroup->unbindModel(
			array('hasMany' => array('Event'),
			'hasAndBelongsToMany' => array('User')	
			)
		); 
		if ($this->Session->check('userid') && $currenteventGroup['EventGroup']['parent_id'] == 0)
			$this->User->addEventGroupToUser($this->Session->read('userid'), $id);//add to watchlist
		$eventGroups = $this->EventGroup->children($id);
		//just doing this to get the earliest date
		$eventsUnderGroup = $this->EventGroup->getAllEventsUnderThis($id, $this->Session->read('userid'), array('status' => array('confirmed', 'hidden')));
		$groupPath = $this->EventGroup->getPath($id);
		$this->set(compact('groupPath', 'eventGroups', 'currenteventGroup', 'eventsUnderGroup'));
		$this->set('phpVars', array('currentEventGroupId'=> $id));		
	}
	function view_admin() {
		$pathUrl = explode("/",$this->params['url']['url']);
		unset($pathUrl[0]);
		unset($pathUrl[1]);
		$pathUrl = implode("/", $pathUrl);
		$currenteventGroup = $this->EventGroup->find('first', array('conditions' => array(
		'path' => $pathUrl)));
		$id = $currenteventGroup['EventGroup']['id'];
		if (empty($currenteventGroup)) {
			$this->Session->setFlash(__('Invalid EventGroupss.', true));
			$this->redirect(array('action'=>'index'));
		}
//		$this->MyAcl->runcheck('EventGroup',$id,'create');
		
		$this->EventGroup->unbindModel(
			array('hasMany' => array('Event'),
			'hasAndBelongsToMany' => array('User')	
			)
		); 
		
		$eventGroups = $this->EventGroup->children($id);
		$eventsUnderGroup = $this->EventGroup->getAllEventsUnderThis($id, $this->Session->read('userid'), array('status' => array('confirmed', 'hidden')));
		$treeList = $this->EventGroup->generateTreeList();
		$this->set(compact('groupPath', 'eventGroups', 'currenteventGroup', 'treeList', 'eventsUnderGroup'));
		$this->set('phpVars', array('currentEventGroupId'=> $id));	
		$this->set('isAdmin', true);	
	}

	function add($parentId = null) {
		if (!empty($this->data)) {
			$parentId = $this->data['EventGroup']['parent_id'];
		}
		$this->MyAcl->runcheck('EventGroup',$parentId,'create');
		//todo add row in event_groups_users
		$currenteventGroup = $this->EventGroup->find('first', array('conditions' => array(
		'id' => $parentId)));
		$groupPath = $this->EventGroup->getPath($parentId);
		if (!empty($this->data)) {
			$this->data['pathstart'] = $this->params['form']['pathstart']; 
			$possibleSame = $this->EventGroup->find('first', array('conditions' => array('path' => $this->EventGroup->getencodedPath($this->data))));
			if (empty($possibleSame)) {
				$oldData = $this->data;
				if (!empty($groupPath)) {
					$this->data['EventGroup']['highest_name'] = $groupPath[0]['EventGroup']['name'];	
				} else {
					$this->data['EventGroup']['highest_name'] = $this->data['EventGroup']['name']; 
				}
				
				$this->EventGroup->create();
				if ($this->EventGroup->save($this->data)) {
					$eventGroupId = $this->EventGroup->getLastInsertId();
					//now add an aco
					if ($this->data['EventGroup']['parent_id'] == 0) {
						$acoParentId = null;
					} else {
						$acoParent = $this->EventGroup->query("SELECT id FROM acos WHERE foreign_key = ".$this->data['EventGroup']['parent_id']." AND model = 'EventGroup'");
						if (!empty($acoParent))
							$acoParentId = $acoParent[0]['acos']['id'];
						else
							$acoParentId = null;
					}
					
					$acoArr = array(
						'model' => 'EventGroup',
						'parent_id' => $acoParentId,
						'foreign_key' => $eventGroupId
					);
					$this->Acl->Aco->create();
					$this->Acl->Aco->save($acoArr);
					//and now add permissions to the users
					//NOTE: we assume that the user is logged in to get to this page (and has a session)
					//NOTE: we are giving the users who make the event groups full permissions
					if ($acoParentId == null) {
						$userid = $this->Session->read('userid');
						$this->Acl->allow(array('model' => 'User', 'foreign_key' => $userid), array('model' => 'EventGroup', 'foreign_key' => $eventGroupId));
						//add read priveleges for guests
						$this->Acl->allow(array('model' => 'User', 'foreign_key' => 5), array('model' => 'EventGroup', 'foreign_key' => $eventGroupId), 'read');
					}
					$this->set('notification', 'The group has been saved. You can now add events or more subgroups.');
					$newGroup = $this->EventGroup->findById($eventGroupId);
					$this->redirect("/event_groups/view_admin/".$newGroup['EventGroup']['path']);
				} else {
					$this->data = $oldData;
					$this->Session->setFlash(__('The EventGroup could not be saved. Please, try again.', true));
				}
			} else {
				$this->Session->setFlash(__('This path has already been taken.', true));
			}
		}
		
		
		$this->data['EventGroup']['location'] = $currenteventGroup['EventGroup']['location'];
		$this->set(compact('parentId', 'currenteventGroup', 'groupPath'));
		$this->set('isAdmin', true);
	}

	function edit($id = null) {
//		if (!empty($this->data['EventGroup']) && array_key_exists('parent_id', $this->data['EventGroup']))
//			$parentId = $this->data['EventGroup']['parent_id'];

		if ($id != null){
			$parentId = $this->EventGroup->findById($id);
			$parentId = $parentId['EventGroup']['parent_id'];
		}			
		else
			$parentId = $this->data['Other']['parent_id'];
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid EventGroup', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->MyAcl->runcheck('EventGroup',$id,'update');
		$currenteventGroup = $this->EventGroup->findById($parentId);
		if (!empty($this->data)) {
			if (!$id)
				$id = $this->data['EventGroup']['id'];
			$this->data['pathstart'] = $this->params['form']['pathstart'];
			if ($this->data['EventGroup']['name'] != $currenteventGroup['EventGroup']['name']) {//change all event groups under with the new highest name if it changed
				$eventGroups = $this->EventGroup->children($id);
				foreach ($eventGroups as $eventGroup) {
					$eventGroup['EventGroup']['highest_name'] = $this->data['EventGroup']['name'];
					$this->EventGroup->save($eventGroup);
				}
				$this->data['EventGroup']['highest_name'] = $this->data['EventGroup']['name'];
			} 
			if ($this->EventGroup->save($this->data)) {
				$this->Session->setFlash(__('The EventGroup has been saved', true));
				$eventStuff = $this->EventGroup->findById($id);
				$this->redirect("/event_groups/view_admin/".$eventStuff['EventGroup']['path']);
			} else {
				$this->Session->setFlash(__('The EventGroup could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EventGroup->read(null, $id);
		}
//		$this->set('parentEventGroup',$this->EventGroup->findById(0));
		$this->set('parentEventGroup',$this->EventGroup->findById($parentId));
		$groupPath = $this->EventGroup->getPath($parentId);
		
		$this->set(compact('groupPath', 'parentId', 'currenteventGroup'));
		$this->set('isAdmin', true);
	}

	function delete($id = null) {
		//todo permission check (for all delete methods as well)
		$this->MyAcl->runcheck('EventGroup',$id,'delete');
		$this->autoRender = false;
		$eventStuff = $this->EventGroup->findById($id);
		$eventParent = $this->EventGroup->findById($eventStuff['EventGroup']['parent_id']);
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for EventGroup', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EventGroup->delete($id)) {
			//now delete the aco
			$acosRow = $this->Acl->Aco->findByForeignKey($id);
			$this->Acl->Aco->delete($acosRow['Aco']['id']);
			$this->Acl->Aco->query("DELETE FROM aros_acos WHERE aco_id = ".$acosRow['Aco']['id']);
			
			
			$this->Session->setFlash(__('EventGroup deleted', true));
			$repath = "/event_groups/view_admin/".$eventParent['EventGroup']['path'];
			if ($eventStuff['EventGroup']['parent_id']==0)
				$repath = "/users/index";
			$this->redirect($repath);
		}
		
	}
	function ajaxListEvents($id) {
		
		$this->sharedAjaxList($id);
		
		$this->render('ajax_list_events', 'ajax');
	}
	function map_view($id) {
		$this->sharedAjaxList($id);
		$this->render('map_view', 'ajax');
	}
	function sharedAjaxList($id) {
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
		if (isset($this->params['url']['viewType']) && $this->params['url']['viewType'] == 'map') {
			$newArr = array();
			foreach ($eventsUnderGroup as $event) {
				if (!empty($event['Event']['latitude'])) {
					$newArr[] = $event;
				}
			}
			$eventsUnderGroup = $newArr;
		}
		$this->set(compact('groupPath', 'eventsUnderGroup', 'treeList', 'eventGroups', 'aclNum','currenteventGroup', 'userStuff', 'viewCalendar'));
	}
	
	

}
?>

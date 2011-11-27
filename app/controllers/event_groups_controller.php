<?php
class EventGroupsController extends AppController {

	var $name = 'EventGroups';
	var $uses = array('EventGroup', 'User', 'UserAlias', 'UserPerm');
	var $helpers = array('Html', 'Form', 'Javascript', 'Navigation');
	var $components = array('MyAcl', 'Email');

	function index() {
		$this->EventGroup->unbindModel(
			array('hasMany' => array('Event'),
			'hasAndBelongsToMany' => array('User')	
			)
		);
		$eventGroups = $this->EventGroup->find('all',array(
			'conditions' => array("EventGroup.parent_id" => 0),
			'fields' => array("EventGroup.*")
		));
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
		//$this->MyAcl->runcheck('EventGroup',$id,'read');
		
		$this->EventGroup->unbindModel(
			array('hasMany' => array('Event'),
			'hasAndBelongsToMany' => array('User')	
			)
		); 
		$eventGroups = $this->EventGroup->children($id);
		//just doing this to get the earliest date
		$eventsUnderGroup = $this->EventGroup->getAllEventsUnderThis($id, $this->Session->read('userid'), array('status' => array('confirmed', 'hidden')));
		//$groupPath = $this->EventGroup->getPath($id);
		$access = $this->MyAcl;
		$this->set(compact(/*'groupPath', */'eventGroups', 'currenteventGroup', 'eventsUnderGroup', 'access'));
		$this->set('phpVars', array('currentEventGroupId'=> $id));	
		
		$this -> pageTitle = 'Schedule';
		$this -> layout = 'timeline';
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
		$this->MyAcl->runcheck('EventGroup',$id,'read');
		$this->EventGroup->unbindModel(
			array('hasMany' => array('Event'),
			'hasAndBelongsToMany' => array('User')	
			)
		);
		$eventGroups = $this->EventGroup->children($id);
		$eventsUnderGroup = $this->EventGroup->getAllEventsUnderThis($id, $this->Session->read('userid'), array('status' => array('confirmed', 'hidden')));
		$treeList = $this->EventGroup->generateTreeList();
		
		
		
		
		
		
		//start permissions section
		//check permissions
		//from now on, assume userid is set
		$groupId = $id;//noob
		if ($this->MyAcl->check('EventGroup',$groupId,'editperms'))
		{
			
			$currentGroup = $this->EventGroup->findById($groupId);
			$hasAlias = false;
			$unregistered = false;
			if (!empty($this->data)) {//adding a user
				$userRow = $this->User->findByEmail($this->data['email']);
				if (!empty($userRow) && $this->MyAcl->checkUser('EventGroup',$groupId,$userRow['User']['id'], 'create'))
					$this->Session->setFlash("This user already has permissions for this group.");
				else {
					if (empty($userRow)) {
						$aliasRow = $this->UserAlias->findByAlias($this->data['email']);
						if (!empty($aliasRow)) {
							$userRow['User'] = $aliasRow['User'];
							$hasAlias = true;
						} else {
							//add this user to the database and email the user about it
							$this->User->create();
							$userData = array('email' => $this->data['email'], 'pass' => 'unregistered');
							$this->User->set($userData);
							$this->User->save();
							$userRow = $this->User->findById($this->User->getLastInsertId());
							$unregistered = true;
							
						}
					} 
					
					//add permissions
					$this->UserPerm->addPerm($userRow['User']['id'], $groupId);
					
					if ($unregistered) {
						$alertText = "This user has not registered yet. He/she will be sent an email to sign up.";
						$emailText = sprintf("You have been granted permissions to %s. Go here to sign up: %s",
						FULL_BASE_URL.$this->webroot.$currentGroup['EventGroup']['path'],
						FULL_BASE_URL.$this->webroot."users/add/".$userRow['User']['id']);
					}
					elseif ($hasAlias) {
						$alertText = $userRow['User']['email']."(".$this->data['email'].") added";
						$emailText = sprintf("You have been granted permissions to %s.",
						FULL_BASE_URL.$this->webroot.$currentGroup['EventGroup']['path']);
					}
					else {
						$alertText = $userRow['User']['email']." added";
						$emailText = sprintf("You have been granted permissions to %s.",
						FULL_BASE_URL.$this->webroot.$currentGroup['EventGroup']['path']);
					}
					$this->Session->setFlash($alertText);
					
					$this->Email->from    = 'RushRabbit <frozen_fire1991@yahoo.com>';
					$this->Email->to      = sprintf('%s <%s>', $userRow['User']['email'], $userRow['User']['email']);
					$this->Email->subject = 'You\'ve been granted permissions on RushRabbit';
					$this->Email->send($emailText);
				}
							
				
			
			}
			$numRequests = count($this->EventGroup->getAllEventsUnderThis($groupId, null, array('status' => 'unconfirmed')));
			$userPerms = $this->EventGroup->getAllPermissions($groupId, $this->Session->read('userid'));
			
			$this->set(compact('userPerms', 'groupId', 'groupPath', 'numRequests'));
		}
		//end permissions section
		
		
		$access = $this->MyAcl;
		$this->set(compact('groupPath', 'eventGroups', 'currenteventGroup', 'treeList', 'eventsUnderGroup', 'access'));
		$this->set('phpVars', array('currentEventGroupId'=> $id));	
		$this->set('isAdmin', true);	
	}
	function view_permissions($groupId) {
		
	}

	function add($parentId = null) {
		if (!empty($this->data)) {
			$parentId = $this->data['EventGroup']['parent_id'];
		}
		$this->MyAcl->runcheck('EventGroup',$parentId,'create');
		
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
					//and now add permissions to the users
					//NOTE: we assume that the user is logged in to get to this page (and has a session)
					//NOTE: we are giving the users who make the event groups full permissions
					if ($this->data['EventGroup']['parent_id'] == 0) {
						$userid = $this->Session->read('userid');
						// add permissions
						$this->UserPerm->addPerm($userid, $eventGroupId);
						$this->Session->setFlash('Great! You\'ve just created a Gathering. Now you can start adding events, permissions, and groups below.');
					} else {
						$this->Session->setFlash('Great! You\'ve just created a group.');
					}
					$eventGroupId = $this->EventGroup->getLastInsertId();
					$newGroup = $this->EventGroup->findById($eventGroupId);
					$this->redirect("/event_groups/view_admin/".$newGroup['EventGroup']['path']);
				} else {
					$this->data = $oldData;
					$this->Session->setFlash(__('The group could not be saved. Please, try again.', true));
				}
			} else {
				$this->Session->setFlash(__('This path has already been taken.', true));
			}
		}
		
		
		$this->data['EventGroup']['location'] = $currenteventGroup['EventGroup']['location'];
		$this->set(compact('parentId', 'currenteventGroup', 'groupPath'));
		$this->set('isAdmin', true);
	}
	function addTool($parentId = null) {
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
		$currenteventGroup = $this->EventGroup->findById($id);
		if (!empty($this->data)) {
			if (!$id)
				$id = $this->data['EventGroup']['id'];
			if ($this->data['EventGroup']['name'] != $currenteventGroup['EventGroup']['name']) {
				if ($currenteventGroup['EventGroup']['parent_id'] == 0) {//change all event groups under with the new highest name if it changed
					$eventGroups = $this->EventGroup->children($id);
					foreach ($eventGroups as $eventGroup) {
						$eventGroup['EventGroup']['highest_name'] = $this->data['EventGroup']['name'];
						$this->EventGroup->save($eventGroup);
					}
					$this->data['EventGroup']['highest_name'] = $this->data['EventGroup']['name'];
				} else {//change all subgroup paths as well as the current group if the name changes
					$path = $currenteventGroup['EventGroup']['path'];
					$pathArr = explode('/', $path);
					$pathArr[count($pathArr)-1] = $this->data['EventGroup']['name'];
					$newpath = implode('/', $pathArr);
					$this->data['EventGroup']['path'] = $newpath;
					$eventGroups = $this->EventGroup->children($id);
					foreach ($eventGroups as $eventGroup) {
						$eventGroup['EventGroup']['path'] = preg_replace("@".$path."@", $newpath, $eventGroup['EventGroup']['path']);
						echo "cooler path".$eventGroup['EventGroup']['path'];
						$this->EventGroup->save($eventGroup);
					}
				}
			} 
			if ($this->EventGroup->save($this->data)) {
				$this->Session->setFlash(__('The EventGroup has been saved', true));
				$eventStuff = $this->EventGroup->findById($id);
				$this->redirect("/event_groups/view_admin/".$eventStuff['EventGroup']['path']);
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please try again.', true));
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
			$this->Session->setFlash(__('Invalid group ID.', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EventGroup->delete($id)) {
			$this->UserPerm->deleteGroupPerms($id);
			
			
			$this->Session->setFlash(__('Group successfully deleted.', true));
			$repath = "/event_groups/view_admin/".$eventParent['EventGroup']['path'];
			if ($eventStuff['EventGroup']['parent_id']==0)
				$repath = "/users/index";
			$this->redirect($repath);
		}
		
	}
	function ajaxListEvents($id) {
		
		$this->sharedAjaxList($id, 20);
		
		$this->render('ajax_list_events', 'ajax');
	}
	function map_view($id) {
		$this->sharedAjaxList($id, 20);
		$this->render('map_view', 'ajax');
	}
	function sharedAjaxList($id, $eventsPerPage) {
		
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
				sprintf('MATCH(`Event.description`, `Event.title`, `Event.location`, `Event.tags`)
				AGAINST("%s" IN BOOLEAN MODE)', preg_replace('/[^ \-+a-z0-9]/', "", $this->params['url']['search']) ));
			}
			$timeStart = date("Y-m-d H:i:s", strtotime($this->params['url']['date_start']) + $this->params['url']['time_start']*3600);
			$params[] = sprintf('time_start >= \'%s\'', $timeStart); 
		}
		$params['status'] = array('confirmed', 'hidden');
		//$groupPath = $this->EventGroup->getPath($id);
		//$treeList = $this->EventGroup->generateTreeList();
		if (strpos($this->params['url']['viewType'], 'calendar') !== false) {
			if ($this->Session->check('userid'))
				$eventsUnderGroup = $this->EventGroup->getFavorites($this->Session->read('userid'));
			else
				$eventsUnderGroup = array();
		} else {
			$p = 1;
			if (isset($this->params['url']['p'])) {
				$p = $this->params['url']['p'];
			}
			$curPage = $p;
			$eventsUnderGroup = $this->EventGroup->getAllEventsUnderThis($id, $this->Session->read('userid'), $params);
			$totalEventCount = count($eventsUnderGroup); // super inefficient; this should be cached in a db table.
			$eventsUnderGroup = array_slice($eventsUnderGroup, ($p-1)*$eventsPerPage, $eventsPerPage);
		}
		if (strpos($this->params['url']['viewType'], 'map') !== false) {
			$newArr = array();
			foreach ($eventsUnderGroup as $event) {
				if (!empty($event['Event']['latitude'])) {
					$newArr[] = $event;
				}
			}
			$eventsUnderGroup = $newArr;
		}
		$this->set(compact(/*'groupPath', */'eventsUnderGroup', 'eventGroups', 'aclNum',
		'currenteventGroup', 'totalEventCount', 'curPage', 'eventsPerPage'));
	}
	
	

}
?>

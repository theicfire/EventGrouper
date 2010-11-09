<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $uses = array('User', 'UserAlias', 'EventGroup', 'Event');
	var $helpers = array('Html', 'Form', 'Javascript', 'Access');
	var $components = array('Acl');
	function index() {
		if (!$this->Session->check('userid')) {
			$this->Session->setFlash('Log in first');
			$this->redirect('/');
		}
		$userEventGroups = $this->User->query("SELECT EventGroup.* FROM `aros` 
		LEFT JOIN (aros_acos, acos, event_groups AS EventGroup) 
		ON (aros.id = aros_acos.aro_id AND aros_acos.aco_id = acos.id AND acos.foreign_key = EventGroup.id) 
		WHERE aros.foreign_key = ".$this->Session->read('userid')." AND acos.model = 'EventGroup';");
		$ids = array();
		foreach ($userEventGroups as $single) {
			$ids[] = $single['EventGroup']['id'];
		}
		foreach ($userEventGroups as $key=>$value) {
			if (in_array($value['EventGroup']['parent_id'], $ids))
				unset($userEventGroups[$key]);
		}
		foreach ($userEventGroups as $key=>$value) {
			$userEventGroups[$key]['EventGroup']['eventcount'] = count($this->EventGroup->getAllEventsUnderThis($value['EventGroup']['id'], null, array('status' => array('confirmed', 'hidden'))));
			$userEventGroups[$key]['EventGroup']['eventgroupcount'] = count($this->EventGroup->getAllEventGroupsUnderThis($value['EventGroup']['id']))-1;
			$userEventGroups[$key]['EventGroup']['groupPath'] = $this->EventGroup->getPath($value['EventGroup']['id']);
		}
		$sentEvents = $this->Event->find('all', array('conditions' => array('user_id' => $this->Session->read('userid'), array('NOT' => array('status' => array('hidden'))))));
		$this->set(compact('userEventGroups','sentEvents'));
		$this->set('isAdmin', true);
		
//		$this->User->recursive = 0;
//		$this->set('users', $this->paginate());
//		$options['joins'] = array(
//		    array('table' => 'events',
//		        'alias' => 'EventsUserOwns',
//		        'type' => 'LEFT',
//		        'conditions' => array(
//		            'User.id = EventsUserOwns.user_id',
//		        )
//		    ),
//		    array('table' => 'events_users',
//		        'alias' => 'EventsLinker',
//		        'type' => 'LEFT',
//		        'conditions' => array(
//		            'User.id = EventsLinker.user_id',
//		        )
//		    ),
//		    array('table' => 'events',
//		        'alias' => 'EventsOnCalendar',
//		        'type' => 'LEFT',
//		        'conditions' => array(
//		            'EventsLinker.event_id = EventsOnCalendar.id',
//		        )
//		    )
//		);
//		$options['fields'] = array('EventsUserOwns.*', 'User.*');
//				
//		$this->set('usertemp', $this->User->find('all', $options));
	}

//	function view($id = null) {
//		if (!$id) {
//			$this->Session->setFlash(__('Invalid User.', true));
//			$this->redirect(array('action'=>'index'));
//		}
//		$this->set('user', $this->User->read(null, $id));
//	}

	function add($unregisteredId = null, $hasAccount = null) {
		if ($this->Session->check('userid'))
			$this->redirect("/");
		$this->Session->destroy();
		$unregisteredData = null;
		if ($unregisteredId != null) {
			$unregisteredData = $this->User->findById($unregisteredId);
		}
		$oldData = $this->data;
		if (!empty($this->data)) {
			if (!empty($unregisteredId)) {
				if ($hasAccount == "newaccount") {
					$this->User->findById($unregisteredId);
					$this->data['User']['id'] = $unregisteredId;
					$this->data['User']['pass'] = sha1($this->data['User']['pass']);
					if ($oldData['User']['confirm password'] == $oldData['User']['pass'] && $this->User->save($this->data)) {
						$this->Session->write('username', $this->data['User']['email']);//todo is this secure?
						$this->Session->write('userid', $unregisteredId);//todo is this secure?
						
						$this->Session->setFlash(__('You are now registered!', true));
						$this->redirect(array('controller' => 'event_groups', 'action'=>'index'));//todo change this
					} else {
						$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
					}
				} else { //make alias
					//todo it's bad to assume that the user/pass is correct (because js checks it)
					$realUser = $this->User->findByEmail($this->data['User']['email']);
					$aliasUser = $this->User->findById($unregisteredId);
					$realAro = $this->Acl->Aro->findByForeignKey($realUser['User']['id']);
					$aliasAro = $this->Acl->Aro->findByForeignKey($aliasUser['User']['id']);
					$this->Acl->Aro->query("UPDATE aros_acos SET aro_id = ".$realAro['Aro']['id']." WHERE aro_id = ".$aliasAro['Aro']['id']);
					$aliasData = array('UserAlias' => array('alias' => $aliasUser['User']['email'],
					'user_id' => $realUser['User']['id']));
					$this->UserAlias->save($aliasData);
					$this->User->delete($unregisteredId);
					$this->Acl->Aro->delete($aliasAro['Aro']['id']);
					
					$this->Session->write('username', $this->data['User']['email']);//todo is this secure?
					$this->Session->write('userid', $realUser['User']['id']);//todo is this secure?
					$this->Session->setFlash(sprintf("You're account %s now has the alias %s", $this->data['User']['email'], $aliasUser['User']['email']));
					$this->redirect(array('controller' => 'event_groups', 'action'=>'index'));//todo change this
				}
			} else {
				$emailData = $this->User->findByEmail($this->data['User']['email']);
				if (empty($emailData)) {
					$this->User->create();
					$this->data['User']['pass'] = sha1($this->data['User']['pass']);
					if ($oldData['User']['confirm password'] == $oldData['User']['pass'] && $this->User->save($this->data)) {
						//add aro
						$userId = $this->User->getLastInsertId();
						$aroArr = array(
							'model' => 'User',
							'foreign_key' => $userId,
							'parent_id' => 1//This is the designated guest id in aros
						);
						$this->Acl->Aro->create();
						$this->Acl->Aro->save($aroArr);
						$this->Session->write('username', $this->data['User']['email']);//todo is this secure?
						$this->Session->write('userid', $userId);//todo is this secure?
						$this->Session->setFlash('You are now registered!');
						$this->redirect(array('controller' => 'event_groups', 'action'=>'index'));
					} else {
						$this->Session->setFlash('The User could not be saved. Please, try again.');
					}
				} else {
					$this->set('error', 'email_taken');
				}
			}
		}
		$this->data = $oldData;
		$this->set(compact('unregisteredData', 'hasAccount'));
	}
	
//	function edit($id = null) {
//		$this->loadModel('Event');
//		if (!$id && empty($this->data)) {
//			$this->Session->setFlash(__('Invalid User', true));
//			$this->redirect(array('action'=>'index'));
//		}
//		if (!empty($this->data)) {
//			if ($this->User->save($this->data)) {
//				$this->Session->setFlash(__('The User has been saved', true));
//				$this->redirect(array('action'=>'index'));
//			} else {
//				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
//			}
//		}
//		if (empty($this->data)) {
//			$this->data = $this->User->read(null, $id);
//		}
//		$eventGroups = $this->User->EventGroup->find('list');
//		$events = $this->User->Event->find('list');
//		$ownedEvents = $this->Event->find('all', array(
//			'fields' => array('Event.title'),
//			'conditions' => array('Event.user_id' => $id)
//		));
//		$this->set(compact('eventGroups','events', 'ownedEvents'));
//	}

//	function delete($id = null) {
//		if (!$id) {
//			$this->Session->setFlash(__('Invalid id for User', true));
//			$this->redirect(array('action'=>'index'));
//		}
//		if ($this->User->delete($id)) {
//			$this->Session->setFlash(__('User deleted', true));
//			$this->redirect(array('action'=>'index'));
//		}
//	}

}
?>

<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form');
	var $components = array('Acl');

	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
		$options['joins'] = array(
		    array('table' => 'events',
		        'alias' => 'EventsUserOwns',
		        'type' => 'LEFT',
		        'conditions' => array(
		            'User.id = EventsUserOwns.user_id',
		        )
		    ),
		    array('table' => 'events_users',
		        'alias' => 'EventsLinker',
		        'type' => 'LEFT',
		        'conditions' => array(
		            'User.id = EventsLinker.user_id',
		        )
		    ),
		    array('table' => 'events',
		        'alias' => 'EventsOnCalendar',
		        'type' => 'LEFT',
		        'conditions' => array(
		            'EventsLinker.event_id = EventsOnCalendar.id',
		        )
		    )
		);
		$options['fields'] = array('EventsUserOwns.*', 'User.*');
				
		$this->set('usertemp', $this->User->find('all', $options));
	}

//	function view($id = null) {
//		if (!$id) {
//			$this->Session->setFlash(__('Invalid User.', true));
//			$this->redirect(array('action'=>'index'));
//		}
//		$this->set('user', $this->User->read(null, $id));
//	}

	function add($unregisteredId = null, $hasAccount = null) {
		$unregisteredData = null;
		if ($unregisteredId != null) {
			$unregisteredData = $this->User->findById($unregisteredId);
		}
		$oldData = $this->data;
		if (!empty($this->data)) {
			if (!empty($unregisteredId) && $hasAccount == "newaccount") {
				$this->User->findById($unregisteredId);
				$this->data['User']['pass'] = sha1($this->data['User']['pass']);
				if ($oldData['User']['confirm password'] == $oldData['User']['pass'] && $this->User->save($this->data)) {
					$this->Session->write('username', $this->data['User']['email']);//todo is this secure?
					$this->Session->write('userid', $unregisteredId);//todo is this secure?
					
					$this->Session->setFlash(__('You are now registered!', true));
					$this->redirect(array('controller' => 'event_groups', 'action'=>'index'));//todo change this
				} else {
					$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
				}
			}
			else {
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
						$this->Session->setFlash(__('You are now registered!', true));
						$this->redirect(array('controller' => 'event_groups', 'action'=>'index'));
					} else {
						$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
					}
				} else {
					$this->Session->setFlash(__('That username has already been taken.', true));
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
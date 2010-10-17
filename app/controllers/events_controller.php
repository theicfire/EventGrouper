<?php
class EventsController extends AppController {

	var $name = 'Events';
	var $uses = array('Event', 'User', 'EventGroup', 'CategoryChoice');
	var $helpers = array('Html', 'Form', 'Javascript');
	var $components = array('Acl', 'MyAcl');

	function index() {
		$this->Event->recursive = 0;
		$this->set('events', $this->paginate());
		$this->set('eventtemp', $this->Event->find('all'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Event.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('event', $this->Event->read(null, $id));
	}

	function add($eventGroupId = null) {
		if (!empty($this->data)) {
			$eventGroupId = $this->data['Event']['event_group_id'];
			$this->Event->create();
			if ($this->Event->save($this->data)) {
				
				
				
				$acoParent = $this->Event->query("SELECT id FROM acos WHERE foreign_key = ".$this->data['Event']['event_group_id']);
				if (!empty($acoParent))
					$acoParentId = $acoParent[0]['acos']['id'];
				else
					echo "Not supposed to happen";
				$eventGroupId = $this->Event->getLastInsertId();
				$acoArr = array(
					'model' => 'Event',
					'parent_id' => $acoParentId,
					'foreign_key' => $eventGroupId
				);
				$this->Acl->Aco->create();
				$this->Acl->Aco->save($acoArr);
				//and now add permissions to the users
				//NOTE: we assume that the user is logged in to get to this page (and has a session)
				//NOTE: we are giving the users who make the event groups full permissions
				$userid = $this->Session->read('userid');
				$this->Acl->allow(array('model' => 'User', 'foreign_key' => $userid), array('model' => 'Event', 'foreign_key' => $eventGroupId));
			
			
			
			
				$pathRes = $this->EventGroup->findById($this->data['Event']['event_group_id']);
				$this->Session->setFlash(__('The Event has been saved', true));
				$this->redirect("/".$pathRes['EventGroup']['path']);
			} else {
				$this->Session->setFlash(__('The Event could not be saved. Please, try again.', true));
			}
		}
		if ($eventGroupId == null)
			echo "Something's wrong";
		
		$categoryChoices = $this->CategoryChoice->find('list', array('conditions' => array('event_group_id' =>$eventGroupId)));
		$users = $this->Event->User->find('list');
		$users = $this->Event->User->find('list');
		$eventGroup = $this->EventGroup->findById($eventGroupId);
		$this->set(compact('categoryChoices', 'users', 'eventGroup', 'users', 'eventGroupId'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Event', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Event->save($this->data)) {
				$pathRes = $this->Event->findById($this->data['Event']['id']);
				$this->Session->setFlash(__('The Event has been saved', true));
				$this->redirect("/".$pathRes['EventGroup']['path']);
			} else {
				$this->Session->setFlash(__('The Event could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Event->read(null, $id);
		}
		$groupId = $this->Event->findById($id);
		$groupId = $groupId['Event']['event_group_id'];
		$categoryChoices = $this->CategoryChoice->find('list', array('conditions' => array('event_group_id' =>$groupId)));
		$users = $this->Event->User->find('list');
		$eventGroups = $this->Event->EventGroup->find('list');
		$users = $this->Event->User->find('list');
		$this->set(compact('categoryChoices','users','eventGroups','users', 'eventGroupId'));
	}

	function delete($id = null) {
		$pathRes = $this->Event->findById($id);
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Event', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Event->delete($id)) {
			$this->Session->setFlash(__('Event deleted', true));
			$this->redirect("/".$pathRes['EventGroup']['path']);
		}
		echo "hey";
	}
	
	function viewCalendar() {
		if ($this->Session->check('username')) {
			$userStuff = $this->User->find('first', array('conditions' => array('email' => $this->Session->read('username'))));
			$eventsOnCalendar = $userStuff['EventsOnCalendar'];
			//print_r($eventsOnCalendar);
			$this->set(compact('eventsOnCalendar'));
		} else {
			echo "false (not logged in)";
		}
		//$this->render(false);
	}
	
	function addToCalendar($id = null) {
		if ($id == null) {
			echo "you don't have an event to add";
		} else {
			if ($this->User->addEventToUser($this->Session->read('userid'), $id))
				echo "event added";
			else
				echo "event already added"; 
		}
		
		$this->render(false);
	}
	function removeFromCalendar($id = null) {
		if ($id == null) {
			echo "you don't have an event to remove";
		} else {
			if ($this->User->deleteEventFromUser($this->Session->read('userid'), $id))
				echo "event deleted";
			else
				echo "event already deleted"; 
		}
		
		$this->render(false);
	}
	function mapTesting() {
		
	}

}
?>
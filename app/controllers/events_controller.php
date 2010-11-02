<?php
class EventsController extends AppController {

	var $name = 'Events';
	var $uses = array('Event', 'User', 'EventGroup', 'CategoryChoice');
	var $helpers = array('Html', 'Form', 'Javascript', 'Configuration', 'Access');
	var $components = array('Acl', 'MyAcl');


	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Event.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->MyAcl->runcheck('Event',$id,'read');
		$event = $this->Event->read(null, $id);
		$groupPath = $this->EventGroup->getPath($event['EventGroup']['id']);
		
		$this->set(compact('event', 'groupPath'));
	}

	function add($eventGroupId = null) {
		if (!$eventGroupId) {
			$this->Session->setFlash(__('Invalid EventGroup.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->MyAcl->runcheck('EventGroup',$eventGroupId,'create');
		if (!empty($this->data)) {
			$this->Event->create();
			$this->data['Event']['event_group_id'] = $eventGroupId;
			$this->data['Event']['time_start'] = $this->data['Other']['date_start']." ".$this->data['Other']['time_start'];
			$this->data['Event']['duration'] = (strtotime($this->data['Other']['date_end']." ".$this->data['Other']['time_end']) - strtotime($this->data['Other']['date_start']." ".$this->data['Other']['time_start']))/60; 
			if ($this->Event->save($this->data)) {
				
				
				
				$acoParent = $this->Event->query("SELECT id FROM acos WHERE foreign_key = ".$eventGroupId);
				if (!empty($acoParent))
					$acoParentId = $acoParent[0]['acos']['id'];
				else
					echo "Not supposed to happen";
				$eventId = $this->Event->getLastInsertId();
				$acoArr = array(
					'model' => 'Event',
					'parent_id' => $acoParentId,
					'foreign_key' => $eventId
				);
				$this->Acl->Aco->create();
				$this->Acl->Aco->save($acoArr);
				//and now add permissions to the users
				//NOTE: we assume that the user is logged in to get to this page (and has a session)
				//NOTE: we are giving the users who make the event groups full permissions
				$userid = $this->Session->read('userid');
				$this->Acl->allow(array('model' => 'User', 'foreign_key' => $userid), array('model' => 'Event', 'foreign_key' => $eventId));
			
			
			
			
				$pathRes = $this->EventGroup->findById($eventGroupId);
				$this->Session->setFlash('The Event has been saved');
				$this->redirect("/".$pathRes['EventGroup']['path']);
			} else {
				$this->Session->setFlash(__('The Event could not be saved. Please, try again.', true));
			}
		}
		
		$categoryChoices = $this->CategoryChoice->find('list', array('conditions' => array('event_group_id' =>$eventGroupId)));
		$users = $this->Event->User->find('list');
		$users = $this->Event->User->find('list');
		$eventGroup = $this->EventGroup->findById($eventGroupId);
		$groupPath = $this->EventGroup->getPath($eventGroupId);
		$this->set(compact('categoryChoices', 'eventGroup', 'users', 'eventGroupId', 'groupPath'));
		$this->set('isAdmin', true);
	}

	function edit($id = null) {
		if (!empty($this->data))
			$id = $this->data['Event']['id'];
		if (!$id) {
			$this->Session->setFlash(__('Invalid Event', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->MyAcl->runcheck('Event',$id,'update');
		if (!empty($this->data)) {
			
			// add code here to change form input
			if ($this->Event->save($this->data)) {
				$pathRes = $this->Event->findById($id);
				$this->Session->setFlash(__('The Event has been saved', true));
				$this->redirect("/events/view/".$id);
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
		$groupPath = $this->EventGroup->getPath($groupId);
		$eventGroupId = $groupId;
		$this->set(compact('categoryChoices','users','eventGroups', 'eventGroupId', 'groupPath'));
		$this->set('isAdmin', true);
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Event', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->MyAcl->runcheck('Event',$eventGroupId,'delete');
		$pathRes = $this->Event->findById($id);
		if ($this->Event->delete($id)) {
			$this->Session->setFlash(__('Event deleted', true));
			$this->redirect("/".$pathRes['EventGroup']['path']);
		}
	}
	
	function viewCalendar() {
		if ($this->Session->check('username')) {
			$userStuff = $this->User->find('first', array('conditions' => array('email' => $this->Session->read('username'))));
			$eventsOnCalendar = $userStuff['EventsOnCalendar'];
			//print_r($eventsOnCalendar);
			$this->set(compact('eventsOnCalendar'));
		} else {
			$this->redirect("/login");
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

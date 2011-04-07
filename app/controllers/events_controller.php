<?php
class EventsController extends AppController {

	var $name = 'Events';
	var $uses = array('Event', 'User', 'EventGroup');
	var $helpers = array('Html', 'Form', 'Javascript', 'Access');
	var $components = array('Acl', 'MyAcl');


	function view($id = null) {
		$event = $this->Event->read(null, $id);
		$this->set(compact('event'));
		$this->render('view', 'ajax');
	}

	function add($eventGroupId = null) {
		$this->MyAcl->runcheck('EventGroup',$eventGroupId,'create');
		$eventGroup = $this->EventGroup->findById($eventGroupId);
		if (!empty($this->data)) {
			$this->Event->create();
			$userid = $this->Session->read('userid');
			$this->data['Event']['user_id'] = $userid;
			$this->data['Event']['event_group_id'] = $eventGroupId;
			
			App::import('Helper', 'Html'); // loadHelper('Html'); in CakePHP 1.1.x.x
	        $html = new HtmlHelper();			
			$flashMessage = "<b>".$this->data['Event']['title']."</b> has been submitted and is under review. To see it's status go to the ".$html->link('Admin Panel Home', '/users/index')." Page."; 
			if ($this->MyAcl->check('EventGroup',$eventGroupId,'bigOwner')) {
				$this->data['Event']['status'] = 'hidden'; 
				$flashMessage = "<b>".$this->data['Event']['title']."</b> saved. ".$html->link('See it in the timeline.', "/".$eventGroup['EventGroup']['path']);
			}
			$this->Session->setFlash($flashMessage);
			if ($this->Event->save($this->data)) {
				$acoParent = $this->Event->query("SELECT id FROM acos WHERE foreign_key = ".$eventGroupId." AND model = 'EventGroup'");
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
				//since this has a parent_id, permissions should already be set
				
				$this->data = array();
//				$this->redirect("/event_groups/view_admin/".$eventGroup['EventGroup']['path']);
			} else {
				$this->Session->setFlash(__('The Event could not be saved. Please, try again.', true));
			}
		}
		
		
		//$users = $this->Event->User->find('list');
		//$users = $this->Event->User->find('list');
		$this->data['Event']['location'] = $eventGroup['EventGroup']['location'];
		$groupPath = $this->EventGroup->getPath($eventGroupId);
		$eventsUnderGroup = $this->EventGroup->getAllEventsUnderThis($eventGroupId, $this->Session->read('userid'), array('status' => array('confirmed', 'hidden')));
		$this->set(compact('eventGroup', 'users', 'eventGroupId', 'groupPath', 'eventsUnderGroup'));
		$this->set('isAdmin', true);
	}

	function edit($id = null) {
		if (!empty($this->data))
			$id = $this->data['Event']['id'];
		
		$this->MyAcl->runcheck('Event',$id,'update');
		$groupId = $this->Event->findById($id);
		$groupId = $groupId['Event']['event_group_id'];
		$eventGroup = $this->EventGroup->findById($groupId);
		if (!empty($this->data)) {
			if ($this->Event->save($this->data)) {
				$this->Session->setFlash(__('The Event has been saved', true));
				$this->redirect("/event_groups/view_admin/".$eventGroup['EventGroup']['path']);
			} else {
				$this->Session->setFlash(__('The Event could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Event->read(null, $id);
		}
		$users = $this->Event->User->find('list');
		$eventGroups = $this->Event->EventGroup->find('list');
		$users = $this->Event->User->find('list');
		$groupPath = $this->EventGroup->getPath($groupId);
		
		$this->set(compact('users','eventGroups', 'eventGroupId', 'groupPath', 'eventGroup'));
		$this->set('isAdmin', true);
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Event', true));
			$this->redirect(array('action'=>'index'));
		}
		$groupId = $this->Event->findById($id);
		$groupId = $groupId['Event']['event_group_id'];
		$this->MyAcl->runcheck('EventGroup',$groupId,'create');
		$pathRes = $this->Event->findById($id);
		$eventGroup = $this->EventGroup->findById($groupId);
		if ($this->Event->delete($id)) {
			$this->Session->setFlash(__('Event deleted', true));
			$this->redirect("/event_groups/view_admin/".$eventGroup['EventGroup']['path']);
		}
	}
	
//	function viewCalendar() {
//		if ($this->Session->check('username')) {
//			$userStuff = $this->User->find('first', array('conditions' => array('email' => $this->Session->read('username'))));
//			$eventsOnCalendar = $userStuff['EventsOnCalendar'];
//			//print_r($eventsOnCalendar);
//			$this->set(compact('eventsOnCalendar'));
//		} else {
//			$this->redirect("/login");
//		}
//		//$this->render(false);
//	}
	
	function addToCalendar($id = null) {
		if ($id == null) {
			echo "you don't have an event to add";
		} else {
			if ($this->User->addEventToUser($this->Session->read('userid'), $id))
				echo "event added";
			else
				echo "event already added"; 
		}
		
		$this->autoRender = false;
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
		
		$this->autoRender = false;
	}
	function mapTesting() {
		
	}

}
?>

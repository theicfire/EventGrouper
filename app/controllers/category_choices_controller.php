<?php
class CategoryChoicesController extends AppController {

	var $name = 'CategoryChoices';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->CategoryChoice->recursive = 0;
		$this->set('categoryChoices', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CategoryChoice.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('categoryChoice', $this->CategoryChoice->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->CategoryChoice->create();
			if ($this->CategoryChoice->save($this->data)) {
				$this->Session->setFlash(__('The CategoryChoice has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CategoryChoice could not be saved. Please, try again.', true));
			}
		}
		$events = $this->CategoryChoice->Event->find('list');
		$eventGroups = $this->CategoryChoice->EventGroup->find('list');
		$users = $this->CategoryChoice->User->find('list');
		$this->set(compact('events', 'eventGroups', 'users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CategoryChoice', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CategoryChoice->save($this->data)) {
				$this->Session->setFlash(__('The CategoryChoice has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CategoryChoice could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CategoryChoice->read(null, $id);
		}
		$events = $this->CategoryChoice->Event->find('list');
		$eventGroups = $this->CategoryChoice->EventGroup->find('list');
		$users = $this->CategoryChoice->User->find('list');
		$this->set(compact('events','eventGroups','users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CategoryChoice', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CategoryChoice->delete($id)) {
			$this->Session->setFlash(__('CategoryChoice deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
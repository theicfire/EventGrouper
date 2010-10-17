<?php
class LoginController extends AppController {

	var $name = 'Login';
	var $uses = array('User');//don't use a model
	var $helpers = array('Html', 'Form', 'Javascript');

	function index() {
		if (!empty($this->data)) {
			$userData = $this->User->find('first', array('conditions' => array('email' => $this->data['User']['email']), 'recursive' => -1));
			if (!empty($this->data['User']['pass']) && !empty($userData['User']['pass']) && sha1($this->data['User']['pass']) == $userData['User']['pass']) {
				$this->Session->write('username', $this->data['User']['email']);//todo is this secure?
				$this->Session->write('userid', $userData['User']['id']);//todo is this secure?
			} else {
				$this->Session->write('username', null);
				$this->Session->write('userid', null);
			}
		}
	}
	
	function checkLogin() {
		$this->autoRender = false;
		if (!empty($_POST['email'])) {
			$userData = $this->User->find('first', array('conditions' => array('email' => $_POST['email']), 'recursive' => -1));
			if (!empty($_POST['pass']) && !empty($_POST['email']) && sha1($_POST['pass']) == $userData['User']['pass']) {
				$this->Session->write('username', $_POST['email']);//todo is this secure?
				$this->Session->write('userid', $userData['User']['id']);//todo is this secure?
				echo "good";
			} else {
				$this->Session->write('username', null);
				$this->Session->write('userid', null);
				echo "bad";
			}
		} else {
			echo "post is empty";
		}
	}
	
	function logout() {
		$this->Session->destroy();
		$this->redirect(array('controller' => 'event_groups', 'action'=>'index'));
	}
	
	

}
?>
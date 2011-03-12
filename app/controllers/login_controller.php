<?php
class LoginController extends AppController {

	var $name = 'Login';
	var $uses = array('User');//inherit User from appcontroller
	var $helpers = array('Html', 'Form', 'Javascript');

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
	function checkEmailExists() {
		$this->autoRender = false;
		if (!empty($_POST['email'])) {
			$userData = $this->User->find('first', array('conditions' => array('email' => $_POST['email']), 'pass !=' => 'unregistered', 'recursive' => -1));
			if (!empty($userData)) {
				echo "good";
			} else {
				echo "bad";
			}
		} else {
			echo "post is empty";
		}
	}
	
	function logout() {
		$this->autoRender = false;
		$this->Session->destroy();
		$this->redirect($this->referer());
	}
	
	

}
?>
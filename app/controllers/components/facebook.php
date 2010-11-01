<?php
class FacebookComponent extends Object {
	var $components = array('Session', 'Acl');
		

	//called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->controller =& $controller;
		$this->User= ClassRegistry::init('User');
		$this->controller->set('FACEBOOK_APP_ID', Configure::read('FACEBOOK_APP_ID'));
	}
	function get_facebook_cookie($app_id, $application_secret) {
	  $args = array();
	  if (!array_key_exists('fbs_' . $app_id, $_COOKIE))
	  	return null;
	  parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
	  ksort($args);
	  $payload = '';
	  foreach ($args as $key => $value) {
	    if ($key != 'sig') {
	      $payload .= $key . '=' . $value;
	    }
	  }
	  if (md5($payload . $application_secret) != $args['sig']) {
	    return null;
	  }
	  return $args;
	}
	
	function getEmail() {
		$cookie = $this->get_facebook_cookie(Configure::read('FACEBOOK_APP_ID'), Configure::read('FACEBOOK_SECRET'));
		if ($cookie)
			$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$cookie['access_token']));
		else
			return "";
		return $user->email;
	}
	
	function login() {
		if ($this->Session->read('username') == null) {
			$email = $this->getEmail();
			if ($email != "") {
				$emailData = $this->User->findByEmail($email);
				if (empty($emailData)) {
					$this->User->create();
					$this->data['User']['pass'] = "fromfacebook";
					$this->data['User']['email'] = $email;
					if ($this->User->save($this->data)) {
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
						$this->Session->write('userid', $userId);
						$this->Session->write('username', $email);
					} else {
						$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
					}
				} else {
					$this->Session->write('userid', $emailData['User']['id']);
					$this->Session->write('username', $email);
				}
			}
		}
	}
}
?>

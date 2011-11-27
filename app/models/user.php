<?php
class User extends AppModel {

	var $name = 'User';
	var $actsAs = 'ExtendAssociations';
//	javascript can do the validation here... if the user passes this, whatever.
//	var $validate = array(
//		'email' => array(
//			'rule' => '/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i',
//			'message' => 'Required. Must be valid.',
//			'allowEmpty' => false
//		),
//		'pass' => array(
//		),
//		'confirm password' => array(
//		)
//	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		/*'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),*/
		'UserAlias' => array(
			'className' => 'UserAlias',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	
	function addEventToUser ($userId, $eventId) {
		$hasEvent = $this->userHasEvent($eventId, $userId);
		if (!$hasEvent) {
			$this->query("INSERT INTO events_users (user_id, event_id) VALUES(".$userId.", ".$eventId.");");
			return true;
		}
		return false;
	}
	
	function deleteEventFromUser ($userId, $eventId) {
		$hasEvent = $this->userHasEvent($eventId, $userId);
		if ($hasEvent) {
			$this->query(sprintf("DELETE FROM events_users WHERE user_id = %d AND event_id = %d",$userId, $eventId));
			return true;
		}
		return false;
	}
	
	function userHasEvent($eventId, $userId) {
		$num = $this->query(sprintf("SELECT count(*) FROM events_users WHERE event_id = %d AND user_id = %d", $eventId, $userId));
		if ($num[0][0]['count(*)'] == 1) {
			return true;
		}
		return false;
	}
	

}
?>

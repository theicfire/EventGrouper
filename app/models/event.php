<?php
class Event extends AppModel {

	var $name = 'Event';
	var $actsAs = 'ExtendAssociations';
//	var $validate = array(
//		'title' => array(
//			'valid' => array ('rule' => '/^[a-z0-9&.!,\'\? ]+$/i','message' => 'Required. Letters, numbers, and spaces only!'),
//			'isUnique' => array('rule' => 'isUnique', 'message' => 'This event name has been taken')
//			
//		),
//		'photo_url' => array(
//			'rule' => 'url',
//			'message' => "That's not a valid url",
//			'allowEmpty' => true
//		),
//		'time_start' => array(
//			'rule' => '/^[0-9: -]+$/i',
//			'message' => "Fix this..."
//		),
//		'location' => array(
//			'rule' => '/^[a-z0-9 ]+$/i',
//			'message' => 'Letters, numbers, and spaces only!',
//			'allowEmpty' => true
//		),
//	); 

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'EventGroup' => array(
			'className' => 'EventGroup',
			'foreignKey' => 'event_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserOwner' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'User',
			'joinTable' => 'events_users',
			'foreignKey' => 'event_id',
			'associationForeignKey' => 'user_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	function delete($id) {
		$this->query("DELETE FROM events WHERE id=".$id);
		$this->query("DELETE FROM events_users WHERE event_id=".$id);//todo you should probably tell ppl that the event is cancelled
		return true;
	}
	
	function save($data = null, $validate = true, $fieldList = array()) {
		$data['Event']['time_start'] = date('Y-m-d H:i:s', strtotime($data['Other']['date_start']." ".$data['Other']['time_start']));
		$data['Event']['duration'] = (strtotime($data['Other']['date_end']." ".$data['Other']['time_end']) - strtotime($data['Other']['date_start']." ".$data['Other']['time_start']))/60;
		$data['Event']['tags'] = strtolower($data['Event']['tags']);
        return parent::save($data, $validate, $fieldList);
    } 
	

}
?>
<?php
class UserPerm extends AppModel {

	var $name = 'UserPerm';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
/*	var $belongsTo = array(
		'UserOwner' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	var $hasMany = array(
		'EventGroup' => array(
			'className' => 'EventGroup',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);*/
	function addPerm($userId, $groupId) {
		$this->create();
		$userPerm = array(
			'user_id' => $userId,
			'group_id' => $groupId
		);
		$this->save($userPerm);
	}
	function deleteGroupPerms($groupId) {
		$this->query("DELETE FROM user_perms WHERE group_id = ".$groupId);
	}
	function deleteUserPerms($userId) {
		$this->query("DELETE FROM user_perms WHERE user_id = ".$userId);
	}
	// groupIds is an array of group ids for which to delete from
	function deletePerm($userId, $groupIds) {
		$this->query("DELETE FROM user_perms WHERE user_id = ".$userId." AND group_id  IN (".implode(",",$groupIds).")");
	}
	function changeUserId($oldUserId, $newUserId) {
		$this->query("UPDATE user_perms SET user_id = ".$newUserId." WHERE user_id = ".$oldUserId);
	}
	function getAllUserPerms($userId) {
		$res = $this->query("SELECT group_id from user_perms WHERE user_id = ".$userId);
		$ret = array();
		foreach ($res as $single) {
			$ret[$single['user_perms']['group_id']] = 1;
		}
		return $ret;
	}
	function hasPerms($userId, $groupId) {
		$res = $this->find('first', array('conditions' => array(
			'user_id' => $userId,
			'group_id' => $groupId)));
		return !empty($res);
	}

}
?>
<form name="loginForm" id="loginForm" method="post" action="<?php echo $html->url(array('controller' => 'permissions', 'action' => 'view', $groupId));?>">
	Add a User: <input type="text" name="data[email]">
	<input type="submit" value="Add">
</form>

--Users that have permissions--
<table cellpadding="0" cellspacing="0" id="events">
<tr>
<td>Id</td><td>Email</td><td>create</td><td>actions</td>
</tr>
<?php foreach ($userPerms as $userPerm) {?>
<tr>
		<td>
			<?php echo $userPerm['users']['id']; ?>
		</td>
		<td>
			<?php echo $userPerm['users']['email']; ?>
		</td>
		<td>
			<?php echo $userPerm['aros_acos']['_create']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $groupId, $userPerm['aros_acos']['id']), null, "Are you sure you want to delete this?");?>
		</td>
</tr>
<?php }?>
</table>
<div id="edit_account" class="info_box">
    
	<h1>Edit Permissions</h1>
	<p>in <?= $this->element('grouppath', array('groupStr' => $currentEventGroup['EventGroup']['path'], 'highestName' => $currentEventGroup['EventGroup']['highest_name']))?></p>	        
	<div class="form_section">
		<h2>Email Addresses</h2>
		<form name="loginForm" id="loginForm" method="post" action="<?php echo $html->url(array('controller' => 'permissions', 'action' => 'view', $groupId));?>">
		Add a User: <input type="text" name="data[email]" class="textfield">
		<input type="submit" value="Add" class="make_button">
		</form>      
		<table class="full_width">
			
		            
			<tr><th>Email address</th><th>Permissions</th><th>Actions</th></tr>  
		     <?php foreach ($userPerms as $userPerm) {?>
			<tr>
					<td>
						<?php echo $userPerm['users']['email']; ?>
					</td>
					<td>
						<?php foreach($userPerm['userEventGroups'] as $eventGroup) {
							echo $this->element('grouppath', array('groupStr' => $eventGroup['EventGroup']['path'], 'highestName' => $eventGroup['EventGroup']['highest_name']));
							echo "<br>";
						}
						?>
					</td>
					<td class="actions">
						<?php echo $html->link('Remove', array('action' => 'delete', $groupId, $userPerm['aros_acos']['aro_id']), array('class' => 'make_button'), "Are you sure you want to delete this?");?>
					</td>
			</tr>
			<?php }?>      
	            
		</table>
	</div>      
	<!--<a href="#" class="make_button"><img src="rinoa/add.png" class="rinoa_small_inline" /> Add another email address</a>-->
</div>

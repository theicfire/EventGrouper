<?php print_r($userPerms);?>
<?php echo $this->element('admin/top');?>



<div id="edit_account" class="info_box">
    
	<h1>Edit Permissions</h1>
	<p>in <?php 
				$linksArr = array($html->link(__('Home', true), array('action' => 'index')));
				if ($groupPath != null) {
					foreach ($groupPath as $single) {
						$linksArr[] = $html->link($single['EventGroup']['name'], "/".$single['EventGroup']['path']);
					}
				}
				echo implode($linksArr," > ");
				?></p>	        
	<div class="form_section">
		<h2>Email Addresses</h2>
		<form name="loginForm" id="loginForm" method="post" action="<?php echo $html->url(array('controller' => 'permissions', 'action' => 'view', $groupId));?>">
		Add a User: <input type="text" name="data[email]" class="textfield">
		<input type="submit" value="Add" class="make_button">
		</form>      
		<table class="full_width">
			
		            
			<tr><th>Email address</th><th>Actions</th></tr>  
		     <?php foreach ($userPerms as $userPerm) {?>
			<tr>
					<td>
						<?php echo $userPerm['users']['email']; ?>
					</td>
					<td class="actions">
						<?php echo $html->link('Remove', array('action' => 'delete', $groupId, $userPerm['aros_acos']['aro_id']), array('class' => 'make_button'), "Are you sure you want to delete this?");?>
					</td>
			</tr>
			<?php }?>      
	            
		</table>
	</div>      
	<!--<a href="#" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/add.png" class="rinoa_small_inline" /> Add another email address</a>-->
</div>

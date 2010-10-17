<?php if ($unregisteredData == null) {?><div class="users form">
	<?php echo $form->create('User');?>
		<fieldset>
	 		<legend><?php __('Add User');?></legend>
		<?php
			echo $form->input('email');
			echo $form->input('pass', array('type'=>'password'));
			echo $form->input('confirm password', array('type'=>'password'));//todo js checking
		?>
		</fieldset>
	<?php echo $form->end('Submit');?>
	</div>
<?php } else if ($hasAccount == null) {?>
	You have been given access to create events and groups in XXX.
	<br>
	<?php echo $html->link(__('Go here if you have never registered for this site', true), array('action' => 'add', $unregisteredData['User']['id'], "newaccount")); ?>
	<br>
	<?php echo $html->link(__('Go here if you have already registered for this site and are using a different email than this', true), array('action' => 'add', $unregisteredData['User']['id'], "makealias")); ?>
	<br>
	<?php } else if ($hasAccount == "makealias") {?>
	create an alias...

<?php } else {?>
	<?php echo $form->create('User', array('action' => sprintf("add/%d/%s", $unregisteredData['User']['id'], $hasAccount)));?>
		<fieldset>
	 		<legend><?php __('Add User');?></legend>
		<?php
			echo $form->input('email', array('disabled' => 'disabled', 'value' => $unregisteredData['User']['email']));
			echo $form->input('email', array('type' => 'hidden', 'value' => $unregisteredData['User']['email']));
			echo $form->input('pass', array('type'=>'password'));
			echo $form->input('confirm password', array('type'=>'password'));//todo js checking
		?>
		</fieldset>
	<?php echo $form->end('Submit');?>
	</div>
<?php }?>
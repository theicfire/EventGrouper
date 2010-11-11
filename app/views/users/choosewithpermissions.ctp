<div class="form_section" style="width: 800px; margin: 10px auto">
	<h2>Access Granted</h2>
	<p>
	You (<b><?=$unregisteredData['User']['email']?></b>) have been given access to create events and groups in RushRabbit.
	<br>
	Which one describes you best?</p>
	<?php echo $html->link(__('I do not have a RushRabbit account', true), array('action' => 'add', $unregisteredData['User']['id'], "newaccount"), array('class'=>'make_button')); ?>

	<?php echo $html->link(__('I have a RushRabbit account under a different email address', true), array('action' => 'add', $unregisteredData['User']['id'], "makealias"), array('class'=>'make_button')); ?>
	</div>
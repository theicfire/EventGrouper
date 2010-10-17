<div class="categoryChoices form">
<?php echo $form->create('CategoryChoice');?>
	<fieldset>
 		<legend><?php __('Edit CategoryChoice');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('event_group_id');
		echo $form->input('user_id');
		echo $form->input('Event');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('CategoryChoice.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('CategoryChoice.id'))); ?></li>
		<li><?php echo $html->link(__('List CategoryChoices', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Event Groups', true), array('controller' => 'event_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Event Group', true), array('controller' => 'event_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Events', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Event', true), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>

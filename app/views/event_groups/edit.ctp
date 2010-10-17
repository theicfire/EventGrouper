<div class="eventGroups form">
<?php 
print_r($categoryStr);
echo $form->create('EventGroup');?>
	<fieldset>
 		<legend><?php __('Edit EventGroup');?></legend>
	<?php
		echo $form->input('id', array('type'=>'hidden')); 
		echo $form->input('name', array('type' => 'text'));
		echo $form->input('description');
		echo $form->input('photo_url', array('type' => 'text'));
	if ($parentEventGroup['EventGroup']['id'] == 0) {	
	?>
		Category List (1 per row)
		<textarea name="data[Other][category_list]" id="OtherCategoryList"><?=$categoryStr?></textarea>
	<?php }?>
	<input type="hidden" name="data[Other][parent_id]" id="OtherParentId" value="<?=$parentEventGroup['EventGroup']['id']?>">
	<input type="hidden" name="pathstart" value="<?=$parentEventGroup['EventGroup']['path']?>">
	</fieldset>
	<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('EventGroup.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('EventGroup.id'))); ?></li>
		<li><?php echo $html->link(__('List EventGroups', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Event Groups', true), array('controller' => 'event_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Parent Event Group', true), array('controller' => 'event_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Category Choices', true), array('controller' => 'category_choices', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Category Choice', true), array('controller' => 'category_choices', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Events', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Event', true), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>

<?php echo $this->Session->read('username');?>
<div class="eventGroups form">
<?php echo $form->create('EventGroup');?>
	<fieldset>
 		<legend><?php __('Add EventGroup');?></legend>
	<?php
		echo $form->input('name', array('type' => 'text'));
		echo $form->input('description');
		echo $form->input('photo_url', array('type' => 'text'));
		if (empty($currenteventGroup['EventGroup']['path']))
			$path = "/";
		else
			$path = "/".$currenteventGroup['EventGroup']['path']."/";
		if ($parentId == 0)
			echo $form->input('path', array('type' => 'text', 'label' => "http://www.oursite.com".$path));
	if ($parentId == 0) {	
	?>
	Category List (1 per row)
		<textarea name="data[Other][category_list]" id="OtherCategoryList">Food
Fun</textarea>
	<?php }?>
	<input type="hidden" name="data[EventGroup][parent_id]" id="EventGroupParentId" value="<?=$parentId?>">
	<input type="hidden" name="pathstart" value="<?=$currenteventGroup['EventGroup']['path']?>">
	</fieldset>
<?php 
echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
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

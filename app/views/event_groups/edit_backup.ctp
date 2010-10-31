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

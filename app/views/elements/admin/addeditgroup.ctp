<?php echo $this->Form->create('EventGroup'); ?>
<div id="new_group" class="info_box">
    
    <h1><img src="<?php echo $html->url('/'); ?>css/rinoa/user_add.png" class="rinoa_large_inline" /> 
	<?php 
	if ($type == 'add') echo "New group";
	else echo "Edit group";
	?>
	</h1>
    <p>in <?= $this->element('grouppath', array('groupPath' => $groupPath))?></p>
    
        <div class="form_section">
        <h2>Basic Information</h2>
        
        
        <?php echo $form->create('EventGroup');?>
        <?php echo $form->input('name', array('type' => 'text', 'class' => 'textfield'));?>
        <p class="form_tip">This name will be displayed on the group's page, and will be used for searching. (for example, "Baker Hall")</p>
        
        <label>Picture</label>
        <input type="file" name="picture" />
        <p class="form_tip">This image will be displayed alongside the group description on the group's page.</p>
        
<?php	
	if ($parentId == 0) {
		if ($type == 'add') {
			if (empty($currenteventGroup['EventGroup']['path']))
				$path = "/";
			else
				$path = "/".$currenteventGroup['EventGroup']['path']."/";
			echo $form->input('path', array('type' => 'text', 'label' => "http://www.oursite.com".$path));
		}
?>
	<label>Category List (1 per row)</label>
	<input name="data[Other][category_list]" id="OtherCategoryList" value="<?php 
	if ($type == 'add') echo "Food, Fun";
	else echo $categoryStr;
	?>">

<?php 
	}
?>
	
        <label>Description</label>
		<?php echo $form->textarea('description');?>
        <p class="form_tip">The full description will be displayed on the event page, but only the first few words will show up on the timeline.  A preview of this event's timeline block is shown in the top right.</p>        
        </div>
        
        <?php echo $this->element('admin/map');?>
        
        <div class="form_section">
        <h2>Submit for Approval</h2>
        <input type="hidden" name="data[EventGroup][parent_id]" id="EventGroupParentId" value="<?=$parentId?>">
		<?php if ($type == 'add') {?><input type="hidden" name="pathstart" value="<?=$currenteventGroup['EventGroup']['path']?>"><?php }?>
		<?php if ($type == 'edit') echo $form->input('id', array('type'=>'hidden'));?>
        <?=$this->Form->button('Submit', array('type' => 'submit', 'class' => 'make_button'));?> 
        <p class="form_tip">This group will be approved by the REX coordinators.  Check here: <input type="checkbox" name="should_email" /> if you want to receive an email when it is approved.</p>
        </div>
    
    </div>
<?php echo $this->Form->end(); ?>
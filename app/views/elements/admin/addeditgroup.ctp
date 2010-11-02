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
			echo $form->input('path', array('type' => 'text', 'label' => 'Group URL', 'class' => 'textfield'));
			
			echo '<p class="form_tip">Your group will be found at <span id="group_url_update">';
			
			if($path == "/")
			{ echo "http://www.oursite.com".$path . "[Group URL]"; }
			else
			{ echo "http://www.oursite.com".$path;	}
			
			echo '</span></p>';
		}
?>
		<label>Category List</label>
		<input name="data[Other][category_list]" id="OtherCategoryList" class="textfield" value="<?php 
		if ($type == 'add') echo "Food, Tours, Information";
		else echo $categoryStr;
		?>">
		<p class="form_tip">Input possible categories for events, separated by commas.</p>

<?php 
	}
?>
	
        <label>Description</label>
		<?php echo $form->textarea('description', array('class' => 'description_textarea'));?>      
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

<?php if ($type == 'add') echo $this->Form->create('Event', array('action' => "add/".$eventGroupId));
else echo $this->Form->create('Event', array('action' => "edit/".$this->data['Event']['id'])); ?>

<div id="new_event" class="info_box">

<h1><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png"
	class="rinoa_large_inline" /> <?php 
	if ($type == 'add') echo "New event";
	else echo "Edit event";
	?></h1>
<p>in <?= $this->element('grouppath', array('groupPath' => $groupPath))?></p>

<div class="form_section">
<h2>Basic Information</h2>


<?php echo $form->input('title', array('type' => 'text', 'class' => 'textfield'));?>
<?php echo $form->input('description', array('type' => 'text', 'class' => 'textfield'));?>
<label>Start Time</label> Time: <input type="text"
	name="data[Other][time_start]" class="time_input textfield"
	value="20:54:00" /> Date: <input type="text"
	name="data[Other][date_start]" class="date_input textfield"
	value="<?php echo date('Y-m-d');?>" /> 
<label>End Time</label> Time: <input
	type="text" name="data[Other][time_end]" class="time_input textfield"
	value="22:54:00" /> Date: <input type="text"
	name="data[Other][date_end]" class="date_input textfield"
	value="<?php echo date('Y-m-d');?>" /> 
<?php echo $form->input('CategoryChoice', array('type' => 'select', 'multiple' => 'checkbox', 'label' => 'Tags'));?>

<?php echo $this->element('admin/map');?>

<div class="form_section">
<h2>Submit for Approval</h2>
<?php if ($type == 'edit') echo $form->input('id', array('type'=>'hidden'));?>
<?=$this->Form->button('Submit', array('type' => 'submit', 'class' => 'make_button'));?>
<p class="form_tip">This group will be approved by the REX coordinators.
Check here: <input type="checkbox" name="should_email" /> if you want to
receive an email when it is approved.</p>
</div>

</div>
<?php echo $this->Form->end(); ?>
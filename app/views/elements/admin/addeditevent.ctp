<?php if ($type == 'add') echo $this->Form->create('Event', array('action' => "add/".$eventGroupId));
else echo $this->Form->create('Event', array('action' => "edit/")); ?>


<script type="text/javascript" >
    
    $(document).ready( init_validation );
    
    function nospecial( value, element ){ return this.optional(element) || value.match("^[-0-9a-zA-Z_+&.!, ]*$");  }
    function validurl( value, element ){ return this.optional(element) || value.match("^[-0-9a-zA-Z]*$");  }
    
    jQuery.validator.addMethod("nospecial", nospecial, "Only use letters, numbers, spaces, and . , ! & + _");
    jQuery.validator.addMethod("validurl", validurl, "Only use letters, numbers, and dashes. (no spaces)");
    
    jQuery.validator.addMethod("updateurl", updateurl, "Error, this should never show up.");
    
    function init_validation(){
		$("input[name='data[EventGroup][name]']").blur( function(){
			
			if( $("input[name='data[EventGroup][path]']").val() == "" )
			{
				$("input[name='data[EventGroup][path]']").val( $("input[name='data[EventGroup][name]']").val().replace( /[^A-Za-z0-9]/g, "-" ).toLowerCase() );
			}
			
		});
		
		$("#EventGroupAddForm").validate({
			rules: {
				'data[EventGroup][name]': {
					required: true,
					minlength: 2,
					nospecial: true
				},
				'data[EventGroup][path]': {
					required: true,
					minlength: 2,
					validurl: true
				},
			},
		});
	}
    
    </script>


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
<label>Description</label>
<?php echo $form->textarea('description', array('class' => 'description_textarea'));?>

<label>Start Time</label> Time: <input type="text"
	name="data[Other][time_start]" class="time_input textfield"
	value="" /> Date: <input type="text"
	name="data[Other][date_start]" class="date_input textfield"
	value="" /> 
<p class="form_tip">for example: 8:05 pm</p>

<label>End Time</label> Time: <input
	type="text" name="data[Other][time_end]" class="time_input textfield"
	value="22:54" /> Date: <input type="text"
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

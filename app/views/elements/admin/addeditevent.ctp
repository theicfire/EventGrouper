<script type="text/javascript" >
    
    $(document).ready(function() {
    	$("#time1, #time2").timePicker({
        	show24Hours:false
        });
        $('#date1, #date2').datepicker();
            
        // Keep the duration between the two inputs.
        $("#time1").change(function() {
          if ($("#time2").val()) { // Only update when second input has a value.
            // Calculate duration.
            var duration = 60*60*1000;
            var time = $.timePicker("#time1").getTime();
            // Calculate and update the time in the second input.
            $.timePicker("#time2").setTime(new Date(new Date(time.getTime() + duration)));
          }
        });
        $("#time2").change(function() {
            if($.timePicker("#time1").getTime() > $.timePicker(this).getTime()) {
          	  var duration = 60*60*1000;
          	  var time = $.timePicker("#time2").getTime();
                // Calculate and update the time in the second input.
                $.timePicker("#time1").setTime(new Date(new Date(time.getTime() - duration)));
            }
          });
        $("#date1").change(function() {
        	$("#date2").val($('#date1').val());
          });
        $("#date2").change(function() {
            var date1 = new Date($("#date1").val());
            var date2 = new Date($("#date2").val());
            if (date2 < date1)
            	$("#date1").val($('#date2').val());
            
        });
        init_validation(); 
    });
    
    function nospecial( value, element ){ return this.optional(element) || value.match("^[-0-9a-zA-Z_+&.!,'? ]*$");  }
    
    jQuery.validator.addMethod("nospecial", nospecial, "Only use letters, numbers, spaces, and . , ! & + _ '");
    
    function init_validation(){
    	
		$.validator.addMethod("TAGS", function(value, element) {  
		    return this.optional(element) || /^([a-z]|, ?)*$/i.test(value);  
		    }, "Please enter a comma seperated list of tags (i.e. food, adventure, organization).");
		$("form").validate({
				rules: {
				'data[Event][title]': {
					required: true,
					minlength: 2,
					nospecial: true
				},
				'data[Event][description]': {
					required: false,
					nospecial: true
				},
				'data[Event][location]': {
					required: false,
					nospecial: true
				},
				'data[Event][tags]': "TAGS",
			}
		});
	}
    
    </script>

<?php if ($type == 'add') echo $this->Form->create('Event', array('action' => "add/".$eventGroupId));
else echo $this->Form->create('Event', array('action' => "edit/")); ?>
<div id="new_event" class="info_box">

<h1><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png"
	class="rinoa_large_inline" /> <?php 
	if ($type == 'add') echo "New event";
	else echo "Edit event";
	?></h1>
<p>in <?= $this->element('grouppath', array('groupStr' => $eventGroup['EventGroup']['path'], 'highestName' => $eventGroup['EventGroup']['highest_name']))?></p>

<div class="form_section">
<h2>Basic Information</h2>


<?php echo $form->input('title', array('type' => 'text', 'class' => 'textfield'));?>
<label>Description</label>
<?php echo $form->textarea('description', array('class' => 'description_textarea'));?>

<br /><br/>
<div class="clear"></div>
<?php 
//default times
//$time_start = date('g:i a');
if (!empty($eventsUnderGroup))
	$timeIn = strtotime($eventsUnderGroup[0]['Event']['time_start']);
else
	$timeIn = strtotime(date('y-m-d 12:00', strtotime('now')));
$time_start = date('g:i a', $timeIn);
$date_start = date('m/d/Y', $timeIn);
$time_end = date('g:i a', $timeIn+60*60);
$date_end = date('m/d/Y', $timeIn+60*60);
if (!empty($this->data['Event']['time_start'])) {
	$date_start = date('m/d/Y', strtotime($this->data['Event']['time_start']));
	$time_start = date('g:i a', strtotime($this->data['Event']['time_start']));
}
if (!empty($this->data['Event']['duration'])) {
	$date_end = date('m/d/Y', strtotime($this->data['Event']['time_start'])+$this->data['Event']['duration']*60);
	$time_end = date('g:i a', strtotime($this->data['Event']['time_start'])+$this->data['Event']['duration']*60);
}
?>
<div style="float:left;">
	<label>Start Time</label><input type="text"
		name="data[Other][time_start]" class="time_input textfield" id="time1"
		value="<?=$time_start?>" />
	<p class="form_tip">For example: 8:05 pm or 17:47</p>	
	</div>
	<div style="float:left; padding-left: 20px;">
		<label>Start Date</label><input type="text"
		name="data[Other][date_start]" class="date_input textfield" id="date1"
		value="<?=$date_start?>" /> 
	<p class="form_tip">Click inside the field for a date picker.</p>
</div>

<div class="clear"></div>

<div id="debug_time"></div>

<div style="float:left;">
	<label>End Time</label><input
		type="text" name="data[Other][time_end]" class="time_input textfield" id="time2"
		value="<?=$time_end?>" />
		<p class="form_tip">&nbsp;</p>
		</div>
		<div style="float:left; padding-left: 20px;">
		
		
		<label>End Date</label><input type="text"
		name="data[Other][date_end]" class="date_input textfield" id="date2"
		value="<?=$date_end?>" /> 
</div>

<div class="clear"></div>
	
<?php echo $form->input('tags', array('type' => 'text', 'class' => 'textfield'));?>

</div>

<?php 
$centerLat = $eventGroup['EventGroup']['latitude'];
if (empty($centerLat)) $centerLat = '42.359051';
$centerLong = $eventGroup['EventGroup']['longitude'];
if (empty($centerLong)) $centerLong = '-71.093623';
$hasDefault = false;
if (!empty($eventGroup['EventGroup']['longitude']))
	$hasDefault = true;
echo $this->element('admin/map', array('type'=>'Event', 'centerLat' => $centerLat, 'centerLong' => $centerLong, 'hasDefault' => $hasDefault));
?>

<div class="form_section">
<h2>Submit for Approval</h2>
<?php if ($type == 'edit') echo $form->input('id', array('type'=>'hidden'));?>
<?=$form->submit('Submit', array('type' => 'submit', 'class' => 'make_button'));?>
<p class="form_tip">This group will be approved by the group coordinators.</p>
</div>

</div>
<?php echo $this->Form->end(); ?>

<?php if ($type == 'add') echo $this->Form->create('Event', array('action' => "add/".$eventGroupId));
else echo $this->Form->create('Event', array('action' => "edit/")); ?>


<script type="text/javascript" >
    
    $(document).ready( init_validation );
    
    function nospecial( value, element ){ return this.optional(element) || value.match("^[-0-9a-zA-Z_+&.!,'? ]*$");  }
    function isdate( value, element ){ return this.optional(element) || value.match("^[0-9][0-9]?/[0-9][0-9]?/(19|20|21)?[0-9][0-9]$");  }
    function istime( value, element ){
		if(value.match( /^[0-9][0-9]?(:[0-9][0-9](:[0-9][0-9])?)?( )*(am|pm|a|p)?$/i ))
		validformat = true;
		else
		return this.optional(element);
		
		if(gettime(value))		
		return true;
		else
		return this.optional(element);
	}
	
	function gettime( value )
	{
		if(value.match( /(am|pm|a|p)/i ))
		{timeformat = "12 hour";}
		else
		{timeformat = "24 hour";}
		
		if(timeformat=="12 hour")	{
			if(value.match( /(am|a)/i )) time_offset = 0;
			else time_offset = 12;
			value = value.replace( /( )*(am|pm|a|p)$/i, "");
		}
		else
		{ time_offset = 0; }
		
		timearray = value.split(":");
		
		hours=minutes=seconds=0;
		
		hours = parseInt(timearray[0]) + time_offset;
		if(timearray[1])
		minutes = parseInt(timearray[1]);
		if(timearray[2])
		seconds = parseInt(timearray[2]);
		if(hours<24 && minutes<60 && seconds<60)
		{
			return hours.toString() + ":" + (minutes<10?'0':'') + minutes.toString() + ":" + (seconds<10?'0':'') + seconds.toString();
		}
		else
		{
			return false;
		}
	}
	
	function comparestartandend( value, element ){
		
		date_start = new Date( $("[name='data[Other][date_start]']").val() );
		date_end = new Date( $("[name='data[Other][date_end]']").val() );
		
		time_start = gettime( $("[name='data[Other][time_start]']").val() ).split(":");
		time_end = gettime( $("[name='data[Other][time_end]']").val() ).split(":");
		
		date_start.setHours( time_start[0] );
		date_start.setMinutes( time_start[1] );
		date_start.setSeconds( time_start[2] );
		
		date_end.setHours( time_end[0] );
		date_end.setMinutes( time_end[1] );
		date_end.setSeconds( time_end[2] );
		
		return this.optional(element) || (date_start < date_end);
	}
    
    jQuery.validator.addMethod("nospecial", nospecial, "Only use letters, numbers, spaces, and . , ! & + _ '");
    jQuery.validator.addMethod("istime", istime, "Please enter a valid time.");
    jQuery.validator.addMethod("isdate", isdate, "Please enter a valid date.");
    jQuery.validator.addMethod("comparedates", comparestartandend, "Make sure your end time is after your start time.");
    
    function init_validation(){
		
		now = new Date();
		
		now_in_mseconds = now.getTime();
		an_hour = 1000*60*60;
		next_hour = now_in_mseconds - (now_in_mseconds % an_hour) + an_hour;
		next_hour_date = new Date( next_hour );
		
		$("[name='data[Other][time_start]']").val( next_hour_date.getHours() + ":00" );
		$("[name='data[Other][date_start]']").val( (next_hour_date.getMonth()+1) + "/" + next_hour_date.getDate() + "/"  + next_hour_date.getFullYear() );
		
		in_an_hour = next_hour + an_hour;
		in_an_hour_date = new Date( in_an_hour );
		
		$("[name='data[Other][time_end]']").val( in_an_hour_date.getHours() + ":00" );
		$("[name='data[Other][date_end]']").val( (in_an_hour_date.getMonth()+1) + "/" + in_an_hour_date.getDate() + "/"  + in_an_hour_date.getFullYear() );
		
		$("input[name='data[Other][date_start]']").blur( function(){
			
			if( $("input[name='data[Other][date_end]']").val() == "" )
			{
				date_start = new Date( $("[name='data[Other][date_start]']").val() );
				time_start = gettime( $("[name='data[Other][time_start]']").val() ).split(":");
				date_start.setHours( time_start[0] );
				date_start.setMinutes( time_start[1] );
				date_start.setSeconds( time_start[2] );
				dt_start = date_start.getTime();
				
				dt_end = dt_start + an_hour;
				dt_end_date = new Date( dt_end );
				
				$("[name='data[Other][time_end]']").val( dt_end_date.getHours() + ":00" );
				$("input[name='data[Other][date_end]']").val( (dt_end_date.getMonth()+1) + "/" + dt_end_date.getDate() + "/"  + dt_end_date.getFullYear() )
			}
			
		});
		
		$("form").validate({
			rules: {
				'data[Event][title]': {
					required: true,
					minlength: 2,
					nospecial: true
				},
				'data[Other][time_start]': {
					required: true,
					istime: true
				},
				'data[Other][time_end]': {
					required: true,
					istime: true
				},
				'data[Other][date_start]': {
					required: true,
					isdate: true
				},
				'data[Other][date_end]': {
					required: true,
					isdate: true,
					comparedates: true
				},
			}
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

<br /><br/>
<div class="clear"></div>

<div style="float:left;">
	<label>Start Time</label><input type="text"
		name="data[Other][time_start]" class="time_input textfield"
		value="" />
	<p class="form_tip">For example: 8:05 pm or 17:47</p>	
	</div>
	<div style="float:left; padding-left: 20px;">
		<label>Start Date</label><input type="text"
		name="data[Other][date_start]" class="date_input textfield"
		value="" /> 
	<p class="form_tip">Click inside the field for a date picker.</p>
</div>

<div class="clear"></div>

<div id="debug_time"></div>

<div style="float:left;">
	<label>End Time</label><input
		type="text" name="data[Other][time_end]" class="time_input textfield"
		value="" />
		<p class="form_tip">&nbsp;</p>
		</div>
		<div style="float:left; padding-left: 20px;">
		
		<label>End Date</label><input type="text"
		name="data[Other][date_end]" class="date_input textfield"
		value="" /> 
</div>

<div class="clear"></div>
	
<?php echo $form->input('CategoryChoice', array('type' => 'select', 'multiple' => 'checkbox', 'label' => 'Categories'));?>

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
<?=$this->Form->button('Submit', array('type' => 'submit', 'class' => 'make_button'));?>
<p class="form_tip">This group will be approved by the REX coordinators.
Check here: <input type="checkbox" name="should_email" /> if you want to
receive an email when it is approved.</p>
</div>

</div>
<?php echo $this->Form->end(); ?>

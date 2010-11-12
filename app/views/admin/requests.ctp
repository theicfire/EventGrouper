<script type="text/javascript">
$(document).ready(function() {
	$('.confirmEvent').click(function() {
		$.get("<?php echo $html->url('/');?>admin/changeEventStatus/"+$(this).parent().parent().attr('id').split('-')[1]+"/confirmed");
		$(this).parent().parent().hide();
	});
	$('.rejectEvent').click(function() {
		$.get("<?php echo $html->url('/');?>admin/changeEventStatus/"+$(this).parent().parent().attr('id').split('-')[1]+"/rejected");
		$(this).parent().parent().hide();
	});
	
});
</script>

<div id="admin_notifications" class="info_box">


<h1 class="hr"><img src="<?php echo $html->url('/'); ?>css/rinoa/info.png" class="rinoa_large_inline" />Requests</h1>

<table class="full_width">
	<tr><th>User</th><th>title</th><th>description</th><th>Time</th><th>event group</th><th>actions</th></tr>
		<?php foreach ($eventsUnderGroup as $event) {
			if (!$session->check('userid') || ($session->check('userid') && !array_key_exists('onUsersCalendar',$event['Event']))) {?>
		<tr id="event-<?=$event['Event']['id']?>">
				<td>
					<?php echo $event['UserOwner']['email']; ?>
				</td>
				<td>
					<?php echo $event['Event']['title']; ?>
				</td>
				<td>
					<?php echo $event['Event']['description']; ?>
				</td>
				<td>
					<?php echo date('m/d/y g:i a', strtotime($event['Event']['time_start']))." to ".
					date('m/d/y g:i a', strtotime($event['Event']['time_start']) + $event['Event']['duration']*60); ?>
				</td>
				<td>
					<?php echo $event['EventGroup']['name']; ?>
				</td>
				<td>
					<a href="#"class="make_button confirmEvent"><img src="<?php echo $html->url('/'); ?>css/rinoa/check.png" class="rinoa_small" /></a> 
					<a href="#" class="make_button rejectEvent"><img src="<?php echo $html->url('/'); ?>css/rinoa/cancel.png" class="rinoa_small" /></a> 
					<a href="#" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png" class="rinoa_small" /></a>
				</td>
		</tr>
		<?php }}?>

</table>

</div>


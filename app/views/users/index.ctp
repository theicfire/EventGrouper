<script type="text/javascript">
$(document).ready(function() {
	$('.hideEvent').click(function() {
		$.get("<?php echo $html->url('/');?>admin/changeEventStatus/"+$(this).parent().parent().attr('id').split('-')[1]+"/hidden");
		$(this).parent().parent().hide();
	});
	
});
</script>

<div id="admin_groups" class="info_box">

<h1 class="hr"><img src="<?php echo $html->url('/'); ?>css/rinoa/group.png"
	class="<?php echo $html->url('/'); ?>css/rinoa_large_inline" /> Groups</h1>

<table class="full_width">
	<tr>
		<th>Group</th>
		<th>Subgroups</th>
		<th>Events</th>
		<th>Actions</th>
	</tr>
<?php 
	foreach($userEventGroups as $group) {
?>
	<tr>
		<td><?= $this->element('grouppath', array('groupPath' => $group['EventGroup']['groupPath']));?></td>
		<td><?= $group['EventGroup']['eventgroupcount']?></td>
		<td><?= $group['EventGroup']['eventcount']?></td>
		<td><a href="<?php echo $html->url("/event_groups/view_admin/".$group['EventGroup']['id']); ?>" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png"
			class="rinoa_small_inline" /> View details</a> 
			<?php if ($access->check('EventGroup',$group['EventGroup']['id'], 'update')) {?>
				<a href="<?php echo $html->url("/event_groups/edit/".$group['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png"
				class="rinoa_small_inline" /> Edit info</a>
			<?php }?>
			<?php if ($access->check('EventGroup',$group['EventGroup']['id'], 'create')) {?> 
				<a href="<?php echo $html->url("/event_groups/add/".$group['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/user_add.png"
				class="rinoa_small_inline" /> Add subgroups</a>
			<?php }?>
			<?php if ($access->check('EventGroup',$group['EventGroup']['id'], 'create')) {?> 
				<a href="<?php echo $html->url("/events/add/".$group['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png"
				class="rinoa_small_inline" /> Add events</a>
			<?php }?>
			<?php if ($access->check('EventGroup',$group['EventGroup']['id'], 'bigOwner')) {?> 
				<a href="<?php echo $html->url("/admin/requests/".$group['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png"
				class="rinoa_small_inline" />Check Requests</a>
			<?php }?>
			</td>
	</tr>

<?php 
	}
?>

</table>

</div>
<div id="admin_notifications" class="info_box">


<h1 class="hr"><img src="<?php echo $html->url('/'); ?>css/rinoa/info.png" class="rinoa_large_inline" /> Sent Events</h1>

<table class="full_width">
	<tr>
		<th>Title</th>
		<th>Status</th>
		<th>Actions</th>
	</tr>
	<?php foreach ($sentEvents as $event) {?>
	<tr id="event-<?=$event['Event']['id']?>">
		<td><?=$event['Event']['title']?></td>
		<td><?=$event['Event']['status']?></td>
		<td><a href="#" class="hideEvent">Hide</a></td>
	</tr>
	<?php }?>

</table>

</div>


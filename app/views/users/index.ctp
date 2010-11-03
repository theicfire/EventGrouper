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
			</td>
	</tr>

<?php 
	}
?>

</table>

</div>

<div id="admin_notifications" class="info_box">


<h1 class="hr"><img src="<?php echo $html->url('/'); ?>css/rinoa/info.png" class="rinoa_large_inline" />
Notifications + Requests</h1>

<table class="full_width">
	<tr>
		<th>From</th>
		<th>Group</th>
		<th>Contents</th>
		<th>Actions</th>
	</tr>
	<tr>
		<td>Saif Hakim</td>
		<td>Phi Kappa Theta</td>
		<td>Event created: <a href="#">Carribean Party</a> at 8:00 pm
		3/14/2010</td>
		<td><a href="#" class="make_button"><img
			src="<?php echo $html->url('/'); ?>css/rinoa/check.png" class="rinoa_small" /></a> <a href="#"
			class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/cancel.png"
			class="rinoa_small" /></a> <a href="#" class="make_button"><img
			src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png" class="rinoa_small" /></a></td>
	</tr>

</table>

</div>


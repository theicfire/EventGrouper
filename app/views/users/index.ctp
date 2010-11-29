<script type="text/javascript">
$(document).ready(function() {
	$('.hideEvent').click(function() {
		$.get("<?php echo $html->url('/');?>admin/changeEventStatus/"+$(this).parent().parent().attr('id').split('-')[1]+"/hidden");
		$(this).parent().parent().hide();
		return false
	});
	
});
</script>



<div id="admin_groups" class="info_box">

<h1 class="info_box_heading"><img src="<?php echo $html->url('/'); ?>css/rinoa/group.png"
	class="rinoa_large_inline" /> My [conference]s</h1>

<?php

$top_level = false;
$not_top_level = false;
if(count($userEventGroups)!=0)
foreach($userEventGroups as $group) {
	if ($group['EventGroup']['parent_id'] == 0) {
		$top_level = true;
	} else {
		$not_top_level = true;
	}
}
?>
			
<?php if($top_level){ ?>

<table class="full_width">
	<tr>
		<th>Name</th>
		<th>Actions</th>
	</tr>
<?php 
	foreach($userEventGroups as $group) {
		if ($group['EventGroup']['parent_id'] == 0) {
?>
		<tr>
			<td><?= $this->element('grouppath', array('groupStr' => $group['EventGroup']['path'], 'highestName' => $group['EventGroup']['highest_name']));?></td>
			<td class="table_tiny_buttons"><a href="<?php echo $html->url("/".$group['EventGroup']['path']); ?>" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png"
				class="small_icon_inline_button" /> View in timeline</a> 
				<?php if ($access->check('EventGroup',$group['EventGroup']['id'], 'update')) {?>
					<a href="<?php echo $html->url("/event_groups/edit/".$group['EventGroup']['id']); ?>"
					class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png"
					class="small_icon_inline_button" /> Edit info</a>
				<?php }?>
				<?php if ($access->check('EventGroup',$group['EventGroup']['id'], 'create')) {?> 
					<a href="<?php echo $html->url("/event_groups/add/".$group['EventGroup']['id']); ?>"
					class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/user_add.png"
					class="small_icon_inline_button" /> Add subgroup</a>
				<?php }?>
				<?php if ($access->check('EventGroup',$group['EventGroup']['id'], 'create')) {?> 
					<a href="<?php echo $html->url("/events/add/".$group['EventGroup']['id']); ?>"
					class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png"
					class="small_icon_inline_button" /> Add event</a>
				<?php }?>
				<?php if ($access->check('EventGroup',$group['EventGroup']['id'], 'bigOwner')) {?> 
					<a href="<?php echo $html->url("/admin/requests/".$group['EventGroup']['id']); ?>"
					class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/check.png"
					class="small_icon_inline_button" /> Check requests</a>
				<?php }?>
				</td>
		</tr>

<?php 
		}
	}
	
?>



</table>

<?php } else { ?>

<p class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> You are not an administrator of any [conference].  However, you can create your own by clicking the button below!</p>

<?php } ?>

<a href="<?php echo $html->url('/'); ?>event_groups/add/0" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/add.png"
			class="small_icon_inline_button" /> Create a new [conference]</a>
</div>



<div id="admin_groups" class="info_box">

<h1 class="info_box_heading"><img src="<?php echo $html->url('/'); ?>css/rinoa/group.png"
	class="rinoa_large_inline" /> My Groups</h1>

<?php if($not_top_level){ ?>
	
<table class="full_width">
	<tr>
		<th>Group</th>
		<th>Actions</th>
	</tr>
<?php 
	foreach($userEventGroups as $group) {
		if ($group['EventGroup']['parent_id'] != 0) {
?>
		<tr>
			<td><?= $this->element('grouppath', array('groupStr' => $group['EventGroup']['path'], 'highestName' => $group['EventGroup']['highest_name']));?></td>
			<td class="table_tiny_buttons"><a href="<?php echo $html->url("/".$group['EventGroup']['path']); ?>" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png"
				class="small_icon_inline_button" /> View in timeline</a> 
				<?php if ($access->check('EventGroup',$group['EventGroup']['id'], 'update')) {?>
					<a href="<?php echo $html->url("/event_groups/edit/".$group['EventGroup']['id']); ?>"
					class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png"
					class="small_icon_inline_button" /> Edit info</a>
				<?php }?>
				<?php if ($access->check('EventGroup',$group['EventGroup']['id'], 'create')) {?> 
					<a href="<?php echo $html->url("/event_groups/add/".$group['EventGroup']['id']); ?>"
					class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/user_add.png"
					class="small_icon_inline_button" /> Add subgroups</a>
				<?php }?>
				<?php if ($access->check('EventGroup',$group['EventGroup']['id'], 'create')) {?> 
					<a href="<?php echo $html->url("/events/add/".$group['EventGroup']['id']); ?>"
					class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png"
					class="small_icon_inline_button" /> Add events</a>
				<?php }?>
				<?php if ($access->check('EventGroup',$group['EventGroup']['id'], 'bigOwner')) {?> 
					<a href="<?php echo $html->url("/admin/requests/".$group['EventGroup']['id']); ?>"
					class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/check.png"
					class="small_icon_inline_button" /> Check Requests</a>
				<?php }?>
				</td>
		</tr>

<?php 
		}
	}
	
?>


</table>

<?php } else { ?>

<p class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> You are not part of any groups.  <a href="#">What's a group?</a></p>

<?php } ?>

</div>
<div id="admin_notifications" class="info_box">


<h1 class="info_box_heading"><img src="<?php echo $html->url('/'); ?>css/rinoa/info.png" class="rinoa_large_inline" /> Events I Created</h1>

<?php if(count($sentEvents)!=0){ ?>

<table class="full_width">
	<tr>
		<th>Title</th>
		<th>Group</th>
		<th>Approval Status</th>
		<th>Actions</th>
	</tr>
	<?php foreach ($sentEvents as $event) {?>
	<tr id="event-<?=$event['Event']['id']?>">
		<td><?=$event['Event']['title']?></td>
		<td><?= $this->element('grouppath', array('groupStr' => $event['EventGroup']['path'], 'highestName' => $event['EventGroup']['highest_name']))?></td>
		<td <?php switch($event['Event']['status']){
			case "unconfirmed": echo "class='unconfirmed'"; break;
			
			
			
			} ?> ><?=$event['Event']['status']?></td>
		<td><?php if ($event['Event']['status'] == 'confirmed'){ ?><a href="#" class="hideEvent">Hide</a><?php }?></td>
	</tr>
	<?php }?>

</table>

<?php } else { ?>

<p class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> You have not created any events yet.  If you have permission to create an event in an existing [conference], click an "Add events" button above.  If not, create your own [conference] and add events to it!</p>

<?php } ?>

</div>


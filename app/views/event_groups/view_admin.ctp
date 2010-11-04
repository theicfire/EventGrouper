
<?php if(isset($notification))
{ ?>
	
	<div class="cake_notification">
		<img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png" class="rinoa_small_inline" />
		<?php echo $notification; ?>
	</div>
	
<?php } ?>

<div class="info_box">
    
	<h1>Current Group</h1>
	<p><?= $this->element('grouppath', array('groupPath' => $groupPath))?></p>
	<div class="form_section">
		<h2><?php echo $currenteventGroup['EventGroup']['name']; ?></h2>
				<div><p>Description:</p><p><?php echo $currenteventGroup['EventGroup']['description']; ?></p></div>
				<div style="height: 10px;"> </div>
			<div>
				<a href="<?php echo $html->url("/".$currenteventGroup['EventGroup']['path']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png"
				class="small_icon_inline_button" /> View group</a>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'update')) {?>
				<a href="<?php echo $html->url("/event_groups/edit/".$currenteventGroup['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png"
				class="small_icon_inline_button" /> Edit info</a>
			<?php }?>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'create')) {?> 
				<a href="<?php echo $html->url("/event_groups/add/".$currenteventGroup['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/user_add.png"
				class="small_icon_inline_button" /> Add subgroups</a>
			<?php }?>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'create')) {?> 
				<a href="<?php echo $html->url("/events/add/".$currenteventGroup['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png"
				class="small_icon_inline_button" /> Add events</a>
			<?php }?>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'delete')) {?>
				
				<a class="make_button" href="<?php echo $html->url("/event_groups/delete/" . $currenteventGroup['EventGroup']['id']); ?>" onclick="return confirm(&#039;Are you sure you want to delete the group <?php echo $currenteventGroup['EventGroup']['name']; ?>?&#039;);"><img src="<?php echo $html->url('/'); ?>css/rinoa/close.png" class="small_icon_inline_button" /> Delete</a>

			<?php }?>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'editperms')) {?>
				
				<a class="make_button" href="<?php echo $html->url("/permissions/view/" . $currenteventGroup['EventGroup']['id']); ?>"><img src="<?php echo $html->url('/'); ?>css/rinoa/applications.png" class="small_icon_inline_button" /> Give someone permission to edit <?php echo $currenteventGroup['EventGroup']['name']; ?></a>
			<?php }?>
			</div>
	</div>
</div>
<div class="info_box">
    
	<h1>Contents of "<?php echo $currenteventGroup['EventGroup']['name']; ?>"</h1>      
	<div class="form_section">
		<h2>Groups Contained</h2>  
		<table class="full_width">
			<tr><th>Path</th><th>Description</th><th>Actions</th></tr>  
		    <?php foreach ($eventGroups as $eventGroup) {?>
				<tr>
						<td>
							<?= $this->element('grouppath', array('groupPath' => $eventGroup['EventGroup']['groupPath']));?>
						</td>
						<td>
							<?php echo $eventGroup['EventGroup']['description']; ?>
						</td>
						<td><a href="<?php echo $html->url("/event_groups/view_admin/".$eventGroup['EventGroup']['id']); ?>" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png"
						class="small_icon_inline_button" /> View details</a> 
						<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'update')) {?>
							<a href="<?php echo $html->url("/event_groups/edit/".$eventGroup['EventGroup']['id']); ?>"
							class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png"
							class="small_icon_inline_button" /> Edit info</a>
						<?php }?>
						<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'create')) {?> 
							<a href="<?php echo $html->url("/event_groups/add/".$eventGroup['EventGroup']['id']); ?>"
							class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/user_add.png"
							class="small_icon_inline_button" /> Add subgroups</a>
						<?php }?>
						<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'create')) {?> 
							<a href="<?php echo $html->url("/events/add/".$eventGroup['EventGroup']['id']); ?>"
							class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png"
							class="small_icon_inline_button" /> Add events</a>
						<?php }?>
						<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'delete')) {?>
						<a class="make_button" href="/EventGrouper/event_groups/delete/<?php echo $eventGroup['EventGroup']['id']; ?>" onclick="return confirm(&#039;Are you sure you want to delete the group <?php echo $eventGroup['EventGroup']['name']; ?>?&#039;);"><img src="<?php echo $html->url('/'); ?>css/rinoa/close.png" class="small_icon_inline_button" /> Delete</a>
						<?php 
							//echo $html->link(__('Delete', true), array('action' => 'delete', $eventGroup['EventGroup']['id']), array('class'=>'make_button'), sprintf(__('Are you sure you want to delete # %s?', true), $currenteventGroup['EventGroup']['id']));
						}?>
						</td>
				</tr>
			<?php }?>      
	            
		</table>
		</div>
		
		<div class="form_section">
		<h2>Events Contained</h2>  
		<table class="full_width">
			<tr><th>Title</th><th>Description</th><th>Time</th><th>Categories</th><th>Event Group</th><th>Actions</th></tr>
			<?php foreach ($eventsUnderGroup as $event) {
				if (!$session->check('userid') || ($session->check('userid') && !array_key_exists('onUsersCalendar',$event['Event']))) {?>
			<tr id="event-<?=$event['Event']['id']?>">
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
						<?php $categories = array();
						foreach ($event['CategoryChoice'] as $category) $categories[] = $category['name'];
						echo implode(", ",$categories); ?>
					</td>
					<td>
						<?php echo $event['EventGroup']['name']; ?>
					</td>
					<td class="actions">
						<?php echo $html->link(__('View', true), array('controller' => 'events', 'action' => 'view', $event['Event']['id'])); ?>
						<?php if ($access->check('EventGroup',$event['Event']['event_group_id'], 'create')) {
							echo $html->link(__('Edit', true), array('controller' => 'events', 'action' => 'edit', $event['Event']['id'])); 
						}?>
						<?php if ($access->check('EventGroup',$event['Event']['event_group_id'], 'create')) {
							echo $html->link(__('Delete', true), array('controller' => 'events', 'action' => 'delete', $event['Event']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $event['Event']['id'])); 
						}?>
					</td>
			</tr>
			<?php }}?>
		</table>
	</div>      
	<!--<a href="#" class="make_button"><img src="/eventgrouper/css/rinoa/add.png" class="rinoa_small_inline" /> Add another email address</a>-->
</div>

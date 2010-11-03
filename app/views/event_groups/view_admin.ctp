<div id="edit_account" class="info_box">
    
	<h1>Current Group</h1>
	<div class="form_section">
		<h2>Current Group</h2>
				<div>Name: <?php echo $currenteventGroup['EventGroup']['name']; ?></div>
				<div>Description: <?php echo $currenteventGroup['EventGroup']['description']; ?></div>
			<div>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'update')) {?>
				<a href="<?php echo $html->url("/event_groups/edit/".$currenteventGroup['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png"
				class="rinoa_small_inline" /> Edit info</a>
			<?php }?>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'create')) {?> 
				<a href="<?php echo $html->url("/event_groups/add/".$currenteventGroup['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/user_add.png"
				class="rinoa_small_inline" /> Add subgroups</a>
			<?php }?>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'create')) {?> 
				<a href="<?php echo $html->url("/events/add/".$currenteventGroup['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png"
				class="rinoa_small_inline" /> Add events</a>
			<?php }?>
			</div>
	</div>
</div>
<div id="edit_account" class="info_box">
    
	<h1>Group Info</h1>
	<p>in <?= $this->element('grouppath', array('groupPath' => $groupPath))?></p>	        
	<div class="form_section">
		<h2>Groups Contained</h2>  
		<table class="full_width">
			<tr><th>Path</th><th>description</th><th>Actions</th></tr>  
		    <?php foreach ($eventGroups as $eventGroup) {?>
				<tr>
						<td>
							<?= $this->element('grouppath', array('groupPath' => $eventGroup['EventGroup']['groupPath']));?>
						</td>
						<td>
							<?php echo $eventGroup['EventGroup']['description']; ?>
						</td>
						<td><a href="<?php echo $html->url("/event_groups/view_admin/".$eventGroup['EventGroup']['id']); ?>" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png"
						class="rinoa_small_inline" /> View details</a> 
						<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'update')) {?>
							<a href="<?php echo $html->url("/event_groups/edit/".$eventGroup['EventGroup']['id']); ?>"
							class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png"
							class="rinoa_small_inline" /> Edit info</a>
						<?php }?>
						<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'create')) {?> 
							<a href="<?php echo $html->url("/event_groups/add/".$eventGroup['EventGroup']['id']); ?>"
							class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/user_add.png"
							class="rinoa_small_inline" /> Add subgroups</a>
						<?php }?>
						<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'create')) {?> 
							<a href="<?php echo $html->url("/events/add/".$eventGroup['EventGroup']['id']); ?>"
							class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png"
							class="rinoa_small_inline" /> Add events</a>
						<?php }?>
						</td>
				</tr>
			<?php }?>      
	            
		</table>
		<h2>Events Contained</h2>  
		<table class="full_width">
			<tr><th>title</th><th>description</th><th>Time</th><th>Categories</th><th>event group</th><th>actions</th></tr>
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
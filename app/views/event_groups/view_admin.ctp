<div class="actions">
	<ul>
		<li><?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'create')) {
			echo $html->link(__('Add EventGroup Under This', true), array('action' => 'add', $currenteventGroup['EventGroup']['id'])); 
		}?> </li>
		<li><?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'create')) {
			echo $html->link(__('Add Event Under This', true), array('controller' => 'events', 'action' => 'add', $currenteventGroup['EventGroup']['id'])); 
		}?> </li>
	</ul>
</div>
<br>
--Group Info--
<table cellpadding="0" cellspacing="0">
<tr>
<td>id</td><td>name</td><td>description</td><td>photo_url</td><td>parent_id</td><td>Actions</td>
</tr>
<tr>
		<td>
			<?php echo $currenteventGroup['EventGroup']['id']; ?>
		</td>
		<td>
			<?php echo $currenteventGroup['EventGroup']['name']; ?>
		</td>
		<td>
			<?php echo $currenteventGroup['EventGroup']['description']; ?>
		</td>
		<td>
			<?php echo $currenteventGroup['EventGroup']['photo_url']; ?>
		</td>
		<td>
			<?php echo $currenteventGroup['EventGroup']['parent_id']; ?>
		</td>
		<td class="actions">
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'update')) {
				echo $html->link(__('Edit', true), array('action' => 'edit', $currenteventGroup['EventGroup']['id'])); 
			}?>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'delete')) {
				echo $html->link(__('Delete', true), array('action' => 'delete', $currenteventGroup['EventGroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $currenteventGroup['EventGroup']['id'])); 
			}?>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'editperms')) {
				echo $html->link(__('Edit Permissions', true), array('controller' => 'permissions', 'action' => 'view', $currenteventGroup['EventGroup']['id']));
			}?>
		</td>
</tr>
</table>
<div id="edit_account" class="info_box">
    
	<h1>Group Info</h1>
	<p>in <?= $this->element('grouppath', array('groupPath' => $groupPath))?></p>	        
	<div class="form_section">
		<h2>Groups Contained</h2>  
		<table class="full_width">
			<tr><th>name</th><th>description</th><th>Actions</th></tr>  
		    <?php foreach ($eventGroups as $eventGroup) {?>
				<tr>
						<td>
							<?php echo $eventGroup['EventGroup']['name']; ?>
						</td>
						<td>
							<?php echo $eventGroup['EventGroup']['description']; ?>
						</td>
						<td class="actions">
							<a href="<?=$this->base."/".$eventGroup['EventGroup']['path']?>">View</a>
							<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'update')) {
								echo $html->link(__('Edit', true), array('action' => 'edit', $eventGroup['EventGroup']['id'])); 
							}?>
							<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'delete')) {
								echo $html->link(__('Delete', true), array('action' => 'delete', $eventGroup['EventGroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $eventGroup['EventGroup']['id']));
							}?>
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
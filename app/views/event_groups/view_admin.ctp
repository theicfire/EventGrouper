<?php if ($currenteventGroup['EventGroup']['parent_id'] == 0) {

	$top_level = true;
}
else { $top_level = false; }

?>
<?php if(isset($notification))
{ ?>
	
	<div class="cake_notification">
		<img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png" class="rinoa_small_inline" />
		<?php echo $notification; ?>
	</div>
	
<?php } ?>

<div class="info_box">
    
	<h1><?php echo $currenteventGroup['EventGroup']['name']; ?></h1>
	<div class="form_section">
		<h2><?php echo $top_level?"[Conference] Information":"Group Information"; ?></h2>
				<table class="horizontal_no_border">
					<tr>
						<th>Name</th><td><?php echo $currenteventGroup['EventGroup']['name']; ?></td>
					</tr>
					<tr>
					
					<?php if($top_level)
					{
						echo "<th>URL</th><td>" . "/".$currenteventGroup['EventGroup']['path']."/"."</td>";
						}
					else
					{
						echo "<th>Path</th><td>".$this->element('grouppath', array('groupStr' => $currenteventGroup['EventGroup']['path'], 'highestName' => $currenteventGroup['EventGroup']['highest_name']))."</td>"; 
						
					}?>
					</tr>
					<tr>
						<th>Description</th><td><?php 
				if( !$currenteventGroup['EventGroup']['description'] == "") 
				echo $currenteventGroup['EventGroup']['description'] ;
				else
				echo " <em>No Description</em>"; ?></td>
					</tr>
					<tr>
					<?php $location = $currenteventGroup['EventGroup']['location'];
					 $centerLat = $currenteventGroup['EventGroup']['latitude'];
							$centerLong = $currenteventGroup['EventGroup']['longitude'];?>
					
					
						<th>Location Name</th><td><?php echo $location; ?>
						
						</td>
					</tr>
					<tr>
					
					
						<th>Location on Map</th><td>					
						<img id='staticmap' src="http://maps.google.com/maps/api/staticmap?center=<?php echo $centerLat; ?>,<?php echo $centerLong; ?>&zoom=16&size=400x100&maptype=roadmap&markers=color:red|label:A|<?php echo $centerLat; ?>,<?php echo $centerLong; ?>&sensor=false" />
						
						</td>
					</tr>
				</table>
				<div style="height: 10px;"> </div>
			<div>
				<a href="<?php echo $html->url("/".$currenteventGroup['EventGroup']['path']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png"
				class="small_icon_inline_button" /> View in timeline</a>
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
			
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'editperms')) {?>
				
				<a class="make_button" href="<?php echo $html->url("/permissions/view/" . $currenteventGroup['EventGroup']['id']); ?>">
				<img src="<?php echo $html->url('/'); ?>css/rinoa/applications.png" class="small_icon_inline_button" /> Edit Permissions</a>
			<?php }?>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'delete')) {?>
				
				<a class="make_button" href="<?php echo $html->url("/event_groups/delete/" . $currenteventGroup['EventGroup']['id']); ?>" onclick="return confirm(&#039;Are you sure you want to delete the group <?php echo $currenteventGroup['EventGroup']['name']; ?>?&#039;);"><img src="<?php echo $html->url('/'); ?>css/rinoa/close.png" class="small_icon_inline_button" /> Delete</a>

			<?php }?>
			</div>
	</div>

    
	<!-- <h1>Contents of "<?php echo $currenteventGroup['EventGroup']['name']; ?>"</h1> -->     
	<div class="form_section">
		<h2>Groups Contained</h2>
		
		<?php if( count($eventGroups)==0 )
		{ ?>
		
		<p class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> There are no subgroups in "<?php echo $currenteventGroup['EventGroup']['name']; ?>".</p>
		
		<?php }
		else { 
		?>
		  
		<table class="full_width">
			<tr><th>Path</th><th>Description</th><th>Actions</th></tr>  
		    <?php foreach ($eventGroups as $eventGroup) {?>
				<tr>
						<td>
							<?= $this->element('grouppath', array('groupStr' => $eventGroup['EventGroup']['path'], 'highestName' => $eventGroup['EventGroup']['highest_name']));?>
						</td>
						<td>
							<?php echo $eventGroup['EventGroup']['description']; ?>
						</td>
						<td class="table_tiny_buttons"><a href="<?php echo $html->url("/".$eventGroup['EventGroup']['path']); ?>" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png"
						class="small_icon_inline_button" /> View in timeline</a> 
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
						<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'editperms')) {?>
				
							<a class="make_button" href="<?php echo $html->url("/permissions/view/" . $eventGroup['EventGroup']['id']); ?>">
							<img src="<?php echo $html->url('/'); ?>css/rinoa/applications.png" class="small_icon_inline_button" /> Edit Permissions</a>
						<?php }?>
						<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'delete')) {?>
						<a class="make_button" href="<?=$html->url('/'); ?>event_groups/delete/<?php echo $eventGroup['EventGroup']['id']; ?>" onclick="return confirm(&#039;Are you sure you want to delete the group <?php echo $eventGroup['EventGroup']['name']; ?>?&#039);"><img src="<?php echo $html->url('/'); ?>css/rinoa/close.png" class="small_icon_inline_button" /> Delete</a>
						<?php 
							//echo $html->link(__('Delete', true), array('action' => 'delete', $eventGroup['EventGroup']['id']), array('class'=>'make_button'), sprintf(__('Are you sure you want to delete # %s?', true), $currenteventGroup['EventGroup']['id']));
						}?>
						</td>
				</tr>
			<?php }?>      
	            
		</table>
		<?php } ?>
		
		
		</div>
		
		<div class="form_section">
		<h2>Events Contained</h2>  
		
		<?php if( count($eventsUnderGroup)==0 )
		{ ?>
			<p class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> There are no events in "<?php echo $currenteventGroup['EventGroup']['name']; ?>" or any of its subgroups.</p>
		<?php }
		else {
		?>
		
		<table class="full_width">
			<tr><th>Title</th><th>Description</th><th>Time</th><th>Group</th><th>Location</th><th>Actions</th></tr>
			<?php foreach ($eventsUnderGroup as $event) {?>
			<tr id="event-<?=$event['Event']['id']?>">
					<td>
						<?php echo $event['Event']['title']; ?>
					</td>
					<td>
						<?php echo $event['Event']['description']; ?>
					</td>
					<td>
						<?php echo date('g:i a n/d/y', strtotime($event['Event']['time_start']))." to ". date('g:i a n/d/y', strtotime($event['Event']['time_start']) + $event['Event']['duration']*60); ?>
					</td>
					<td>
						<?php echo $event['EventGroup']['name']; ?>
					</td>
					<td>
						<?php echo $event['Event']['location']; ?>
					</td>
					<td class="actions">
						<?php echo $html->link(__('View', true), array('controller' => 'events', 'action' => 'view', $event['Event']['id'])); ?>
						<?php if ($access->check('Event',$event['Event']['id'], 'update')) {
							echo $html->link(__('Edit', true), array('controller' => 'events', 'action' => 'edit', $event['Event']['id'])); 
						}?>
						<?php if ($access->check('Event',$event['Event']['id'], 'delete')) {
							echo $html->link(__('Delete', true), array('controller' => 'events', 'action' => 'delete', $event['Event']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $event['Event']['id'])); 
						}?>
					</td>
			</tr>
			<?php }?>
		</table>
		<?php } ?>
	</div>      
	<!--<a href="#" class="make_button"><img src="/eventgrouper/css/rinoa/add.png" class="rinoa_small_inline" /> Add another email address</a>-->
</div>

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
				<div><p>Description:<?php 
				if( !$currenteventGroup['EventGroup']['description'] == "") 
				echo "</p><p>" . $currenteventGroup['EventGroup']['description'] . "</p>";
				else
				echo " <em>No Description</em></p>"; ?></div>
				<p><? echo $top_level?"":"Path: ".$this->element('grouppath', array('groupStr' => $currenteventGroup['EventGroup']['path'])); ?></p>
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
							<?= $this->element('grouppath', array('groupStr' => $eventGroup['EventGroup']['path']));?>
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
						<a class="make_button" href="<?=$html->url('/'); ?>event_groups/delete/<?php echo $eventGroup['EventGroup']['id']; ?>" onclick="return confirm(&#039;Are you sure you want to delete the group <?php echo $eventGroup['EventGroup']['name']; ?>?&#039;);"><img src="<?php echo $html->url('/'); ?>css/rinoa/close.png" class="small_icon_inline_button" /> Delete</a>
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
			<tr><th>Title</th><th>Description</th><th>Time</th><th>Event Group</th><th>Actions</th></tr>
			<?php foreach ($eventsUnderGroup as $event) {?>
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
						<?php echo $event['EventGroup']['name']; ?>
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

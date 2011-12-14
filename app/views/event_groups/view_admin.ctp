<script type="text/javascript">
$(document).ready(function() {
	$("form#loginForm").validate({
		rules: {
			'data[email]': {
				required:true,
				email: true
			}
		}
	});
});
</script>
<?php
$top_level = $currenteventGroup['EventGroup']['parent_id'] == 0;
$canCreate = false;
if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'create')) {
	$canCreate = true;
}
$addSubgroups = $top_level && $access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'bigOwner');
if(isset($notification))
{ ?>
	
	<div class="cake_notification">
		<img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png" class="rinoa_small_inline" />
		<?php echo $notification; ?>
	</div>
	
<?php } ?>

<div class="info_box">
    
	<h1><?php echo $currenteventGroup['EventGroup']['name']; ?></h1>
	<div class="form_section">
		<h2><?php echo $top_level?"Gathering Information":"Group Information"; ?></h2>
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
					
					
						<th>Default Location</th><td><?php echo $location; ?>
						
						</td>
					</tr>
					<tr>
					
					
						<th></th><td>	
						<?php if (!empty($centerLat)) {?>				
						<img id='staticmap' src="http://maps.google.com/maps/api/staticmap?center=<?php echo $centerLat; ?>,<?php echo $centerLong; ?>&zoom=16&size=400x100&maptype=roadmap&markers=color:red|label:A|<?php echo $centerLat; ?>,<?php echo $centerLong; ?>&sensor=false" />
						<?php } else {?>
						No Location
						<?php }?>
						</td>
					</tr>
				</table>
				<div style="height: 10px;"> </div>
			<div>
				<a href="<?php echo $html->url("/".$currenteventGroup['EventGroup']['path']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png"
				class="small_icon_inline_button" /> View in timeline</a>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'bigOwner')) {?>
				<a href="<?php echo $html->url("/event_groups/edit/".$currenteventGroup['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png"
				class="small_icon_inline_button" /> Edit info</a>
			<?php }?>
			<?php if ($addSubgroups) {?> 
				<a href="<?php echo $html->url("/event_groups/add/".$currenteventGroup['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/user_add.png"
				class="small_icon_inline_button" /> Add subgroups</a>
			<?php }?>
			<?php if ($canCreate) {?> 
				<a href="<?php echo $html->url("/events/add/".$currenteventGroup['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png"
				class="small_icon_inline_button" /> Add events</a>
			<?php }?>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'bigOwner')) {?> 
					<a href="<?php echo $html->url("/admin/requests/".$currenteventGroup['EventGroup']['id']); ?>"
					class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/check.png"
					class="small_icon_inline_button" /> Check requests (<?=$numRequests?>)</a>
				<?php }?>
			
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'delete')) {?>
				
				<a class="make_button" href="<?php echo $html->url("/event_groups/delete/" . $currenteventGroup['EventGroup']['id']); ?>" onclick="return confirm(&#039;Are you sure you want to delete the group <?php echo $currenteventGroup['EventGroup']['name']; ?>?&#039;);"><img src="<?php echo $html->url('/'); ?>css/rinoa/close.png" class="small_icon_inline_button" /> Delete</a>

			<?php }?>
			</div>
	</div>
	<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'editperms')) {?>
		<div class="form_section">
			<h2>Permissions</h2>
			<form name="loginForm" id="loginForm" method="post">
			<p>Enter someone's email to give them permission to edit "<?php echo $currenteventGroup['EventGroup']['name']; ?>".  <a href="#">What is this?</a></p>
			<input type="text" name="data[email]" class="textfield">
			<input type="submit" value="Add" class="make_button"> 
			</form>   
			<?php if( count($userPerms)==0 ) { ?>
			<p class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> No one else has permission to edit "<?php echo $currenteventGroup['EventGroup']['name']; ?>" or any subgroups.</p>
			<?php } else {?>   
				<table class="full_width">
					
				            
					<tr><th>Email address</th><th>Permissions to</th><th>Actions</th></tr>  
				     <?php foreach ($userPerms as $userPerm) {?>
					<tr>
							<td>
								<?php echo $userPerm['users']['email']; ?>
							</td>
							<td>
								<?php foreach($userPerm['userEventGroups'] as $eventGroup) {
									echo $this->element('grouppath', array('groupStr' => $eventGroup['EventGroup']['path'], 'highestName' => $eventGroup['EventGroup']['highest_name']));
									echo "<br>";
								}
								?>
							</td>
							<td class="actions">
								<?php echo $html->link('Remove', array('controller' => 'permissions', 'action' => 'delete', $groupId, $userPerm['users']['id']), array('class' => 'make_button'), "Are you sure you want to delete this?");?>
							</td>
					</tr>
					<?php }?>      
			            
				</table>
			<?php }?>
		</div>      
    <?php }?>
	<!-- <h1>Contents of "<?php echo $currenteventGroup['EventGroup']['name']; ?>"</h1> -->     
	<div class="form_section">
		<h2>Subgroups 
		</h2> 
		<?php if ($addSubgroups) {?> 
				<a href="<?php echo $html->url("/event_groups/add/".$currenteventGroup['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/user_add.png"
				class="small_icon_inline_button" /> Add subgroups</a>
			<?php }?>
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
						<td style="width: 200px;" class="table_tiny_buttons"><a href="<?php echo $html->url("/".$eventGroup['EventGroup']['path']); ?>">View in timeline</a> 
						<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'update')) {?>
							<a href="<?php echo $html->url("/event_groups/edit/".$eventGroup['EventGroup']['id']); ?>">Edit info</a>
						<?php }?><br />
						<?php if ($addSubgroups) {?> 
							<a href="<?php echo $html->url("/event_groups/add/".$eventGroup['EventGroup']['id']); ?>">Add subgroups</a>
						<?php }?>
						<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'create')) {?> 
							<a href="<?php echo $html->url("/events/add/".$eventGroup['EventGroup']['id']); ?>">Add events</a>
						<?php }?>
						<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'delete')) {?>
						<a href="<?=$html->url('/'); ?>event_groups/delete/<?php echo $eventGroup['EventGroup']['id']; ?>" onclick="return confirm(&#039;Are you sure you want to delete the group <?php echo $eventGroup['EventGroup']['name']; ?>?&#039);">Delete</a>
						<?php 
							//echo $html->link(__('Delete', true), array('action' => 'delete', $eventGroup['EventGroup']['id']), array('class'=>'make_button'), sprintf(__('Are you sure you want to delete # %s?', true), $currenteventGroup['EventGroup']['id']));
						}?>
						</td>
						
						
						<!-- <td class="table_tiny_buttons"><a href="<?php echo $html->url("/".$eventGroup['EventGroup']['path']); ?>" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png"
						class="small_icon_inline_button" /> View in timeline</a> 
						<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'update')) {?>
							<a href="<?php echo $html->url("/event_groups/edit/".$eventGroup['EventGroup']['id']); ?>"
							class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png"
							class="small_icon_inline_button" /> Edit info</a>
						<?php }?>
						<?php if ($addSubgroups) {?> 
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
						<a class="make_button" href="<?=$html->url('/'); ?>event_groups/delete/<?php echo $eventGroup['EventGroup']['id']; ?>" onclick="return confirm(&#039;Are you sure you want to delete the group <?php echo $eventGroup['EventGroup']['name']; ?>?&#039);"><img src="<?php echo $html->url('/'); ?>css/rinoa/close.png" class="small_icon_inline_button" /> Delete</a>
						<?php 
							//echo $html->link(__('Delete', true), array('action' => 'delete', $eventGroup['EventGroup']['id']), array('class'=>'make_button'), sprintf(__('Are you sure you want to delete # %s?', true), $currenteventGroup['EventGroup']['id']));
						}?>
						</td> -->
				</tr>
			<?php }?>      
	            
		</table>
		<?php } ?>
		
		
		</div>
		
		<div class="form_section">
		<h2>Events  </h2> 
		<?php if ($canCreate) {?> 
				<a href="<?php echo $html->url("/events/add/".$currenteventGroup['EventGroup']['id']); ?>"
				class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png"
				class="small_icon_inline_button" /> Add events</a>
			<?php }?>
		
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
					<th>
						<?php echo $event['Event']['title']; ?>
					</th>
					<td>
						<?php echo $event['Event']['description']; ?>
					</td>
					<td style="width: 120px;">
						<?php echo date('g:i a n/d/y', strtotime($event['Event']['time_start']))."<br />to ". date('g:i a n/d/y', strtotime($event['Event']['time_start']) + $event['Event']['duration']*60); ?>
					</td>
					<td>
						<?php echo $event['EventGroup']['name']; ?>
					</td>
					<td>
						<?php echo $event['Event']['location']; ?>
					</td>
					<td class="actions">
						<?php if ($canCreate) {
							echo $html->link(__('Edit', true), array('controller' => 'events', 'action' => 'edit', $event['Event']['id'])); 
						}?>
						<?php if ($canCreate) {
							echo $html->link(__('Delete', true), array('controller' => 'events', 'action' => 'delete', $event['Event']['id']), null, sprintf(__('Are you sure you want to delete %s?', true), $event['Event']['title'])); 
						}?>
					</td>
			</tr>
			<?php }?>
		</table>
		<?php } ?>
	</div>      
	<!--<a href="#" class="make_button"><img src="/eventgrouper/css/rinoa/add.png" class="rinoa_small_inline" /> Add another email address</a>-->
</div>

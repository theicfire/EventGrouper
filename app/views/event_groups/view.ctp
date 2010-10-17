<form method="get">
<?php 
$search = "";
if (array_key_exists('search', $this->params['url']))
	$search = $this->params['url']['search'];
$timeStart = date("Y-m-d H:i:s");
if (array_key_exists('date_start', $this->params['url']))
	$timeStart = $this->params['url']['date_start'];
$timeEnd = date("Y-m-d H:i:s") + 86400;
if (array_key_exists('date_end', $this->params['url']))
	$timeEnd = $this->params['url']['date_end'];
?>
Search: <input type="text" name="search" value="<?=$search?>">
Time Start: <input type="text" name="date_start" value="<?=$timeStart?>">
Time End: <input type="text" name="date_end" value="<?=$timeEnd?>">
<?php foreach (array_keys($categoryChoices) as $key){
?>
<input type="checkbox" name="categories[]" value="<?=$key?>" 
<?php if (array_key_exists('categories', $this->params['url']) && in_array($key, $this->params['url']['categories'])) echo "checked"?>
> <?=$categoryChoices[$key]?><br>
<?php }?>
<br>
<input type="submit" value="search">
</form>

<?php if (!array_key_exists('map', $this->params['url'])) {
?>
<?php 
$actions = array('create','delete','read','update');
foreach ($actions as $action) {
if($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], $action))
		echo "You can ".$action."<br>";
	else
		echo "You can NOT ".$action."<br>";
}
?>
<?php print_r($treeList);?>
<br>
<?php 
$linksArr = array($html->link(__('Home', true), array('action' => 'index')));
foreach ($groupPath as $single) {
	$linksArr[] = $html->link($single['EventGroup']['name'], "/".$single['EventGroup']['path']);
}
echo implode($linksArr," > ");
?>
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
--Groups Contained--
<table cellpadding="0" cellspacing="0">
<tr>
<td>id</td><td>name</td><td>description</td><td>photo_url</td><td>parent_id</td><td>Actions</td>
</tr>
<?php foreach ($eventGroups as $eventGroup) {?>
<tr>
		<td>
			<?php echo $eventGroup['EventGroup']['id']; ?>
		</td>
		<td>
			<?php echo $eventGroup['EventGroup']['name']; ?>
		</td>
		<td>
			<?php echo $eventGroup['EventGroup']['description']; ?>
		</td>
		<td>
			<?php echo $eventGroup['EventGroup']['photo_url']; ?>
		</td>
		<td>
			<?php echo $eventGroup['EventGroup']['parent_id']; ?>
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

--Events Contained--
<table cellpadding="0" cellspacing="0" id="events">
<tr>
<td>id</td><td>title</td><td>description</td><td>event_group_id</td><td>photo_url</td><td>more here</td><td>actions//fix</td>
</tr>
<?php foreach ($eventsUnderGroup as $event) {
	if (!$session->check('userid') || ($session->check('userid') && !array_key_exists('onUsersCalendar',$event['Event']))) {?>
<tr id="event-<?=$event['Event']['id']?>">
		<td>
			<?php echo $event['Event']['id']; ?>
		</td>
		<td>
			<?php echo $event['Event']['title']; ?>
		</td>
		<td>
			<?php echo $event['Event']['description']; ?>
		</td>
		<td>
			<?php echo $event['Event']['event_group_id']; ?>
		</td>
		<td>
			<?php echo $event['Event']['photo_url']; ?>
		</td>
		<td>more</td>
		<td class="actions">
			<?php 
			if ($session->check('userid')) {
				echo $html->link('Add To Calendar', "#", array('class' => "addEvent"));
			}
			?>
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
<?php if ($userStuff != null) {?>
--Users Events--
<table cellpadding="0" cellspacing="0" id="usersCalendar">
<tr>
<td>id</td><td>title</td><td>description</td><td>event_group_id</td><td>photo_url</td><td>more here</td><td>actions//fix</td>
</tr>
<?php 
	foreach ($userStuff['EventsOnCalendar'] as $event) {
?>
<tr id="userEvent-<?php echo $event['id']; ?>">
		<td>
			<?php echo $event['id']; ?>
		</td>
		<td>
			<?php echo $event['title']; ?>
		</td>
		<td>
			<?php echo $event['description']; ?>
		</td>
		<td>
			<?php echo $event['event_group_id']; ?>
		</td>
		<td>
			<?php echo $event['photo_url']; ?>
		</td>
		<td>more</td>
		<td class="actions">
		<?php echo $html->link('Remove From Calendar', "#", array('class' => "removeEvent"));?>
			<?php echo $html->link(__('View', true), array('controller' => 'events', 'action' => 'view', $event['id'])); ?>
			
		</td>
</tr>
<?php }?>
</table>
<?php }?>

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

<script type="text/javascript">
$(document).ready(function() {
	  // Handler for .ready() called.

	$('.removeEvent').each(function(i) {
		$(this).click(function() {
			var id = $(this).parent().parent().attr('id').split("-")[1];
			$.ajax({url: "<?=$this->base?>/events/removeFromCalendar/"+id,
				success: function() {window.location.reload();}
			});
			return false;
		});
	});
	$('.addEvent').each(function(i) {
		$(this).click(function() {
			var id = $(this).parent().parent().attr('id').split("-")[1];
			$.ajax({url: "<?=$this->base?>/events/addToCalendar/"+id,
				success: function() {window.location.reload();}
			});
			return false;
		});
	});
	  
});
</script>
<?php } else {
echo $javascript->link('mapstuff.js');
?>
<div id="placeMarkers">
<?php 
$latlngs = array(
array('37.4719', '-122.1419'),
array('37.4519', '-122.1419'),
array('37.4619', '-122.1419')
);
echo json_encode($latlngs);
?>


</div>

 <div style="width: 500px; ">
      <div style="margin-bottom: 5px;">

        <div>
          <input type="text" id="queryInput" value="pizza" style="width: 250px;"/>
          <input type="button" value="Find" onclick="doSearch()"/>
        </div>
      </div>
      <div style="position: absolute; left: 540px;">
        <div id="searchwell"></div>
      </div>
      <div id="map" style="height: 350px; border: 1px solid #979797;"></div>
      

    </div>
<?php 
}?>

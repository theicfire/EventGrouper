blasdfdsadfsdffh<h2><?php __('EventGroups');?></h2>
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
			<?php echo $html->link("View", "/".$eventGroup['EventGroup']['path']); ?>
			<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'update')) {
				echo $html->link(__('Edit', true), array('action' => 'edit', $eventGroup['EventGroup']['id'])); 
			}?>
			<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'delete')) {
				echo $html->link(__('Delete', true), array('action' => 'delete', $eventGroup['EventGroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $eventGroup['EventGroup']['id']));
			} ?>
		</td>
</tr>
<?php }?>
</table>
<div class="actions">
	<ul>
		<li><?php if ($session->check('userid')) {
			echo $html->link(__('Add a top level EventGroup', true), array('action' => 'add', 0)); 
		}?> </li>
	</ul>
</div>

<div class="users view">
<h2><?php  __('User');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pass'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['pass']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit User', true), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete User', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Events', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Event', true), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Event Groups', true), array('controller' => 'event_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Event Group', true), array('controller' => 'event_groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Events');?></h3>
	<?php if (!empty($user['Event'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Event Group Id'); ?></th>
		<th><?php __('Photo Url'); ?></th>
		<th><?php __('Location'); ?></th>
		<th><?php __('Time Start'); ?></th>
		<th><?php __('Duration'); ?></th>
		<th><?php __('Latitude'); ?></th>
		<th><?php __('Longitude'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Event'] as $event):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $event['id'];?></td>
			<td><?php echo $event['title'];?></td>
			<td><?php echo $event['description'];?></td>
			<td><?php echo $event['event_group_id'];?></td>
			<td><?php echo $event['photo_url'];?></td>
			<td><?php echo $event['location'];?></td>
			<td><?php echo $event['time_start'];?></td>
			<td><?php echo $event['duration'];?></td>
			<td><?php echo $event['latitude'];?></td>
			<td><?php echo $event['longitude'];?></td>
			<td><?php echo $event['user_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'events', 'action' => 'view', $event['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'events', 'action' => 'edit', $event['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'events', 'action' => 'delete', $event['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $event['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Event', true), array('controller' => 'events', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Event Groups');?></h3>
	<?php if (!empty($user['EventGroup'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Photo Url'); ?></th>
		<th><?php __('Event Group Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['EventGroup'] as $eventGroup):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $eventGroup['id'];?></td>
			<td><?php echo $eventGroup['name'];?></td>
			<td><?php echo $eventGroup['description'];?></td>
			<td><?php echo $eventGroup['photo_url'];?></td>
			<td><?php echo $eventGroup['event_group_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'event_groups', 'action' => 'view', $eventGroup['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'event_groups', 'action' => 'edit', $eventGroup['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'event_groups', 'action' => 'delete', $eventGroup['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $eventGroup['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Event Group', true), array('controller' => 'event_groups', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>

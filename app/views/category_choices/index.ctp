<div class="categoryChoices index">
<h2><?php __('CategoryChoices');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('event_group_id');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($categoryChoices as $categoryChoice):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $categoryChoice['CategoryChoice']['id']; ?>
		</td>
		<td>
			<?php echo $categoryChoice['CategoryChoice']['name']; ?>
		</td>
		<td>
			<?php echo $html->link($categoryChoice['EventGroup']['name'], array('controller' => 'event_groups', 'action' => 'view', $categoryChoice['EventGroup']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($categoryChoice['User']['id'], array('controller' => 'users', 'action' => 'view', $categoryChoice['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $categoryChoice['CategoryChoice']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $categoryChoice['CategoryChoice']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $categoryChoice['CategoryChoice']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $categoryChoice['CategoryChoice']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New CategoryChoice', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Event Groups', true), array('controller' => 'event_groups', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Event Group', true), array('controller' => 'event_groups', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Events', true), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Event', true), array('controller' => 'events', 'action' => 'add')); ?> </li>
	</ul>
</div>

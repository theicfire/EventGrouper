<?php
/* /app/views/helpers/link.php (using other helpers) */
class NavigationHelper extends AppHelper {
    var $helpers = array('Html');

    function makeNavigation($id=null) {
        // Use the HTML helper to output
        // formatted data:
		$output = "<div class=\"actions\">
		<ul>
		<li>".$this->Html->link(__('Add EventGroup Under This', true), array('action' => 'add', $id))."</li>
		<li>".$this->Html->link(__('Add Event Under This', true), array('controller' => 'events', 'action' => 'add', $id))."</li>
		<li>".$this->Html->link(__('Edit EventGroup', true), array('action' => 'edit', $id))."</li>
		<li>".$this->Html->link(__('List EventGroups', true), array('action' => 'index'))."</li>
		<li>".$this->Html->link(__('New EventGroup', true), array('action' => 'add'))."</li>
		<li>".$this->Html->link(__('List Event Groups', true), array('controller' => 'event_groups', 'action' => 'index'))."</li>
		<li>".$this->Html->link(__('List Events', true), array('controller' => 'events', 'action' => 'index'))."</li>
		<li>".$this->Html->link(__('New Event', true), array('controller' => 'events', 'action' => 'add'))."</li>
		<li>".$this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index'))."</li>
		<li>".$this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add'))."</li>
	</ul>
</div>";
        return $this->output($output);
    }
}
?>

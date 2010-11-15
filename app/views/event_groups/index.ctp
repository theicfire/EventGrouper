<div class="info_page">
<h1>Welcome to RushRabbit.</h1>
<p class="subtitle">the world's most advanced event and conference organization system.</p>
<div class="hr"></div>

<div class="form_section" style="float:left; width: 430px;">
<h2>What is it?</h2>
<p>RushRabbit allows you to manage large numbers of events.  It offers groundbreaking new features for the administrator and the conference attendee.</p>
<p>
	<ul class="front_page_list">
		<li class="fpl_item">for administrators:
			<ul class="front_page_sublist">
			<li>Delegation of event planning</li>
			<li>Interface for administrator approval of events</li>
			<li>Rigid structure of groups and subgroups to ensure organization</li>
			</ul>

		</li>
		<li class="fpl_item">for attendees:
			<ul class="front_page_sublist">
			<li>Filtering, sorting, and searching through events</li>
			<li>Location-based event searching (even from a GPS-enabled phone)</li>
			<li>Personal schedule builder</li>
			</ul>

		</li>
	</ul>
</p>
</div>

<?php if ($this->Session->read('username') == null) { ?>

<div class="form_section" style="float:right; width: 430px;">
<h2>Get Started</h2>

<label>Have an account?</label>
<a href="javascript:open_dialog()" class="make_button">Login</a>

<script type="text/javascript">
function open_dialog()
{ $( '#dialog-form' ).dialog( 'open' ); }

</script>

<label>Need an account?</label>
<?php echo $html->link("Register", "/users/add", array('class'=>'make_button'));?>

</div>

<?php } else { ?>

<div class="form_section" style="float:right; width: 430px;">
<h2>Recently Viewed [Conference]s</h2>

<?php if (isset($watchlist)) {?>
	<table class="full_width generic">
	<tr>
	<th>Name</th><th>Last visited</th>
	</tr>
	<?php foreach ($watchlist as $eventGroup) {?>
	<tr>
			<td>
				<?php echo $html->link($eventGroup['event_groups']['name'], "/".$eventGroup['event_groups']['path']); ?>
			</td>
			<td>
				<?php echo date( 'l, F jS Y' , strtotime($eventGroup['event_groups_users']['time']) ); ?>
			</td>
	</tr>
	<?php }?>
	</table>
<?php }?>
</div>

<div class="form_section" style="float:right; width: 430px;">
<h2>Create a [Conference]</h2>

<?php echo $html->link('Click here to create a [conference]', '/event_groups/add/0', array('class'=>'make_button')); ?>

</div>

<?php } ?>

<!-- the real thing
<div class="form_section" style="float:right; width: 430px;">
<h2>Create a Conference</h2>

<label>Name</label>
<input type="text" class="textfield" />
<p class="form_tip">for example, MIT Campus Preview Weekend</p>

<input type="submit" value="Get started" class="make_button" />

</div>

<div class="form_section" style="float:right; width: 430px;">
<h2>Search for a Conference</h2>

<input type="text" class="textfield" />

<input type="submit" value="Search" class="make_button" />

</div> -->

<div class="clear"></div>

</div>







<h2><?php __('EventGroups');?></h2>
<table border="1">
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

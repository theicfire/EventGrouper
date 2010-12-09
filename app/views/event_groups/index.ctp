<div class="fixed_width_page">


	<?php if ($this->Session->read('username') == null) { ?>
	

		<?php } else { ?>
<div class="form_section">
		<?php if (isset($watchlist)) {?>
			Your Recently Viewed Gatherings: 
			<?php foreach ($watchlist as $eventGroup) {?>

						<?php echo $html->link($eventGroup['event_groups']['name'], "/".$eventGroup['event_groups']['path']); ?>
						<?php // echo date( 'l, F jS Y' , strtotime($eventGroup['event_groups_users']['time']) ); ?>

			<?php }?>
		<?php }
		else {
		?>
		<!--<p class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> You haven't viewed any Gatherings yet. Use the search bar at the top of the page to find one.</p>-->
		<? } ?>
		
		<div style="float: right"><?php echo $html->link('Create your own Gathering', '/event_groups/add/0', array('class'=>'')); ?></div>
		
		</div>
		
		<?php } ?>
		
		
		

<div id="header_box">

	<div id="header_logo"><h1>RushRabbit</h1><p>...hop on over</p>
	</div>

	<div id="header_actions">
	<?php if ($this->Session->read('username') == null) { ?>
	<div class="form_section">
	<h2>Get Started!</h2>
	
	
	Have an account? <a href="javascript:open_dialog()">Log in</a> 

		<script type="text/javascript">
		function open_dialog()
		{ $( '#dialog-form' ).dialog( 'open' ); }

		</script>
<br />
		Need an account? <?php echo $html->link("Register", "/users/add", array('class'=>''));?>
	
	</div>
	
	
	<? } ?>
	</div>

<div class="clear"></div>

</div>

<div class="fp_content">

<h2 class="fp_h2">Viewing Events</h2>

	<table class="fp_boxes">
	<tr><td>
	<div class="fp_padding">
	<h2 class="fp_info_header">Switch Between Timeline View and Map View</h2>
	<p>RushRabbit allows you to view events on a map, so you can find what's going on near you.</p>
	</div>
	</td><td>
	<div class="fp_padding">
	<h2 class="fp_info_header">Keep Track of Your Favorite Events</h2>
	<p>Create an account and add events to your Favorites to keep track of those that interest you most.  Then, print out your Favorites, email them to someone, or sync them with your calendar.</p>
	</div>
	</td><td>
	<div class="fp_padding">
	<h2 class="fp_info_header">Log in with Facebook</h2>
	<p>If you have a Facebook account, you don't need to register with RushRabbit - just click the Facebook login button to connect with your existing account.</p>
	</div>
	</td>
	</tr>
	<tr>
	<td>
	<div class="fp_padding">
	<h2 class="fp_info_header">Sync with Your Calendar</h2>
	<p>Import the entire schedule of a Gathering or just your Favorites into Google Calender, iCal, Outlook, and many other programs.  Take it on the go with your smartphone.</p>
	</div>
	</td><td>
	<div class="fp_padding">
	<h2 class="fp_info_header">Go to the Mobile Site</h2>
	<p>Visit RushRabbit.com on your internet-enabled mobile phone to view your favorites or a map of events happening around you.  We support iPhone, Android, and WebOS.</p>
	</div>
	</td>
	<td></td>
	</tr>
	</table>
</div>

<div class="fp_content">

<h2 class="fp_h2">Creating Events</h2>

	<table class="fp_boxes">
	<tr><td>
	<div class="fp_padding">
	<h2 class="fp_info_header">Organize Large Numbers of Events</h2>
	<p>There is no limit to how many events a single Gathering can contain, and RushRabbit is especially good at making sure you don't get overwhelmed.</p>
	</div>
	</td><td>
	<div class="fp_padding">
	<h2 class="fp_info_header">Create Groups and Subgroups</h2>
	<p>If your gathering has events hosted by different groups or for different purposes, RushRabbit can reflect that structure.</p>
	</div>
	</td><td>
	<div class="fp_padding">
	<h2 class="fp_info_header">Give Groups Permission to Edit Their Own Events</h2>
	<p>If there are lots of events hosted by different groups, all the coordinator has to do is create the groups, and let the people in the group do all the work of creating the events.</p>
	</div>
	</td>
	</tr>
	</table>
	
	
	
	
	
	
	
	

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

</div>

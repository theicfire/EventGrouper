<div class="fixed_width_page">

<?php /*
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
		<p class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> You haven't viewed any Gatherings yet. Use the search bar at the top of the page to find one.</p>
		<? } ?>
		
		<div style="float: right"><?php echo $html->link('Create your own Gathering', '/event_groups/add/0', array('class'=>'')); ?></div>
		
		</div>
		
		<?php } ?>
		
		
		

<div id="header_box">

	<div id="header_logo"><h1>MIT</h1><p>Campus Preview Weekend</p>
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

<form method="get" action="<?=$html->url('/search/index')?>">
<input type="text" name="q">
<input type="submit" value="Search For Test Dataset">
</form>

 */?>
 
 <div class="spacer">&nbsp;</div>
 <div class="spacer">&nbsp;</div>
 <div class="spacer">&nbsp;</div>
<p>Welcome to the new</p>
<h1 class="fp_title">CPW event system</h1>

<p><a style="font-size: 2em" href='<?=$html->url('/cpw') ?>'>Click here to see the events!</a></p>

<div class="hr">&nbsp;</div>

<p>Some of our main features:</p>

<div class="spacer">&nbsp;</div>

<a href='cpw'><img src="<?php echo $html->url('/img/highlights_sm.png'); ?>" /></a>

<!--
<h2 class="fpn_h2">Search Filters</h2>
<p>Easy to use search for tags, text in events, start time, and day.</p>

<div class="hr">&nbsp;</div>

<h2 class="fpn_h2">Event Map</h2>
<p>Click on the button that says 'map' in the top left of the events list
to see what events are closest to you!</p>

<div class="hr">&nbsp;</div>
<h2 class="fpn_h2">Favorites</h2>
<p>Make an account, and click the heart next to an event to add it to your
list of favorites - then log in sometime later on your computer or
your phone to look at the events you have already picked out!</p>
<div class="hr">&nbsp;</div>
<h2 class="fpn_h2">Mobile Site</h2>
<p>Look at a map of events close to you from your phone - the mobile
site has been tested on Android and iPhone.  Just point your phone's
browser to ---------.</p>
 -->

<span class="footnote">CPW Scheduler by Chase Lambert and Sashko Stubailo, Class of 2014</span>

</div>

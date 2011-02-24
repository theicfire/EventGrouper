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

	<div id="header_logo"><h1>new CPW</h1><p>test site</p>
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
</div>

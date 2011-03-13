<div class="ajax_event_list">

<?php 
if (isset($curPage)) {
	if ($curPage != 1) {
		echo '<a href="javascript:prev_page()" class="button_small" id="prevpage"><label class="button_label">Previous Page</label></a>';
	}
	if ($curPage-2 > 1) {
		echo "...";
	}
	for ($i = $curPage-2; $i <= $curPage+2; $i++) {
		if ($i > 0 && $i < $totalEventCount/$eventsPerPage){ // page is hardcoded
			$style = "";
			if ($i == $curPage) $style = "style='font-weight:bold'";
			echo "<a href=\"javascript:go_to_page(".$i.")\" class=\"button_small\" ".$style.">".$i."</a> ";
		}
	}
	
	if ($curPage < ($totalEventCount-1)/$eventsPerPage-1) {
		echo '<a href="javascript:next_page()" class="button_small" id="nextpage"><label class="button_label">Next Page</label></a>';
	}
}
?>


	<?php //if there are no events, show this message
	if (count($eventsUnderGroup) == 0)
	{ ?>
		<div class="no_results ui-state-highlight">
		<span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> There are no events which match this set of options.
		</div>
		
	<?php } ?>
	
<?php

//initializing variables for main loop
$oldDay = ""; //used to determine when to show the day headers
$odd= true; //used to shade alternate lines

for ($i = 0; $i < count($eventsUnderGroup); $i++) //main loop
{
	$event = $eventsUnderGroup[$i];
	
	//test for new day
	$currentDay = date('Y-m-d', strtotime($event['Event']['time_start']));	
	if ($oldDay != $currentDay) {
		$oldDay = $currentDay;?>
	
			<div id="which_day_container">
				<h2 id="which_day_is_it"><?php echo date('l, F j Y', strtotime($event['Event']['time_start'])); ?></h2>            
				<!-- <a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/back.png" class="small_icon_inline_button" />Previous day</a><a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/go.png" class="small_icon_inline_button" />Next day</a> -->
			</div> 

	<?php }
	//end test for new day
	
	//determine if the event is in the user's favorites
	if ($session->check('userid') && array_key_exists('onUsersCalendar',$event['Event'])) { $onUserCalendar = true; }
	else { $onUserCalendar = false;	}
	?>
            	
    <?php $odd = !$odd; //alternate rows ?>
    
    <?php //start event block ?>	
    <div class="event_block<?php echo ($onUserCalendar?" onCalendar":"") . ($odd?" odd":""); ?>" id="event-<?=$event['Event']['id']?>">
		<div class="hiddenid"><?=$event['Event']['id']?></div>
		<div class="event_top_row">
			<div style="display:none" id="latitude"><?=$event['Event']['latitude']?></div>
			<div style="display:none" id="longitude"><?=$event['Event']['longitude']?></div>
			
			<h3 class="event_title" style="display: inline"><?php echo $html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'view', $event['Event']['id']), array('class' => "group_".$event['EventGroup']['id'])); ?></h3> 
			&nbsp; 
			<span class="event_time">
				<?php
				//get start and end times; maybe add some better logic here later.. show dates?
				$start_time = strtotime($event['Event']['time_start']);
				$end_time = strtotime($event['Event']['time_start']) + $event['Event']['duration'] * 60;
				echo date('g:i a', $start_time);
				
				if($event['Event']['duration'] > 0 ){
					$end_time = strtotime($event['Event']['time_start']) + $event['Event']['duration'] * 60;
					echo " to " . date('g:i a', $end_time);
				}
				?>
			</span>
			
			<?php
			// I feel like location should never be empty.  maybe sometimes there won't be a lat/long, but there should always be a location...
			if (!empty($event['Event']['location'])) {?>
				<span class="event_location">
					at <a href="#" class="locLink"><?=$event['Event']['location']?></a>
				</span>
			<?php }?>
			
			<?php // button to add to favorites ?>
			<div class="favwrap<?=$onUserCalendar?" onCalendar":""?>" style="display:inline" id="favevent-<?=$event['Event']['id']?>">
				<a href="#" class="scheduletoggle addToSchedule" style="<?php if ($onUserCalendar) { echo "display:none";} ?>">
				<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_add_muted.png" class="timeline_icon"  />
				</a>
				
				<a href="#" class="scheduletoggle removeFromSchedule" style="<?php if (!$onUserCalendar) { echo "display:none";} ?>">
				<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_delete.png" class="timeline_icon"  />
				</a>
			</div>
			
			<?php if (!empty($event['Event']['tags'])) { ?>	 
				<span class="event_tags group_<?=$event['EventGroup']['id']?>">
					<?php
						echo "Tags: ";
						$tagArr = explode(" ", $event['Event']['tags']);
						foreach ($tagArr as $tag) {
								echo "<a href='#' class='tagLink'>".trim($tag)."</a> ";	
						}
					?>
				</span>
			<?php } ?>			
			
			<div class="clear"></div>	
		</div> <!-- end top row -->
		<div> <!-- second row -->
			<span class="event_description">
				<?=$event['Event']['description']?>
				<small style="font-size: .8em">[posted by <?=$this->element('grouppath', array('groupStr' => $event['EventGroup']['path'], 'highestName' => $event['EventGroup']['highest_name']))?>]</small>
			</span>
		</div>
	</div> <!-- end event block -->
<?php } //end main loop ?>
</div>

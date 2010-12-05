<div id="desktop_map_window">
<input id="eventCount" type="hidden" value="<?php echo count($eventsUnderGroup)?>">
	<div id="desktop_map_event_list">
		<h2>Search Results</h2>
		
		<?php
		echo "<span id='json_map_data' style='display: none'>";
		echo json_encode($eventsUnderGroup);
		echo "</span>";
		?>
		
		<div id="map_search_result_list">
		
			<?php 

			if( count($eventsUnderGroup) > 0 )
			{
				//initialize variables for main loop
				$i = 0;
				$imageArr = array('a_ns', 'b_ns', 'c_ns', 'd_ns', 'e_ns', 'f_ns', 'g_ns', 'h_ns', 'i_ns', 'j_ns', 'rest');
				$odd = false;
				foreach ($eventsUnderGroup as $event) {
		
					//determine if the event is in the user's favorites
					if ($session->check('userid') && array_key_exists('onUsersCalendar',$event['Event'])) { $onUserCalendar = true; }
					else { $onUserCalendar = false;	}
					?>
					
					<div class="map_search_result <?=($odd?'odd':'') ?>">
						<a href="javascript:map_open_by_id(<?=$event['Event']['id']?>)"><img src="<?=$html->url('/') ?>img/maps/<?=$imageArr[$i] ?>.png" class="msr_icon"></a>
		
						<span id="event_id_<?=$event['Event']['id']?>" style="display: none;"><?=$i?></span>
		
						<h3 class="msr_title">
							<a href="javascript:map_open_by_id(<?=$event['Event']['id']?>)"><?=$event['Event']['title']?></a>
		
							<a href="#" class="scheduletoggle addToSchedule" style="<?php if ($onUserCalendar) { echo "display:none";} ?>">
							<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_add.png" class="msr_fav_icon"  />
							</a>
							
							<a href="#" class="scheduletoggle removeFromSchedule" style="<?php if (!$onUserCalendar) { echo "display:none";} ?>">
							<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_delete.png" class="msr_fav_icon"  />
							</a>
						</h3>
						
						<p class="msr_time"><?=date('g:i a n/d/Y', strtotime($event['Event']['time_start']))?> at <?=$event['Event']['location']?></p>
						
						<p class="msr_desc"><?=$event['Event']['description']?>  Posted by <?= $this->element('grouppath', array('groupStr' => $event['EventGroup']['path'], 'highestName' => $event['EventGroup']['highest_name']))?></p>
		
						<div id="<?=$i?>_infowindow" style="display: none">
							<?php //start event block ?>	
							<div class="event_block<?php echo ($onUserCalendar?" onCalendar":""); ?>" id="event-<?=$event['Event']['id']?>">
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
										echo date('g:i a', $start_time) . " to " . date('g:i a', $end_time);
										?>
									</span>
									
									<?php
									// I feel like location should never be empty.  maybe sometimes there won't be a lat/long, but there should always be a location...
									if (!empty($event['Event']['location'])) {?>
										<span class="event_location">
											at <?=$event['Event']['location']?>
										</span>
									<?php }?>
									
									<?php // button to add to favorites ?>
									<a href="#" class="scheduletoggle addToSchedule" style="<?php if ($onUserCalendar) { echo "display:none";} ?>">
									<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_add.png" class="timeline_icon"  />
									</a>
									
									<a href="#" class="scheduletoggle removeFromSchedule" style="<?php if (!$onUserCalendar) { echo "display:none";} ?>">
									<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_delete.png" class="timeline_icon"  />
									</a>
									
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
										Posted by <?=$this->element('grouppath', array('groupStr' => $event['EventGroup']['path'], 'highestName' => $event['EventGroup']['highest_name']))?>
									</span>
								</div>
							</div> <!-- end event block -->
		
		
						</div>
		
					</div>
					
					<?php
					$i++;
					if ($i >= count($imageArr)) $i = count($imageArr)-1; 
					$odd = !$odd;
				}

			}
			else //if there are no results
			{
				?>
				<p class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> There are no events which match this set of options.</p>
				<?php
			}

			?>
		</div>
	</div>


	<div id="desktop_map_container">
	</div>
</div>

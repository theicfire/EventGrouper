
<?php
if (count($eventsUnderGroup) == 0)
	echo "There are no events in those search parameters";
$oldDay = "";
for ($i = 0; $i < count($eventsUnderGroup); $i++) {
	$event = $eventsUnderGroup[$i];
	$currentHour = date('H', strtotime($event['Event']['time_start']));
	$currentDay = date('Y-m-d', strtotime($event['Event']['time_start']));	
	if ($oldDay != $currentDay) {
		$oldDay = $currentDay;?>
	
		 <tr><td class="timeslot_title"></td><td class="timeline_cell">
			<div id="which_day_container_locator"></div>
			<div id="which_day_container">
				<span id="which_day_is_it"><?php echo date('l, F j', strtotime($event['Event']['time_start'])); ?></span>            
				<a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/back.png" class="small_icon_inline_button" />Previous day</a><a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/go.png" class="small_icon_inline_button" />Next day</a>
			</div>    
			</td><td class="mys_cell">
			<div class="mys_timeslot">
			<div id="top_locator"></div>
			</div>
		</td></tr>
	<?php }?>
	<tr><td class="timeslot_title"><?php echo date('g:00 a', strtotime($event['Event']['time_start'])); ?></td><td class="timeline_cell">
            <?php while (true) {
            	$event = $eventsUnderGroup[$i];
            	$onUserCalendar = false;
            	if ($session->check('userid') && array_key_exists('onUsersCalendar',$event['Event']))
					$onUserCalendar = true;
            ?>
            	
            	<div class="event_block<?php if ($onUserCalendar) echo " onCalendar"; ?>" id="event-<?=$event['Event']['id']?>">
            	
            	<div class="hiddenid"><?=$event['Event']['id']?></div>
            	
            	<div class="event_top_row">
                	
                	<!--
                    <td class="event_titlebar" rowspan="2">
						<div class="titlebar_text">
						
						<ul class="event_block_actions">
						
						<li>
							<?php 
							if (!$session->check('userid'))
								echo "add to my schedule";
							else {
								?><a href="#" class="scheduletoggle">
								<?php 
								if ($onUserCalendar) echo "remove from my schedule"; 
								else echo "add to my schedule"; 
								?>
								</a>
								
							<?php }?>
						</li>
						 <li><a href="#">share</a></li>
						 <li><a href="#">view on map</a></li>
						 </div>
					 </td>-->

							<span class="event_title">
								<?php echo $html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'view', $event['Event']['id']), array('class' => "group_".$event['EventGroup']['id'])); ?>
							</span>
							
							<span class="event_time">
								<?php echo date('g:i a', strtotime($event['Event']['time_start']))." to ".date('g:i a', strtotime($event['Event']['time_start'])+$event['Event']['duration']*60)?>
							</span>
							
							<?php if (!empty($event['Event']['location'])) {?>
							<span class="event_location">
								at <a class="group_1" href="#location"><?=$event['Event']['location']?></a>
							</span>
							<?php }?>

							<span class="event_tags">
									posted <?php if (count($event['CategoryChoice'])>0) {
									$categoryLinks = array();
									foreach ($event['CategoryChoice'] as $category) { 
										$categoryLinks[] = "<a class=\"group_1 categoryLink\" hiddenclass='categoryLink-".$category['id']."' href=\"#\">".$category['name']."</a>";
									} 
									echo " in ".implode(", ",$categoryLinks);
								}?> 
								by <a href="<?php echo $html->url("/".$event['EventGroup']['path']);?>" class="group_<?=$event['EventGroup']['id']?>"><?php echo $event['EventGroup']['name']; ?></a>
							</span>
                </div>
                <div>
                        
                        <div class="event_description"><?=$event['Event']['description']?></div>
                        
                </div>        

                    

                </div> 
                
                <?php 
            	$i++;
            	if (!($i < count($eventsUnderGroup) && date('H', strtotime($eventsUnderGroup[$i]['Event']['time_start'])) == $currentHour)) {
            		$i--;
            		break;
            	}
            }?>
                <!-- end event block -->
                </tr>
                
<?php
}?>      
 


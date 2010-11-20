<table>
<?php
if (count($eventsUnderGroup) == 0)
{ ?>
	<div class="no_results">
	<img src="<?php echo $html->url('/css/'); ?>rinoa/document.png" class="small_icon_inline_button" /> There are no events which match this set of options.
	</div>
	
<?php }
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
				<!-- <a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/back.png" class="small_icon_inline_button" />Previous day</a><a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/go.png" class="small_icon_inline_button" />Next day</a> -->
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
								if ($onUserCalendar) echo "Unfavorite"; 
								else echo "Favorite"; 
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
								at <a  class="group_<?=$event['EventGroup']['id']?>" href="#location"><?=$event['Event']['location']?></a>
							</span>
							<?php }?>

							<span class="event_tags group_<?=$event['EventGroup']['id']?>">
<!--									posted by <a href="<?php echo $html->url("/".$event['EventGroup']['path']);?>" class="group_<?=$event['EventGroup']['id']?>"><?php echo $event['EventGroup']['name']; ?></a>-->
									posted by <?= $this->element('grouppath', array('groupStr' => $event['EventGroup']['path'], 'highestName' => $event['EventGroup']['highest_name']))?>
									<?php if (!empty($event['Event']['tags'])) { 
										echo " in ";
										$tagArr = explode(",", $event['Event']['tags']);
										foreach ($tagArr as $tag) {
											echo "<a href='#' class='tagLink'>".trim($tag)."</a> ";
										}
									}?>
							</span>
							<?php 
							if (!$session->check('userid'))
								echo "Login to Favorite";
							else {?>
								<a href="#" class="scheduletoggle addToSchedule" style="<?php if ($onUserCalendar) { echo "display:none";} ?>">
								<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_add.png" class="small_icon_inline_button"  />
								</a>
								
								<a href="#" class="scheduletoggle removeFromSchedule" style="<?php if (!$onUserCalendar) { echo "display:none";} ?>">
								<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_delete.png" class="small_icon_inline_button"  /> 
					
								</a>
								
							<?php }?>
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
 </table>


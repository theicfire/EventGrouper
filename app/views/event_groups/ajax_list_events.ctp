
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
	
			<div id="which_day_container">
				<span id="which_day_is_it"><?php echo date('l, F j', strtotime($event['Event']['time_start'])); ?></span>            
				<!-- <a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/back.png" class="small_icon_inline_button" />Previous day</a><a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/go.png" class="small_icon_inline_button" />Next day</a> -->
			</div> 

	<?php }?>

            <?php while (true) {
            	$event = $eventsUnderGroup[$i];
            	$onUserCalendar = false;
            	if ($session->check('userid') && array_key_exists('onUsersCalendar',$event['Event']))
					$onUserCalendar = true;
				
            ?>
            	
            	<div class="event_block<?php if ($onUserCalendar) echo " onCalendar"; ?>" id="event-<?=$event['Event']['id']?>">
            	
            	<div class="hiddenid"><?=$event['Event']['id']?></div>
            	
            	<div class="event_top_row">
					<a href="#" class="scheduletoggle addToSchedule" style="<?php if ($onUserCalendar) { echo "display:none";} ?>">
					<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_add.png" class="small_icon_inline_button"  />
					</a>
					
					<a href="#" class="scheduletoggle removeFromSchedule" style="<?php if (!$onUserCalendar) { echo "display:none";} ?>">
					<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_delete.png" class="small_icon_inline_button"  /> 
		
					</a>
					
					<span class="event_title">
						<?php echo $html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'view', $event['Event']['id']), array('class' => "group_".$event['EventGroup']['id'])); ?>
					</span>
					
					<?php if (!empty($event['Event']['location'])) {?>
						<span class="event_location">
							<b>At</b> <?=$event['Event']['location']?>
						</span>
					<?php }?>
					 <b>In</b> <span class="event_path"><?= $this->element('grouppath', array('groupStr' => $event['EventGroup']['path'], 'highestName' => $event['EventGroup']['highest_name']))?></span>
					<span class="event_tags group_<?=$event['EventGroup']['id']?>">
							
							<?php if (!empty($event['Event']['tags'])) {
								$tagArr = explode(",", $event['Event']['tags']);
								foreach ($tagArr as $tag) {
									echo "<a href='#' class='tagLink'>".trim($tag)."</a> ";
								}
							}?>
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

                
<?php
}?>      



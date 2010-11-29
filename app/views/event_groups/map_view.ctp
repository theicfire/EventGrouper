<div id="desktop_map_window">
<div id="desktop_map_event_list">
<h2>Search Results</h2>

						<?php
						echo "<span id='json_map_data' style='display: none'>";
						echo json_encode($eventsUnderGroup);
						echo "</span>";
						?>
<div id="map_search_result_list">
<?php 
$i = 0;
$imageArr = array('a_ns', 'b_ns', 'c_ns', 'd_ns', 'e_ns', 'f_ns', 'g_ns', 'h_ns', 'i_ns', 'j_ns', 'rest');
$odd = false;
foreach ($eventsUnderGroup as $event) {
	
	$onUserCalendar = false;
            	if ($session->check('userid') && array_key_exists('onUsersCalendar',$event['Event']))
					$onUserCalendar = true;
	
	?>
	<div class="map_search_result <?=($odd?'odd':'') ?>">
	<a href="javascript:open_window_by_i(<?=$i?>)"><img src="<?=$html->url('/') ?>img/maps/<?=$imageArr[$i] ?>.png" class="msr_icon"></a>
	
	<h3 class="msr_title"><a href="javascript:open_window_by_i(<?=$i?>)"><?=$event['Event']['title']?></a>
	
						<a href="#" class="scheduletoggle addToSchedule" style="<?php if ($onUserCalendar) { echo "display:none";} ?>">
						<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_add.png" class="msr_fav_icon"  />
						</a>
						
						<a href="#" class="scheduletoggle removeFromSchedule" style="<?php if (!$onUserCalendar) { echo "display:none";} ?>">
						<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_delete.png" class="msr_fav_icon"  />
			
						</a>
	
	
	</h3><p class="msr_time"><?=date('g:i a n/d/Y', strtotime($event['Event']['time_start']))?> at <?=$event['Event']['location']?>
	
	
	
	</p><p class="msr_desc"><?=$event['Event']['description']?>  Posted by <?= $this->element('grouppath', array('groupStr' => $event['EventGroup']['path'], 'highestName' => $event['EventGroup']['highest_name']))?></p>
	
	<div id="<?=$i?>_infowindow" style="display: none">
	
				<div class="event_block<?php if ($onUserCalendar) echo " onCalendar"; ?>" id="event-<?=$event['Event']['id']?>">
            	
					<div class="hiddenid"><?=$event['Event']['id']?></div>
            	
					<div class="event_top_row">
						
						<div style="display:none" id="latitude"><?=$event['Event']['latitude']?></div>
						<div style="display:none" id="longitude"><?=$event['Event']['longitude']?></div>
						<span class="event_title">
							<?php echo $html->link($event['Event']['title'], array('controller' => 'events', 'action' => 'view', $event['Event']['id']), array('class' => "group_".$event['EventGroup']['id'])); ?>
						</span> 
						
						&nbsp; 
						
						
						
						<span class="event_time">
								<?php  
								$start_time = strtotime($event['Event']['time_start']);
								$end_time = strtotime($event['Event']['time_start']) + $event['Event']['duration'] * 60;
								
								/*if( date('a', $start_time) ==  date('a', $end_time) )
								{
									echo date('g:i', $start_time) . " to " . date('g:i a', $end_time);
								}
								else
								{*/
									echo date('g:i a', $start_time) . " to " . date('g:i a', $end_time);
								
								
								  ?>
							</span>
						<?php if (!empty($event['Event']['location'])) {?>
							<span class="event_location">
								at <?=$event['Event']['location']?>
							</span>
						<?php }?>
						
						<a href="#" class="scheduletoggle addToSchedule" style="<?php if ($onUserCalendar) { echo "display:none";} ?>">
						<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_add.png" class="timeline_icon"  />
						</a>
						
						<a href="#" class="scheduletoggle removeFromSchedule" style="<?php if (!$onUserCalendar) { echo "display:none";} ?>">
						<img src="<?php echo $html->url('/'); ?>css/rinoa/favorites_delete.png" class="timeline_icon"  />
			
						</a>
						 
						
							
						<div class="clear"></div>	
					</div>
                <div>
                        
                        <span class="event_description"><?=$event['Event']['description']?> Posted by <?= $this->element('grouppath', array('groupStr' => $event['EventGroup']['path'], 'highestName' => $event['EventGroup']['highest_name']))?></span>
                        
                </div>        
                
                <div><span class="event_tags group_<?=$event['EventGroup']['id']?>">
								
								<?php if (!empty($event['Event']['tags'])) {
									
									echo "Tags: ";
									
									$tagArr = explode(",", $event['Event']['tags']);
									foreach ($tagArr as $tag) {
										echo "<a href='#' class='tagLink'>".trim($tag)."</a> ";
									}
								}?>
						</span></div>
                <!-- <div style="float: right">
                
                in <span class="event_path"></span>
                </div>

                    <div class="clear"></div> -->

                </div> 
                
                <!-- end event block -->
	
	
	</div>
	
	</div>
	 <?php
	$i++;
	if ($i >= count($imageArr)) $i = count($imageArr)-1; 
	$odd = !$odd;
}?>
</div>
</div>


<div id="desktop_map_container">


</div>
</div>

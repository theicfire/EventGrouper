<!-- <?php print_r($eventsUnderGroup); ?> lol -->

<div id="desktop_map_window">
<div id="desktop_map_event_list">
<h2>Search Results</h2>

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
					?><?php while (true) {
									$event = $eventsUnderGroup[$i];
									$onUserCalendar = false;
									if ($session->check('userid') && array_key_exists('onUsersCalendar',$event['Event']))
										$onUserCalendar = true;
									
								?>
									
									<div class="event_block<?php if ($onUserCalendar) echo " onCalendar"; ?>" id="event-<?=$event['Event']['id']?>" style="font-size: 10px;">
									
									<div class="hiddenid"><?=$event['Event']['id']?></div>
									
									<div>
										
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
												<br />
												<span class="event_group">posted by <?= $this->element('grouppath', array('groupStr' => $event['EventGroup']['path']))?></span>

												<span style="display: none;" class="event_tags group_<?=$event['EventGroup']['id']?>">
					<!--									posted by <a href="<?php echo $html->url("/".$event['EventGroup']['path']);?>" class="group_<?=$event['EventGroup']['id']?>"><?php echo $event['EventGroup']['name']; ?></a>-->
														
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
									<div style="display: none;">
											
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
</div>


<div id="desktop_map_container">


</div>
</div>




<?php $javascript->link('jqueryui/jquery-ui-1.8.5.custom.min.js', false); ?>
<?php $javascript->link('jqueryui/jquery.ui.timeselector.js', false); ?>
<?php $javascript->link('timeline.js', false); ?>
<?php echo $html->css('timeline', 'stylesheet', array('media'=>'all' ), false); ?>
<?php 
//goes in style tags
echo "<style type='text/css'>";
//goes in style tags
$pathLength = array();
foreach ($eventGroups as $eventGroup) {
	$pathLength[count(explode('/',$eventGroup['EventGroup']['path']))][] = $eventGroup['EventGroup']['path'];
}
$minLength = min(array_keys($pathLength));
$colorList = array('C00', '360', '606', '009', '630', '033', 'f60', 'C09');
foreach ($eventGroups as $eventGroup) {
	$idIndex = array_search($eventGroup['EventGroup']['path'], $pathLength[$minLength]);
	if ($idIndex ==null) {
		for ($i = 0; $i < count($pathLength[$minLength]); $i++) {
			if (preg_match("@".$eventGroup['EventGroup']['path']."@", $pathLength[$minLength][$i])) {//todo make sure the @ symbol is not in the path
				$idIndex = $i;
				break;
			}
		}
	}
	echo "a.group_".$eventGroup['EventGroup']['id']." { color: #".$colorList[$idIndex]."; }\n";
	echo ".group_".$eventGroup['EventGroup']['id']." a { color: #".$colorList[$idIndex]."; }\n";
}
echo "</style>";
?>

    <div id="conference_header">
    	
    
    	<div id="ch_left">
        <div id="ch_right">
        	<div class="curr_time_large"><span class="is_currently">It's currently</span> <span id="curr_time">7:55 pm</span> <span id="curr_date">August 27, 2010</span></div>
        </div>
		<!--<ul>
			<li><?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'create')) {
				echo $html->link(__('Add EventGroup Under This', true), array('action' => 'add', $currenteventGroup['EventGroup']['id'])); 
			}?> </li>
			<li><?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'create')) {
				echo $html->link(__('Add Event Under This', true), array('controller' => 'events', 'action' => 'add', $currenteventGroup['EventGroup']['id'])); 
			}?> </li>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'update')) {
				echo $html->link(__('Edit', true), array('action' => 'edit', $currenteventGroup['EventGroup']['id'])); 
			}?>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'delete')) {
				echo $html->link(__('Delete', true), array('action' => 'delete', $currenteventGroup['EventGroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $currenteventGroup['EventGroup']['id'])); 
			}?>
			<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'editperms')) {
				echo $html->link(__('Edit Permissions', true), array('controller' => 'permissions', 'action' => 'view', $currenteventGroup['EventGroup']['id']));
			}?>
		</ul>-->
        	<!--<div id="chl_organization"><a href="#">REX (Residence Exploration)</a></div>-->
        	
            <div id="chl_title"><?php echo $currenteventGroup['EventGroup']['name']; ?></div>
            
            <div id="chl_address"><?php echo $currenteventGroup['EventGroup']['description']; ?></div>
            
            <?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'create')) {
				//echo $html->link(__('Edit in admin panel', true), array('action' => 'edit', $currenteventGroup['EventGroup']['id'])); 
				
				?> <a class="make_button" href="<?php echo $html->url("/event_groups/view_admin/" . $currenteventGroup['EventGroup']['path']); ?>">
				<img src="<?php echo $html->url('/'); ?>css/rinoa/document_edit.png" class="small_icon_inline_button" /> Edit in admin panel</a> <?php
			}?>
        </div>
        
        
        
        <div class="clear"></div>
    </div>
    
    <!--<div class="mini_event_stream_horizontal">
    	<div id="mes_header">Coming up</div>
        <ul class="mes_list">
        	<li class="mes_item">Item</li>
            <li class="mes_item">Item</li>
            <li class="mes_item">Item</li>
            <li class="mes_item">Item</li>
            <li class="mes_item">Item</li>
            <li class="mes_item">Item</li>
            <li class="mes_item">Item</li>
            <li class="mes_item">Item</li>
            <li class="mes_item">Item</li>
        </ul>
        <div class="clear"></div>
    </div>-->
    
    <div id="main_tabs">
    <ul id="mt_list">
        <li class="mt_tab"><a class="active" href="#" id="gotoall">Timeline</a></li> 
        <li class="mt_tab"><a href="#" id="gotoschedule">
        	<?php echo $session->check('userid')?"Favorites":"Login to view your favorites";?>
		</a></li>
    </ul>
    <div class="clear"></div>
    </div>
    
    <div id="timeline_content">
    
        <div id="tl_navigation">
            <div id="breadcrumb">
                <div class="nav_title">currently viewing</div>
                <div class="nav_links">
                <?= $this->element('grouppath', array('groupStr' => $currenteventGroup['EventGroup']['path']))?>
				</div>
            </div>
        
            <div id="subgroups">
                <div class="nav_title">groups inside "<?=$currenteventGroup['EventGroup']['name'];?>"</div>
                <div class="nav_links">
<!--                    <a href="#" class="group_1">Burton-Conner</a> -->
<!--                    <a href="#" class="group_2">Next House</a> -->
<!--                    <a href="#" class="group_3">Random Hall</a> -->
<!--                    <a href="#" class="group_4">New House</a>-->
                    <?php 
					$linksArr = array();
					foreach ($eventGroups as $eventGroup) {
						if(in_array($eventGroup['EventGroup']['path'], $pathLength[$minLength])) {
							$linksArr[] = $html->link($eventGroup['EventGroup']['name'], "/".$eventGroup['EventGroup']['path'], array('class' => "group_".$eventGroup['EventGroup']['id']));
						}
					}
					echo implode($linksArr," ");
					?>
                </div>
            </div>     

            <div class="clear"></div>
        </div>
    
    <script type="text/javascript">

		var width_set = false;

		$(document).ready( page_init );

		function page_init(){
		$(".button_large").button();
		$(".button_small").button();
		
		$(".ui-button-text").css("padding", "4px");
		}
		</script>
    
    <div id="r_main_ribbon_container">
    
    	<div class="r_ribbon_box" id="view_mode" priority="1000">
        	<div class="r_rb_title">View Mode</div>
            
            <div class="r_rb_left_bottom"></div>
            <div class="r_rb_right_bottom"></div>
            
            <div class="r_priority_box">
            	
                <a href="#" class="button_large"><img src="<?php echo $html->url('/'); ?>css/rinoa/report.png" /><br /><label class="button_label">List</label></a>
                <a href="#" class="button_large"><img src="<?php echo $html->url('/'); ?>css/rinoa/web.png" /><br /><label class="button_label">Map</label></a>
                <a href="#" class="button_large"><img src="<?php echo $html->url('/'); ?>css/rinoa/favorites.png" /><br /><label class="button_label">Favorites</label></a>
            
            </div>
            
        </div>
        
         <div class="r_ribbon_box" id="filters" priority="800">
        	<div class="r_rb_title">Filters</div>
            
            <div class="r_rb_left_bottom"></div>
            <div class="r_rb_right_bottom"></div>
            
            <div class="r_priority_box" id="filter_time">
            	
                <div class="r_third_text_row">Time <a id="filter_auto_time_small" href="#" class="button_small" style="margin-bottom: -5px; display:none;"><label class="button_label">Options</label><div class="r_down_arrow_container"><span class="ui-icon ui-icon-triangle-1-s"></span></div></a></div>
               	<form >
                <div class="r_rb_form_row"><img src="<?php echo $html->url('/'); ?>css/rinoa/clock.png" class="r_mini_icon" /> <label class="form_label">Time</label> <select name="time_start" id="time_start" class="putInHash input_text">
                        	<option value="0">midnight</option>
                            <option value="1">1:00 am</option>
                            <option value="2">2:00 am</option>
                            <option value="3">3:00 am</option>
                            
                            <option value="4">4:00 am</option>
                            <option value="5">5:00 am</option>
                            <option value="6">6:00 am</option>
                            <option value="7">7:00 am</option>
                            
                            <option value="8">8:00 am</option>
                            <option value="9">9:00 am</option>
                            <option value="10">10:00 am</option>
                            <option value="11">11:00 am</option>
                            
                            <option value="12">noon</option>
                            <option value="13">1:00 pm</option>
                            <option value="14">2:00 pm</option>
                            <option value="15">3:00 pm</option>
                            
                            <option value="16">4:00 pm</option>
                            <option value="17">5:00 pm</option>
                            <option value="18">6:00 pm</option>
                            <option value="19">7:00 pm</option>
                            
                            <option value="20">8:00 pm</option>
                            <option value="21">9:00 pm</option>
                            <option value="22">10:00 pm</option>
                            <option value="23">11:00 pm</option>
                        </select></div>
                <div class="r_rb_form_row"><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png" class="r_mini_icon" /> <label class="form_label">Date</label> <input type="text" name="date_start" id="datestart" class="input_text putInHash" style="width: 70px;" value="7/23/2010" /></div>                
                </form>
            
            </div>
            
            <div class="r_priority_box" id="filter_auto_time_big">
            	
                <div class="r_third_text_row">Auto Time</div>
                <a href="#" class="button_small"><label class="button_label">Now</label></a>
                <a href="#" class="button_small"><label class="button_label">Today</label></a><br />
                <a href="#" class="button_small"><label class="button_label">First Day</label></a>
            
            </div>
            
            <div class="r_priority_box" id="filter_text">
            	
                <div class="r_third_text_row">Text</div>
                <div class="r_rb_form_row"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png" class="r_mini_icon" /> <label class="form_label">Keywords</label> <input type="text" name="search" id="searchBox" class="putInHash input_text" style="width: 90px;" /></div>              

                <div class="r_form_tip" id="text_tip_large">Search in currently displayed events.<br />For example: "food" or "tour"</div>
                <div class="r_form_tip" id="text_tip_small" style="display: none;">Example: "food" or "tour"</div>
            <input type="checkbox" class="putInHash" name="isCalendar" id="isCalendar" style="display:none">
            </div>
            
             <div class="r_priority_box" id="refresh_button">
            	
                <a href="#" class="button_large" id="filter_submit"><img src="<?php echo $html->url('/'); ?>css/rinoa/refresh.png" /><br /><label class="button_label">Refresh</label></a><br />
                <a href="#" class="button_small" id="filter_reset"><label class="button_label">Reset</label></a>
            
            </div>
            
            
            
        </div>
        
        <div class="r_ribbon_box" id="my_account" priority="1200">
        	<div class="r_rb_title">My Account</div>
            
            <div class="r_rb_left_bottom"></div>
            <div class="r_rb_right_bottom"></div>
            
            <div class="r_priority_box">
            	
                <div class="r_third_text_row">Hello, sashko@mit.edu</div>
                <a href="#" class="button_small"><img src="<?php echo $html->url('/'); ?>css/rinoa/user.png" /><label class="button_label">Account Options</label><div class="r_down_arrow_container"><span class="ui-icon ui-icon-triangle-1-s"></span></div></a><br />
                <a href="#" class="button_small"><img src="<?php echo $html->url('/'); ?>css/rinoa/unlock.png" /><label class="button_label">Log Out</label></a>
            
            </div>
            
        </div>
        
       
        
        <div class="r_ribbon_box" id="administration" priority="901">
        	<div class="r_rb_title">Administration</div>
            
            <div class="r_rb_left_bottom"></div>
            <div class="r_rb_right_bottom"></div>
            
            <div class="r_priority_box">
            	
                <div class="r_third_text_row">You can add events here.</div>
                <a href="#" class="button_small"><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png" /><label class="button_label">Add Event</label></a><br />
                <a href="#" class="button_small"><img src="<?php echo $html->url('/'); ?>css/rinoa/applications.png" /><label class="button_label">Go to Admin Panel</label></a>
            
            </div>
            
        </div>
        
        <div class="r_ribbon_box" id="log_in" style="display: none;" priority="900">
        	<div class="r_rb_title">Log In</div>
            
            <div class="r_rb_left_bottom"></div>
            <div class="r_rb_right_bottom"></div>
            
            <div class="r_priority_box">
            	
               	<form >
                <div class="r_rb_form_row"><input type="text" class="input_text" /> <label>Email</label></div>
                <div class="r_rb_form_row"><input type="text" class="input_text" /> <label>Password</label></div>
                
                <a href="#" class="button_small"><img src="<?php echo $html->url('/'); ?>css/rinoa/user.png" /><label class="button_label">Log In</label></a>
                <a href="#" class="button_small"><img src="<?php echo $html->url('/'); ?>css/rinoa/user_add.png" /><label class="button_label">Register</label></a>
                
                </form>
            
            </div>
            
        </div>
    
    
    
    </div>
    
    
    	<div id="split">
        <table id="main_view_table">
        
        	<tr class="mvt_head"><td colspan="2" class="timeline_cell">
            	<!-- <div class="tl_head" id="filters_box">
                    <form action="timeline.html" id="filterForm" method="get">
                    <div class="head_float_group_box">
                        <div class="tl_head_title">Time</div>
                        <div class="tl_head_subt">choose a time period to display</div>
                        <table class="padded_grid">
                        <tr><td>from:</td><td>
                        
                        <select name="time_start" id="time_start" class="putInHash textinput">
                        	<option value="0">midnight</option>
                            <option value="1">1:00 am</option>
                            <option value="2">2:00 am</option>
                            <option value="3">3:00 am</option>
                            
                            <option value="4">4:00 am</option>
                            <option value="5">5:00 am</option>
                            <option value="6">6:00 am</option>
                            <option value="7">7:00 am</option>
                            
                            <option value="8">8:00 am</option>
                            <option value="9">9:00 am</option>
                            <option value="10">10:00 am</option>
                            <option value="11">11:00 am</option>
                            
                            <option value="12">noon</option>
                            <option value="13">1:00 pm</option>
                            <option value="14">2:00 pm</option>
                            <option value="15">3:00 pm</option>
                            
                            <option value="16">4:00 pm</option>
                            <option value="17">5:00 pm</option>
                            <option value="18">6:00 pm</option>
                            <option value="19">7:00 pm</option>
                            
                            <option value="20">8:00 pm</option>
                            <option value="21">9:00 pm</option>
                            <option value="22">10:00 pm</option>
                            <option value="23">11:00 pm</option>
                        </select>
                        
                        <input name="date_start" id="datestart" class="textinput putInHash" type="text" value="01/27/2010"></td></tr>
                        
                        </table>
                    </div>
                    <div class="head_float_group_box">
                        <div class="tl_head_title">Search</div>
                        <div class="tl_head_subt">look for something</div>
                       	<input name="search" type="text" id="searchBox" class="putInHash">
                    </div> 
                    <input type="checkbox" class="putInHash" name="isCalendar" id="isCalendar" style="display:none">
                    
                    <div class="clear"></div>
                    <a id="filter_submit"><img src="<?php echo $html->url('/css/'); ?>rinoa/refresh.png" class="small_icon_inline_button" /> Save options and refresh</a>
                    
                    </form>
                        
                        
                        
                    <div class="clear"></div>
                </div>
            </td><td class="mys_cell">
            	<div id="mys_head" class="tl_head">
                	<div class="tl_head_title"><a href="#">My Schedule</a></div>
                    <div class="tl_head_subt">add events here, then:</div>
                    <table class="padded_grid">
                    <tr><td><a href="#">send to phone</a></td><td><a href="#">view my schedule</a></td></tr>
                    <tr><td><a href="#">print schedule</a></td><td><a href="#">export to calendar</a></td></tr>
                    </table>
                </div> -->
            </td></tr>
            
            <!--<tr><td class="timeslot_title"></td><td class="timeline_cell"><a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/up.png" class="small_icon_inline_button" />Show previous events</a>
            
            <div class="clear"></div>
            </td><td class="mys_cell"></td></tr>-->
            
           
            
<!--            Now the events go here-->
            
            
            </table>
            <?php echo $html->image('loading.gif', array('id' => 'loadingimage'));?>
            <table class="ajax_events" id="eventHolder">
        	</table>
        	
        <table width="100%">
        
        
        
        <!--<tr><td class="timeslot_title"></td><td class="timeline_cell"><a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/down.png" class="small_icon_inline_button" />Show more events</a>
            
            <div class="clear"></div>
            </td><td class="mys_cell"></td></tr> -->
        
        </table> <!-- end main view table -->
        </div>
    
    </div>
    




<?php $javascript->link('jqueryui/jquery-ui-1.8.5.custom.min.js', false); ?>
<?php $javascript->link('jqueryui/jquery.ui.timeselector.js', false); ?>
<?php $javascript->link('timeline.js', false); ?>
<?php echo $html->css('timeline', 'stylesheet', array('media'=>'all' ), false); ?>

<?php 
//goes in style tags
echo "<style type='text/css'>";
//goes in style tags
$colorList = array('C00', '360', '606', '009', '630', '033', 'f60', 'C09');
$i = 0;
foreach ($eventGroups as $eventGroup) {
echo "a.group_".$eventGroup['EventGroup']['id']." { color: #".$colorList[$i]."; }\n";
echo "group_".$eventGroup['EventGroup']['id']." a { color: #".$colorList[$i]."; }\n";
$i++;
if ($i == count($colorList)) $i = 0;
}
echo "</style>";
?>


    <div id="conference_header">
    	
    
    	<div id="ch_left">
        <div id="ch_right">
        	<div class="curr_time_large">It's currently <span id="curr_time">7:55 pm</span> on <span id="curr_date">August 27, 2010</span></div>
        </div>
		<ul>
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
		</ul>
        	<div id="chl_organization"><a href="#">REX (Residence Exploration)</a></div>
            <div id="chl_title"><?php echo $currenteventGroup['EventGroup']['name']; ?></div>
            <div id="chl_address">At the core of the MIT housing experience is a powerful sense of community. Every undergraduate and graduate residence offers its own rich social network, a distinct culture, lifestyle, and perspective. The goal of the MIT Housing Office is to keep those residences functioning and the communities and within them thriving. And to give students the freedom and flexibility to decide where they would most like to put down roots.</div>
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
    	<li class="mt_tab"><a href="#">Overview</a></li>
        <li class="mt_tab"><a class="active" href="#">Timeline</a></li>
        <li class="mt_tab"><a href="#">Map</a></li>
    </ul>
    <div class="clear"></div>
    </div>
    
    <div id="timeline_content">
    
        <div id="tl_navigation">
            <div id="breadcrumb">
                <div class="nav_title">currently viewing</div>
                <div class="nav_links">
                <?= $this->element('grouppath', array('groupPath' => $groupPath))?>
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
						$linksArr[] = $html->link($eventGroup['EventGroup']['name'], "/".$eventGroup['EventGroup']['path'], array('class' => "group_".$eventGroup['EventGroup']['id']));
					}
					echo implode($linksArr," ");
					?>
                </div>
            </div>     

            <div class="clear"></div>
        </div>
    
    
    
    	<div id="split">
        <table id="main_view_table">
        
        	<tr class="mvt_head"><td colspan="2" class="timeline_cell">
            	<div class="tl_head" id="filters_box">
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
                        <div class="tl_head_title">Categories</div>
                        <div class="tl_head_subt">choose which categories to display</div>
                        <table class="padded_grid">
                        <tr>
                        <?php 
                        $i = 0;
                        foreach (array_keys($categoryChoices) as $key) {
	                        ?>
	                        <td><div class="checkbox_container"><input class="categorycheckbox putInHash" name="categories[]" value="<?=$key?>" id="categorycheckbox-<?=$key?>" type="checkbox"> <?=$categoryChoices[$key]?></div></td>
	                        <?php 
	                        if ($i == 2) {
	                        	echo "</tr><tr>";
	                        	$i = 0;	
	                        }
                        }?>
                        </tr>
                        </table>
                    </div>   
                    <div class="head_float_group_box">
                        <div class="tl_head_title">Search</div>
                        <div class="tl_head_subt">look for something</div>
                       	<input name="search" type="text" id="searchBox" class="putInHash">
                    </div> 
                    <input type="checkbox" class="putInHash" name="isCalendar" id="isCalendar" style="display:none">
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
                </div>
            </td></tr>
            
            <tr><td class="timeslot_title"></td><td class="timeline_cell"><a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/up.png" class="small_icon_inline_button" />Show previous events</a>
            
            <div class="clear"></div>
            </td><td class="mys_cell"></td></tr>
            
           
            
<!--            Now the events go here-->
            
            
            </table>
            <table style="width:100%" id="eventHolder">
            
        	</table>
        <table width="100%">
        
        
        
        <tr><td class="timeslot_title"></td><td class="timeline_cell"><a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/down.png" class="small_icon_inline_button" />Show more events</a>
            
            <div class="clear"></div>
            </td><td class="mys_cell"></td></tr>
        
        </table> <!-- end main view table -->
        </div>
    
    </div>
    

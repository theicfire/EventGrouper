


<?php $javascript->link('jqueryui/jquery-ui-1.8.5.custom.min.js', false); ?>
<?php $javascript->link('jqueryui/jquery.ui.timeselector.js', false); ?>
<?php $javascript->link('timeline.js', false); ?>

<script type="text/javascript"
    src="http://maps.google.com/maps/api/js?sensor=false">
</script>

<?php echo $html->css('timeline', 'stylesheet', array('media'=>'all' ), false); ?>
<?php 
$pathLength = array();
foreach ($eventGroups as $eventGroup) {
	$pathLength[count(explode('/',$eventGroup['EventGroup']['path']))][] = $eventGroup['EventGroup']['path'];
}
$minLength = 0;
if (!empty($pathLength))
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
}
?>
    
    <div id="main_tabs"> <h1 id="conference_title"><?=$currenteventGroup['EventGroup']['name'];?></h1>
    <ul id="mt_list">
        <li class="mt_tab"><a class="active" href="#" id="gotoall">Timeline</a></li> 
        <li class="mt_tab"><a href="#" id="gotoschedule">Favorites</a></li> 
		<li class="mt_tab"><a href="#" id="gotomap">Map</a></li>
		<div class="clear"></div>
    </ul>
    <div class="clear"></div>
    </div>
    
    <div id="timeline_content">
    
    
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
        	<div class="r_rb_title">Currently Viewing</div>
            
            <div class="r_rb_left_bottom"></div>
            <div class="r_rb_right_bottom"></div>
            
            <div class="r_priority_box">
            	
                <div id="breadcrumb">
					<div class="nav_title">currently viewing</div>
					<div class="nav_links">
					<?= $this->element('grouppath', array('groupStr' => $currenteventGroup['EventGroup']['path'], 'highestName' => $currenteventGroup['EventGroup']['highest_name']))?>
					</div>
				</div>
			
				<div id="subgroups">
					<div class="nav_title">groups inside "<?=$currenteventGroup['EventGroup']['name'];?>"</div>
					<div class="nav_links">
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
                <div class="r_rb_form_row"><img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png" class="r_mini_icon" />
                <?php if (!empty($eventsUnderGroup))
                		$dateIn = date('m/d/Y', strtotime($eventsUnderGroup[0]['Event']['time_start']));
                	else
                		$dateIn = date('m/d/Y');?> 
                <label class="form_label">Date</label> <input type="text" name="date_start" id="datestart" class="input_text putInHash" style="width: 70px;" 
                	value="<?=$dateIn?>" />
                </div>  
                <input type="hidden" id="date_start_default" value="<?=$dateIn?>">
                </form>
            
            </div>
            
            <div class="r_priority_box" id="filter_auto_time_big" style="display: none">
            	
                <div class="r_third_text_row">Auto Time</div>
                <a href="#" class="button_small"><label class="button_label">Now</label></a>
                <a href="#" class="button_small"><label class="button_label">Today</label></a><br />
                <a href="#" class="button_small"><label class="button_label">First Day</label></a>
            
            </div>
            
            <div class="r_priority_box" id="filter_text">
            	
                <div class="r_third_text_row">Text</div>
                <div class="r_rb_form_row"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png" class="r_mini_icon" /> <label class="form_label">Keywords</label> <input type="text" name="search" id="searchBox" class="putInHash input_text" style="width: 90px;" /></div>              

                <div class="r_form_tip" id="text_tip_large">Search in currently displayed events.<br />For example: "food" or "tour"</div>
                <div class="r_form_tip" id="searcherr">Please search for at least 4 letters</div>
<!--            <input type="checkbox" class="putInHash" name="isCalendar" id="isCalendar" style="display:none">-->
            <input type="hidden" class="putInHash" name="viewType" id="viewType" value="">
            </div>
            
             <div class="r_priority_box" id="refresh_button">
                <a href="#" class="button_large" id="filter_submit"><img src="<?php echo $html->url('/'); ?>css/rinoa/refresh.png" /><br /><label class="button_label">Refresh</label></a><br />
                <a href="#" class="button_small" id="filter_reset"><label class="button_label">Reset</label></a>
                <a href="#" class="button_small" id="filter_reset_date"><label class="button_label">First Day</label></a>
            
            </div>
            
            
            
        </div>
        
        
    
    <div class="clear"></div>
    
    </div>
    
    
    	<div id="split">
        
            <?php echo $html->image('loading.gif', array('id' => 'loadingimage'));?>
            <div class="ajax_events" id="eventHolder">
        	</div>
        </div>
    
    </div>
    

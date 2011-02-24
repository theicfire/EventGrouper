
<?php echo $html->css('event_page', 'stylesheet', array('media'=>'all' ), false); ?>
<style type="text/css">
      @import url("http://www.google.com/uds/css/gsearch.css");
</style>
<?php $javascript->link('jqueryui/jquery-ui-1.8.5.custom.min.js', false); ?>
<?php $javascript->link('jqueryui/jquery.ui.timeselector.js', false); ?>
<?php $javascript->link('timeline.js', false); ?>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<?php echo $html->css('timeline', 'stylesheet', array('media'=>'all' ), false); ?>
<?php //this needs to be cleaned up/explained
$pathLength = array();
foreach ($eventGroups as $eventGroup) {
	$pathLength[count(explode('/',$eventGroup['EventGroup']['path']))][] = $eventGroup['EventGroup']['path'];
}
$minLength = 0;
if (!empty($pathLength))  $minLength = min(array_keys($pathLength));
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
<div id="fixed_top"> <?php //stuff at the top ?>
	<div id="noscroll">
	
	<div id="main_tabs"> 
			<ul id="mt_list">
				<li class="mt_tab"><a class="active" href="#" id="gotoall"><?=$currenteventGroup['EventGroup']['highest_name']?></a></li> <?php //possibly add icons to the other tabs ?>
				<li class="mt_tab"><a href="#" id="gotoschedule"><img src="<?php echo $html->url('/'); ?>css/rinoa/favorites.png" class="tab_icon"  /> Favorites</a></li> 
				<div class="clear"></div>
			</ul>
			<div class="clear"></div>
		</div> 
	
	<div id="conference_info">
	
		<a id="minimize_link" href="javascript:toggle_top()" style="float: right">- minimize box</a>
		<a id="maximize_link" href="javascript:toggle_top()" style="float: right; display: none;">+ maximize box</a>
		<h1 id="conference_title"><?=$currenteventGroup['EventGroup']['name'];?></h1>
		
		<div id="top_stuff_toggle">
		<p><?php echo $currenteventGroup['EventGroup']['description'];?></p>
		
		<?php //still not sure what this does...
			$linksArr = array();
			foreach ($eventGroups as $eventGroup) {
				if(in_array($eventGroup['EventGroup']['path'], $pathLength[$minLength])) {
					$linksArr[] = $html->link($eventGroup['EventGroup']['name'], "/".$eventGroup['EventGroup']['path'], array('class' => "group_".$eventGroup['EventGroup']['id']));
				}
			}
		?>
					
		<?php if( count($linksArr) > 0 ) { //if there are subgroups... ?>
		
		<script type="text/javascript">
		
		function toggle_subgroups()
		{
			$(".subgroups_drop_content").slideToggle("fast", function () {
		
		$(window).trigger("resize");
		
		});
			$("#sd_icon_closed").toggle();
			$("#sd_icon_open").toggle();
		}
		
		</script>
			
			<div id="subgroups">
				<div class="subgroups_drop"><a href="javascript:toggle_subgroups()" id="subgroups_drop_link"><span id="sd_icon_closed" class='ui-icon ui-icon-triangle-1-e' style='float: left; margin-right: 5px;'></span><span id="sd_icon_open" class='ui-icon ui-icon-triangle-1-s' style='float: left; margin-right: 5px; display: none;'></span> Subgroups of <?=$currenteventGroup['EventGroup']['name'];?> (<?=count($linksArr)?>) </a>
				
				<div class="subgroups_drop_content pathLinks" style="display: none;">
					
					<?php
					echo implode($linksArr," ");
					?>
				</div>
				
				</div>
				<div class="clear"></div>
			</div>
		<?php } ?>
		
		
		</div>
		<?php if ($access->check('EventGroup',$currenteventGroup['EventGroup']['id'], 'create')) {
			echo $html->link('Edit this group', "/event_groups/view_admin/".$currenteventGroup['EventGroup']['path']);
		}?>
			
	</div>
		
		
	</div>
    
    <div id="scroll_locator"></div> <?php //used to determine whether or not the #scroll div should float above the list or not ?>
    
    <div style="position: relative;">
		<div id="scroll" >
			<div id="toolbar_small_shadow"></div>
			<div id="r_main_ribbon_container">
				<div id="timelineOnly" style="display:none">
				<div id="breadcrumb" style="float: left;" >
					<div class="nav_title">currently viewing</div>
					<div class="nav_links">
					<?= $this->element('grouppath', array('groupStr' => $currenteventGroup['EventGroup']['path'], 'highestName' => $currenteventGroup['EventGroup']['highest_name']))?>
					</div>
				</div>
				
				<div class="filter_buttons">
					<a href="#" class="viewMap button_small" style="display:none"><img src="<?php echo $html->url('/'); ?>css/rinoa/web.png" /><label class="button_label">Map View</label></a>
					<a href="#" class="viewList button_small" style="display:none"><img src="<?php echo $html->url('/'); ?>css/rinoa/document.png" /><label class="button_label">List View</label></a>	
				</div>
				
				<?php //hidden fields to put in the hash ?>
				<input type="hidden" class="putInHash" name="viewType" id="viewType" value="" />
				<input type="hidden" class="putInHash" name="viewId" id="viewId" value="" />
				<input type="hidden" class="putInHash" name="mapViewId" id="mapViewId" value="" />
				<input type="hidden" class="putInHash" name="p" id="p" value="1" />

				<div class="filter_section">
					<img src="<?php echo $html->url('/'); ?>css/rinoa/clock.png" class="filter_icon" alt="Time:" title="Time" /> <label class="form_label">Time</label> <select name="time_start" id="time_start" class="putInHash input_text">
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
				</div>
												
				<div class="filter_section">
					<?php //default date is first event in the list
					if (!empty($eventsUnderGroup)) { $dateIn = date('m/d/Y', strtotime($eventsUnderGroup[0]['Event']['time_start'])); }
					else { $dateIn = date('m/d/Y'); }
					?> 
					
					<img src="<?php echo $html->url('/'); ?>css/rinoa/calendar.png" alt="Date:" title="Date" class="filter_icon" />
					<label class="form_label">Date</label> <?php //label is made invisible with CSS ?>
					<input type="text" name="date_start" id="datestart" class="input_text putInHash" style="width: 100px;" value="<?=$dateIn?>" />
					<input type="hidden" id="date_start_default" value="<?=$dateIn?>">
				</div>
				
				<div class="filter_section">
					<img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png" class="filter_icon" title="Search" alt="Search:" />
					<label class="form_label">Search</label>
					<input type="text" name="search" id="searchBox" class="putInHash input_text" style="width: 100px;" /> 
					<div class="r_form_tip" id="searcherr">Please search for at least 4 letters</div> <?php // needs to be styled better... ?>
				</div>
					
				<div class="filter_buttons">
					<a href="#" class="button_small" id="filter_submit"><img src="<?php echo $html->url('/'); ?>css/rinoa/refresh.png" /><label class="button_label">Update</label></a>
					<a href="#" class="button_small" id="filter_reset"><label class="button_label">Reset</label></a>
					<a href="#" class="button_small" id="filter_reset_date"><label class="button_label">First Day</label></a>
					<!-- add a now button -->
					<a href="javascript:prev_page()" class="button_small" id="prevpage"><label class="button_label">Previous Page</label></a>
					<a href="javascript:next_page()" class="button_small" id="nextpage"><label class="button_label">Next Page</label></a>
				</div>
				</div>
				<div id="favoritesOnly" style="display:none">
				<div class="filter_section">These are your favorites.</div>
				<div class="filter_buttons">
					<a href="#" class="viewMap button_small" style="display:none"><img src="<?php echo $html->url('/'); ?>css/rinoa/web.png" /><label class="button_label">Map View</label></a>
					<a href="#" class="viewList button_small" style="display:none"><img src="<?php echo $html->url('/'); ?>css/rinoa/document.png" /><label class="button_label">List View</label></a>	
				</div>
				</div>
				<div class="clear"></div>
				
				
			</div>
				
<!--			<div id="favorites_ribbon" style="display: none;">-->
<!--				-->
<!--				<a href="#" id="viewMap">Map</a>-->
<!--				<a href="#" id="viewList">List</a>-->
<!--				<div class="clear"></div>-->
<!--			</div>-->
			
			<div class="clear"></div>
		</div>
	</div>
</div> <!-- end top stuff -->
    
<div id="spacer"></div>
    
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
    <div id="split">
		<?php echo $html->image('loading.gif', array('id' => 'loadingimage'));?>
		<div class="ajax_events" id="eventHolder"></div>
    </div>
</div>

<!--Event popup-->
<div id="event-popup" class="popup" title="Event Details">
	<?php echo $html->image('loading.gif', array('id' => 'eventloadingimage'));?>
	<div id="event-content"></div>
</div>
<!--End Event Popup-->

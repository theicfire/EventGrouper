
<?php 
//goes in style tags
//$colorList = array('C00', '360', '606', '009', '630', '033', 'f60', 'C09');
//$i = 0;
//foreach ($eventGroups as $eventGroup) {
//	echo "a.group_".$eventGroup['EventGroup']['id']." { color: #".$colorList[$i]."; }\n";
//	echo "group_".$eventGroup['EventGroup']['id']." a { color: #".$colorList[$i]."; }\n";
//	$i++;
//	if ($i == count($colorList)) $i = 0;
//}
?>

<?php $javascript->link('jqueryui/jquery-ui-1.8.5.custom.min.js', false); ?>
<?php $javascript->link('jqueryui/jquery.ui.timeselector.js', false); ?>
<script>

function addtoschedule( a_id )
{
	alert("add " + a_id + " to schedule");
}

function update_time()
{
	currentTime = new Date();
	var currentHours = currentTime.getHours ( );
	var currentMinutes = currentTime.getMinutes ( );
	var currentSeconds = currentTime.getSeconds ( );
	
	currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
	currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
	
	var timeOfDay = ( currentHours < 12 ) ? "am" : "pm";
	currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
	currentHours = ( currentHours == 0 ) ? 12 : currentHours;
	
	var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
	
	$("#curr_time").html(currentTimeString);
	
	var m_names = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	var curr_date = currentTime.getDate();
	var curr_month = currentTime.getMonth();
	var curr_year = currentTime.getFullYear();
	currentDateString = m_names[curr_month] + " " + curr_date + ", " + curr_year;
	
	$("#curr_date").html(currentDateString);
}

var floating = false;

function scroll_handler(event)
{
		/*console.log($(document).height()-($(document).scrollTop()+$(window).height()));*/
		if($("#top_locator").offset().top - $(document).scrollTop() < 10 )
		{
			left_distance = $("#top_locator").offset().left - $(document).scrollLeft();
			$("#right_floater").addClass("floating_box");
			$("#right_floater").css("left", left_distance);
		}
		else if($("#top_locator").offset().top - $(document).scrollTop() > 10 )
		{
			$("#right_floater").removeClass("floating_box");
		}
		
		if($("#which_day_container_locator").offset().top - $(document).scrollTop() < 10 )
		{
			left_distance = $("#which_day_container_locator").offset().left - $(document).scrollLeft() - 6;
			$("#which_day_container").addClass("day_floating_box");
			$("#which_day_container").css("left", left_distance);
			
			$("#which_day_container_locator").addClass("which_day_spacer");
		}
		else if($("#which_day_container_locator").offset().top - $(document).scrollTop() > 10 )
		{
			$("#which_day_container").removeClass("day_floating_box");
			$("#which_day_container_locator").removeClass("which_day_spacer");
		}
}
function giveEventsJs() {
//	$( ".timeline_cell" ).find(".event_block").draggable({ revert: "invalid", helper: "clone", opacity: .7, zIndex: 1000 });
//	$( ".timeline_cell" ).find(".event_block").css("cursor", "move");
//	
//	$( ".mys_cell" ).droppable({hoverClass: "mys_hover", activeClass: "mys_acceptor",
//		
//	drop: function(event, ui)
//	{
//		var hiddenid = $(ui.draggable).attr("hiddenid");
//		addtoschedule(hiddenid);
//		$(ui.draggable).fadeTo(1, .5);
//
//		$.ajax({url: "<?=$this->base?>/events/addToCalendar/"+hiddenid,
//			success: function() {
//				alert('added');
//			}
//		});
//	}
//		
//	});
	$(".scheduletoggle").click(function() {
		var eventBlock = $(this).parent().parent().parent(); 
		var id = eventBlock.attr('id').split("-")[1];
		var textEl = $(this);
		if (eventBlock.hasClass('onCalendar')) {
			$.ajax({url: "<?=$this->base?>/events/removeFromCalendar/"+id,
			success: function() {
				eventBlock.removeClass('onCalendar');
				eventBlock.addClass('offCalendar');
				textEl.html('add to schedule');				
			}
			});
		} else {
			$.ajax({url: "<?=$this->base?>/events/addToCalendar/"+id,
			success: function() {
				eventBlock.removeClass('offCalendar');
				eventBlock.addClass('onCalendar');
				textEl.html('remove from schedule');				
			}
			});

			
		}
		return false;
	});

	$(".categoryLink").click(function() {
		var id = $(this).attr('hiddenclass').split("-")[1];
		$(".categorycheckbox").each(function() {
			if ($(this).val() == id)
				$(this).attr('checked', true);
			else
				$(this).attr('checked', false);
		});
		refreshEvents();
		return false;
	});
}
function getEvents(date, search, categoryChoices, time_start) {
	$.get("<?php echo $html->url("/event_groups/ajaxListEvents/".$currenteventGroup['EventGroup']['id']);?>", { date_start: date, search: search, 'categories[]': categoryChoices, time_start:time_start},
   function(data){
     $("#eventHolder").html(data);
     giveEventsJs();
     
   });
}
function refreshEvents() {
	var categoryChoices = new Array();//need this so that if no categories are checked, nothing comes up
	$(".categorycheckbox:checked").each(function() {
		categoryChoices.push($(this).val());
	});
	
	getEvents($("#datestart").val(), $("#searchBox").val(), categoryChoices, $("#time_start").val());
	setHashFromPage();
}
function setHashFromPage(){
	var paramArr = [];
//	paramArr['id'] = $("#quizletId").val();
//	paramArr['transferSpeed'] = $("#moveToStackSpeed").val();
	$(".putInHash").each(function(){
		console.log('go');
		if(this.type!="checkbox"){
			paramArr[this.id]=$(this).val();
		}
		else{
			paramArr[this.id]=this.checked;
		}
	});
	var urlStrArr = [];
	console.log(paramArr);
	for (var key in paramArr) {
		urlStrArr.push(key+"="+paramArr[key]);
	}	
	location.hash = urlStrArr.join("&");
	console.log('done');
	
}
function setPageFromHash(){
	if (location.hash){
		hash =location.hash.substring(1);
		urlStrArr = hash.split("&");
		for (var key in urlStrArr) {
			var params = urlStrArr[key].split("=");
			if($("#"+params[0]).attr('type')!="checkbox"){
				$("#"+params[0]).val(params[1]);
			}
			else{
				$("#"+params[0]).attr('checked',params[1]=="true");
			}
		}
	}
}

$(document).ready( function(){
	
	$("#datestart").datepicker();
	$("#filterForm").submit(function() {
		refreshEvents();
		return false;
	});
	
	$(".previous_events_button").button();
	$("#filter_submit").button();
	
	$(".make_button").button();
	
	
	
//	$("#filter_submit").hide();
	
	$(window).scroll( scroll_handler );
	$(window).resize( scroll_handler );
	
	setInterval( "update_time()", 1000 );

	setPageFromHash();
	$("#filterForm").trigger('submit');

	
	
});


</script>

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
                <?php 
				$linksArr = array($html->link(__('Home', true), array('action' => 'index')));
				foreach ($groupPath as $single) {
					$linksArr[] = $html->link($single['EventGroup']['name'], "/".$single['EventGroup']['path']);
				}
				echo implode($linksArr," > ");
				?>
				</div>
            </div>
        
            <div id="subgroups">
                <div class="nav_title">groups inside "dorms"</div>
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
                        
                        <select name="time_start" id="time_start" class="putInHash">
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
                    
                    <input type="submit" value="Save options and refresh" id="filter_submit" />
                    
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
            
            <tr><td class="timeslot_title"></td><td class="timeline_cell"><a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/up.png" class="small_icon_inline_button" />Show events from the previous 3 hours</a>
            
            <div class="clear"></div>
            </td><td class="mys_cell"></td></tr>
            
            <tr><td class="timeslot_title"></td><td class="timeline_cell">
            <div id="which_day_container_locator"></div>
            <div id="which_day_container">
                <span id="which_day_is_it">Thursday, August 28</span>
                
                <a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/back.png" class="small_icon_inline_button" />Previous day</a><a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/go.png" class="small_icon_inline_button" />Next day</a>
            </div>
                
            </td><td class="mys_cell"><div class="mys_timeslot">
            <div id="top_locator"></div>
            
            </div></td></tr>
            
<!--            Now the events go here-->
            
            
            </table>
            <table style="width:100%" id="eventHolder">
            
        	</table>
        <table width="100%">
        
        
        
        <tr><td class="timeslot_title"></td><td class="timeline_cell"><a class="make_button" href="#"><img src="<?php echo $html->url('/css/'); ?>rinoa/down.png" class="small_icon_inline_button" />Show events from the next 3 hours</a>
            
            <div class="clear"></div>
            </td><td class="mys_cell"></td></tr>
        
        </table> <!-- end main view table -->
        </div>
    
    </div>
    
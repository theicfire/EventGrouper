<script type="text/javascript">

var positions = new Array();

$(document).ready( function () {

	front();
	
	$("#front_comp").click( front );
	$("#back_comp").click( back );

});

function orient_front()
{
	$("#front_comp").animate( { left: '37.5%', top: -50, width: 779, height: 641, marginLeft: '-390', zIndex: 2 } );
	
	$("#back_comp").animate( { left: '85%', top: 130, width: 350, height: 296, marginLeft: '-175', zIndex: 1 } );
}

function orient_back()
{
	$("#front_comp").animate( { left: '15%', top: 130, width: 350, height: 288, marginLeft: '-175', zIndex: 1 } );
	
	$("#back_comp").animate( { left: '62.5%', top: -50, width: 785, height: 664, marginLeft: '-392', zIndex: 2 } );
}

function front()
{
	orient_front();
	
	$("#front_info").show();
	$("#back_info").hide();
	
	$("#front_end").addClass("front_page_active");
	$("#back_end").removeClass("front_page_active");
	
	$("#back_end").addClass("front_page_inactive");
	$("#front_end").removeClass("front_page_inactive");
	
	
}

function back()
{
	orient_back();
	
	$("#front_info").hide();
	$("#back_info").show();
	
	$("#back_end").addClass("front_page_active");
	$("#front_end").removeClass("front_page_active");
	
	$("#front_end").addClass("front_page_inactive");
	$("#back_end").removeClass("front_page_inactive");
}

</script>

<div class="gray">
<div id="what_is_a_gathering">RushRabbit lets you organize a conference, fair, college orientation, sports tournament, or any other large group of events.  Read about some of our features below, or see an example Gathering.</div>

<div id="front_page">

<img id="front_comp" src="<?php echo $html->url('/'); ?>img/front_comp.png" />

<img id="back_comp" src="<?php echo $html->url('/'); ?>img/back_comp.png" />

<div id="tabs">

<a href="javascript:front()" id="front_end" class="front_page_active">
<span class="mini_heading">Front End</span>
<h2 class="fp_heading">View Events</h2>
</a>

<a href="javascript:back()" id="back_end" class="front_page_inactive">
<span class="mini_heading">Back End</span>
<h2 class="fp_heading">Create Gatherings</h2>
</a>

</div>

</div>
</div>



<div class="info_overlay" id="front_info">
<div class="fp_content">
	<table class="fp_boxes">
	<tr><td><h2 class="fp_info_header">Switch Between Timeline View and Map View</h2>
	<p>RushRabbit allows you to view events on a map, so you can find what's going on near you.</p>
	</td><td>
	<h2 class="fp_info_header">Keep Track of Your Favorite Events</h2>
	<p>Create an account and add events to your Favorites to keep track of those that interest you most.  Then, print out your Favorites, email them to someone, or sync them with your calendar.</p>
	</td><td>
	<h2 class="fp_info_header">Log in with Facebook</h2>
	<p>If you have a Facebook account, you don't need to register with RushRabbit - just click the Facebook login button to connect with your existing account.</p>
	</td>
	</tr>
	<tr>
	<td>
	<h2 class="fp_info_header">Sync with Your Calendar</h2>
	<p>Import the entire schedule of a Gathering or just your Favorites into Google Calender, iCal, Outlook, and many other programs.  Take it on the go with your smartphone.</p>
	</td><td>
	<h2 class="fp_info_header">Go to the Mobile Site</h2>
	<p>Visit RushRabbit.com on your internet-enabled mobile phone to view your favorites or a map of events happening around you.  We support iPhone, Android, and WebOS.</p>
	</td>
	</tr>
	</table>
</div>
</div>

<div class="info_overlay" id="back_info" style="display: none">
<div class="fp_content">

	<h2 class="fp_info_header">Organize Large Numbers of Events</h2>
	<p>This is some stuff in a paragraph.</p>
	
	<h2 class="fp_info_header">Create Groups and Subgroups</h2>
	<p>This is some stuff in a paragraph.</p>
	
	<h2 class="fp_info_header">Give Groups Permission to Edit Their Own Events</h2>
	<p>This is some stuff in a paragraph.</p>
	
	<h2 class="fp_info_header"></h2>
	<p>This is some stuff in a paragraph.</p>

</div>

</div>

<?php if ($this->Session->read('username') == null) { ?>

<div class="form_section" style="float:right; width: 430px;">
<h2>Get Started</h2>

<label>Have an account?</label>
<a href="javascript:open_dialog()" class="make_button">Login</a>

<script type="text/javascript">
function open_dialog()
{ $( '#dialog-form' ).dialog( 'open' ); }

</script>

<label>Need an account?</label>
<?php echo $html->link("Register", "/users/add", array('class'=>'make_button'));?>

</div>

<?php } else { ?>

<div class="form_section" style="float:right; width: 430px;">
<h2>Recently Viewed [Conference]s</h2>

<?php if (isset($watchlist)) {?>
	<table class="full_width generic">
	<tr>
	<th>Name</th><th>Last visited</th>
	</tr>
	<?php foreach ($watchlist as $eventGroup) {?>
	<tr>
			<td>
				<?php echo $html->link($eventGroup['event_groups']['name'], "/".$eventGroup['event_groups']['path']); ?>
			</td>
			<td>
				<?php echo date( 'l, F jS Y' , strtotime($eventGroup['event_groups_users']['time']) ); ?>
			</td>
	</tr>
	<?php }?>
	</table>
<?php }?>
</div>

<div class="form_section" style="float:right; width: 430px;">
<h2>Create a [Conference]</h2>

<?php echo $html->link('Click here to create a [conference]', '/event_groups/add/0', array('class'=>'make_button')); ?>

<?php } ?>

<!-- the real thing
<div class="form_section" style="float:right; width: 430px;">
<h2>Create a Conference</h2>

<label>Name</label>
<input type="text" class="textfield" />
<p class="form_tip">for example, MIT Campus Preview Weekend</p>

<input type="submit" value="Get started" class="make_button" />

</div>

<div class="form_section" style="float:right; width: 430px;">
<h2>Search for a Conference</h2>

<input type="text" class="textfield" />

<input type="submit" value="Search" class="make_button" />

</div> -->

<div class="clear"></div>

</div>







<h2><?php __('EventGroups');?></h2>
<table border="1">
<tr>
<td>id</td><td>name</td><td>description</td><td>photo_url</td><td>parent_id</td><td>Actions</td>
</tr>
<?php foreach ($eventGroups as $eventGroup) {?>
<tr>
		<td>
			<?php echo $eventGroup['EventGroup']['id']; ?>
		</td>
		<td>
			<?php echo $eventGroup['EventGroup']['name']; ?>
		</td>
		<td>
			<?php echo $eventGroup['EventGroup']['description']; ?>
		</td>
		<td>
			<?php echo $eventGroup['EventGroup']['photo_url']; ?>
		</td>
		<td>
			<?php echo $eventGroup['EventGroup']['parent_id']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link("View", "/".$eventGroup['EventGroup']['path']); ?>
			<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'update')) {
				echo $html->link(__('Edit', true), array('action' => 'edit', $eventGroup['EventGroup']['id'])); 
			}?>
			<?php if ($access->check('EventGroup',$eventGroup['EventGroup']['id'], 'delete')) {
				echo $html->link(__('Delete', true), array('action' => 'delete', $eventGroup['EventGroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $eventGroup['EventGroup']['id']));
			} ?>
		</td>
</tr>
<?php }?>
</table>

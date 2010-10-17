<?php echo $javascript->link('mapstuff.js');?>
<div class="events form">
<?php echo $form->create('Event');?>
	<fieldset>
 		<legend><?php __('Add Event');?></legend>
	<?php
		echo $form->input('title', array('type' => 'text'));
		echo $form->input('description');
		echo $form->input('photo_url', array('type' => 'text'));
		echo $form->input('location', array('label' => 'Location Name', 'type' => 'text'));
//		echo $form->input('time_start', array('value' => '2010-10-25 20:54:00'));
		echo $form->input('time_start', array('value' => '2010-10-25 20:54:00', 'type' => 'text'));
		echo $form->input('duration', array('value' => '60', 'type' => 'text'));
//		echo $form->input('latitude');
//		echo $form->input('longitude');
//		echo $form->input('user_id');
		echo $form->input('CategoryChoice');
//		echo $form->input('User');
	?>
	 <div>
      <div style="margin-bottom: 5px;">

        <div>
          <input type="text" id="queryInput" value="pizza" style="width: 250px;"/>
          <input type="button" value="Find" onclick="doSearch()"/>
        </div>
      </div>
      <div style="float:right">
        <div id="searchwell"></div>
      </div>
      <div id="map" style="height: 350px; border: 1px solid #979797;"></div>
      

    </div>
      <input name="data[Event][latitude]" type="text" id="EventLatitude" value="<?php echo $eventGroup['EventGroup']['latitude']?$eventGroup['EventGroup']['latitude']:"";?>" />
      <input name="data[Event][longitude]" type="text" id="EventLongitude" value="<?php echo $eventGroup['EventGroup']['longitude']?$eventGroup['EventGroup']['longitude']:"";?>" />
	<input type="hidden" name="data[Event][event_group_id]" id="EventEventGroupId" value="<?=$eventGroupId?>">
	</fieldset>
<?php echo $form->end('Submit');?>
</div>


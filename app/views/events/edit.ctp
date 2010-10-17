<div class="events form">
<?php echo $form->create('Event');?>
	<fieldset>
 		<legend><?php __('Edit Event');?></legend>
	<?php
		echo $form->input('title', array('type' => 'text'));
		echo $form->input('description');
		echo $form->input('photo_url', array('type' => 'text'));
		echo $form->input('location', array('label' => 'Location Name', 'type' => 'text'));
//		echo $form->input('time_start', array('value' => '2010-10-25 20:54:00'));
		echo $form->input('time_start', array('type' => 'text'));
		echo $form->input('duration', array('type' => 'text'));
//		echo $form->input('latitude');
//		echo $form->input('longitude');
//		echo $form->input('user_id');
		echo $form->input('CategoryChoice');
//		echo $form->input('User');
		echo $form->input('id', array('type'=>'hidden')); 
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
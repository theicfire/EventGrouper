
<div class="users form">
	<?php echo $form->create('User');?>

		
		<div class="form_section" style="width: 50%; margin: 0 auto;">
	 		<h2><?php __('Registration Form');?></h2>
	 		
	 		
		<?php
			echo $form->input('email', array( 'class'=>'textfield', 'label'=>'Email' ));
			if(isset($error) && $error == 'email_taken'){ echo '<label class="error">That email address has already been taken.</label>'; }
			echo $form->input('pass', array('type'=>'password', 'class'=>'textfield', 'label'=>'Password'));
			echo $form->input('confirm password', array('type'=>'password', 'class'=>'textfield', 'label'=>'Confirm Password'));
		?>

	<?php echo $form->end(array('label' => 'Submit', 'class'=>'make_button'));?>
			</div>
	</div>
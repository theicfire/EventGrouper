
<script type="text/javascript">

$(document).ready( page_init );

function page_init()
{
	$("#loginForm").validate({
			rules: {
				'data[User][email]': {
					required: true,
					email: true
				},
				'data[User][pass]': {
					required: true,
					minlength: 6
				},
				'data[User][newpass]': {
					required: true,
					minlength: 6
				},
				'data[User][confirm password]': {
					required: true,
					equalTo: "[name='data[User][newpass]']"
				},
			},
			messages: {
				'data[User][confirm password]': {
					equalTo: "Please enter the same password as before."
				}
			},
		});
	
	
	
}


</script>


<div class="info_box">
	<h1>Edit Account</h1>
	<?php echo $form->create('User', array('name' => 'loginForm', 'id' => 'loginForm'));?>
	<div class="form_section">
 		<h2>Change Password</h2>
	 	<div id="badLogin" class="error" style="display:none;">Your email/password combination was incorrect.</div>	
	 		
		<?php
			if ($session->check('username')) {
				echo $form->input('emaildis', array( 'class'=>'textfield', 'label'=>'Email','disabled' => 'disabled', 'value' => $session->read('username') ));
				echo $form->input('email', array('type' => 'hidden', 'id' => 'email', 'value' => $session->read('username') ));
			} else {
				echo $form->input('email', array( 'class'=>'textfield', 'label'=>'Email', 'id' => 'email' ));
			}
			if(isset($error) && $error == 'email_taken'){ echo '<label class="error">That email address has already been taken.</label>'; }
			if(isset($error) && $error == 'email_preregistered'){ echo '<label class="error">Someone has already registered for you! Check your email and follow the instructions.</label>'; }
			echo $form->input('pass', array('type'=>'password', 'class'=>'textfield', 'label'=>'Old Password', 'id' => 'password'));
			echo $form->input('newpass', array('type'=>'password', 'class'=>'textfield', 'label'=>'New Password'));
			echo $form->input('confirm password', array('type'=>'password', 'class'=>'textfield', 'label'=>'Confirm New Password'));
		?>
	</div>
	<?php echo $form->end(array('label' => 'Submit', 'class'=>'make_button'));?>
</div>

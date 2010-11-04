<?php if ($unregisteredData == null) {?>

<script type="text/javascript">

$(document).ready( page_init );

function page_init()
{
	$("#UserAddForm").validate({
			rules: {
				'data[User][email]': {
					required: true,
					email: true
				},
				'data[User][pass]': {
					required: true,
					minlength: 6
				},
				'data[User][confirm password]': {
					required: true,
					equalTo: "[name='data[User][pass]']"
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

	<div style="padding: 5px"><?php echo $form->end('Submit');?></div>
			</div>
	</div>
<?php } else if ($hasAccount == null) {?>
	You have been given access to create events and groups in XXX.
	<br>
	<?php echo $html->link(__('Go here if you have never registered for this site', true), array('action' => 'add', $unregisteredData['User']['id'], "newaccount")); ?>
	<br>
	<?php echo $html->link(__('Go here if you have already registered for this site and are using a different email than this', true), array('action' => 'add', $unregisteredData['User']['id'], "makealias")); ?>
	<br>
<?php } else if ($hasAccount == "makealias") {?>
	<div id="badLogin" style="display:none; background-color:yellow">You're email/password combination was incorrect. Forgot password? Register?</div>
	<form name="loginForm" id="loginForm" method="post">
		<fieldset>
	 		<legend>Login</legend>
		 	Email:
			<input type="text" name="data[User][email]" id="email">
			Password:
			<input type="password" name="data[User][password]" id="password">
		</fieldset>
		<input type="submit" value="Login!">
	</form>
	<script type="text/javascript">
	$(document).ready(function() {
		  // Handler for .ready() called.
	
		$('#loginForm').submit(function() {
			var username = $('#email').attr('value');
			var pass = $('#password').attr('value');
			var goodLogin = true;
			$.ajax({
			   type: "POST",
			   async: false,
			   url: "<?=$this->base?>/login/checkLogin",
			   data: {email: username, pass: pass},
			   success: function (data) {
					if (data != "good") {
						$("#badLogin").show(200);
					} else {
						$("#badLogin").css('display', 'none');
					}
				}
			 });
			if ($("#badLogin").is(':visible'))
				return false;
		});
		  
	});
	</script>	

<?php } else {?>
<div class="users form">
	<?php echo $form->create('User', array('action' => sprintf("add/%d/%s", $unregisteredData['User']['id'], $hasAccount)));?>
		<fieldset>
	 		<legend><?php __('Add User');?></legend>
		<?php
			echo $form->input('email', array('disabled' => 'disabled', 'value' => $unregisteredData['User']['email']));
			echo $form->input('email', array('type' => 'hidden', 'value' => $unregisteredData['User']['email']));
			echo $form->input('pass', array('type'=>'password'));
			echo $form->input('confirm password', array('type'=>'password'));//todo js checking
		?>
		</fieldset>
	<?php echo $form->end('Submit');?>
	</div>
<?php }?>

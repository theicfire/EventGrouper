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

	<?php echo $form->end(array('label' => 'Submit', 'class'=>'make_button'));?>
			</div>
	</div>
<?php } else if ($hasAccount == null) {?>
	
	<div class="form_section" style="width: 800px; margin: 10px auto">
	<h2>Access Granted</h2>
	<p>
	You (email@example.com) have been given access to create events and groups in XXX.
	<br>
	Which one describes you best?</p>
	<?php echo $html->link(__('I do not have a RushRabbit account', true), array('action' => 'add', $unregisteredData['User']['id'], "newaccount"), array('class'=>'make_button')); ?>

	<?php echo $html->link(__('I have a RushRabbit account under a different email address', true), array('action' => 'add', $unregisteredData['User']['id'], "makealias"), array('class'=>'make_button')); ?>
	</div>
<?php } else if ($hasAccount == "makealias") {?>

	<div class="form_section" style="width: 800px; margin: 10px auto">
	
	<script type="text/javascript">
	$(document).ready( init_alias_login );
	
	function init_alias_login()
	{
		$("#loginForm").validate({
			rules: {
				'data[User][email]': {
					required: true,
					email: true
				},
				'data[User][password]': {
					required: true,
				},
			},
		});
	}
	</script>
	
	<h2>Access Granted</h2>
	<div id="badLogin" class="error" style="display:none;">Your email/password combination was incorrect.</div>
	<form name="loginForm" id="loginForm" method="post">
		<fieldset>
	 		<p class="form_tip">Please log in to your existing account.</p>
		 	<label>Email</label>
			<input type="text" name="data[User][email]" id="email" class="textfield">
			<label>Password</label>
			<input type="password" name="data[User][password]" id="password"  class="textfield">
		</fieldset>
		<div style="padding: 5px"><input type="submit" value="Submit"></div>
	</form>
	</div>
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
	
	<div class="form_section" style="width: 800px; margin: 10px auto">
	
	<script type="text/javascript">
	$(document).ready( init_alias_login );
	
	function init_alias_login()
	{
	
	$("form").validate({
			rules: {
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
	
	<h2>Access Granted</h2>
	
	<?php echo $form->create('User', array('action' => sprintf("add/%d/%s", $unregisteredData['User']['id'], $hasAccount)));?>
		<fieldset>
		<?php
			echo $form->input('email', array('disabled' => 'disabled', 'class'=>'textfield', 'label'=>'Email', 'value' => $unregisteredData['User']['email']));
			echo $form->input('email', array('type' => 'hidden', 'class'=>'textfield', 'value' => $unregisteredData['User']['email']));
			echo $form->input('pass', array('type'=>'password', 'label'=>'Password', 'class'=>'textfield'));
			echo $form->input('confirm password', array('type'=>'password', 'label'=>'Confirm Password', 'class'=>'textfield'));//todo js checking
		?>
		</fieldset>
	<div style="padding: 5px"><?php echo $form->end('Submit');?></div>
	
	</div>
</div>
<?php }?>


<script type="text/javascript">

$(document).ready( page_init );

function page_init()
{
	$("#forgotPasswordForm").validate({
			rules: {
				'data[User][email]': {
					required: true,
					email: true
				},
			},
		});
	
	
	
}


</script>

	
	<div class="form_section" style="width: 50%; margin: 0 auto;">
	<?php echo $form->create('User', array('name' => 'loginForm', 'id' => 'forgotPasswordForm'));?>
 		<h2>Forgot Password</h2>
	 	
	 		
		<?php
			echo $form->input('email', array( 'class'=>'textfield', 'label'=>'Email', 'id' => 'email' ));
			
		?>
		<div id="badLogin" class="error" style="display:none;">That email doesn't exist on this site.</div>	
		<?php echo $form->end(array('label' => 'Submit', 'class'=>'make_button'));?>
	</div>
	

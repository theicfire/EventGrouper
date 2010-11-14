
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

	<?php echo $form->create('User', array('name' => 'loginForm', 'id' => 'forgotPasswordForm'));?>
	<div class="form_section" style="width: 50%; margin: 0 auto;">
 		<h2>Forgot Password</h2>
	 	<div id="badLogin" class="error" style="display:none;">That email doesn't exist on this site.</div>	
	 		
		<?php
			echo $form->input('email', array( 'class'=>'textfield', 'label'=>'Email', 'id' => 'email' ));
			
		?>
	</div>
	<?php echo $form->end(array('label' => 'Submit', 'class'=>'make_button'));?>

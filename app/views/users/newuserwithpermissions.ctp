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
	
	<h2>Create Account</h2>
	
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
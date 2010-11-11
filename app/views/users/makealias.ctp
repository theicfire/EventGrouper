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
	
	<h2>Login</h2>
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
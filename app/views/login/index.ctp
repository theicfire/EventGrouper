<?php 
if ($this->Session->read('username') == null) {?>
	<div id="badLogin" style="display:none; background-color:yellow">You're email/password combination was incorrect. Forgot password? Register?</div>
	<form name="loginForm" id="loginForm" method="post" action="somewhere">
		<fieldset>
	 		<legend>Login</legend>
		 	Email:
			<input type="text" name="email" id="email">
			Password:
			<input type="password" name="password" id="password">
		</fieldset>
		<input type="submit" value="Login!">
		</form>
		<?php 
} else {
	?>
	You're logged in! <a href="#" id="logout">Logout</a>
	<?php 
}
?>
<script type="text/javascript">
$(document).ready(function() {
	  // Handler for .ready() called.

	$('#loginForm').submit(function() {
		var username = $('#email').attr('value');
		var pass = $('#password').attr('value');
		$.post("login/checkLogin", {email: username, pass: pass}, function (data) {
			if (data == "good")
				window.location = "<?=$this->base?>/";
			else
				$("#badLogin").show(200);
		});
		 return false;
	});

	$('#logout').click(function() {
		$.post('logout');
		location.reload(true);
	});
	  
});
</script>
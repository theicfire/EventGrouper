$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog" ).dialog( "destroy" );
		
		var email = $( "#dialog-form #email" ),
			password = $( "#dialog-form #password" ),
			allFields = $( [] ).add( name ).add( email ).add( password ),
			tips = $( ".validateTips" );

		function updateTips( t ) {
			tips.text( t ).addClass( "ui-state-highlight" );
		}
		
		email.keydown( check_for_enter );
		password.keydown( check_for_enter );
		
		function check_for_enter( event )
		{
			if(event.which == 13) //this is the enter key
			{
				log_in();
			}
		}
		
		function log_in()
		{
			$.post(phpVars.root+'/login/checkLogin', 
							{email: email.val(), pass: password.val()}, function (data) {
						if (data == "good")
							window.location.reload();
						else
							updateTips("Incorrect email and password combination.");
					});
		}
		
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				"Login": log_in,
				"Cancel": function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#login" )
			.click(function() {
				$( "#dialog-form" ).dialog( "open" );
				return false;
			});
		$('#loginForm').submit(function() {
			var username = $('#loginForm #email').attr('value');
			var pass = $('#loginForm #password').attr('value');
			var goodLogin = true;
			$.ajax({
			   type: "POST",
			   async: false,
			   url: phpVars.root+"/login/checkLogin",
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
		$('#forgotPasswordForm').submit(function() {
			var username = $('#forgotPasswordForm #email').attr('value');
			$.ajax({
			   type: "POST",
			   async: false,
			   url: phpVars.root+"/login/checkEmailExists",
			   data: {email: username},
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
			return false;
		});
	});

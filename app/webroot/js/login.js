$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog" ).dialog( "destroy" );
		
		var email = $( "#email" ),
			password = $( "#password" ),
			allFields = $( [] ).add( name ).add( email ).add( password ),
			tips = $( ".validateTips" );

		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}
		
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 300,
			width: 350,
			modal: true,
			buttons: {
				"Login": function() {
					$.post(phpVars.root+'/login/checkLogin', 
							{email: email.val(), pass: password.val()}, function (data) {
						if (data == "good")
							window.location.reload();
						else
							updateTips("You're email and password did not match");
					});
				},
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
	});

<div id="container">
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
	</div>
<!--	facebook stuff-->
	<div id="fb-root"></div>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script>
      FB.init({appId: '<?php echo $FACEBOOK_APP_ID;?>', status: true,
               cookie: true, xfbml: true});
      FB.Event.subscribe('auth.login', function(response) {
        window.location.reload();
      });
    </script>
    <!--	end facebook stuff-->
    <script language="javascript">
    $('#logoutlink').click(function() {
    	$.post('<?php echo $html->url(array("controller" => 'login', 'action' => 'logout'));?>', function() {
    		FB.getLoginStatus(function(response) {
    		  if (response.session) {
	    		  FB.logout(function () {
	        		window.location.reload();
    	        });
    		  } else {
    			window.location.reload();
    		  }
    		});
    	});
    	return false;
    });
    </script>
	<?php echo $this->element('sql_dump'); ?>
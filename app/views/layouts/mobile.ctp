<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" 
      xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Mobile EventGrouper | '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	    <link href="http://www.google.com/uds/css/gsearch.css" rel="stylesheet" type="text/css"/>
    
    
    
	<?php
		echo $this->Html->meta('icon');
		echo $scripts_for_layout;
		echo $html->css(array('main_style.css','forms.css')); 
		
	?>
	
	
</head>
<body>

<script type="text/javascript">
	$(document).ready( function () { $(".make_button").button() } );
</script>

<div id="help_modal"></div>

    
			<?php echo $html->link("RushRabbit", "/mob/index", array('class'=>'uh_logo'))?> <span><a href="<?= $html->url('/about_us');?>" class="general_link">About Us</a> <a href="<?= $html->url('/feedback');?>" class="general_link">Feedback</a></span>
		        
			<?php
			if ($this->Session->read('username') == null) {
				?>
				
				<?php echo $html->link("Log In", "/mob/login", array('id' => 'login', 'class'=>'uh_link'));?> | <?php echo $html->link("Register", "/users/add", array('class'=>'uh_link'));?> | <fb:login-button perms="email"></fb:login-button>
				<?php 
			} else {
				?><?php echo "Logged in as: ".$this->Session->read('username');?> | <?php echo $html->link("Log Out", "/mob/logout", array("class" => "logoutlink"));?>
			<?php }?>
	 
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
    $('.logoutlink').click(function() {
    	$.post('<?php echo $html->url(array("controller" => 'login', 'action' => 'logout'));?>', function() {
    		FB.getLoginStatus(function(response) {
    		  if (response.session) {
	    		  FB.logout(function () {
	        		window.location = '<?php echo $html->url("/");?>'
    	        });
    		  } else {
    			  window.location = '<?php echo $html->url("/");?>'
    		  }
    		});
    	});
    	return false;
    });
    </script>

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <div class="sql_dump">
		<?php echo $this->element('sql_dump'); ?>
	</div>
</body>
</html>

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
		<?php __('EventGrouper | '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	    <link href="http://www.google.com/uds/css/gsearch.css" rel="stylesheet" type="text/css"/>
<!--    todo make local-->
	<?php echo $html->css(array('main_style.css','smoothness/jquery-ui-1.8.5.custom.css')); ?>
	
	
<!--    todo put locally^^-->

    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script src="http://www.google.com/uds/api?file=uds.js&amp;v=1.0&amp;key=ABQIAAAAjU0EJWnWPMv7oQ-jjS7dYxQ82LsCgTSsdpNEnBsExtoeJv4cdBSUkiLH6ntmAr_5O4EfjDwOa0oZBQ" type="text/javascript"></script>
    
    
    
	<?php
		echo $this->Html->meta('icon');
		if (!isset($phpVars))
			$phpVars = array();
		$phpVars['root'] = $this->base;
		echo $this->Html->scriptBlock('var phpVars = '.$javascript->object($phpVars).';');
//		echo $this->Html->css('cake.custom');
		echo $javascript->link(array('jquery-1.4.2.min.js', 'login.js', 'jqueryui/jquery-ui-1.8.5.custom.min.js', 'jquery-validate.js'));
		echo $scripts_for_layout;
		
	?>
	<?php if (isset($isAdmin)) {
		echo $html->css(array('forms.css', 'admin_style.css'));
		echo $javascript->link(array('admin.js'));
	}?>
	
	
</head>
<body>
<div id="help_modal"></div>

    <?php if (isset($isAdmin)) {?>
	
	    <div id="personal_id" class="info_box">
	    
	    	<div class="left"><p><img src="<?php echo $html->url('/'); ?>css/rinoa/lock.png" class="rinoa_small_inline" /> You are logged in as <span id="main_email"><?=$session->read('username')?></span>.</p></div>
	        <div class="right"><p>
	        
	        <a href="<?php echo $html->url('/'); ?>" class="make_button">Exit admin panel</a> <a href="#" class="make_button">Edit account</a> <a href="<?php echo $html->url("/");?>" class="make_button logoutlink">Log out</a> 
	        
	        </p>
	        
	        
	        </div>
	        <div class="clear"></div>
	    </div>
    <?php } else {?>
    
	    <div id="universal_header">
			<div id="uh_left"><?php echo $html->link("RushRabbit", "/")?></div>
		        
			<?php
			if ($this->Session->read('username') == null) {
				?>
				<fb:login-button perms="email"></fb:login-button>
				<div id="uh_right">what is RushRabbit? | <?php echo $html->link("Log In", "/login", array('id' => 'login'));?> | <?php echo $html->link("Register", "/users/add");?></div>
				<?php 
			} else {
				?>
				<div id="uh_right">what is RushRabbit? | <?php echo $html->link("Admin Panel", "/users/index");?> | <?php echo "You are logged in as: ".$this->Session->read('username');?> | <?php echo $html->link("Log Out", "/logout", array("class" => "logoutlink"));?></div>
			<?php }?>
			<div class="clear"></div>
	    </div>
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
	        		window.location = <?php echo $html->url("/");?>
    	        });
    		  } else {
    			  window.location = <?php echo $html->url("/");?>
    		  }
    		});
    	});
    	return false;
    });
    </script>
<!--login stuff    -->
<div id="dialog-form" class="popup" title="Login">
	<p class="validateTips">All form fields are required.</p>

	<form>
	<fieldset>
		<label for="email">Email</label>
		<input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all" />
		<label for="password">Password</label>
		<input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all" />
		<a href="#">Forgot Password?</a><br>
		<?php echo $html->link("Register", "/users/add");?>
	</fieldset>
	</form>


</div>
<!--end login stuff-->

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <div class="sql_dump">
		<?php echo $this->element('sql_dump'); ?>
	</div>
</body>
</html>

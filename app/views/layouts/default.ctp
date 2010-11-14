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
	<?php echo $html->css(array('main_style.css','smoothness/jquery-ui-1.8.5.custom.css')); 
	echo $html->css(array('forms.css')); ?>
	
	
<!--    todo put locally^^-->

    
    
    
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
		
		echo $javascript->link(array('admin.js'));
		echo $html->css(array('admin_style.css'));
	}?>
	
	
</head>
<body>

<script type="text/javascript">
	$(document).ready( function () { $(".make_button").button() } );
</script>

<div id="help_modal"></div>

    <?php if (isset($isAdmin) && $session->check('userid')) {?>
	
	    <div id="personal_id" class="admin_header">
	    
	    	<div class="left"><div class="admin_panel_logo"><strong>RushRabbit</strong> Administration Panel</div>
	    	<p><img src="<?php echo $html->url('/'); ?>css/rinoa/lock.png" class="rinoa_small_inline" /> You are logged in as <span id="main_email"><?=$session->read('username')?></span>.</p></div>
	        <div class="right"><p>
	        
	        <a href="<?php echo $html->url('/users/index'); ?>" class="make_button">Admin panel home</a> <a href="<?php echo $html->url('/'); ?>" class="make_button">Exit admin panel</a> <a href="<?php echo $html->url('/users/changepassword'); ?>" class="make_button">Edit Account</a> <a href="<?php echo $html->url("/");?>" class="make_button logoutlink">Log out</a> 
	        
	        </p>
	        
	        
	        </div>
	        <div class="clear"></div>
	    </div>
    <?php } else {?>
    
	    <div id="universal_header">
			<div id="uh_left"><?php echo $html->link("RushRabbit", "/", array('class'=>'uh_logo'))?> <span><a href="<?= $html->url('/about_us');?>" class="general_link">About Us</a> <a href="<?= $html->url('/feedback');?>" class="general_link">Feedback</a></span></div>
		        
			<?php
			if ($this->Session->read('username') == null) {
				?>
				
				<div id="uh_right"><?php echo $html->link("Log In", "/login", array('id' => 'login', 'class'=>'uh_link'));?> | <?php echo $html->link("Register", "/users/add", array('class'=>'uh_link'));?> | <fb:login-button perms="email"></fb:login-button></div>
				<?php 
			} else {
				?>
				<div id="uh_right"><?php echo "Logged in as: ".$this->Session->read('username');?> | <?php echo $html->link("Admin Panel", "/users/index");?> | <?php echo $html->link("Log Out", "/logout", array("class" => "logoutlink"));?></div>
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
<!--login stuff    -->
<div id="dialog-form" class="popup" title="Login">
<div class="form_section" style="padding: 0; margin: 0; border: none">
<p class="validateTips">All form fields are required.</p>

<?php // echo $html->link("Register", "/users/add");?>

	<form>
	<fieldset>
		<label for="email">Email</label>
		<input type="text" name="email" id="email" value="" class="textfield" />
		<label for="password">Password</label>
		<input type="password" name="password" id="password" value="" class="textfield" />
<p><a href="<?=$html->url('/users/forgotpassword')?>">Forgot Password?</a> </p>
	</fieldset>
	</form>

</div>
</div>
<!--end login stuff-->

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <div class="sql_dump">
		<?php echo $this->element('sql_dump'); ?>
	</div>
</body>
</html>

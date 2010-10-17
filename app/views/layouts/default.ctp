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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('EventGrouper | '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	    <link href="http://www.google.com/uds/css/gsearch.css" rel="stylesheet" type="text/css"/>
    <link href="./places.css" rel="stylesheet" type="text/css"/>

    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script src="http://www.google.com/uds/api?file=uds.js&amp;v=1.0&amp;key=ABQIAAAAjU0EJWnWPMv7oQ-jjS7dYxQ82LsCgTSsdpNEnBsExtoeJv4cdBSUkiLH6ntmAr_5O4EfjDwOa0oZBQ" type="text/javascript"></script>
    
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.custom');

		echo $scripts_for_layout;
		if (!empty($javascript))
			echo $javascript->link('jquery-1.4.2.min.js');
	?>
	
</head>
<body>
<?php 
echo $html->link("Home", "/", array("style" => "color:red"))." ";
if ($this->Session->read('username') == null) {
	echo $html->link("Log In", "/login", array("style" => "color:red"))." ";
	echo $html->link("Register", "/users/add", array("style" => "color:red"));
} else {
	echo "You are logged in as: ".$this->Session->read('username');
	echo $html->link("Log Out", "/logout", array("style" => "color:red"));
}?>
	<div id="container">
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
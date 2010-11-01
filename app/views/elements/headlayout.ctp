<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('EventGrouper | '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	    <link href="http://www.google.com/uds/css/gsearch.css" rel="stylesheet" type="text/css"/>
    <link href="./places.css" rel="stylesheet" type="text/css"/>
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
		if (!empty($javascript))
			echo $javascript->link('jquery-1.4.2.min.js');
		echo $scripts_for_layout;
		
	?>
	
	
	
</head>
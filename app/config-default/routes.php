<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'event_groups', 'action' => 'index'));
	Router::connect('/logout', array('controller' => 'login', 'action' => 'logout'));
	Router::connect('/login', array('controller' => 'login', 'action' => 'index'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	
	//get all controllers
//	$Configure = &Configure::getInstance();
//	$controllerList = $Configure->listObjects('controller');
//	print_r($controllerList);
//	foreach($controllerList as $controllerName)
//	{
//		//map all controllers (apart from app and pages to their name
//		if($controllerName != "App" & $controllerName != "Pages")
//		{
//		
//			//route the normal name
//			Router::connect('/' . $controllerName . '/:action/*', array('controller' => $controllerName));
//			
//			//get the name with first letter lower
//			$firstLetterLower = strtolower(substr($controllerName,0,1));
//			$lowerCaseName = $firstLetterLower . substr($controllerName,1);
//			
//			//route the name with first letter lowered
//			Router::connect('/' . $lowerCaseName . '/:action/*', array('controller' => $lowerCaseName));
//		}
//	}

	// Set default controller routes
	Router::connect('/event_groups/:action/*', array('controller' => 'event_groups'));
	Router::connect('/permissions/:action/*', array('controller' => 'permissions'));
	Router::connect('/login/:action/*', array('controller' => 'login'));
	Router::connect('/events/:action/*', array('controller' => 'events'));
	Router::connect('/users/:action/*', array('controller' => 'users'));
	Router::connect('/admin/:action/*', array('controller' => 'admin'));
	Router::connect('/feedback', array('controller' => 'other', 'action' => 'feedback'));
	Router::connect('/about_us', array('controller' => 'other', 'action' => 'about_us')); 
	Router::connect('/*', array('controller' => 'event_groups', 'action' => 'view')); 

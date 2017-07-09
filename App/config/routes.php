<?php

/**
 * The routes configuration...
 *
 * @version 0.0.1
 * @package App\Config
 * @author  Clément Cazaud <opportus@gmail.com>
 */

return array(
	'#^/?$#' => array(
		'controller' => 'App\Controller\HomeController',
		'action'     => 'view',
	),
	'#^/post/(.+)$#i' => array(
		'controller' => 'App\Controller\PostController',
		'action'     => 'view',
	),
	'#^/(.+)#i' => array(
		'controller' => 'App\Controller\_404Controller',
		'action'     => 'view',
	),
);


<?php

/**
 * Register your routes here using the given array structure...
 *
 * @version 0.0.1
 * @author  Clément Cazaud <opportus@gmail.com>
 */

return array(
	'#^/?$#' => array(
		'controller' => 'App\Controller\HomeController',
		'action'     => 'view',
	),
	'#^/contact/?$#' => array(
		'controller' => 'App\Controller\HomeController',
		'action'     => 'contact',
	),
	'#^/blog/?$#i' => array(
		'controller' => 'App\Controller\BlogController',
		'action'     => 'view',
	),
	'#^/post/(.+)$#i' => array(
		'controller' => 'App\Controller\PostController',
		'action'     => 'view',
	),
	'#^/cockpit/post/edit/(.*)$#i' => array(
		'controller' => 'App\Controller\PostController',
		'action'     => 'edit',
	),
	'#^/cockpit/post/save/(.*)$#i' => array(
		'controller' => 'App\Controller\PostController',
		'action'     => 'save',
	),
	'#^/cockpit/post/delete/(.+)$#i' => array(
		'controller' => 'App\Controller\PostController',
		'action'     => 'delete',
	),
	'#^/(.+)#i' => array(
		'controller' => 'App\Controller\_404Controller',
		'action'     => 'view',
	),
);


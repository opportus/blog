<?php

/**
 * Register your routes here using the given array structure...
 */

return array(
	'#^/?$#' => array(
		'controller' => 'OC\Blog\Controller\HomeController',
		'action'     => 'view',
	),
	'#^/contact/?$#' => array(
		'controller' => 'OC\Blog\Controller\HomeController',
		'action'     => 'contact',
	),
	'#^/blog/?$#i' => array(
		'controller' => 'OC\Blog\Controller\BlogController',
		'action'     => 'view',
	),
	'#^/post/(.+)$#i' => array(
		'controller' => 'OC\Blog\Controller\PostController',
		'action'     => 'view',
	),
	'#^/cockpit/post/edit/(.*)$#i' => array(
		'controller' => 'OC\Blog\Controller\PostController',
		'action'     => 'edit',
	),
	'#^/cockpit/post/save/(.*)$#i' => array(
		'controller' => 'OC\Blog\Controller\PostController',
		'action'     => 'save',
	),
	'#^/cockpit/post/delete/(.+)$#i' => array(
		'controller' => 'OC\Blog\Controller\PostController',
		'action'     => 'delete',
	),
	'#^/oc/blog/(.+)$#i' => array(
		'controller' => 'OC\Blog\Controller\AssetController',
		'action'     => 'get',
	),
	'#^/(.+)#i' => array(
		'controller' => 'OC\Blog\Controller\_404Controller',
		'action'     => 'view',
	),
);


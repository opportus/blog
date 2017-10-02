<?php

/**
 * The Dependency Injection Container configuration...
 *
 * Set here the DIC registry you want by default using the following syntax:
 *
 * 'alias' => function () use (&$container) {
 * 		return new App\MyClass($container->get('Dependency1'), 'dependency2');
 * }
 *
 * This way, you can redefine the instances to be loaded at core initialization.
 * For example, you can redefine the default data Gateway as follow:
 *
 * 'Gateway' => function () use (&$container) {
 *		return new App\MyAdapters\DataGateway($container->get('Config'), $container->get('Toolbox'));
 * }
 *
 * The DIC will then inject your DataGateway in instances depending on the 'Gateway' alias.
 *
 * @version 0.0.1
 * @package App\Config
 * @author  Clément Cazaud <opportus@gmail.com>
 */

return array(

	'App\Controller\_404Controller' => function () use (&$container) {
		return new App\Controller\_404Controller(
			$container->get('Config'),
			$container->get('Toolbox'),
			$container->get('Session'),
			$container->get('Request'),
			$container->get('Response'),
			$container
		);
	},
	'App\Controller\HomeController' => function () use (&$container) {
		return new App\Controller\HomeController(
			$container->get('Config'),
			$container->get('Toolbox'),
			$container->get('Session'),
			$container->get('Request'),
			$container->get('Response'),
			$container
		);
	},
	'App\Controller\BlogController' => function () use (&$container) {
		return new App\Controller\BlogController(
			$container->get('Config'),
			$container->get('Toolbox'),
			$container->get('Session'),
			$container->get('Request'),
			$container->get('Response'),
			$container
		);
	},
	'App\Controller\PostController' => function () use (&$container) {
		return new App\Controller\PostController(
			$container->get('Config'),
			$container->get('Toolbox'),
			$container->get('Session'),
			$container->get('Request'),
			$container->get('Response'),
			$container
		);
	},
	'App\Model\ImageMapper' => function () use (&$container) {
		return new App\Model\ImageMapper($container->get('Gateway'), 'images');
	},
	'App\Model\UserMapper' => function () use (&$container) {
		return new App\Model\UserMapper($container->get('Gateway'), 'users');
	},
	'App\Model\PostMapper' => function () use (&$container) {
		return new App\Model\PostMapper($container->get('Gateway'), 'posts', array('UserMapper' => $container->get('App\Model\UserMapper')));
	},
	'App\Model\ImageRepository' => function () use (&$container) {
		return new App\Model\ImageRepository($container, $container->get('App\Model\ImageMapper'));
	},
	'App\Model\UserRepository' => function () use (&$container) {
		return new App\Model\UserRepository($container, $container->get('App\Model\UserMapper'));
	},
	'App\Model\PostRepository' => function () use (&$container) {
		return new App\Model\PostRepository($container, $container->get('App\Model\PostMapper'));
	},
	'App\Model\ImageModel' => function () use (&$container) {
		return new App\Model\ImageModel($container->get('Toolbox'));
	},
	'App\Model\UserModel' => function () use (&$container) {
		return new App\Model\UserModel($container->get('Toolbox'));
	},
	'App\Model\PostModel' => function () use (&$container) {
		return new App\Model\PostModel($container->get('Toolbox'));
	},
);


<?php

namespace Hedo\App;

use Hedo\Base\AbstractComposer;
use Hedo\Service\Container;
use Hedo\Service\Autoloader;
use Hedo\Bootstrap\Router;

/**
 * The composer...
 *
 * IT HAS NOTHING TO DO WITH THE PHP PACKAGE MANAGER.
 *
 * This is the entry point of your application. Compose here with all instances.
 * That's the right place to register your dependencies, namespaces, routes, etc...
 * EG:
 *
 * $container->set($alias, $resolver);
 * $autoloader->registerNamespace($namespace, array($dir1, $dir2));
 * $router->registerRoute($path, array('controller' => 'Controller', 'action' => 'view'));
 *
 * @see     Hedo\Base\AbstractComposer
 * @version 0.0.1
 * @package Bootstrap
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Composer extends AbstractComposer
{
	/**
	 * Registers dependencies.
	 *
	 * @param Container $container
	 */
	protected function registerDependencies(Container $container)
	{
		$this->container->set('App\Controller\_404Controller', function () {
			return new \App\Controller\_404Controller(
				$this->container->get('Config'),
				$this->container->get('Toolbox'),
				$this->container->get('Session'),
				$this->container->get('Request'),
				$this->container->get('Response'),
				$this->container
			);
		});
		$this->container->set('App\Controller\HomeController', function () {
			return new \App\Controller\HomeController(
				$this->container->get('Config'),
				$this->container->get('Toolbox'),
				$this->container->get('Session'),
				$this->container->get('Request'),
				$this->container->get('Response'),
				$this->container
			);
		});
		$this->container->set('App\Controller\BlogController', function () {
			return new \App\Controller\BlogController(
				$this->container->get('Config'),
				$this->container->get('Toolbox'),
				$this->container->get('Session'),
				$this->container->get('Request'),
				$this->container->get('Response'),
				$this->container
			);
		});
		$this->container->set('App\Controller\PostController', function () {
			return new \App\Controller\PostController(
				$this->container->get('Config'),
				$this->container->get('Toolbox'),
				$this->container->get('Session'),
				$this->container->get('Request'),
				$this->container->get('Response'),
				$this->container
			);
		});
		$this->container->set('App\Model\ImageMapper', function () {
			return new \App\Model\ImageMapper(
				$this->container->get('Gateway'),
				'images'
			);
		});
		$this->container->set('App\Model\UserMapper', function () {
			return new \App\Model\UserMapper(
				$this->container->get('Gateway'),
				'users'
			);
		});
		$this->container->set('App\Model\PostMapper', function () {
			return new \App\Model\PostMapper(
				$this->container->get('Gateway'),
				'posts',
				array('UserMapper' => $this->container->get('App\Model\UserMapper'))
			);
		});
		$this->container->set('App\Model\ImageRepository', function () {
			return new \App\Model\ImageRepository(
				$this->container,
				$this->container->get('App\Model\ImageMapper')
			);
		});
		$this->container->set('App\Model\UserRepository', function () {
			return new \App\Model\UserRepository(
				$this->container,
				$this->container->get('App\Model\UserMapper')
			);
		});
		$this->container->set('App\Model\PostRepository', function () {
			return new \App\Model\PostRepository(
				$this->container,
				$this->container->get('App\Model\PostMapper')
			);
		});
		$this->container->set('App\Model\ImageModel', function () {
			return new \App\Model\ImageModel(
				$this->container->get('Toolbox')
			);
		});
		$this->container->set('App\Model\UserModel', function () {
			return new \App\Model\UserModel(
				$this->container->get('Toolbox')
			);
		});
		$this->container->set('App\Model\PostModel', function () {
			return new \App\Model\PostModel(
				$this->container->get('Toolbox'));
		});
	}

	/**
	 * Registers namespaces.
	 *
	 * @param Autoloader $autoloader
	 */
	protected function registerNamespaces(Autoloader $autoloader)
	{
		$this->container->get('Autoloader')->registerNamespace('App\Controller', APP_DIR . '/Controller');
		$this->container->get('Autoloader')->registerNamespace('App\Model', APP_DIR . '/Model');
	}

	/**
	 * Registers routes.
	 *
	 * @param Router $router
	 */
	protected function registerRoutes(Router $router)
	{
	}
}


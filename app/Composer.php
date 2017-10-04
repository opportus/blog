<?php

namespace Hedo\Bootstrap;

use Hedo\Base\AbstractComposer;

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
	protected function registerDependencies(Container $container) {}

	/**
	 * Registers namespaces.
	 *
	 * @param Autoloader $autoloader
	 */
	protected function registerNamespaces(Autoloader $autoloader) {}

	/**
	 * Registers routes.
	 *
	 * @param Router $router
	 */
	protected function registerRoutes(Router $router) {}
}


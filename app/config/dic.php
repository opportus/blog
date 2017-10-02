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
	//'App\Controller\HomeController' => function () use (&$container) {
	//	return new App\Controller\HomeController($container->get('Config'), $container->get('Toolbox'), $container->get('Request'), $container->get('Response'), $container);
	//},
);


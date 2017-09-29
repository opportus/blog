<?php

namespace Hedo\Core;

/**
 * The initializer...
 *
 * @version 0.0.1
 * @package Core
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Initializer
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->init();
	}

	/**
	 * Initializes the core.
	 */
	protected function init()
	{
		$this->define();
		$this->require();

		$container = new Container();

		$this->registerDependencies($container);
		$this->registerNamespaces($container->get('Autoloader'));

		$container->get('Config');
		$container->get('Toolbox');
		$container->get('Gateway');
		$container->get('Session');
		$container->get('Request');
		$container->get('Response');
		$container->get('Router');
		$container->get('Dispatcher');
	}

	/**
	 * Defines constants.
	 */
	protected function define()
	{
		define('ROOT',    dirname(dirname(__FILE__)));

		define('CORE',    ROOT . '/Core');
		define('BASE',    ROOT . '/Core/Base');
		define('APP',     ROOT . '/App');
		define('CONFIG',  APP  . '/config');
		define('WEBROOT', APP  . '/webroot');
	}

	/**
	 * Requires files.
	 */
	protected function require()
	{
		require_once(CORE . '/Container.php');
		require_once(CORE . '/Autoloader.php');
	}

	/**
	 * Registers namespaces.
	 *
	 * @param object $autoloader
	 */
	protected function registerNamespaces($autoloader)
	{
		$autoloader->registerNamespace('Hedo\Core', CORE);

		foreach (require(CONFIG . '/namespaces.php') as $namespace => $dirs) {
			foreach ($dirs as $dir) {
				$autoloader->registerNamespace($namespace, $dir);
			}
		}
	}

	/**
	 * Registers dependencies.
	 *
	 * @param object $container
	 */
	protected function registerDependencies($container)
	{
		$container->set('Autoloader', function () {
			return new Autoloader();
		});
		$container->set('Config', function () {
			return new Config(require(CONFIG . '/dic.php'), require(CONFIG . '/db.php'), require(CONFIG . '/routes.php'), require(CONFIG . '/app.php'));
		});
		$container->set('Toolbox', function () {
			return new Toolbox($container->get('Config'));
		});
		$container->set('Gateway', function () {
			return new Gateway($container->get('Config'), $container->get('Toolbox'));
		});
		$container->set('Session', function () {
			return new Session($container->get('Config'), $container->get('Toolbox'));
		});
		$container->set('Request', function () {
			return new Request($container->get('Config'), $container->get('Toolbox'), $container->get('Session'));
		});
		$container->set('Response', function () {
			return new Response($container->get('Config'), $container->get('Toolbox'));
		});
		$container->set('Router', function () {
			return new Router($container->get('Config'), $container->get('Toolbox'), $container->get('Request'));
		});
		$container->set('Dispatcher', function () {
			return new Dispatcher($container->get('Config'), $container->get('Toolbox'), $container->get('Request'), $container->get('Response'), $container->get('Router'), $container);
		});

		foreach (require(CONFIG . '/dic.php') as $alias => $resolver) {
			$this->set($alias, $resolver);
		}
	}
}


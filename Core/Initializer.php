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

		$autoloader = $container->get('Autoloader');
		$this->registerNamespaces($autoloader);

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

		define('CORE_NAMESPACE', 'Hedo\Core');
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
		$container->set('Toolbox', function () use ($container) {
			return new Toolbox($container->get('Config'));
		});
		$container->set('Gateway', function () use ($container) {
			return new Gateway($container->get('Config'), $container->get('Toolbox'));
		});
		$container->set('Session', function () use ($container) {
			return new Session($container->get('Config'), $container->get('Toolbox'));
		});
		$container->set('Request', function () use ($container) {
			return new Request($container->get('Config'), $container->get('Toolbox'), $container->get('Session'));
		});
		$container->set('Response', function () use ($container) {
			return new Response($container->get('Config'), $container->get('Toolbox'));
		});
		$container->set('Router', function () use ($container) {
			return new Router($container->get('Config'), $container->get('Toolbox'), $container->get('Request'));
		});
		$container->set('Dispatcher', function () use ($container) {
			return new Dispatcher($container->get('Config'), $container->get('Toolbox'), $container->get('Request'), $container->get('Response'), $container->get('Router'), $container);
		});

		foreach (require(CONFIG . '/dic.php') as $alias => $resolver) {
			$container->set($alias, $resolver);
		}
	}

	/**
	 * Registers namespaces.
	 *
	 * @param object $autoloader
	 */
	protected function registerNamespaces($autoloader)
	{
		$autoloader->registerNamespace(CORE_NAMESPACE, CORE);

		foreach (require(CONFIG . '/namespaces.php') as $namespace => $dirs) {
			foreach ($dirs as $dir) {
				$autoloader->registerNamespace($namespace, $dir);
			}
		}
	}
}


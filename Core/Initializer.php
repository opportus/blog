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
		$container->get('Stream');
		$container->get('Uri');
		$container->get('Request');
		$container->get('Response');
		//$container->get('ServerRequest');
		//$container->get('UploadedFile');
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
			return new Config(
				require(CONFIG . '/dic.php'),
				require(CONFIG . '/namespaces.php'),
				require(CONFIG . '/db.php'),
				require(CONFIG . '/routes.php'),
				require(CONFIG . '/app.php')
			);
		});
		$container->set('Toolbox', function () use ($container) {
			return new Toolbox(
				$container->get('Config')
			);
		});
		$container->set('Gateway', function () use ($container) {
			return new Gateway(
				$container->get('Config'),
				$container->get('Toolbox')
			);
		});
		$container->set('Session', function () use ($container) {
			return new Session(
				$container->get('Config'),
				$container->get('Toolbox')
			);
		});
		$container->set('Stream', function () use ($container) {
			return new Stream(
				fopen('php://temp', 'r+')
			);
		});
		$container->set('Uri', function () use ($container) {
			return new Uri(
				$_SERVER['REQUEST_URI']
			);
		});
		$container->set('Request', function () use ($container) {
			return new Request(
				$_SERVER['SERVER_PROTOCOL'],
				$_SERVER['REQUEST_METHOD'],
				getAllHeaders(),
				$container->get('Stream'),
				$container->get('Uri')
			);
		});
		$container->set('Response', function () use ($container) {
			return new Response(
				$container->get('Request')->getProtocolVersion(),
				http_response_code(),
				$container->get('Request')->getHeaders(),
				$container->get('Request')->getBody()
			);
		});
		//$container->set('ServerRequest', function () {
		//	return new ServerRequest();
		//});
		//$container->set('UploadedFile', function () {
		//	return new UploadedFile();
		//});
		$container->set('Router', function () use ($container) {
			return new Router(
				$container->get('Config'),
				$container->get('Toolbox'),
				$container->get('Request')
			);
		});
		$container->set('Dispatcher', function () use ($container) {
			return new Dispatcher(
				$container->get('Config'),
				$container->get('Toolbox'),
				$container->get('Session'),
				$container->get('Request'),
				$container->get('Response'),
				$container->get('Router'),
				$container
			);
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
		$autoloader->registerNamespace('PSR\Http\Message', CORE . '/Vendor/PSR/http-message');

		foreach (require(CONFIG . '/namespaces.php') as $namespace => $dirs) {
			foreach ($dirs as $dir) {
				$autoloader->registerNamespace($namespace, $dir);
			}
		}
	}
}


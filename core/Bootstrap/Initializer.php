<?php

namespace Hedo\Bootstrap;

use Hedo\Abstraction\Config;
use Hedo\Abstraction\Session;
use Hedo\Abstraction\Gateway;
use Hedo\Http\Stream;
use Hedo\Http\Uri;
use Hedo\Http\Request;
use Hedo\Http\Response;
//use Hedo\Http\ServerRequest;
//use Hedo\Http\UploadedFile;
use Hedo\Lib\Toolbox;
use Hedo\Service\Container;
use Hedo\Service\Autoloader;

/**
 * The initializer...
 *
 * @version 0.0.1
 * @package Bootstrap
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
		define('ROOT_DIR', dirname(dirname(dirname(__FILE__))));

		define('CORE_DIR',        ROOT_DIR . '/core');
		define('ABSTRACTION_DIR', CORE_DIR . '/Abstraction');
		define('BASE_DIR',        CORE_DIR . '/Base');
		define('BOOTSTRAP_DIR',   CORE_DIR . '/Bootstrap');
		define('HTTP_DIR',        CORE_DIR . '/Http');
		define('LIB_DIR',         CORE_DIR . '/Lib');
		define('SERVICE_DIR',     CORE_DIR . '/Service');

		define('APP_DIR',     ROOT_DIR . '/app');
		define('CONFIG_DIR',  APP_DIR  . '/config');
		define('WEBROOT_DIR', APP_DIR  . '/webroot');

		define('ABSTRACTION_NS', 'Hedo\Abstraction');
		define('BASE_NS',        'Hedo\Base');
		define('BOOTSTRAP_NS',   'Hedo\Bootstrap');
		define('HTTP_NS',        'Hedo\Http');
		define('LIB_NS',         'Hedo\Lib');
		define('SERVICE_NS',     'Hedo\Service');
	}

	/**
	 * Requires files.
	 */
	protected function require()
	{
		require_once(SERVICE_DIR . '/Container.php');
		require_once(SERVICE_DIR . '/Autoloader.php');
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
				require(CONFIG_DIR . '/dic.php'),
				require(CONFIG_DIR . '/namespaces.php'),
				require(CONFIG_DIR . '/db.php'),
				require(CONFIG_DIR . '/routes.php'),
				require(CONFIG_DIR . '/app.php')
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

		foreach (require(CONFIG_DIR . '/dic.php') as $alias => $resolver) {
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
		$autoloader->registerNamespace(ABSTRACTION_NS, ABSTRACTION_DIR);
		$autoloader->registerNamespace(BASE_NS, BASE_DIR);
		$autoloader->registerNamespace(BOOTSTRAP_NS, BOOTSTRAP_DIR);
		$autoloader->registerNamespace(HTTP_NS, HTTP_DIR);
		$autoloader->registerNamespace(LIB_NS, LIB_DIR);
		$autoloader->registerNamespace(SERVICE_NS, SERVICE_DIR);
		$autoloader->registerNamespace('Psr\Http\Message', CORE_DIR . '/vendors/psr/http-message');

		foreach (require(CONFIG_DIR . '/namespaces.php') as $namespace => $dirs) {
			foreach ($dirs as $dir) {
				$autoloader->registerNamespace($namespace, $dir);
			}
		}
	}
}


<?php

namespace Hedo\Bootstrap;

use Hedo\Service\Autoloader;
use Hedo\Abstraction\Config;
use Hedo\Service\Container;
use Hedo\Abstraction\Gateway;
use Hedo\Http\Request;
use Hedo\Http\Response;
use Hedo\Abstraction\Session;
use Hedo\Http\Stream;
//use Hedo\Http\ServerRequest;
use Hedo\Lib\Toolbox;
//use Hedo\Http\UploadedFile;
use Hedo\Http\Uri;

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

		$container->get('Autoloader');
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
		$container->get('Composer');
	}

	/**
	 * Defines constants.
	 */
	protected function define()
	{
		define('ROOT_DIR',        dirname(dirname(dirname(__FILE__))));
		define('CORE_DIR',        ROOT_DIR . '/core');
		define('ABSTRACTION_DIR', CORE_DIR . '/Abstraction');
		define('BASE_DIR',        CORE_DIR . '/Base');
		define('BOOTSTRAP_DIR',   CORE_DIR . '/Bootstrap');
		define('HTTP_DIR',        CORE_DIR . '/Http');
		define('LIB_DIR',         CORE_DIR . '/Lib');
		define('SERVICE_DIR',     CORE_DIR . '/Service');
		define('APP_DIR',         ROOT_DIR . '/app');
		define('CONFIG_DIR',      APP_DIR  . '/config');
		define('WEBROOT_DIR',     APP_DIR  . '/webroot');

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
			return new Autoloader(
				array(
					ABSTRACTION_NS     => array(ABSTRACTION_DIR),
					BASE_NS            => array(BASE_DIR),
					BOOTSTRAP_NS       => array(BOOTSTRAP_DIR, APP_DIR),
					HTTP_NS            => array(HTTP_DIR),
					LIB_NS             => array(LIB_DIR),
					SERVICE_NS         => array(SERVICE_DIR),
					'Psr\Http\Message' => array(CORE_DIR . '/vendors/psr/http-message'),
				)
			);
		});

		$container->set('Config', function () {
			return new Config(
				array(
					CONFIG_DIR . '/app.php',
					CONFIG_DIR . '/container.php',
					CONFIG_DIR . '/database.php',
					CONFIG_DIR . '/locale.php',
					CONFIG_DIR . '/logger.php',
					CONFIG_DIR . '/router.php',
					CONFIG_DIR . '/security.php',
				)
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

		$container->set('Composer', function () use ($container) {
			return new Composer(
				$container
			);
		});

		foreach (require(CONFIG_DIR . '/container.php') as $alias => $resolver) {
			$container->set($alias, $resolver);
		}
	}
}


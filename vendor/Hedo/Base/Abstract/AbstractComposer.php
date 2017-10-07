<?php

namespace Hedo\Base;

use Hedo\Autoloader;
use Hedo\Config;
use Hedo\Container;
use Hedo\Gateway;
use Hedo\Request;
use Hedo\Response;
use Hedo\Router;
use Hedo\Session;
use Hedo\Stream;
use Hedo\Toolbox;
use Hedo\Uri;

use \Exception;

/**
 * The base composer...
 *
 * @version 0.0.1
 * @package Hedo\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
abstract class AbstractComposer
{
	/**
	 * @var Container $container
	 */
	protected $container;

	/**
	 * Initializes Hedo environement.
	 */
	protected function init()
	{
		$this->define();

		$this->registerContainer();
		$this->registerDependencies();

		$this->container->get('Hedo\Autoloader');
		$this->registerNamespaces();

		$this->container->get('Hedo\Config');
		$this->registerConfig();

		$this->container->get('Hedo\Toolbox');
		$this->container->get('Hedo\Gateway');
		$this->container->get('Hedo\Session');
		$this->container->get('Hedo\Stream');
		$this->container->get('Hedo\Uri');
		$this->container->get('Hedo\Request');
		$this->container->get('Hedo\Response');
		$this->container->get('Hedo\Router');

		$this->registerModules();
	}

	/**
	 * Defines constants.
	 */
	protected function define()
	{
		define('ROOT_DIR',      dirname(dirname(dirname(dirname(dirname(__FILE__))))));
		define('CONFIG_DIR',    ROOT_DIR   . '/config');
		define('MODULE_DIR',    ROOT_DIR   . '/module');
		define('WEBROOT_DIR',   ROOT_DIR   . '/webroot');
		define('VENDOR_DIR',    ROOT_DIR   . '/vendor');
		define('HEDO_DIR',      VENDOR_DIR . '/Hedo');
		define('HEDO_BASE_DIR', HEDO_DIR   . '/Base');

		define('HEDO_NS',       'Hedo');
		define('HEDO_BASE_NS',  'Hedo\Base');
	}

	/**
	 * Registers the container.
	 */
	protected function registerContainer()
	{
		require_once(HEDO_DIR . '/Container.php');

		$this->container = new Container();
	}

	/**
	 * Registers Hedo dependencies.
	 */
	protected function registerDependencies()
	{
		$container = $this->container;

		require_once(HEDO_DIR . '/Autoloader.php');

		$container->set('Hedo\Autoloader', function () {
			return new Autoloader();
		});

		$container->set('Hedo\Config', function () {
			return new Config();
		});

		$container->set('Hedo\Toolbox', function () use ($container) {
			return new Toolbox(
				$container->get('Hedo\Config')
			);
		});

		$container->set('Hedo\Gateway', function () use ($container) {
			return new Gateway(
				$container->get('Hedo\Config'),
				$container->get('Hedo\Toolbox')
			);
		});

		$container->set('Hedo\Session', function () use ($container) {
			return new Session(
				$container->get('Hedo\Toolbox')
			);
		});

		$container->set('Hedo\Stream', function () {
			return new Stream(
				fopen('php://temp', 'r+')
			);
		});

		$container->set('Hedo\Uri', function () {
			return new Uri(
				$_SERVER['REQUEST_SCHEME'],
				isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '',
				isset($_SERVER['PHP_AUTH_USER_PW']) ? $_SERVER['PHP_AUTH_USER_PW'] : '',
				$_SERVER['HTTP_HOST'],
				(int) $_SERVER['SERVER_PORT'],
				current(explode('?', $_SERVER['REQUEST_URI'])),
				$_SERVER['QUERY_STRING'],
				''
			);
		});

		$container->set('Hedo\Request', function () use ($container) {
			return new Request(
				$_SERVER['SERVER_PROTOCOL'],
				$_SERVER['REQUEST_METHOD'],
				getAllHeaders(),
				$container->get('Hedo\Stream'),
				$container->get('Hedo\Uri')
			);
		});

		$container->set('Hedo\Response', function () use ($container) {
			return new Response(
				$container->get('Hedo\Request')->getProtocolVersion(),
				http_response_code(),
				array(),
				$container->get('Hedo\Stream')
			);
		});

		$container->set('Hedo\Router', function () use ($container) {
			return new Router(
				$container->get('Hedo\Request')
			);
		});
	}

	/**
	 * Registers Hedo namespaces.
	 */
	protected function registerNamespaces()
	{
		$autoloader = $this->container->get('Hedo\Autoloader');

		$autoloader->registerNamespace(HEDO_NS, HEDO_DIR);
		$autoloader->registerNamespace(HEDO_BASE_NS, HEDO_BASE_DIR . '/Abstract');
		$autoloader->registerNamespace(HEDO_BASE_NS, HEDO_BASE_DIR . '/Interface');
		$autoloader->registerNamespace('Psr\Http\Message', HEDO_BASE_DIR . '/Interface');
	}

	/**
	 * Registers config.
	 */
	protected function registerConfig()
	{
		$config = $this->container->get('Hedo\Config');

		foreach ($this->scanConfig() as $entity => $settings) {
			foreach ($settings as $setting => $keys) {
				foreach ($keys as $key => $value) {
					$config->set($entity, $setting, $key, $value);
				}
			}
		}
	}

	/**
	 * Registers modules dependencies.
	 */
	protected function registerModules()
	{
		$container  = $this->container;
		$config     = $container->get('Hedo\Config');
		$autoloader = $container->get('Hedo\Autoloader');
		$router     = $container->get('Hedo\Router');
		$modules    = $this->activateModules();
		$settings   = array(
			'container',
			'autoloader',
			'router'
		);

		foreach ($modules as $module) {
			$moduleDir  = substr($module, strrpos($module, '\\') + 1);
			foreach ($settings as $setting) {
				foreach ($config->get($moduleDir, $setting) as $key => $value) {
					switch ($setting) {
						case 'container':
							$container->set($key, $value);
							break;
						case 'autoloader':
							foreach ($value as $subvalue) {
								$autoloader->registerNamespace($key, $subvalue);
							}
							break;
						case 'router':
							$router->registerRoute($key, $value);
							break;
					}
				}
			}
		}

		foreach ($modules as $module) {
			$class = $module . '\\' . substr($module, strrpos($module, '\\') + 1) . 'Module';
			new $class();
		}
	}

	/**
	 * Scans config dirs across the app.
	 *
	 * @return array $settings
	 */
	protected function scanConfig()
	{
		$container = $this->container;
		$settings  = array();

		foreach (scandir(MODULE_DIR) as $module) {
			if ($module === '.' || $module === '..' || is_file($module)) {
				continue;
			}

			$moduleConfigDir = MODULE_DIR . '/' . $module . '/config';

			foreach (scandir($moduleConfigDir) as $file) {
				if ($file === '.' || $file === '..' || is_dir($file)) {
					continue;
				}

				$moduleConfigFile = $moduleConfigDir . '/' .$file;
				$setting = substr($file, 0, strpos($file, '.php'));
				$settings[$module][$setting] = include($moduleConfigFile);
			}
		}

		foreach (scandir(ROOT_DIR . '/config') as $file) {
			if ($file === '.' || $file === '..' || is_dir($file)) {
				continue;
			}

			$appConfigFile = ROOT_DIR . '/config/' .$file;
			$setting = substr($file, 0, strpos($file, '.php'));
			$settings['App'][$setting] = include($appConfigFile);
		}

		return $settings;
	}

	/**
	 * Runs the app.
	 *
	 * @throws Exception 500 status when controller not found.
	 */
	protected function run()
	{
		$endpoint = $this->container->get('Hedo\Router')->resolveRoute();
		
		try {
			if (! class_exists($endpoint['controller']) || ! method_exists($endpoint['controller'], $endpoint['action'])) {
				throw new Exception('Controller/Action not found! Check your routes and endpoints...');
			}

		$container = $this->container;
			$controller = $container->get($endpoint['controller']);

			call_user_func_array(
				array(
					$controller,
					$endpoint['action']
				),
				$endpoint['params']
			);

		} catch (Exception $e) {
			if ($this->container->get('Hedo\Config')->get('App', 'logger', 'debug') >= 1) {
				error_log($e->getMessage());
			}

			$this->container->get('Hedo\Response')->withStatus(500)->send();

			die();
		}
	}
}


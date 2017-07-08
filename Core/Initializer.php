<?php

namespace Core;

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
		$this->_init();
	}

	/**
	 * Initializes the core.
	 */
	private function _init()
	{
		$this->_define();
		$this->_require();

		$container = new Container();

		$container->get('Autoloader');
		$container->get('Config');
		$container->get('Toolbox');
		$container->get('Gateway');
		$container->get('Request');
		$container->get('Response');
		$container->get('Router');
		$container->get('Dispatcher');
	}

	/**
	 * Defines constants.
	 */
	private function _define()
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
	private function _require()
	{
		require_once(CORE . '/Container.php');
		require_once(CORE . '/Autoloader.php');
	}
}


<?php

namespace Core;

/**
 * The autoloader...
 *
 * @version 0.0.1
 * @package Core
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Autoloader
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->_register();
	}

	/**
	 * Registers SPL autoload callback.
	 */
	private function _register()
	{
		spl_autoload_register(array($this, 'autoload'));
	}

	/**
	 * Autoload callback.
	 *
	 * @param string $class
	 */
	public function autoload($class)
	{
		$file = str_replace('\\', '/', $class);
		$file = ROOT . '/'. $file . '.php';	

		if (file_exists($file)) {
			require_once($file);
		}
	}
}


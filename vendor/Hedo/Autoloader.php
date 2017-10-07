<?php

namespace Hedo;

/**
 * The autoloader...
 *
 * @version 0.0.1
 * @package Hedo
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Autoloader
{
	/**
	 * @var array $namespaces
	 */
	protected $namespaces = array();

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->init();
	}

	/**
	 * Initializes autoloader.
	 */
	protected function init()
	{
		$this->registerAutoload();
	}

	/**
	 * Registers a namespace for a directory.
	 *
	 * @param string $namespace
	 * @param string $dir
	 * @param bool   $prepend
	 */
	public function registerNamespace($namespace, $dir, $prepend = false)
	{
		// Normalizes params...
		$namespace = trim($namespace, '\\') . '\\';
		$dir       = rtrim($dir, '/') . '/';

		if (isset($this->namespaces[$namespace]) === false) {
			$this->namespaces[$namespace] = array();
		}

		if ($prepend) {
			array_unshift($this->namespaces[$namespace], $dir);

		} else {
			array_push($this->namespaces[$namespace], $dir);
		}
	}

	/**
	 * Registers SPL autoload callback.
	 */
	protected function registerAutoload()
	{
		spl_autoload_register(array($this, 'loadClass'));
	}

	/**
	 * SPL Autoloader's callback.
	 *
	 * @param  string $FQClass
	 * @return mixed  string|bool
	 */
	public function loadClass($FQClass)
	{
		$namespace = $FQClass;

		while (false !== $pos = strrpos($namespace, '\\')) {
			$namespace     = substr($FQClass, 0, $pos + 1);
			$class         = substr($FQClass, $pos + 1);
			$file          = $this->loadFile($namespace, $class);

			if ($file) {
				return $file;
			}

			$namespace = rtrim($namespace, '\\');
		}

		return false;
	}

	/**
	 * Loads the file.
	 *
	 * @param  string $namespace
	 * @param  string $class
	 * @return mixed  string|bool
	 */
	protected function loadFile($namespace, $class)
	{
		if (isset($this->namespaces[$namespace]) === false) {
			return false;
		}

		foreach ($this->namespaces[$namespace] as $dir) {
			$file = $dir . str_replace('\\', '/', $class) . '.php';

			if ($this->requireFile($file)) {
				return $file;
			}
		}

		return false;
	}

	/**
	 * Requires the file.
	 *
	 * @param  string $file
	 * @return bool
	 */
	protected function requireFile($file)
	{
		if (file_exists($file)) {
			require $file;

			return true;
		}

		return false;
	}
}


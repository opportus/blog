<?php

namespace Core;

/**
 * The dependency injection container...
 *
 * @version 0.0.1
 * @package Core
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Container
{
	/**
	 * @var array $_registry
	 */
	private $_registry = array();

	/**
	 * @var array $_instances
	 */
	private $_instances = array();

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->_init();
	}

	/**
	 * Initializes the container.
	 */
	private function _init()
	{
		$this->set('Autoloader', function () {
			return new Autoloader();
		});
		$this->set('Config', function () {
			return new Config(require(CONFIG . '/dic.php'), require(CONFIG . '/db.php'), require(CONFIG . '/routes.php'), require(CONFIG . '/app.php'));
		});
		$this->set('Toolbox', function () {
			return new Toolbox($this->get('Config'));
		});
		$this->set('Gateway', function () {
			return new Gateway($this->get('Config'), $this->get('Toolbox'));
		});
		$this->set('Request', function () {
			return new Request();
		});
		$this->set('Response', function () {
			return new Response();
		});
		$this->set('Router', function () {
			return new Router($this->get('Config'), $this->get('Request'));
		});
		$this->set('Dispatcher', function () {
			return new Dispatcher($this->get('Config'), $this->get('Toolbox'), $this->get('Request'), $this->get('Response'), $this->get('Router'), $this);
		});

		foreach (require(CONFIG . '/dic.php') as $alias => $resolver) {
			$this->set($alias, $resolver);
		}
	}

	/**
	 * Sets registry entry.
	 *
	 * @param string   $alias
	 * @param callable $resolver
	 */
	public function set($alias, Callable $resolver)
	{
		$this->_registry[$alias] = $resolver;
	}

	/**
	 * Gets registry entry.
	 *
	 * @param  string $alias
	 * @return object
	 */
	public function get($alias)
	{
		if (! isset($this->_instances[$alias])) {
			$this->_instances[$alias] = $this->_registry[$alias]();
		}

		return $this->_instances[$alias];
	}

	/**
	 * Checks if the given entry exists in the registry.
	 *
	 * @param  string $alias
	 * @return bool
	 */
	public function has($alias)
	{
		return isset($this->_registry[$alias]) ? true : false;
	}
}


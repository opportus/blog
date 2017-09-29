<?php

namespace Hedo\Core;

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


<?php

namespace Hedo;

/**
 * The dependency injection container...
 *
 * @version 0.0.1
 * @package Hedo
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Container
{
	/**
	 * @var array $registry
	 */
	protected $registry = array();

	/**
	 * @var array $instances
	 */
	protected $instances = array();

	/**
	 * Sets registry entry.
	 *
	 * @param string   $alias
	 * @param callable $resolver
	 */
	public function set($alias, Callable $resolver)
	{
		$this->registry[$alias] = $resolver;
	}

	/**
	 * Gets registry entry.
	 *
	 * @param  string $alias
	 * @return object
	 */
	public function get($alias)
	{
		if (! isset($this->instances[$alias])) {
			$this->instances[$alias] = $this->registry[$alias]();
		}

		return $this->instances[$alias];
	}

	/**
	 * Checks if the given entry exists in the registry.
	 *
	 * @param  string $alias
	 * @return bool
	 */
	public function has($alias)
	{
		return isset($this->registry[$alias]) ? true : false;
	}
}


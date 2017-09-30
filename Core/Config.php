<?php

namespace Hedo\Core;

/**
 * The configuration...
 *
 * @version 0.0.1
 * @package Core
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Config
{
	/**
	 * @var array $dic
	 */
	protected $dic = array();

	/**
	 * @var array $namespaces
	 */
	protected $namespaces = array();

	/**
	 * @var array $db
	 */
	protected $db = array();

	/**
	 * @var array $routes
	 */
	protected $routes = array();

	/**
	 * @var array $app
	 */
	protected $app = array();

	/**
	 * Constructor.
	 *
	 * @param array $dic
	 * @param array $namespaces
	 * @param array $db
	 * @param array $routes
	 * @param array $app
	 */
	public function __construct(array $dic, array $namespaces, array $db, array $routes, array $app)
	{
		$this->init($dic, $namespaces, $db, $routes, $app);
	}

	/**
	 * Initializes the config.
	 *
	 * @param array $dic
	 * @param array $namespaces
	 * @param array $db
	 * @param array $routes
	 * @param array $app
	 */
	protected function init(array $dic, array $namespaces, array $db, array $routes, array $app)
	{
		$this->dic        = $dic;
		$this->namespaces = $namespaces;
		$this->db         = $db;
		$this->routes     = $routes;
		$this->app        = $app;
	}

	/**
	 * Gets DIC configuration.
	 *
	 * @param  string $setting    Default: ''
	 * @return array  $this->dic
	 */
	public function getDic($setting = '')
	{
		if (isset($this->dic[$setting])) {
			return $this->dic[$setting];
		}

		return $this->dic;
	}

	/**
	 * Gets namespaces configuration.
	 *
	 * @param  string $setting           Default: ''
	 * @return array  $this->namespaces
	 */
	public function getNamespaces($setting = '')
	{
		if (isset($this->namespaces[$setting])) {
			return $this->namespaces[$setting];
		}

		return $this->namespaces;
	}

	/**
	 * Gets database configuration.
	 *
	 * @param  string $setting   Default: ''
	 * @return array  $this->db
	 */
	public function getDb($setting = '')
	{
		if (isset($this->db[$setting])) {
			return $this->db[$setting];
		}

		return $this->db;
	}

	/**
	 * Gets routes configuration.
	 *
	 * @param  string $setting       Default: ''
	 * @return array  $this->routes
	 */
	public function getRoutes($setting = '')
	{
		if (isset($this->routes[$setting])) {
			return $this->routes[$setting];
		}

		return $this->routes;
	}

	/**
	 * Gets app configuration.
	 *
	 * @param  string $setting    Default: ''
	 * @return array  $this->app
	 */
	public function getApp($setting = '')
	{
		if (isset($this->app[$setting])) {
			return $this->app[$setting];
		}

		return $this->app;
	}
}


<?php

namespace Core;

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
	 * @var array $_dic
	 */
	private $_dic = array();

	/**
	 * @var array $_db
	 */
	private $_db = array();

	/**
	 * @var array $_routes
	 */
	private $_routes = array();

	/**
	 * @var array $_app
	 */
	private $_app = array();

	/**
	 * Constructor.
	 *
	 * @param array $dic
	 * @param array $db
	 * @param array $routes
	 * @param array $app
	 */
	public function __construct(array $dic, array $db, array $routes, array $app)
	{
		$this->_init($dic, $db, $routes, $app);
	}

	/**
	 * Initializes the config.
	 *
	 * @param array $dic
	 * @param array $db
	 * @param array $routes
	 * @param array $app
	 */
	private function _init(array $dic, array $db, array $routes, array $app)
	{
		$this->_dic    = $dic;
		$this->_db     = $db;
		$this->_routes = $routes;
		$this->_app    = $app;
	}

	/**
	 * Gets DIC configuration.
	 *
	 * @param  string $setting    Default: ''
	 * @return array  $this->_dic
	 */
	public function getDic($setting = '')
	{
		if (isset($this->_dic[$setting])) {
			return $this->_dic[$setting];
		}

		return $this->_dic;
	}

	/**
	 * Gets database configuration.
	 *
	 * @param  string $setting   Default: ''
	 * @return array  $this->_db
	 */
	public function getDb($setting = '')
	{
		if (isset($this->_db[$setting])) {
			return $this->_db[$setting];
		}

		return $this->_db;
	}

	/**
	 * Gets routes configuration.
	 *
	 * @param  string $setting       Default: ''
	 * @return array  $this->_routes
	 */
	public function getRoutes($setting = '')
	{
		if (isset($this->_routes[$setting])) {
			return $this->_routes[$setting];
		}

		return $this->_routes;
	}

	/**
	 * Gets app configuration.
	 *
	 * @param  string $setting    Default: ''
	 * @return array  $this->_app
	 */
	public function getApp($setting = '')
	{
		if (isset($this->_app[$setting])) {
			return $this->_app[$setting];
		}

		return $this->_app;
	}
}


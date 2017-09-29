<?php

namespace Hedo\Core;

/**
 * The router...
 *
 * @version 0.0.1
 * @package Core
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Router
{
	/**
	 * @var object $_config
	 */
	private $_config;

	/**
	 * @var object $_toolbox
	 */
	private $_toolbox;

	/**
	 * @var object $_request
	 */
	private $_request;

	/**
	 * @var array $_route
	 */
	private $_route = array();

	/**
	 * Constructor.
	 *
	 * @param object $config
	 * @param pbject $toolbox
	 * @param object $request
	 */
	public function __construct(Config $config, Toolbox $toolbox, Request $request)
	{
		$this->_init($config, $toolbox, $request);
	}

	/**
	 * Initializes the router.
	 *
	 * @param object $config
	 * @param pbject $toolbox
	 * @param object $request
	 */
	private function _init(Config $config, Toolbox $toolbox, Request $request)
	{
		$this->_config  = $config;
		$this->_toolbox = $toolbox;
		$this->_request = $request;

		$this->_setRoute();
	}

	/**
	 * Sets the route.
	 */
	private function _setRoute()
	{
		foreach ($this->_config->getRoutes() as $route => $settings) {
			if (preg_match($route, $this->_request->getUri(), $matches)) {
				$this->_route['controller'] = isset($settings['controller']) ? $settings['controller'] : '';
				$this->_route['action']     = isset($settings['action']) ? $settings['action'] : '';
				$this->_route['params']     = isset($matches[1]) ? explode('/', trim($matches[1], '/')) : array('');

				break;
			}
		}
	}
	
	/**
	 * Gets the route.
	 *
	 * @param  string       $segment 3 possibilities: 'controller', 'action', 'params'
	 * @return string|array
	 */
	public function getRoute($segment = '')
	{
		if (isset($this->_route[$segment])) {
			return $this->_route[$segment];
		} elseif ('' === $segment) {
			return $this->_route;
		} else {
			return '';
		}
	}
}


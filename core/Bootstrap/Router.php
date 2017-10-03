<?php

namespace Hedo\Bootstrap;

use Hedo\Abstraction\Config;
use Hedo\Http\Request;
use Hedo\Lib\Toolbox;

/**
 * The router...
 *
 * @version 0.0.1
 * @package Bootstrap
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Router
{
	/**
	 * @var object $config
	 */
	protected $config;

	/**
	 * @var object $toolbox
	 */
	protected $toolbox;

	/**
	 * @var object $request
	 */
	protected $request;

	/**
	 * @var array $route
	 */
	protected $route = array();

	/**
	 * Constructor.
	 *
	 * @param Config  $config
	 * @param Toolbox $toolbox
	 * @param Request $request
	 */
	public function __construct(Config $config, Toolbox $toolbox, Request $request)
	{
		$this->init($config, $toolbox, $request);
	}

	/**
	 * Initializes the router.
	 *
	 * @param Config  $config
	 * @param Toolbox $toolbox
	 * @param Request $request
	 */
	protected function init(Config $config, Toolbox $toolbox, Request $request)
	{
		$this->config  = $config;
		$this->toolbox = $toolbox;
		$this->request = $request;

		$this->setRoute();
	}

	/**
	 * Sets the route.
	 */
	protected function setRoute()
	{
		foreach ($this->config->get('router') as $route => $settings) {
			if (preg_match($route, $this->request->getUri()->getPath(), $matches)) {
				$this->route['controller'] = isset($settings['controller']) ? $settings['controller'] : '';
				$this->route['action']     = isset($settings['action']) ? $settings['action'] : '';
				$this->route['params']     = isset($matches[1]) ? explode('/', trim($matches[1], '/')) : array('');

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
		if (isset($this->route[$segment])) {
			return $this->route[$segment];
		} elseif ('' === $segment) {
			return $this->route;
		} else {
			return '';
		}
	}
}


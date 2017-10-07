<?php

namespace Hedo;

use Hedo\Config;
use Hedo\Request;
use Hedo\Toolbox;

/**
 * The router...
 *
 * @version 0.0.1
 * @package Hedo
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Router
{
	/**
	 * @var Request $request
	 */
	protected $request;

	/**
	 * @var array $routes
	 */
	protected $routes = array();

	/**
	 * @var array $endpoint
	 */
	protected $endpoint;

	/**
	 * Constructor.
	 *
	 * @var Request $request
	 */
	public function __construct(Request $request)
	{
		$this->init($request);
	}

	/**
	 * Initializes the router.
	 *
	 * @param Request $request
	 */
	protected function init(Request $request)
	{
		$this->request = $request;
	}

	/**
	 * Registers the route.
	 *
	 * @param string $path
	 * @param array  $endpoint
	 */
	public function registerRoute(string $path, array $endpoint)
	{
		$this->routes[$path] = $endpoint;
	}


	/**
	 * Resolves the route.
	 *
	 * @return array $this->endpoint
	 */
	public function resolveRoute()
	{
		foreach ($this->routes as $path => $endpoint) {
			if (preg_match($path, $this->request->getUri()->getPath(), $matches)) {
				$this->endpoint['controller'] = $endpoint['controller'];
				$this->endpoint['action']     = $endpoint['action'];
				$this->endpoint['params']     = isset($matches[1]) ? explode('/', trim($matches[1], '/')) : array('');

				break;
			}
		}

		return $this->endpoint;
	}
	
	/**
	 * Gets the endpoint.
	 *
	 * @param  string $endpoint
	 * @return mixed
	 */
	public function getEndpoint(string $endpoint = '')
	{
		$endpoint = strtolower($endpoint);

		switch ($endpoint) {
			case '':
				return $this->endpoint;
			case 'controller':
			case 'action':
			case 'params':
				return $this->endpoint[$endpoint];
			default:
				return false;
		}
	}
}


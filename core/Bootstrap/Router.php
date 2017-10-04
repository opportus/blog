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

		foreach ($this->config->get('router') as $path => $endpoint) {
			$this->registerRoute($path, $endpoint);
		}

		$this->resolveRoute();
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
	protected function resolveRoute()
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


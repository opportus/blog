<?php

namespace Hedo\Bootstrap;

use Hedo\Abstraction\Config;
use Hedo\Abstraction\Session;
use Hedo\Http\Request;
use Hedo\Http\Response;
use Hedo\Lib\Toolbox;
use Hedo\Service\Container;

use \Exception;

/**
 * The dispatcher...
 *
 * @version 0.0.1
 * @package Bootstrap
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Dispatcher
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
	 * @var object $session
	 */
	protected $session;

	/**
	 * @var object $request
	 */
	protected $request;

	/**
	 * @var object $response
	 */
	protected $response;

	/**
	 * @var object $router
	 */
	protected $router;

	/**
	 * @var object $container
	 */
	protected $container;

	/**
	 * @var object|bool $controller
	 */
	protected $controller;

	/**
	 * Constructor.
	 *
	 * @param object $config
	 * @param object $toolbox
	 * @param object $session
	 * @param object $request
	 * @param object $response
	 * @param object $router
	 * @param object $container
	 */
	public function __construct(Config $config, Toolbox $toolbox, Session $session, Request $request, Response $response, Router $router, Container $container)
	{
		$this->init($config, $toolbox, $session, $request, $response, $router, $container);
	}

	/**
	 * Initializes the dispatcher.
	 *
	 * @param object $config
	 * @param object $toolbox
	 * @param object $session
	 * @param object $request
	 * @param object $response
	 * @param object $router
	 * @param object $container
	 */
	protected function init(Config $config, Toolbox $toolbox, Session $session, Request $request, Response $response, Router $router, Container $container)
	{
		$this->config    = $config;
		$this->toolbox   = $toolbox;
		$this->session   = $session;
		$this->request   = $request;
		$this->response  = $response;
		$this->router    = $router;
		$this->container = $container;

		$this->dispatch();
	}

	/**
	 * Dispatches.
	 */
	protected function dispatch()
	{
		try {
			$this->loadController();

			call_user_func_array(array($this->controller, $this->router->getRoute('action')), $this->router->getRoute('params'));

		} catch (Exception $e) {
			if ($this->config->getApp('debug') >= 1) {
				error_log($e->getMessage());
			}

			$this->response->withStatus(500)->send();

			die();
		}
	}

	/**
	 * Loads the controller.
	 */
	protected function loadController()
	{
		$controller = $this->router->getRoute('controller');
		$action     = $this->router->getRoute('action');

		if (! class_exists($controller) || ! method_exists($controller, $action)) {
			throw new Exception('Controller/Action not found ! Check your route and controller...');
		}

		$this->controller = $this->container->get($controller);
	}
}


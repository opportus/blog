<?php

namespace Core;

use \Exception;

/**
 * The dispatcher...
 *
 * @version 0.0.1
 * @package Core
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Dispatcher
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
	 * @var object $_response
	 */
	private $_response;

	/**
	 * @var object $_router
	 */
	private $_router;

	/**
	 * @var object $_container
	 */
	private $_container;

	/**
	 * @var object|bool $_controller
	 */
	private $_controller;

	/**
	 * Constructor.
	 *
	 * @param object $config
	 * @param object $toolbox
	 * @param object $request
	 * @param object $response
	 * @param object $router
	 * @param object $container
	 */
	public function __construct(Config $config, Toolbox $toolbox, Request $request, Response $response, Router $router, Container $container)
	{
		$this->_init($config, $toolbox, $request, $response, $router, $container);
	}

	/**
	 * Initializes the dispatcher.
	 *
	 * @param object $config
	 * @param object $toolbox
	 * @param object $request
	 * @param object $response
	 * @param object $router
	 * @param object $container
	 */
	private function _init(Config $config, Toolbox $toolbox, Request $request, Response $response, Router $router, Container $container)
	{
		$this->_config    = $config;
		$this->_toolbox   = $toolbox;
		$this->_request   = $request;
		$this->_response  = $response;
		$this->_router    = $router;
		$this->_container = $container;

		$this->_dispatch();
	}

	/**
	 * Dispatches.
	 */
	private function _dispatch()
	{
		try {
			$this->_loadController();

			call_user_func_array(array($this->_controller, $this->_router->getRoute('action')), $this->_router->getRoute('params'));

		} catch (Exception $e) {
			if ($this->_config->getApp('debug') >= 1) {
				error_log($e->getMessage());
			}

			$this->_response->setCode(500);
			$this->_response->send();

			die();
		}
	}

	/**
	 * Loads the controller.
	 */
	private function _loadController()
	{
		$controller = $this->_router->getRoute('controller');
		$action     = $this->_router->getRoute('action');

		if (! class_exists($controller) || ! method_exists($controller, $action)) {
			throw new Exception('Controller/Action not found ! Check your route and controller...');
		}

		$this->_controller = $this->_container->get($controller);
	}
}


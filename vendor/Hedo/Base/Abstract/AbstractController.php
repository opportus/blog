<?php

namespace Hedo\Base;

use Hedo\Config;
use Hedo\Request;
use Hedo\Response;
use Hedo\Session;
use Hedo\Toolbox;

/**
 * The base controller...
 *
 * @version 0.0.1
 * @package Hedo\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
abstract class AbstractController implements ControllerInterface
{
	/**
	 * @var Config $config
	 */
	protected $config;

	/**
	 * @var Toolbox $toolbox
	 */
	protected $toolbox;

	/**
	 * @var Session $session
	 */
	protected $session;

	/**
	 * @var Request $request
	 */
	protected $request;

	/**
	 * @var Response $response
	 */
	protected $response;

	/**
	 * @var array $repositories
	 */
	protected $repositories;

	/**
	 * @var array $factories
	 */
	protected $factories;

	/**
	 * Constructor.
	 *
	 * @param Config   $config
	 * @param Toolbox  $toolbox
	 * @param Session  $session
	 * @param Request  $request
	 * @param Response $response
	 * @param array  $repositories Default:array()
	 * @param array  $factories    Default:array()
	 */
	public function __construct(Config $config, Toolbox $toolbox, Session $session, Request $request, Response $response, array $repositories = array(), array $factories = array())
	{
		$this->init($config, $toolbox, $session, $request, $response, $repositories, $factories);
	}

	/**
	 * Initializes the controller.
	 *
	 * @param Config   $config
	 * @param Toolbox  $toolbox
	 * @param Session  $session
	 * @param Request  $request
	 * @param Response $response
	 * @param array  $repositories Default:array()
	 * @param array  $factories    Default:array()
	 */
	protected function init(Config $config, Toolbox $toolbox, Session $session, Request $request, Response $response, array $repositories = array(), array $factories = array())
	{
		$this->config       = $config;
		$this->toolbox      = $toolbox;
		$this->session      = $session;
		$this->request      = $request;
		$this->response     = $response;
		$this->repositories = $repositories;
		$this->factories    = $factories;
	}

	/**
	 * Renders the view.
	 *
	 * @param  string $view
	 * @param  array  $data
	 * @return string $view
	 */
	public function render($view, array $data)
	{
		$config  = $this->config;
		$toolbox = $this->toolbox;

		extract($data);

		ob_start();
		require_once($view);
		$view = ob_get_clean();

		return $view;
	}
}


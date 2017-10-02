<?php

namespace Hedo\Base;

use Hedo\Abstraction\Config;
use Hedo\Lib\Toolbox;
use Hedo\Abstraction\Session;
use Hedo\Http\Request;
use Hedo\Http\Response;
use Hedo\Service\Container;

/**
 * The base controller...
 *
 * @version 0.0.1
 * @package Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
abstract class AbstractController implements ControllerInterface
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
	 * @var object $container
	 */
	protected $container;

	/**
	 * Constructor.
	 *
	 * @param object $config
	 * @param object $toolbox
	 * @param object $session
	 * @param object $request
	 * @param object $response
	 * @param object $container
	 */
	public function __construct(Config $config, Toolbox $toolbox, Session $session, Request $request, Response $response, Container $container)
	{
		$this->init($config, $toolbox, $session, $request, $response, $container);
	}

	/**
	 * Initializes the controller.
	 *
	 * @param object $config
	 * @param object $toolbox
	 * @param object $session
	 * @param object $request
	 * @param object $response
	 * @param object $container
	 */
	protected function init(Config $config, Toolbox $toolbox, Session $session, Request $request, Response $response, Container $container)
	{
		$this->config    = $config;
		$this->toolbox   = $toolbox;
		$this->session   = $session;
		$this->request   = $request;
		$this->response  = $response;
		$this->container = $container;
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
		require_once(APP . '/View/' . $view . '.php');
		$view = ob_get_clean();

		return $view;
	}
}


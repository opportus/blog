<?php

namespace Hedo\Base;

use Hedo\Abstraction\Config;
use Hedo\Http\Request;
use Hedo\Http\Response;
use Hedo\Abstraction\Session;
use Hedo\Lib\Toolbox;

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
	 * Constructor.
	 *
	 * @param object $config
	 * @param object $toolbox
	 * @param object $session
	 * @param object $request
	 * @param object $response
	 */
	public function __construct(Config $config, Toolbox $toolbox, Session $session, Request $request, Response $response)
	{
		$this->init($config, $toolbox, $session, $request, $response);
	}

	/**
	 * Initializes the controller.
	 *
	 * @param object $config
	 * @param object $toolbox
	 * @param object $session
	 * @param object $request
	 * @param object $response
	 */
	protected function init(Config $config, Toolbox $toolbox, Session $session, Request $request, Response $response)
	{
		$this->config    = $config;
		$this->toolbox   = $toolbox;
		$this->session   = $session;
		$this->request   = $request;
		$this->response  = $response;
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


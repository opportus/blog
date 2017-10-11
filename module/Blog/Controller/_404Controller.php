<?php

namespace OC\Blog\Controller;

use Hedo\Base\AbstractController;
use Hedo\Base\ControllerInterface;

use Hedo\Config;
use Hedo\Response;
use Hedo\Toolbox;

/**
 * The 404 controller...
 *
 * @version 0.0.1
 * @package OC\Blog\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class _404Controller extends AbstractBlogController implements ControllerInterface
{
	/**
	 * @var Config $config
	 */
	protected $config;

	/**
	 * @var Response $response
	 */
	protected $response;

	/**
	 * @var Toolbox $toolbox
	 */
	protected $toolbox;

	/**
	 * Constructor.
	 *
	 * @param Config   $config
	 * @param Response $response
	 * @param Toolbox  $toolbox
	 */
	public function __construct(Config $config, Response $reponse, Toolbox $toolbox)
	{
		$this->init($config, $response, $toolbox);
	}

	/**
	 * Initializes the asset controller.
	 *
	 * @param Config   $config
	 * @param Response $response
	 * @param Toolbox  $toolbox
	 */
	protected function init(Config $config, Response $response, Toolbox $toolbox)
	{
		$this->config   = $config;
		$this->response = $response;
		$this->toolbox  = $toolbox;
	}

	/**
	 * Renders the view.
	 */
	public function view()
	{
		$this->action404();
	}
}


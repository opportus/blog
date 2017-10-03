<?php

namespace Hedo\Base;

use Hedo\Service\Container;

/**
 * The abstract composer...
 *
 * @version 0.0.1
 * @package Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class AbstractComposer implements ComposerInterface
{
	/**
	 * @var Container $container
	 */
	protected $container;

	/**
	 * Constructor.
	 *
	 * @param Container $container
	 */
	public function __construct(Container $container)
	{
		$this->init($container);
	}

	/**
	 * Initializes your app.
	 *
	 * @param Container $container
	 */
	protected function init(Container $container)
	{
		$this->container = $container;

		$this->setControl();
	}

	/**
	 * Sets control.
	 */
	protected function setControl()
	{
		$this->dispatch();
	}

	/**
	 * Dispatches.
	 */
	protected function dispatch()
	{
		$controller = $this->container->get('Router')->getRoute('controller');
		$action     = $this->container->get('Router')->getRoute('action');

		try {
			if (! class_exists($controller) || ! method_exists($controller, $action)) {
				throw new Exception('Controller/Action not found ! Check your route and controller...');
			}

			$controller = $this->container->get($controller);

			call_user_func_array(
				array(
					$controller,
					$this->container->get('Router')->getRoute('action')
				),
				$this->container->get('Router')->getRoute('params')
			);

		} catch (Exception $e) {
			if ($this->container->get('Config')->get('logger', 'debug') >= 1) {
				error_log($e->getMessage());
			}

			$this->container->get('Response')->withStatus(500)->send();

			die();
		}
	}
}


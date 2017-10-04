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

		$this->registerDependencies($this->container);
		$this->registerNamespaces($this->container->get('Autoloader'));
		$this->registerRoutes($this->container->get('Router'));

		$this->dispatch();
	}

	/**
	 * Registers dependencies.
	 *
	 * @param Container $container
	 */
	protected function registerDependencies(Container $container) {}

	/**
	 * Registers namespaces.
	 *
	 * @param Autoloader $autoloader
	 */
	protected function registerNamespaces(Autoloader $autoloader) {}

	/**
	 * Registers routes.
	 *
	 * @param Router $router
	 */
	protected function registerRoutes(Router $router) {}

	/**
	 * Dispatches.
	 */
	protected function dispatch()
	{
		$endpoint = $this->container->get('Router')->resolveRoute();
		
		try {
			if (! class_exists($endpoint['controller']) || ! method_exists($endpoint['controller'], $endpoint['action'])) {
				throw new Exception('Controller/Action not found! Check your routes and endpoints...');
			}

			$controller = $this->container->get($endpoint['controller']);

			call_user_func_array(
				array(
					$controller,
					$endpoint['action']
				),
				$endpoint['params']
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


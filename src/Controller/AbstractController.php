<?php

namespace Opportus\Blog;

/**
 * The abstract controller...
 *
 * @version 0.0.1
 * @package Opportus\Blog
 * @author  Clément Cazaud <opportus@gmail.com>
 */
abstract class AbstractController
{
	/**
	 * Renders the view.
	 *
	 * @param  string $view
	 * @param  array  $vars Default:array()
	 * @return string $view
	 */
	protected function render(string $view, array $vars = array())
	{
		extract($vars);

		ob_start();
		require_once($view);
		$view = ob_get_clean();

		return $view;
	}

	/**
	 * 404 Not Found action.
	 */
	protected function notFound()
	{
		$body = $this->response->getBody();

		$body->write($this->render(TEMPLATE_DIR . '/not-found.php'));

		$this->response->withStatus(404)->withBody($body)->send();

		exit;
	}
}


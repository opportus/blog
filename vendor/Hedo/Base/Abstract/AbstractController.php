<?php

namespace Hedo\Base;

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
	 * Renders the view.
	 *
	 * @param  string $view
	 * @param  array  $vars
	 * @return string $view
	 */
	public function render(string $view, array $vars)
	{
		extract($vars);

		ob_start();
		require_once($view);
		$view = ob_get_clean();

		return $view;
	}
}


<?php

namespace Hedo\Base;

/**
 * The controller interface...
 *
 * @version 0.0.1
 * @package Hedo\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
interface ControllerInterface
{
	/**
	 * Renders the view.
	 *
	 * @param  string $view
	 * @param  array  $vars
	 * @return string $view
	 */
	public function render(string $view, array $vars);
}


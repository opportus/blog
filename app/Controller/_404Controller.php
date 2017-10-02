<?php

namespace App\Controller;

use Hedo\Core\Base\ControllerInterface;

/**
 * The 404 controller...
 *
 * @version 0.0.1
 * @package App\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
final class _404Controller extends AppController implements ControllerInterface
{
	/**
	 * Renders the view.
	 */
	public function view()
	{
		$this->action404();
	}
}


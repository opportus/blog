<?php

namespace OC\Blog\Controller;

use Hedo\Base\AbstractController;
use Hedo\Base\ControllerInterface;

/**
 * The 404 controller...
 *
 * @version 0.0.1
 * @package OC\Blog\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
final class _404Controller extends AbstractBlogController implements ControllerInterface
{
	/**
	 * Renders the view.
	 */
	public function view()
	{
		$this->action404();
	}
}


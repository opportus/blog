<?php

namespace App\Controller;

use Core\Base\ControllerInterface;

/**
 * The homepage controller...
 *
 * @version 0.0.1
 * @package App\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
final class HomeController extends AppController implements ControllerInterface
{
	/**
	 * Renders the view.
	 */
	public function view()
	{
		$body = $this->render('home', array(
			'title'              => '',
			'description'        => '',
			'author'             => '',
			'menuItems'          => $this->config->getApp('frontMenuItems'),
			'menuItemsRightHand' => $this->config->getApp('frontMenuItemsRightHand'),
		));

		$this->response->setBody($body);
		$this->response->send();
	}
}


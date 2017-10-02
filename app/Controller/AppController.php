<?php

namespace App\Controller;

use Hedo\Base\AbstractController;

/**
 * The app controller...
 *
 * @version 0.0.1
 * @package App\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
abstract class AppController extends AbstractController
{
	/**
	 * The 404 action.
	 */
	protected function action404()
	{
		$body = $this->response->getBody();
		$body->write($this->render('_404', array(
			'title'              => '404 Page Not Found',
			'description'        => '404 page not found',
			'author'             => '',
			'menuItems'          => $this->config->getApp('frontMenuItems'),
			'menuItemsRightHand' => $this->config->getApp('frontMenuItemsRightHand'),
		)));

		$this->response->withStatus(404)->withBody($body)->send();

		exit;
	}
}


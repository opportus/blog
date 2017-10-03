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
			'menuItems'          => $this->config->get('app', 'frontMenuItems'),
			'menuItemsRightHand' => $this->config->get('app', 'frontMenuItemsRightHand'),
		)));

		$this->response->withStatus(404)->withBody($body)->send();

		exit;
	}
}


<?php

namespace App\Controller;

use Hedo\Core\Base\AbstractController;

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
		$this->response->setCode(404);

		$body = $this->render('_404', array(
			'title'              => '404 Page Not Found',
			'description'        => '404 page not found',
			'author'             => '',
			'menuItems'          => $this->config->getApp('frontMenuItems'),
			'menuItemsRightHand' => $this->config->getApp('frontMenuItemsRightHand'),
		));

		$this->response->setBody($body);
		$this->response->send();

		exit;
	}
}


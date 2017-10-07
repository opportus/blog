<?php

namespace OC\Blog\Controller;

use Hedo\Base\AbstractController;
use Hedo\Base\ControllerInterface;

/**
 * The app controller...
 *
 * @version 0.0.1
 * @package OC\Blog\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
abstract class AbstractBlogController extends AbstractController implements ControllerInterface
{
	/**
	 * The 404 action.
	 */
	protected function action404()
	{
		$body = $this->response->getBody();
		$body->write($this->render(MODULE_DIR . '/blog/View/_404.php', array(
			'title'              => '404 Page Not Found',
			'description'        => '404 page not found',
			'author'             => '',
			'menuItems'          => $this->config->get('Blog', 'blog', 'menuItems'),
			'menuItemsRightHand' => $this->config->get('Blog', 'blog', 'menuItemsRightHand'),
		)));

		$this->response->withStatus(404)->withBody($body)->send();

		exit;
	}
}


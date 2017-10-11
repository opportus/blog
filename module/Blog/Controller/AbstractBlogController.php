<?php

namespace OC\Blog\Controller;

use Hedo\Base\AbstractController;
use Hedo\Base\ControllerInterface;

/**
 * The base blog controller...
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
		$body->write($this->render(MODULE_DIR . '/Blog/View/_404.php', array(
			'config'      => $this->config,
			'toolbox'     => $this->toolbox,

			'title'       => '404 Page Not Found',
			'description' => '404 page not found',
			'author'      => '',

			'menuItems'   => array(
				array(
					'name'  => 'ABOUT',
					'link'  => $this->config->get('App', 'app', 'url') . '/#about',
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'PROJECTS',
					'link'  => $this->config->get('App', 'app', 'url') . '/#projects',
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'CONTACT',
					'link'  => $this->config->get('App', 'app', 'url') . '/#contact',
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'BLOG',
					'link'  => $this->config->get('App', 'app', 'url') . '/blog/',
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'WRITE',
					'link'  => $this->config->get('App', 'app', 'url') . '/cockpit/post/edit/',
					'title' => '',
					'class' => '',
					'style' => '',
				),
			),
		)));

		$this->response->withStatus(404)->withBody($body)->send();

		exit;
	}
}


<?php

namespace Opportus\Blog;

/**
 * The abstract controller...
 *
 * @version 0.0.1
 * @package Opportus\Blog
 * @author  Clément Cazaud <opportus@gmail.com>
 */
abstract class AbstractController
{
	/**
	 * Renders the view.
	 *
	 * @param  string $view
	 * @param  array  $vars
	 * @return string $view
	 */
	protected function render(string $view, array $vars)
	{
		extract($vars);

		ob_start();
		require_once($view);
		$view = ob_get_clean();

		return $view;
	}

	/**
	 * 404 Not Found action.
	 */
	protected function notFound()
	{
		$body = $this->response->getBody();

		$body->write($this->render(TEMPLATE_DIR . '/not-found.php', array(
			'metaTitle'       => '404 Page Not Found',
			'metaDescription' => '404 page not found',
			'metaAuthor'      => '',
			'menuItems'       => array(
				array(
					'name'  => 'ABOUT',
					'link'  => APP_URL . '/#about',
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'PROJECTS',
					'link'  => APP_URL . '/#projects',
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'CONTACT',
					'link'  => APP_URL . '/#contact',
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'BLOG',
					'link'  => APP_URL . '/blog/',
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'WRITE',
					'link'  => APP_URL . '/cockpit/post/edit/',
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


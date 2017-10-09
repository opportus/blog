<?php

namespace OC\Blog\Controller;

use Hedo\Base\AbstractController;
use Hedo\Base\ControllerInterface;

/**
 * The blog controller...
 *
 * @version 0.0.1
 * @package OC\Blog\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
final class BlogController extends AbstractBlogController implements ControllerInterface
{
	/**
	 * Renders the view.
	 */
	public function view()
	{
		$posts      = array();

		foreach ($this->repositories['postRepository']->get() as $post) {
			$posts[] = array(
				'title'      => $post->getTitle(),
				'excerpt'    => $post->getExcerpt(),
				'datetime'   => $post->getUpdatedAt() !== null ? $this->toolbox->formatDatetime($post->getUpdatedAt()) : $this->toolbox->formatDatetime($post->getCreatedAt()),
				'id'         => $post->getId(),
			);
		}

		$body = $this->response->getBody();
		$body->write($this->render(MODULE_DIR . '/Blog/View/blog.php', array(
			'title'              => 'My Tech Blog',
			'description'        => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras aliquam pellentesque sem id molestie. Pellentesque nec lectus a sapien posuere sollicitudin. Vivamus nec tortor turpis.',
			'author'             => 'Clément Cazaud',
			'posts'              => $posts,
			'menuItems'          => array(
				array(
					'name'  => 'ABOUT',
					'link'  => $this->toolbox->sanitizeUrl($this->config->get('App', 'app', 'url') . '/#about'),
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'PROJECTS',
					'link'  => $this->toolbox->sanitizeUrl($this->config->get('App', 'app', 'url') . '/#projects'),
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'CONTACT',
					'link'  => $this->toolbox->sanitizeUrl($this->config->get('App', 'app', 'url') . '/#contact'),
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'BLOG',
					'link'  => $this->toolbox->sanitizeUrl($this->config->get('App', 'app', 'url') . '/blog/'),
					'title' => '',
					'class' => '',
					'style' => '',
				),
				array(
					'name'  => 'WRITE',
					'link'  => $this->toolbox->sanitizeUrl($this->config->get('App', 'app', 'url') . '/cockpit/post/edit/'),
					'title' => '',
					'class' => '',
					'style' => '',
				),
			),
		)));

		$this->response->withBody($body)->send();
	}
}


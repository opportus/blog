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
				'datetime'   => $post->getUpdatedAt() !== null ?
					$this->toolbox->formatDatetime($post->getUpdatedAt()) :
					$this->toolbox->formatDatetime($post->getCreatedAt()),
				'id'         => $post->getId(),
			);
		}

		$body = $this->response->getBody();
		$body->write($this->render(MODULE_DIR . '/Blog/View/blog.php', array(
			'title'              => 'Blog',
			'description'        => 'My Blog',
			'author'             => 'Clément Cazaud',
			'posts'              => $posts,
			'menuItems'          => $this->config->get('Blog', 'blog', 'menuItems'),
			'menuItemsRightHand' => $this->config->get('Blog', 'blog', 'menuItemsRightHand'),
		)));

		$this->response->withBody($body)->send();
	}
}


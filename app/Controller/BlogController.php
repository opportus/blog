<?php

namespace App\Controller;

use Hedo\Base\ControllerInterface;

/**
 * The blog controller...
 *
 * @version 0.0.1
 * @package App\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
final class BlogController extends AppController implements ControllerInterface
{
	/**
	 * Renders the view.
	 */
	public function view()
	{
		$posts = array();

		foreach ($this->container->get('App\Model\PostRepository')->get() as $post) {
			$posts[] = array(
				'title'      => $post->getTitle(),
				'excerpt'    => $post->getExcerpt(),
				'datetime'   => $post->getModificationDatetime() !== null ? $this->toolbox->formatDatetime($post->getModificationDatetime()) : $this->toolbox->formatDatetime($post->getCreationDatetime()),
				'id'         => $post->getId(),
				'imageUrl'   => $post->getImage() !== null ? $this->container->get('App\Model\ImageRepository')->get($post->getImage())->getUrl() : '',
				'imageAlt'   => $post->getImage() !== null ? $this->container->get('App\Model\ImageRepository')->get($post->getImage())->getAlt() : '',
				'imageTitle' => $post->getImage() !== null ? $this->container->get('App\Model\ImageRepository')->get($post->getImage())->getTitle() : '',
			);
		}

		$body = $this->response->getBody();
		$body->write($this->render('blog', array(
			'title'              => 'Blog',
			'description'        => 'My Blog',
			'author'             => '',
			'posts'              => $posts,
			'menuItems'          => $this->config->get('app', 'frontMenuItems'),
			'menuItemsRightHand' => $this->config->get('app', 'frontMenuItemsRightHand'),
		)));

		$this->response->withBody($body)->send();
	}
}


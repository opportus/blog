<?php

namespace App\Controller;

use Core\Base\ControllerInterface;

/**
 * The post controller...
 *
 * @version 0.0.1
 * @package App\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
final class PostController extends AppController implements ControllerInterface
{
	/**
	 * Renders the view.
	 *
	 * @param string $slug
	 */
	public function view($id)
	{
		if ($post = $this->container->get('App\Model\PostRepository')->get((int) $id)) {	
			$user = $this->container->get('App\Model\UserRepository')->get($post->getAuthor());
			$body = $this->render('post', array(
				'title'              => $post->getTitle(),
				'description'        => $post->getExcerpt(),
				'author'             => $user->getFirstName() . ' ' . $user->getSecondName(),
				'datetime'           => $post->getModificationDatetime() !== null ? $this->toolbox->formatDatetime($post->getModificationDatetime()) : $this->toolbox->formatDatetime($post->getCreationDatetime()),
				'excerpt'            => $post->getExcerpt(),
				'content'            => $post->getContent(),
				'id'                 => $post->getId(),
				'imageUrl'           => $post->getImage() !== null ? $this->container->get('App\Model\ImageRepository')->get($post->getImage())->getUrl() : '',
				'imageAlt'           => $post->getImage() !== null ? $this->container->get('App\Model\ImageRepository')->get($post->getImage())->getAlt() : '',
				'imageTitle'         => $post->getImage() !== null ? $this->container->get('App\Model\ImageRepository')->get($post->getImage())->getTitle() : '',
				'menuItems'          => $this->config->getApp('frontMenuItems'),
				'menuItemsRightHand' => $this->config->getApp('frontMenuItemsRightHand'),
			));

			$this->response->setBody($body);
			$this->response->send();

			return;
		}

		$this->action404();
	}
}


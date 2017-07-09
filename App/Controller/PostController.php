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
				'datetime'           => $post->getModificationDatetime() !== null ? $toolbox->formatDatetime($post->getModificationDatetime(), $config->getApp('datetimeFormat')) : $toolbox->formatDatetime($post->getCreationDatetime(), $config->getApp('datetimeFormat')),
				'excerpt'            => $post->getExcerpt(),
				'content'            => $post->getContent(),
				'id'                 => $post->getId(),
				'imageUrl'           => '',
				'imageAlt'           => '',
				'imageTitle'         => '',
				'menuItems'          => $this->config->getApp('frontMenuItems'),
				'menuItemsRightHand' => $this->config->getApp('RightHandFrontMenuItems'),
			));

			$this->response->setBody($body);
			$this->response->send();

			return;
		}

		$this->action404();
	}
}


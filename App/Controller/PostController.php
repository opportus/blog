<?php

namespace App\Controller;

use \Exception;
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
	 * @param string $id
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

			die();
		}

		$this->action404();
	}

	/**
	 * Renders the edit view.
	 *
	 * @param string $id
	 */
	public function edit($id)
	{
		if ($id) {
			if (! $post = $this->container->get('App\Model\PostRepository')->get((int) $id)) {
				$this->action404();
			}
		}

		$sessionToken = $this->request->getSession()->setToken('postEditToken');

		$body = $this->render('post-edit', array(
			'failureMessage'     => $this->request->getSession()->get('postEditFailureMessage'),
			'successMessage'     => $this->request->getSession()->get('postEditSuccessMessage'),

			'title'              => isset($post) ? 'Editing ' . $post->getTitle() : 'Editing New Post',
			'description'        => 'Post edition',
			'author'             => '',

			'postId'             => isset($post) ? $post->getId() : '',
			'postSlug'           => isset($post) ? $post->getSlug() : '',
			'postStatus'         => isset($post) ? $post->getStatus() : '',
			'postAuthor'         => isset($post) ? $post->getAuthor() : '',
			'postTitle'          => isset($post) ? $post->getTitle() : '',
			'postExcerpt'        => isset($post) ? $post->getExcerpt() : '',
			'postContent'        => isset($post) ? $post->getContent() : '',

			'token'              => $this->toolbox->generateToken('PostController/edit', $sessionToken),

			'menuItems'          => $this->config->getApp('backMenuItems'),
			'menuItemsRightHand' => $this->config->getApp('backMenuItemsRightHand'),
		));

		$this->request->getSession()->unset('postEditFailureMessage');
		$this->request->getSession()->unset('postEditSuccessMessage');

		$this->response->setBody($body);
		$this->response->send();

		die();
	}

	/**
	 * Saves the post.
	 *
	 * @param string $id
	 */
	public function save($id)
	{
		if (! isset($_POST['token']) || ! $this->toolbox->checkToken($_POST['token'], $this->toolbox->generateToken('PostController/edit', $this->request->getSession()->get('postEditToken')))) {
			$this->request->getSession()->destroy();

			die('No way...');
		}

		$repository = $this->container->get('App\Model\PostRepository');
		$errors     = array();

		switch ($id) {
			case '' :
				$post = $this->container->get('App\Model\PostModel');
				break;
			default :
				$post = $repository->get((int) $id);
				break;
		}

		foreach ($_POST as $key => $value) {
			if (strpos($key, 'post') === 0) {
				$property = str_replace('post', '', $key);
				$setter   = 'set' . $property;

				if (method_exists($post, $setter)) {
					if (false === $post->$setter($value)) {
						$errors[] = 'Invalid ' . $property;
					}
				}
			}
		}

		try {
			if (! $errors) {
				$id      = $repository->add($post);
				$message = 'Your post has succesfully been saved';

				$this->request->getSession()->set('postEditSuccessMessage', $message);

			} else {
				$message = implode(' - ', $errors);

				throw new Exception($message);
			}

		} catch (Exception $e) {
			$message = $e->getMessage();

			$this->request->getSession()->set('postEditFailureMessage', $message);

		} finally {
			$this->response->setHeaders('Location: ' . $this->config->getApp('url') . '/cockpit/post/edit/' . $id);
			$this->response->send();

			die();
		}
	}

	/**
	 * Deletes the post.
	 *
	 * @param string $id
	 */
	public function delete($id)
	{
		if (! isset($_POST['token']) || ! $this->toolbox->checkToken($_POST['token'], $this->toolbox->generateToken('PostController/edit', $this->request->getSession()->get('postEditToken')))) {
			$this->request->getSession()->destroy();

			die('No way...');
		}

		try {
			if ($this->container->get('App\Model\PostRepository')->delete((int) $id)) {
				$message = 'Your post has succesfully been deleted';

				$this->request->getSession()->set('postEditSuccessMessage', $message);

			} else {
				$message = 'Your post couldn\`t be deleted...';

				throw new Exception($message);
			}

		} catch (Exception $e) {
			$message = $e->getMessage();

			$this->request->getSession()->set('postEditFailureMessage', $message);

		} finally {
			$this->response->setHeaders('Location: ' . $this->config->getApp('url') . '/cockpit/post/edit/');
			$this->response->send();

			die();
		}
	}
}


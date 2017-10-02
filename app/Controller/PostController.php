<?php

namespace App\Controller;

use \Exception;
use Hedo\Core\Base\ControllerInterface;

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
			$body = $this->response->getBody();
			$body->write($this->render('post', array(
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
			)));

			$this->response->withBody($body)->send();

			return;
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

		$sessionToken = $this->session->setToken('postEditToken');

		$body = $this->response->getBody();
		$body->write($this->render('post-edit', array(
			'failureMessage'     => $this->session->get('postEditFailureMessage'),
			'successMessage'     => $this->session->get('postEditSuccessMessage'),

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
		)));

		$this->session->unset('postEditFailureMessage');
		$this->session->unset('postEditSuccessMessage');

		$this->response->withBody($body)->send();
	}

	/**
	 * Saves the post.
	 *
	 * @param string $id
	 */
	public function save($id)
	{
		if (! isset($_POST['token']) || ! $this->toolbox->checkToken($_POST['token'], $this->toolbox->generateToken('PostController/edit', $this->session->get('postEditToken')))) {
			$this->session->destroy();

			throw new Exception('Invalid token for IP: ' . $_SERVER['REMOTE_ADDR']);
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

				$this->session->set('postEditSuccessMessage', $message);

			} else {
				$message = implode(' - ', $errors);

				throw new Exception($message);
			}

		} catch (Exception $e) {
			$message = $e->getMessage();

			$this->session->set('postEditFailureMessage', $message);

		} finally {
			$this->response->withHeader('Location: ' . $this->config->getApp('url') . '/cockpit/post/edit/' . $id)->send();

			exit;
		}
	}

	/**
	 * Deletes the post.
	 *
	 * @param string $id
	 */
	public function delete($id)
	{
		if (! isset($_POST['token']) || ! $this->toolbox->checkToken($_POST['token'], $this->toolbox->generateToken('PostController/edit', $this->session->get('postEditToken')))) {
			$this->session->destroy();

			throw new Exception('Invalid token for IP: ' . $_SERVER['REMOTE_ADDR']);
		}

		try {
			if ($this->container->get('App\Model\PostRepository')->delete((int) $id)) {
				$message = 'Your post has succesfully been deleted';

				$this->session->set('postEditSuccessMessage', $message);

			} else {
				$message = 'Your post couldn\`t be deleted...';

				throw new Exception($message);
			}

		} catch (Exception $e) {
			$message = $e->getMessage();

			$this->session->set('postEditFailureMessage', $message);

		} finally {
			$this->response->withHeader('Location: ' . $this->config->getApp('url') . '/cockpit/post/edit/')->send();

			exit;
		}
	}
}


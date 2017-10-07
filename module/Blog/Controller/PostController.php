<?php

namespace OC\Blog\Controller;

use Hedo\Base\AbstractController;
use Hedo\Base\ControllerInterface;

use \Exception;

/**
 * The post controller...
 *
 * @version 0.0.1
 * @package OC\Blog\Controller
 * @author  Clément Cazaud <opportus@gmail.com>
 */
final class PostController extends AbstractBlogController implements ControllerInterface
{
	/**
	 * Renders the view.
	 *
	 * @param string $id
	 */
	public function view($id)
	{
		if ($post = $this->repositories['postRepository']->get((int) $id)) {
			$body = $this->response->getBody();
			$body->write($this->render(MODULE_DIR . '/Blog/View/post.php', array(
				'title'              => $post->getTitle(),
				'description'        => $post->getExcerpt(),
				'author'             => $post->getAuthor(),
				'datetime'           => $post->getUpdatedAt() !== null ? $this->toolbox->formatDatetime($post->getUpdatedAt()) : $this->toolbox->formatDatetime($post->getCreatedAt()),
				'excerpt'            => $post->getExcerpt(),
				'content'            => $post->getContent(),
				'id'                 => $post->getId(),
				'menuItems'          => $this->config->get('Blog', 'blog', 'menuItems'),
				'menuItemsRightHand' => $this->config->get('Blog', 'blog', 'menuItemsRightHand'),
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
			if (! $post = $this->repositories['postRepository']->get((int) $id)) {
				$this->action404();
			}

		} else {
			$post = $this->factories['postFactory']->create();
		}
		if ($this->session->get('postEditFailureMessage')) {
			$post->setTitle($this->session->get('postEditTitle'));
			$post->setSlug($this->session->get('postEditSlug'));
			$post->setAuthor($this->session->get('postEditAuthor'));
			$post->setExcerpt($this->session->get('postEditExcerpt'));
			$post->setContent($this->session->get('postEditContent'));
		}

		$sessionToken = $this->session->setToken('postEditToken');

		$body = $this->response->getBody();
		$body->write($this->render(MODULE_DIR . '/Blog/View/post-edit.php', array(
			'failureMessage'     => $this->session->get('postEditFailureMessage'),
			'successMessage'     => $this->session->get('postEditSuccessMessage'),

			'title'              => is_null($post->getTitle()) ? 'Editing New Post' : 'Editing ' . $post->getTitle(),
			'description'        => 'Post edition',
			'author'             => is_null($post->getAuthor()) ? '' : $post->getAuthor(),

			'postId'             => is_null($post->getId()) ? '' : $post->getId(),
			'postSlug'           => is_null($post->getSlug()) ? '' : $post->getSlug(),
			'postAuthor'         => is_null($post->getAuthor()) ? '' : $post->getAuthor(),
			'postTitle'          => is_null($post->getTitle()) ? '' : $post->getTitle(),
			'postExcerpt'        => is_null($post->getExcerpt()) ? '' : $post->getExcerpt(),
			'postContent'        => is_null($post->getContent()) ? '' : $post->getContent(),
			'menuItems'          => $this->config->get('Blog', 'blog', 'menuItems'),
			'menuItemsRightHand' => $this->config->get('Blog', 'blog', 'menuItemsRightHand'),

			'token'              => $this->toolbox->generateToken('postEditToken', $sessionToken),

		)));

		$this->session->unset('postEditTitle');
		$this->session->unset('postEditSlug');
		$this->session->unset('postEditAuthor');
		$this->session->unset('postEditExcerpt');
		$this->session->unset('postEditContent');
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
		if (! isset($_POST['token']) || ! $this->toolbox->checkToken($_POST['token'], $this->toolbox->generateToken('postEditToken', $this->session->get('postEditToken')))) {
			$this->session->destroy();

			throw new Exception('Invalid token for IP: ' . $_SERVER['REMOTE_ADDR']);
		}

		$repository = $this->repositories['postRepository'];
		$data       = array();
		$errors     = array();

		switch ($id) {
			case '' :
				$post = $this->factories['postFactory']->create();
				break;
			default :
				$post = $repository->get((int) $id);
				break;
		}

		foreach ($_POST as $key => $value) {
			if (strpos($key, 'post') === 0) {
				$property = lcfirst(str_replace('post', '', $key));
				$data[$property] = $value;
			}
		}

		$errors = $post->hydrate($data);

		try {
			$id = $repository->add($post);

			if (! $errors) {
				$message = 'Your post has succesfully been saved';

				$this->session->set('postEditSuccessMessage', $message);

			} else {
				throw new Exception();
			}

		} catch (Exception $e) {
			if ($e->getCode() === 23000) {
				$errors[] = 'slug';
			}

			$message = 'Invalid ' . strtolower(preg_replace('/\B([A-Z])/', ' $1', implode(', ', $errors))) . '...';

			$this->session->set('postEditFailureMessage', $message);
			$this->session->set('postEditTitle', $data['title']);
			$this->session->set('postEditSlug', $data['slug']);
			$this->session->set('postEditAuthor', $data['author']);
			$this->session->set('postEditExcerpt', $data['excerpt']);
			$this->session->set('postEditContent', $data['content']);

		} finally {
			$this->response->withHeader('Location', $this->config->get('App', 'app', 'url') . '/cockpit/post/edit/' . $id)->send();

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
		if (! isset($_POST['token']) || ! $this->toolbox->checkToken($_POST['token'], $this->toolbox->generateToken('postEditToken', $this->session->get('postEditToken')))) {
			$this->session->destroy();

			throw new Exception('Invalid token for IP: ' . $_SERVER['REMOTE_ADDR']);
		}

		try {
			if ($this->repositories['postRepository']->delete((int) $id)) {
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
			$this->response->withHeader('Location', $this->config->get('App', 'app', 'url') . '/cockpit/post/edit/')->send();

			exit;
		}
	}
}


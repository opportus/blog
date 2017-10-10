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

		$sessionToken = $this->session->setToken('postEditToken');

		$body = $this->response->getBody();
		$body->write($this->render(MODULE_DIR . '/Blog/View/post-edit.php', array(
			'title'              => is_null($post->getTitle()) ? 'Editing New Post' : 'Editing ' . $post->getTitle(),
			'description'        => 'Post edition',
			'author'             => is_null($post->getAuthor()) ? '' : $post->getAuthor(),

			'postId'             => is_null($post->getId()) ? '' : $post->getId(),
			'postSlug'           => is_null($post->getSlug()) ? '' : $post->getSlug(),
			'postAuthor'         => is_null($post->getAuthor()) ? '' : $post->getAuthor(),
			'postTitle'          => is_null($post->getTitle()) ? '' : $post->getTitle(),
			'postExcerpt'        => is_null($post->getExcerpt()) ? '' : $post->getExcerpt(),
			'postContent'        => is_null($post->getContent()) ? '' : $post->getContent(),
			'token'              => $this->toolbox->generateToken('postEditToken', $sessionToken),
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

		$repository     = $this->repositories['postRepository'];
		$requiredFields = array('title', 'slug', 'author', 'excerpt', 'content');
		$errors         = array();
		$data           = array();

		switch ($id) {
			case '' :
				$post = $this->factories['postFactory']->create();
				$post->setCreatedAt($this->toolbox->formatDatetime('', 'Y-m-d H:i:s'));
				break;
			default :
				$post = $repository->get((int) $id);
				$post->setUpdatedAt($this->toolbox->formatDatetime('', 'Y-m-d H:i:s'));
				break;
		}

		foreach ($_POST as $key => $value) {
			if (in_array($key, $requiredFields)) {
				if (empty($_POST[$key])) {
					$errors[$key] = 'Required ' . $key;

				} else {
					$setter = 'set' . ucfirst($key);

					if (false === $post->$setter($value)) {
						$errors[$key] = 'Invalid ' . $key;
					}
				}
			}
		}

		try {
			if (empty($errors)) {
				$id = $repository->add($post);
			}

		} catch (Exception $e) {
			// 23000 => SQLSTATE error code when inserted UI is a duplicate...
			if ($e->getCode() === 23000) {
				$errors['slug'] = 'Duplicate slug';
			}

		} finally {
			if (empty($errors)) {
				$notif = 'Saved';

			} else {
				$notif = implode('. ', $errors);
			}

			$notif .= '...';

			$ajaxResponse = json_encode(array(
				'status'   => empty($errors),
				'notif'    => $notif,
				'errors'   => $errors,
				'redirect' => false,
				'refresh'  => $post->getUpdatedAt() ? false : true
			));

			$body = $this->response->getBody();
			$body->write($ajaxResponse);
			$this->response->withHeader('Content-Type', 'application/json')->withBody($body)->send();

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

		$notif = '';

		try {
			$this->repositories['postRepository']->delete((int) $id);

		} catch (Exception $e) {
			$notif = 'Your post couldn\`t be deleted...';

		} finally {
			$ajaxResponse = json_encode(array(
				'status'   => empty($notif),
				'notif'    => $notif,
				'errors'   => array(),
				'redirect' => empty($notif) ? $this->toolbox->sanitizeUrl($this->config->get('App', 'app', 'url') . '/cockpit/post/edit/') : false,
				'refresh'  => false
			));

			$body = $this->response->getBody();
			$body->write($ajaxResponse);
			$this->response->withHeader('Content-Type', 'application/json')->withBody($body)->send();

			exit;
		}
	}
}


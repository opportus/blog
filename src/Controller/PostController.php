<?php

namespace Opportus\Blog;

use Opportus\Session\Session;
use Opportus\Orm\EntityManager;
use Psr\Http\Message\ResponseInterface;
use \Parsedown;
use \Exception;

/**
 * The post controller...
 *
 * @version 0.0.1
 * @package Opportus\Blog
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class PostController extends AbstractController
{
	/**
	 * @var Session $session
	 */
	protected $session;

	/**
	 * @var ResponseInterface $response
	 */
	protected $response;

	/**
	 * @var EntityManager $post
	 */
	protected $entityManager;

	/**
	 * @var Parsedown $parsedown
	 */
	protected $parsedown;

	/**
	 * Constructor.
	 *
	 * @param Session           $session
	 * @param ResponseInterface $response
	 * @param EntityManager     $entityManager
	 * @param Parsedown         $parsedown
	 */
	public function __construct(Session $session, ResponseInterface $response, EntityManager $entityManager, Parsedown $parsedown)
	{
		$this->session       = $session;
		$this->response      = $response;
		$this->entityManager = $entityManager;
		$this->parsedown     = $parsedown;
	}

	/**
	 * Renders the view.
	 *
	 * @param string $id
	 */
	public function view($id)
	{
		if ($post = $this->entityManager->get('post')->get('repository')->get((int) $id)) {
			$body = $this->response->getBody();

			$body->write($this->render(TEMPLATE_DIR . '/post.php', array(
				'parsedown'       => $this->parsedown,
				'metaTitle'       => $post->get('title'),
				'metaDescription' => $post->get('excerpt'),
				'metaAuthor'      => $post->get('author'),
				'postTitle'       => $post->get('title'),
				'postDescription' => $post->get('excerpt'),
				'postAuthor'      => $post->get('author'),
				'postDatetime'    => $post->get('updatedAt') !== null ? $post->get('updatedAt') : $post->get('createdAt'),
				'postExcerpt'     => $post->get('excerpt'),
				'postContent'     => $post->get('content'),
				'postId'          => $post->get('id'),
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

			$this->response->withBody($body)->send();

			return;
		}

		$this->notFound();
	}

	/**
	 * Renders the edition view.
	 *
	 * @param string $id
	 */
	public function edit($id)
	{

		if ($id) {
			if (! $post = $this->entityManager->get('post')->get('repository')->get((int) $id)) {
				$this->notFound();
			}

		} else {
			$post = $this->entityManager->get('post')->get('factory')->create();
		}

		$sessionToken = $this->session->set('postEditToken', hash_hmac('sha256', bin2hex(random_bytes(32)), APP_SECRET_KEY));

		$body = $this->response->getBody();

		$body->write($this->render(TEMPLATE_DIR . '/post-edit.php', array(
			'metaTitle'       => is_null($post->get('title')) ? 'Editing New Post' : 'Editing ' . $post->get('title'),
			'metaDescription' => 'Post edition',
			'metaAuthor'      => is_null($post->get('author')) ? '' : $post->get('author'),
			'postId'          => is_null($post->get('id')) ? '' : $post->get('id'),
			'postSlug'        => is_null($post->get('slug')) ? '' : $post->get('slug'),
			'postAuthor'      => is_null($post->get('author')) ? '' : $post->get('author'),
			'postTitle'       => is_null($post->get('title')) ? '' : $post->get('title'),
			'postExcerpt'     => is_null($post->get('excerpt')) ? '' : $post->get('excerpt'),
			'postContent'     => is_null($post->get('content')) ? '' : $post->get('content'),
			'token'           => hash_hmac('sha256', 'postEditToken', $sessionToken),
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

		$this->response->withBody($body)->send();
	}

	/**
	 * Saves the post.
	 *
	 * @param string $id
	 */
	public function save($id)
	{
		if (! isset($_POST['token']) || ! hash_equals($_POST['token'], hash_hmac('sha256', 'postEditToken', $this->session->get('postEditToken')))) {
			$this->session->destroy();

			throw new Exception('[' . __CLASS__ . '::' . __FUNCTION__ . ']: Invalid token for IP: ' . $_SERVER['REMOTE_ADDR']);
		}

		$repository     = $this->entityManager->get('post')->get('repository');
		$requiredFields = array('title', 'slug', 'author', 'excerpt', 'content');
		$errors         = array();
		$data           = array();

		switch ($id) {
			case '' :
				$post = $this->entityManager->get('post')->get('factory')->create();
				$post->set('createdAt', date('Y-m-d H:i:s', time()));
				break;
			default :
				$post = $repository->get((int) $id);
				$post->set('updatedAt', date('Y-m-d H:i:s', time()));
				break;
		}

		foreach ($_POST as $key => $value) {
			if (in_array($key, $requiredFields)) {
				if (empty($_POST[$key])) {
					$errors[$key] = 'Required ' . $key;

				} else {
					if (false === $post->set($key, $value)) {
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
				'notif'    => empty($errors) ? false : $notif,
				'errors'   => $errors,
				'redirect' => empty($errors) ? APP_URL . '/post/' . $id : false,
				'refresh'  => $post->get('updatedAt') ? false : true
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
		if (! isset($_POST['token']) || ! hash_equals($_POST['token'], hash_hmac('sha256', 'postEditToken', $this->session->get('postEditToken')))) {
			$this->session->destroy();

			throw new Exception('[' . __CLASS__ . '::' . __FUNCTION__ . ']: Invalid token for IP: ' . $_SERVER['REMOTE_ADDR']);
		}

		$notif = '';

		try {
			$this->entityManager->get('post')->get('repository')->delete((int) $id);

		} catch (Exception $e) {
			$notif = 'Your post couldn\`t be deleted...';

		} finally {
			$ajaxResponse = json_encode(array(
				'status'   => empty($notif),
				'notif'    => $notif,
				'errors'   => array(),
				'redirect' => empty($notif) ? APP_URL . '/cockpit/post/edit/' : false,
				'refresh'  => false
			));

			$body = $this->response->getBody();
			$body->write($ajaxResponse);
			$this->response->withHeader('Content-Type', 'application/json')->withBody($body)->send();

			exit;
		}
	}
}


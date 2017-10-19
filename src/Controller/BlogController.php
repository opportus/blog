<?php

namespace Opportus\Blog;

use Opportus\Session\Session;
use Opportus\Orm\EntityManager;
use Psr\Http\Message\ResponseInterface;

/**
 * The blog controller...
 *
 * @version 0.0.1
 * @package Opportus\Blog
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class BlogController extends AbstractController
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
	 * @var EntityManager
	 */
	protected $entitymanager;

	/**
	 * Constructor.
	 *
	 * @param Session           $session
	 * @param ResponseInterface $response
	 * @param EntityManager     $post
	 */
	public function __construct(Session $session, ResponseInterface $response, EntityManager $entityManager)
	{
		$this->session       = $session;
		$this->response      = $response;
		$this->entityManager = $entityManager;
	}

	/**
	 * Renders the view.
	 */
	public function view()
	{
		$posts = array();

		foreach ($this->entityManager->get('post')->get('repository')->get() as $post) {
			$posts[] = array(
				'title'    => $post->get('title'),
				'excerpt'  => $post->get('excerpt'),
				'datetime' => $post->get('updatedAt') !== null ? $post->get('updatedAt') : $post->get('createdAt'),
				'id'       => $post->get('id'),
			);
		}

		$body = $this->response->getBody();

		$body->write($this->render(TEMPLATE_DIR . '/blog.php', array(
			'posts' => $posts,
		)));

		$this->response->withBody($body)->send();
	}
}


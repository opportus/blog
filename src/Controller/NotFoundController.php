<?php

namespace Opportus\Blog;

use Psr\Http\Message\ResponseInterface;

/**
 * The Not Found controller...
 *
 * @version 0.0.1
 * @package Opportus\Blog
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class NotFoundController extends AbstractController
{
	/**
	 * @var ResponseInterface $response
	 */
	protected $response;

	/**
	 * Constructor.
	 *
	 * @param ResponseInterface $response
	 */
	public function __construct(ResponseInterface $response)
	{
		$this->response = $response;
	}

	/**
	 * Renders the view.
	 */
	public function view()
	{
		$this->notFound();
	}
}


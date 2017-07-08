<?php

namespace Core;

/**
 * The request...
 *
 * @version 0.0.1
 * @package Core
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Request
{
	/**
	 * @var string $_uri
	 */
	private $_uri = '';

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->_init();
	}

	/**
	 * Initializes the request.
	 */
	private function _init()
	{
		$this->_uri = $_SERVER['REQUEST_URI'];
	}

	/**
	 * Gets uri.
	 *
	 * @return string $this->_uri
	 */
	public function getUri()
	{
		return $this->_uri;
	}
}


<?php

namespace Hedo\Core;

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
	 * @var object $config
	 */
	protected $config;

	/**
	 * @var object $toolbox
	 */
	protected $toolbox;

	/**
	 * @var object $session
	 */
	protected $session;

	/**
	 * @var string $uri
	 */
	protected $uri = '';

	/**
	 * Constructor.
	 *
	 * @param object $config
	 * @param object $toolbox
	 * @param object $session
	 */
	public function __construct(Config $config, Toolbox $toolbox, Session $session)
	{
		$this->init($config, $toolbox, $session);
	}

	/**
	 * Initializes the session.
	 *
	 * @param object $config
	 * @param object $toolbox
	 * @param object $session
	 */
	protected function init(Config $config, Toolbox $toolbox, Session $session)
	{
		$this->config  = $config;
		$this->toolbox = $toolbox;
		$this->session = $session;

		$this->uri     = $_SERVER['REQUEST_URI'];
	}

	/**
	 * Gets session.
	 *
	 * @return object $this->session
	 */
	public function getSession()
	{
		return $this->session;
	}

	/**
	 * Gets uri.
	 *
	 * @return string $this->uri
	 */
	public function getUri()
	{
		return $this->uri;
	}
}


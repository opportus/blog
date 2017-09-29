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
	 * @var object $_config
	 */
	private $_config;

	/**
	 * @var object $_toolbox
	 */
	private $_toolbox;

	/**
	 * @var object $_session
	 */
	private $_session;

	/**
	 * @var string $_uri
	 */
	private $_uri = '';

	/**
	 * Constructor.
	 *
	 * @param object $config
	 * @param object $toolbox
	 * @param object $session
	 */
	public function __construct(Config $config, Toolbox $toolbox, Session $session)
	{
		$this->_init($config, $toolbox, $session);
	}

	/**
	 * Initializes the session.
	 *
	 * @param object $config
	 * @param object $toolbox
	 * @param object $session
	 */
	private function _init(Config $config, Toolbox $toolbox, Session $session)
	{
		$this->_config  = $config;
		$this->_toolbox = $toolbox;
		$this->_session = $session;

		$this->_uri     = $_SERVER['REQUEST_URI'];
	}

	/**
	 * Gets session.
	 *
	 * @return object $this->_session
	 */
	public function getSession()
	{
		return $this->_session;
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


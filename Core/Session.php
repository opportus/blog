<?php

namespace Core;

/**
 * The session...
 *
 * @version 0.0.1
 * @package Core
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Session
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
	 * @var string $_id
	 */
	private $_id;

	/**
	 * @var array $_tokens
	 */
	private $_tokens = array();

	/**
	 * Constructor.
	 *
	 * @param object $config
	 * @param object $toolbox
	 */
	public function __construct(Config $config, Toolbox $toolbox)
	{
		$this->_init($config, $toolbox);
	}

	/**
	 * Initializes the session.
	 *
	 * @param object $config
	 * @param object $toolbox
	 */
	private function _init(Config $config, Toolbox $toolbox)
	{
		$this->_config  = $config;
		$this->_toolbox = $toolbox;

		$this->start();

		$this->_id     = $this->setId();
		$this->_tokens = $this->setTokens('token');
	}

	/**
	 * Sets the session ID.
	 *
	 * @param string $id Default: null
	 */
	public function setId($id = null)
	{
		$this->_id = session_id($id);
	}

	/**
	 * Gets the session ID.
	 *
	 * @return string $this->_id
	 */
	public function getId()
	{
		return $this->_id;
	}

	/**
	 * Sets tokens.
	 *
	 * @param string $tokenName
	 * @param string $value     Default: ''
	 */
	public function setTokens($tokenName, $value = '')
	{
		$value = $value ? $this->_toolbox->generateToken();

		$this->_tokens[$tokenName] = $value;

		$_SESSION[$tokenName] = $value;
	}

	/**
	 * Gets tokens.
	 *
	 * @param  string       $tokenName
	 * @return string|array
	 */
	public function getTokens($tokenName = '')
	{
		if (isset($this->_tokens[$tokenName])) {
			return $this->_tokens[$tokenName];
		} elseif ('' === $tokenName) {
			return $this->_tokens;
		} else {
			return '';
		}
	}
	/**
	 * Starts the session.
	 *
	 * @return bool
	 */
	public function start()
	{
		return session_start();
	}

	/**
	 * Destroys the session.
	 *
	 * @return bool
	 */
	public function destroy()
	{
		return session_destroy();
	}

	/**
	 * Aborts the session.
	 */
	public function abort()
	{
		session_abort();
	}

	/**
	 * Unsets the session.
	 */
	public function unset()
	{
		session_unset();
	}
}


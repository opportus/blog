<?php

namespace Hedo;

use Hedo\Toolbox;

/**
 * The session...
 *
 * @version 0.0.1
 * @package Hedo
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Session
{
	/**
	 * @var Toolbox $toolbox
	 */
	protected $toolbox;

	/**
	 * Constructor.
	 *
	 * @param Toolbox $toolbox
	 */
	public function __construct(Toolbox $toolbox)
	{
		$this->init($toolbox);
	}

	/**
	 * Initializes the session.
	 *
	 * @param Toolbox $toolbox
	 */
	protected function init(Toolbox $toolbox)
	{
		$this->toolbox = $toolbox;

		$this->start();
	}

	/**
	 * Sets a session variable.
	 *
	 * @param  string|int $name
	 * @param  mixed      $value
	 * @return mixed
	 */
	public function set($name, $value)
	{
		return $_SESSION[$name] = $value;
	}

	/**
	 * Gets a session variable.
	 *
	 * @param  string|int $name
	 * @return mixed
	 */
	public function get($name)
	{
		return isset($_SESSION[$name]) ? $_SESSION[$name]: '';
	}

	/**
	 * Unsets a session variable.
	 *
	 * @param string|int $name
	 */
	public function unset($name)
	{
		if (isset($_SESSION[$name])) {
			unset($_SESSION[$name]);
		}
	}

	/**
	 * Sets a token as session variable.
	 *
	 * @param  string $name
	 * @param  string $salt      Default: ''
	 * @param  string $key       Default: ''
	 * @param  string $algo      Default: ''
	 * @return string
	 */
	public function setToken($name, $salt = '', $key = '', $algo = 'sha256')
	{
		return $_SESSION[$name] = $this->toolbox->generateToken($salt, $key, $algo);
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
}


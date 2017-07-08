<?php

namespace Core;

/**
 * The response...
 *
 * @version 0.0.1
 * @package Core
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Response
{
	/**
	 * @var string $_code
	 */
	private $_code;

	/**
	 * @var array $_headers
	 */
	private $_headers;

	/**
	 * @var string|null $_body
	 */
	private $_body;

	/**
	 * Constructor.
	 *
	 * @param string|int  $code    Default: 200
	 * @param array       $headers Default: array()
	 * @param string|null $body    Default: null
	 */
	public function __construct($code = 200, $headers = array(), $body = null)
	{
		$this->_init($code, $headers, $body);
	}

	/**
	 * Initializes the response.
	 *
	 * @param string|int  $code
	 * @param array       $headers
	 * @param string|null $body
	 */
	private function _init($code, $headers, $body)
	{
		$this->_code    = $code;
		$this->_headers = $headers;
		$this->_body    = $body;
	}

	/**
	 * Sets the HTTP response code.
	 *
	 * @param string|int $code
	 */
	public function setCode($code)
	{
		$this->_code = (int) $code;
	}

	/**
	 * Sets the HTTP response headers.
	 *
	 * @param string|array $headers
	 * @param bool         $replace
	 */
	public function setHeaders($headers, $replace = false)
	{
		if (false === $replace) {
			$this->_headers = array_merge($this->_headers, (array) $headers);

		} else {
			$this->_headers = (array) $headers;
		}
	}

	/**
	 * Sets the HTTP response body.
	 *
	 * @param string $body
	 */
	public function setBody($body)
	{
		$this->_body = (string) $body;
	}

	/**
	 * Sends the HTTP response.
	 */
	public function send()
	{
		http_response_code($this->_code);

		foreach ($this->_headers as $header) {
			header($header);
		}

		if (isset($this->_body)) {
			echo $this->_body;
		}
	}
}


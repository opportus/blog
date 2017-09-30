<?php

namespace Hedo\Core;

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
	 * @var object $config
	 */
	protected $config;

	/**
	 * @var object $toolbox
	 */
	protected $toolbox;

	/**
	 * @var string $code
	 */
	protected $code;

	/**
	 * @var array $headers
	 */
	protected $headers;

	/**
	 * @var string|null $body
	 */
	protected $body;

	/**
	 * Constructor.
	 *
	 * @param object      $config
	 * @param object      $toolbox
	 * @param string|int  $code    Default: 200
	 * @param array       $headers Default: array()
	 * @param string|null $body    Default: null
	 */
	public function __construct(Config $config, Toolbox $toolbox, $code = 200, $headers = array(), $body = null)
	{
		$this->init($config, $toolbox, $code, $headers, $body);
	}

	/**
	 * Initializes the response.
	 *
	 * @param object      $config
	 * @param object      $toolbox
	 * @param string|int  $code
	 * @param array       $headers
	 * @param string|null $body
	 */
	protected function init(Config $config, Toolbox $toolbox, $code, $headers, $body)
	{
		$this->config  = $config;
		$this->toolbox = $toolbox;
		$this->code    = $code;
		$this->headers = $headers;
		$this->body    = $body;
	}

	/**
	 * Sets the HTTP response code.
	 *
	 * @param string|int $code
	 */
	public function setCode($code)
	{
		$this->code = (int) $code;
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
			$this->headers = array_merge($this->headers, (array) $headers);

		} else {
			$this->headers = (array) $headers;
		}
	}

	/**
	 * Sets the HTTP response body.
	 *
	 * @param string $body
	 */
	public function setBody($body)
	{
		$this->body = (string) $body;
	}

	/**
	 * Sends the HTTP response.
	 */
	public function send()
	{
		http_response_code($this->code);

		foreach ($this->headers as $header) {
			header($header);
		}

		if (isset($this->body)) {
			echo $this->body;
		}
	}
}


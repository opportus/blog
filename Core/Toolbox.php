<?php

namespace Core;

use \Datetime;

/**
 * The toolbox...
 *
 * @version 0.0.1
 * @package Core
 * @author  Clément Cazaud <opportus@gmail.com>
 *
 * @todo Implement more tools...
 */
class Toolbox
{
	/**
	 * @var object $_config
	 */
	private $_config;

	/**
	 * Constructor.
	 *
	 * @param object $config
	 */
	public function __construct(Config $config)
	{
		$this->_init($config);
	}

	/**
	 * Initializes the toolbox.
	 *
	 * @param object $config
	 */
	private function _init(Config $config)
	{
		$this->_config = $config;
	}

	/**
	 * Sanitizes strings to include in sql queries.
	 *
	 * @param  string $key
	 * @return string $key
	 */
	public function sanitizeKey($key)
	{
		$key = strtolower($key);
		$key = preg_replace('/[^a-z0-9_*\-]/', '', $key);	

		return $key;
	}

	/**
	 * Sanitizes SQL comparison operators to include in SQL queries.
	 *
	 * @param  string $operator
	 * @return string $operator
	 */
	public function sanitizeOperator($operator)
	{
		$operatorWl = array(
			'>',
			'<',
			'<>',
			'=',
			'>=',
			'<=',
			'<=>',
			'!=',
			'IS',
			'IS NULL',
			'IS NOT',
			'IS NOT NULL',
			'LIKE',
			'NOT LIKE',
		);

		if (! in_array( $operator, $operatorWl)) {
			$operator = '';
		}

		return $operator;
	}

	/**
	 * Sanitizes SQL condition to include in SQL queries.
	 *
	 * @param  string $condition
	 * @return string $condition
	 */
	public function sanitizeCondition($condition)
	{
		$conditionWl = array(
			'AND',
			'OR',
		);

		if (! in_array( $condition, $conditionWl)) {
			$condition = '';
		}

		return $condition;
	}

	/**
	 * Sanitizes integers.
	 *
	 * @param  int $int
	 * @return int $int
	 */
	public function sanitizeInt($int)
	{
		return (int) $int;
	}

	/**
	 * Sanitizes url.
	 *
	 * @param  string $url
	 * @return string
	 */
	public function sanitizeUrl($url)
	{
		return filter_var($url, FILTER_SANITIZE_URL);
	}

	/**
	 * Sanitizes email.
	 *
	 * @param  string $email
	 * @return string
	 */
	public function sanitizeEmail($email)
	{
		return filter_var($email, FILTER_SANITIZE_EMAIL);
	}

	/**
	 * Escapes HTML.
	 *
	 * @param  string $string
	 * @return string
	 */
	public function escHtml($string)
	{
		return filter_var( $string, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES );
	}

	/**
	 * Formats datetime.
	 *
	 * @param  string $datetime
	 * @param  string $format   Default: DATE_ISO8601
	 * @return string
	 */
	public function formatDatetime($datetime, $format = DATE_ISO8601)
	{
		$datetime = new DateTime($datetime);
		return $datetime->format($format);
	}
}


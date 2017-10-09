<?php

namespace Hedo;

use Hedo\Config;

use \Datetime;

/**
 * The toolbox...
 *
 * @version 0.0.1
 * @package Hedo
 * @author  Clément Cazaud <opportus@gmail.com>
 *
 * @todo Implement more tools...
 */
class Toolbox
{
	/**
	 * @var Config $config
	 */
	protected $config;

	/**
	 * Constructor.
	 *
	 * @param Config $config
	 */
	public function __construct(Config $config)
	{
		$this->init($config);
	}

	/**
	 * Initializes the toolbox.
	 *
	 * @param Config $config
	 */
	protected function init(Config $config)
	{
		$this->config = $config;
	}

	/**
	 * Escapes HTML.
	 *
	 * @param  string $string
	 * @return string
	 */
	public function escHtml($string)
	{
		return filter_var($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	/**
	 * Sanitizes string.
	 *
	 * @param  string $string
	 * @return string
	 */
	public function sanitizeString($string)
	{
		return filter_var($string, FILTER_SANITIZE_STRING);
	}

	/**
	 * Sanitize key.
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
	 * Sanitizes SQL query comparison operator.
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
	 * Sanitizes SQL query condition operator.
	 *
	 * @param  string $condition
	 * @return string $condition
	 */
	public function sanitizeCondition($condition)
	{
		$conditionWl = array(
			'AND',
			'OR',
			'NOT',
		);

		if (! in_array( $condition, $conditionWl)) {
			$condition = '';
		}

		return $condition;
	}

	/**
	 * Sanitizes integer.
	 *
	 * @param  int $int
	 * @return int $int
	 */
	public function sanitizeInt($int)
	{
		return (int) $int;
	}

	/**
	 * Sanitizes float.
	 *
	 * @param  float $float
	 * @return float $float
	 */
	public function sanitizeFloat($float)
	{
		return (float) $float;
	}

	/**
	 * Sanitizes stringed integer.
	 *
	 * @param  string $int
	 * @return string $int
	 */
	public function sanitizeStringedInteger($int)
	{
		return filter_var($int, FILTER_SANITIZE_NUMBER_INT);
	}

	/**
	 * Sanitizes stringed float.
	 *
	 * @param  string $float
	 * @return string $float
	 */
	public function sanitizeStringedFloat($float)
	{
		return filter_var($float, FILTER_SANITIZE_NUMBER_FLOAT);
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
	 * Formats/Sanitizes datetime.
	 *
	 * @param  string $datetime Default:''
	 * @param  string $format   Default:''
	 * @param  string $type     Default:'datetime' Possible values: 'datetime', 'date', 'time'
	 * @return string
	 */
	public function formatDatetime($datetime = '', $format = '', $type = 'datetime')
	{
		$datetimeFormatter = new DateTime($datetime);

		if ('' === $format) {
			if (extension_loaded('intl')) {
				switch ($type) {
					case 'datetime':
						$dateType = \IntlDateFormatter::FULL;
						$timeType = \IntlDateFormatter::MEDIUM;
						break;
					case 'date':
						$dateType = \IntlDateFormatter::FULL;
						$timeType = \IntlDateFormatter::NONE;
						break;
					case 'time':
						$dateType = \IntlDateFormatter::NONE;
						$timeType = \IntlDateFormatter::MEDIUM;
						break;
					default :
						$dateType = \IntlDateFormatter::FULL;
						$timeType = \IntlDateFormatter::MEDIUM;
						break;
				}

				$intlDatetimeFormatter = new \IntlDateFormatter($this->config->get('App', 'locale', 'locale'), $dateType, $timeType);

				return ucwords($intlDatetimeFormatter->format($datetimeFormatter));

			} else {
				switch ($type) {
					case 'datetime':
						$format = $this->config->get('App', 'locale', 'defaultDateFormat') . ' ' . $this->config->get('app', 'locale', 'defaultTimeFormat');
						break;
					case 'date':
						$format = $this->config->get('App', 'locale', 'defaultDateFormat');
						break;
					case 'time':
						$format = $this->config->get('App', 'locale', 'defaultTimeFormat');
						break;
				}
			}
		}

		return $datetimeFormatter->format($format);
	}

	/**
	 * Validates string.
	 *
	 * @param  string $string
	 * @return bool
	 */
	public function validateString($string)
	{
		return $this->sanitizeString($string) === $string;
	}

	/**
	 * Validates key.
	 *
	 * @param  string $key
	 * @return bool
	 */
	public function validateKey($key)
	{
		return $this->sanitizeKey($key) === $key;
	}

	/**
	 * Validates integer.
	 *
	 * @param  int  $int
	 * @return bool
	 */
	public function validateInt($int)
	{
		return $this->sanitizeInt($int) === $int;
	}

	/**
	 * Validates float.
	 *
	 * @param  float $float
	 * @return bool
	 */
	public function validateFloat($float)
	{
		return $this->sanitizeFloat($float) === $float;
	}

	/**
	 * Validates stringed integer.
	 *
	 * @param  string $int
	 * @return bool
	 */
	public function validateStringedInteger($int)
	{
		return $this->sanitizeStringedInteger($int) === $int;
	}

	/**
	 * Validates stringed float.
	 *
	 * @param  string  $float
	 * @return bool
	 */
	public function validateStringedFloat($float)
	{
		return $this->sanitizeStringedFloat($float) === $float;
	}

	/**
	 * Validates email.
	 *
	 * @param  string $email
	 * @return bool
	 */
	public function validateEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	/**
	 * Validates URL.
	 *
	 * @param  string $url
	 * @return bool
	 */
	public function validateUrl($url)
	{
		return filter_var($url, FILTER_VALIDATE_URL);
	}

	/**
	 * Validates datetime.
	 *
	 * @param  string $datetime
	 * @param  string $format
	 * @return bool
	 */
	public function validateDatetime($datetime, $format)
	{
		return $this->formatDatetime($datetime, $format) === $datetime;
	}

	/**
	 * Generates token.
	 *
	 * @param  string $salt Default: ''
	 * @param  string $key  Default: ''
	 * @param  string $algo Default: 'sha256'
	 * @return string
	 */
	public function generateToken($salt = '', $key = '', $algo = 'sha256')
	{
		$salt = $salt ? $salt : bin2hex(random_bytes(32));
		$key  = $key  ? $key  : $this->config->get('app', 'security', 'secret');

		return hash_hmac($algo, $salt, $key);
	}

	/**
	 * Checks token.
	 *
	 * @param  string knownToken
	 * @param  string userToken
	 * @return bool
	 */
	public function checkToken($knownToken, $userToken)
	{
		return hash_equals($knownToken, $userToken);
	}
}


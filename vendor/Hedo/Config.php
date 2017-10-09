<?php

namespace Hedo;

/**
 * The configuration...
 *
 * @version 0.0.1
 * @package Hedo
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Config
{
	/**
	 * @var array $settings
	 */
	public $settings = array();

	/**
	 * Sets settings.
	 *
	 * @param  string $entity
	 * @param  string $setting
	 * @param  string $key     Default:null
	 * @param  mixed  $value
	 */
	public function set(string $entity, string $setting, string $key = null, $value)
	{
		if ($key) {
			$this->settings[$entity][$setting][$key] = $value;

		} else {
			$this->settings[$entity][$setting] = (array) $value;
		}
	}

	/**
	 * Gets settings.
	 *
	 * @param  string $entity
	 * @param  string $setting
	 * @param  string $key     Default:null
	 * @return mixed
	 */
	public function get(string $entity, string $setting, string $key = null)
	{
		if ($key !== null) {
			if (isset($this->settings[$entity][$setting][$key])) {
				return $this->settings[$entity][$setting][$key];
			}

		} elseif (isset($this->settings[$entity][$setting])) {
			return $this->settings[$entity][$setting];
		}

		return false;
	}
}


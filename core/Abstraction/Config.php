<?php

namespace Hedo\Abstraction;

/**
 * The configuration...
 *
 * @version 0.0.1
 * @package Abstraction
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Config
{
	/**
	 * @var array $settings
	 */
	protected $settings;

	/**
	 * Constructor.
	 *
	 * @param array $files
	 */
	public function __construct(array $files)
	{
		$this->init($files);
	}

	/**
	 * Initializes the config.
	 *
	 * @param array $files
	 */
	protected function init(array $files)
	{
		foreach ($files as $file) {
			$this->set($file, null, require($file));
		}
	}

	/**
	 * Sets settings.
	 *
	 * @param  string $setting
	 * @param  string $key
	 * @param  mixed  $value
	 */
	public function set(string $setting, string $key, $value)
	{
		if ($key) {
			$this->settings[$setting][$key] = $value;

		} else {
			$this->settings[$setting] = (array) $value;
		}
	}

	/**
	 * Gets settings.
	 *
	 * @param  string $setting
	 * @param  string $key     Default:null
	 * @return mixed
	 */
	public function get(string $setting, string $key = null)
	{
		if ($key !== null) {
			if (isset($this->settings[$setting][$key])) {
				return $this->settings[$setting][$key];
			}

		} elseif (isset($this->settings[$setting]) {
			return $this->settings[$setting];
		}

		return false;
	}
}


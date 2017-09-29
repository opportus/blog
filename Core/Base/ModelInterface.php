<?php

namespace Hedo\Core\Base;

/**
 * The model interface...
 *
 * @version 0.0.1
 * @package Core\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
interface ModelInterface {

	/**
	 * Hydrates the model.
	 *
	 * @param array $data
	 */
	public function hydrate(array $data);

	/**
	 * Extracts model's data.
	 *
	 * @return array
	 */
	public function extractData();

	/**
	 * Gets model's ID.
	 *
	 * @return int $this->id
	 */
	public function getId();
}


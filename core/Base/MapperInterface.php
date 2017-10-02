<?php

namespace Hedo\Base;

/**
 * The mapper interface...
 *
 * @version 0.0.1
 * @package Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
interface MapperInterface
{
	/**
	 * Creates.
	 *
	 * @param  array $data
	 * @return array
	 */
	public function create(array $params);

	/**
	 * Reads.
	 *
	 * @param  array $params
	 * @return array
	 */
	public function read(array $params);

	/**
	 * Updates.
	 *
	 * @param  array $params
	 * @return bool
	 */
	public function update(array $params);

	/**
	 * Deletes.
	 *
	 * @param  array $params
	 * @return bool
	 */
	public function delete(array $params);
}


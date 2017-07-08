<?php

namespace Core\Base;

/**
 * The mapper interface...
 *
 * @version 0.0.1
 * @package Core\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
interface MapperInterface
{
	/**
	 * Gets data.
	 *
	 * @param  array|int $params Default: array()
	 * @return array
	 */
	public function get($params = array());

	/**
	 * Insert/Updates data..
	 *
	 * @param array $data
	 */
	public function add(array $data);

	/**
	 * Deletes data.
	 *
	 * @param int $id
	 */
	public function delete($id);
}


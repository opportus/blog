<?php

namespace Core\Base;

/**
 * The repository interface...
 *
 * @version 0.0.1
 * @package Core\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
Interface RepositoryInterface
{
	/**
	 * Gets the model.
	 *
	 * @param  array|int $params Default: array()
	 * @return array
	 */
	public function get($params = array());

	/**
	 * Adds the model.
	 *
	 * @param object $model
	 */
	public function add(Model $model);

	/**
	 * Deletes the model.
	 *
	 * @param int $id
	 */
	public function delete($id);
}


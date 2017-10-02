<?php

namespace Hedo\Base;

/**
 * The repository interface...
 *
 * @version 0.0.1
 * @package Base
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
	 * @param  object $model
	 * @return bool
	 */
	public function add(AbstractModel $model);

	/**
	 * Deletes the model.
	 *
	 * @param  int  $id
	 * @return bool
	 */
	public function delete($id);
}


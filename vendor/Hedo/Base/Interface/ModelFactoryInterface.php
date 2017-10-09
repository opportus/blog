<?php

namespace Hedo\Base;

/**
 * The model factory interface...
 *
 * @version 0.0.1
 * @package Hedo\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
interface ModelFactoryInterface
{
	/**
	 * Creates the model.
	 *
	 * @param  array         $data Default:array()
	 * @return AbstractModel
	 */
	public function create(array $data = array());
}


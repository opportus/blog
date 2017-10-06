<?php

namespace Hedo\Base;

use Hedo\Toolbox;

/**
 * The base model factory...
 *
 * @version 0.0.1
 * @package Hedo\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
abstract class AbstractModelFactory implements ModelFactoryInterface
{
	/**
	 * @var Toolbox $toolbox
	 */
	protected $toolbox;

	/**
	 * Constructor.
	 *
	 * @param Toolbox $toolbox
	 */
	public function __construct(Toolbox $toolbox)
	{
		$this->init($toolbox);
	}

	/**
	 * Initializes the model factory.
	 *
	 * @param Toolbox $toolbox
	 */
	protected function init(Toolbox $toolbox)
	{
		$this->toolbox = $toolbox;
	}

	/**
	 * Creates the model.
	 *
	 * @param  array         $data Default:array()
	 * @return AbstractModel
	 */
	public function create(array $data = array())
	{
		$model = str_replace('Factory', 'Model', get_class($this));

		return new $model($this->toolbox, $data);
	}
}


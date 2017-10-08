<?php

namespace Hedo\Base;

use Hedo\Toolbox;

/**
 * The base model...
 *
 * @version 0.0.1
 * @package Hedo\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
abstract class AbstractModel implements ModelInterface
{
	/**
	 * @var Toolbox $toolbox
	 */
	protected $toolbox;

	/**
	 * Constructor.
	 *
	 * @param Toolbox $toolbox
	 * @param array   $data    Default: array()
	 */
	public function __construct(Toolbox $toolbox, array $data = array())
	{
		$this->init($toolbox, $data);
	}

	/**
	 * Initializes the model.
	 *
	 * @param Toolbox $toolbox
	 * @param array   $data    Default: array()
	 */
	protected function init(Toolbox $toolbox, array $data = array())
	{
		$this->toolbox = $toolbox;

		$this->hydrate($data);
	}

	/**
	 * Hydrates the model with the passed data.
	 *
	 * @param  array $data
	 * @return array
	 */
	public function hydrate(array $data)
	{
		if (empty($data)) {
			return;
		}
	
		$modelProperties = get_object_vars($this);
		$errors          = array();

		foreach($data as $property => $value) {
			if (array_key_exists($property, $modelProperties)) {
				$setter = 'set' . ucfirst($property);

				if (method_exists($this, $setter)) {
					if ( false === $this->$setter($value)) {
						$errors[] = $property;
					}
				}
			}
		}

		return $errors;
	}

	/**
	 * Extracts the model data.
	 *
	 * @return array $data
	 */
	public function extractData()
	{
		$data         = array();
		$modelMethods = get_class_methods(get_class($this));

		foreach ($modelMethods as $method) {
			if (strpos($method, 'get') === 0) {
				$field = str_replace('get_', '', strtolower(preg_replace('/\B[A-Z]/', '_$0', $method)));
				if ($value = $this->$method()) {
					$data[$field] = $value;
				}
			}
		}

		return $data;
	}

	/**
	 * Gets the ID.
	 *
	 * @return int $this->id
	 */
	public function getId()
	{
		return $this->id;
	}
}


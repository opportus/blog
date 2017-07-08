<?php

namespace Core\Base;

use Core\Toolbox;

/**
 * The base model...
 *
 * @version 0.0.1
 * @package Core\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
abstract class AbstractModel implements ModelInterface
{
	/**
	 * @var object $toolbox
	 */
	protected $toolbox;

	/**
	 * Constructor.
	 *
	 * @param object $toolbox
	 * @param array  $data    Default: array()
	 */
	public function __construct(Toolbox $toolbox, array $data = array())
	{
		$this->init($toolbox, $data);
	}

	/**
	 * Initializes the model.
	 *
	 * @param object $toolbox
	 * @param array  $data    Default: array()
	 */
	protected function init(Toolbox $toolbox, array $data = array())
	{
		$this->toolbox = $toolbox;

		$this->hydrate($data);
	}

	/**
	 * Hydrates the model with the passed data.
	 *
	 * @param array $data
	 */
	public function hydrate(array $data)
	{
		$modelProperties = get_object_vars($this);

		foreach($data as $field => $value) {
			$property = lcfirst(str_replace('_', '', ucwords($field, '_')));

			if (array_key_exists($property, $modelProperties)) {
				$setter = 'set' . ucfirst($property);

				if (method_exists($this, $setter)) {
					$this->$setter($value);
				}
			}
		}
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
				$value = $method();

				$data[$field] = $value;
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


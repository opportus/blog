<?php

namespace Hedo\Base;

use Hedo\Gateway;

use \InvalidArgumentException;

/**
 * The base mapper...
 *
 * @version 0.0.1
 * @package Hedo\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
abstract class AbstractMapper implements MapperInterface
{
	/**
	 * @var Gateway $gateway
	 */
	protected $gateway;

	/**
	 * @var array $mapper
	 */
	protected $mappers;

	/**
	 * @var string $table
	 */
	protected $table;

	/**
	 * Constructor.
	 *
	 * @param Gateway $gateway
	 * @param array   $mappers Default: array()
	 */
	public function __construct(Gateway $gateway, array $mappers = array())
	{
		$this->init($gateway, $mappers);
	}

	/**
	 * Initializes the mapper.
	 *
	 * @param Gateway $gateway
	 * @param array   $mappers Default: array()
	 */
	protected function init(Gateway $gateway, array $mappers = array())
	{
		$this->gateway = $gateway;
		$this->mappers = $mappers; 

		$thisClass   = get_class($this);
		$model       = str_replace('Mapper', '', substr($thisClass, strrpos($thisClass, '\\') + 1));
		$this->table = strtolower(preg_replace('/\B([A-Z])/', '_$1', $model));
	}

	/**
	 * Creates.
	 *
	 * @param  array $params
	 * @return array
	 */
	public function create(array $params)
	{
		$params['table'] = $this->table;

		if ($this->gateway->create($params)) {
			$params = array(
				'where' => array(
					0 => array(
						'column'   => 'id',
						'operator' => '=',
						'value'    => $this->gateway->getLastInsertId('id'),
					),
				),
			);

			return current($this->read($params));

		} else {
			return array();
		}
	}

	/**
	 * Reads.
	 *
	 * @param  array $params
	 * @return array
	 */
	public function read(array $params)
	{
		$params['table'] = $this->table;

		return $this->filterRawData($this->gateway->read($params));
	}

	/**
	 * Updates.
	 *
	 * @param  array $params
	 * @return bool
	 */
	public function update(array $params)
	{
		$params['table'] = $this->table;

		return $this->gateway->update($params);
	}

	/**
	 * Deletes.
	 *
	 * @param  array $params
	 * @return bool
	 */
	public function delete(array $params)
	{
		$params['table'] = $this->table;

		return $this->gateway->delete($params);
	}

	/**
	 * Filters raw data.
	 *
	 * @param  array $rawData
	 * @return array $data
	 */
	protected function filterRawData($rawData)
	{
		$data = array();

		foreach ($rawData as $field => $value) {
			$property = lcfirst(str_replace('_', '', ucwords($field, '_')));
			$data[$property] = $value;
		}

		return $data;
	}
}


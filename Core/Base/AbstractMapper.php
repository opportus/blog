<?php

namespace Core\Base;

use Core\Gateway;
use \InvalidArgumentException;

/**
 * The base mapper...
 *
 * @version 0.0.1
 * @package Core\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
abstract class AbstractMapper implements MapperInterface
{
	/**
	 * @var object $gateway
	 */
	protected $gateway;

	/**
	 * @var string $table
	 */
	protected $table;

	/**
	 * @var array $mapper
	 */
	protected $mappers;

	/**
	 * Constructor.
	 *
	 * @param object  $gateway
	 * @param string  $table
	 * @param $object $mappers Default: array()
	 */
	public function __construct(Gateway $gateway, $table, array $mappers = array())
	{
		$this->init($gateway, $table, $mappers);
	}

	/**
	 * Initializes the mapper.
	 *
	 * @param object $gateway
	 * @param string  $table
	 * @param $object $mappers Default: array()
	 */
	protected function init(Gateway $gateway, $table, array $mappers = array())
	{
		$this->gateway = $gateway;
		$this->table   = $table; 
		$this->mappers = $mappers; 
	}

	/**
	 * Gets.
	 *
	 * @param  array|int $params Default: array()
	 * @return array
	 */
	public function get($params = array())
	{
		if (! is_array($params) && ! is_int($params)) {
			throw new InvalidArgumentException(__CLASS__ . '::' . __FUNCTION__ . '() accepts only array or integer as argument');
		}

		if (is_int($params)) {
			$id     = $params;
			$params = array();

			$params['where'] = array(
				0 => array(
					'field'     => 'id',
					'operator'  => '=',
					'data'      => $id,
					'dataType'  => 1,
				)
			);
		}

		$params['table'] = $this->table;

		$this->gateway->read($params);

		return $this->gateway->getAll();
	}

	/**
	 * Inserts/Updates the data into the table.
	 *
	 * @param array $data
	 * @todo  implement
	 */
	public function add(array $data)
	{	
	}

	/**
	 * Deletes a row.
	 *
	 * @param int $id
	 * @todo  implement
	 */
	public function delete($id)
	{
	}
}


<?php

namespace Hedo\Core\Base;

use Hedo\Core\Gateway;
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
	 * @param object  $gateway
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

			return $this->read($params);

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

		return $this->gateway->read($params);
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
}


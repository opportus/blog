<?php

namespace Hedo\Core\Base;

/**
 * The data gateway interface...
 *
 * Provides a defined interface to the model layer to interact with any gateway.
 *
 * @version 0.0.1
 * @package Core\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
interface GatewayInterface
{
	/**
	 * Connects to the database.
	 *
	 * @param string $database Default: 'default'
	 */
	public function connect($database = 'default');

	/**
	 * Disconnects from the database.
	 *
	 * @param string $database Default: 'default'
	 */
	public function disconnect($database = 'default');

	/**
	 * Gets last insert ID.
	 *
	 * @param  string $name     Default: null
	 * @param  string $database Default: 'default'
	 * @return string
	 */
	public function getLastInsertId($name = null, $database = 'default');

	/**
	 * Creates.
	 *
	 * @param  array $params
	 * @return bool
	 */
	public function create(array $params);

	/**
	 * Reads.
	 *
	 * @param  array $params
	 * @return array
	 */
	public function read(array $params);

	/**
	 * Updates.
	 *
	 * @param  array $params
	 * @return bool
	 */
	public function update(array $params);

	/**
	 * Deletes.
	 *
	 * @param  array $params
	 * @return bool
	 */
	public function delete(array $params);
}


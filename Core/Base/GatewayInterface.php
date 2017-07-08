<?php

namespace Core\Base;

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
	 * Gets the result.
	 *
	 * @return array
	 */
	public function get();

	/**
	 * Gets all results.
	 *
	 * @return array
	 */
	public function getAll();

	/**
	 * Creates.
	 */
	public function create();

	/**
	 * Reads.
	 *
	 * @param array $params
	 */
	public function read(array $params);

	/**
	 * Updates.
	 */
	public function update();

	/**
	 * Deletes.
	 */
	public function delete();
}


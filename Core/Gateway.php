<?php

namespace Hedo\Core;

use \PDO;
use \Exception;
use \PDOException;
use \RunTimeException;
use Hedo\Core\Base\GatewayInterface;

/**
 * The default data gateway depending on PDO_MYSQL...
 *
 * @version 0.0.1
 * @package Core
 * @author  Clément Cazaud <opportus@gmail.com>
 */
class Gateway implements GatewayInterface
{
	/**
	 * @var object $config
	 */
	protected $config;

	/**
	 * @var object $toolbox
	 */
	protected $toolbox;

	/**
	 * @var array $connections
	 */
	protected $connections = array();

	/**
	 * @var object $statement
	 */
	protected $statement;

	/**
	 * Constructor.
	 *
	 * @param object $config
	 * @param object $toolbox
	 */
	public function __construct(Config $config, Toolbox $toolbox)
	{
		$this->init($config, $toolbox);
	}

	/**
	 * Initializes the adapter.
	 *
	 * @param object $config
	 * @param object $toolbox
	 */
	protected function init(Config $config, Toolbox $toolbox)
	{
		$this->config  = $config;
		$this->toolbox = $toolbox;
	}

	/**
	 * Connects to the given database.
	 *
	 * @param string $database Default: 'default'
	 */
	public function connect($database = 'default')
	{
		if (isset($this->connections[$database])) {
			return;
		}

		try {
			$credentials = $this->config->getDb($database);

			$pdo = new PDO(
				'mysql:host=' . $credentials['dbHost'] . ';dbname=' . $credentials['dbName'],
				$credentials['dbUser'],
				$credentials['dbPass'],
				$credentials['dbOptions']
			);

			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

			$this->connections[$database] = $pdo;

		} catch (PDOException $e) {
			throw new RunTimeException($e->getMessage());
		}
	}

	/**
	 * Disconnects from the given database.
	 *
	 * @param string $database Default: 'default'
	 */
	public function disconnect($database = 'default')
	{
		if (isset($this->connections[$database])) {
			$this->connections[$database] = null;
		}
	}

	/**
	 * Gets last insert ID.
	 *
	 * @param  string $name     Default: null
	 * @param  string $database Default: 'database'
	 * @return string
	 */
	public function getLastInsertId($name = null, $database = 'default')
	{
		$this->connect($database);

		try {
			return $this->connections[$database]->lastInsertId($name);

		} catch (PDOException $e) {
			throw new RunTimeException($e->getMessage());
		}
	}

	/**
	 * Prepares the statement.
	 *
	 * @param  string $statement
	 * @param  string $database      Default: 'default'
	 * @param  array  $driverOptions Default: array()
	 * @return object $this
	 */
	protected function prepare($statement, $database = 'default', $driverOptions = array())
	{
		$this->connect($database);

		try {
			$this->statement = $this->connections[$database]->prepare($statement, $driverOptions);

			return $this;

		} catch (PDOException $e) {
			throw new RunTimeException($e->getMessage());
		}
	}

	/**
	 * Binds value to the statement.
	 *
	 * @param  mixed  $parameter
	 * @param  mixed  $value
	 * @param  int    $dataType  Default: null
	 * @return object $this
	 */
	protected function bindValue($parameter, $value, $dataType = null)
	{
		try {
			if (null === $dataType) {
				if (is_string($value)) {
					$dataType = PDO::PARAM_STR;

				} elseif (is_int($value)) {
					$dataType = PDO::PARAM_INT;

				} elseif (is_null($value)) {
					$dataType = PDO::PARAM_NULL;
				}
			}

			$this->statement->bindValue($parameter, $value, $dataType);

			return $this;

		} catch (PDOException $e) {
			throw new RunTimeException($e->getMessage());
		}
	}

	/**
	 * Executes the statement.
	 *
	 * @param  array  $inputParameters Default: null
	 * @return object $this
	 */
	protected function execute(array $inputParameters = null)
	{
		try {
			$this->statement->execute($inputParameters);

			return $this;

		} catch (PDOException $e) {
			throw new RunTimeException($e->getMessage());
		}
	}

	/**
	 * Fetches all results from the statement.
	 *
	 * @param  int   $fetchStyle    Default: PDO::FETCH_ASSOC
	 * @param  mixed $fetchArgument Default: 0
	 * @param  array $ctorArgs      Default: array()
	 * @return array
	 */
	protected function fetchAll($fetchStyle = PDO::FETCH_ASSOC, $fetchArgument = 0, array $ctorArgs = array())
	{
		try {
			switch ($fetchStyle) {
				case PDO::FETCH_COLUMN:
					return $this->statement->fetchAll($fetchStyle, $fetchArgument);
				case PDO::FETCH_FUNC:
					return $this->statement->fetchAll($fetchStyle, $fetchArgument);
				case PDO::FETCH_CLASS:
					return $this->statement->fetchAll($fetchStyle, $fetchArgument, $ctorArgs);
				default:
					return $this->statement->fetchAll($fetchStyle);
			}

		} catch (PDOException $e) {
			throw new RunTimeException($e->getMessage());
		}
	}

	//-----------------------------------------------------------------------------------//
	//---------------------------------| CRUD METHODS  |---------------------------------//
	//-----------------------------------------------------------------------------------//

	/**
	 * Creates.
	 *
	 * @param  array $params
	 * @return bool
	 */
	public function create(array $params)
	{
		$defaultParams = array(
			// The data array MUST be structured as follow: 'column_name' => $value
			'data'     => array(),
			'table'    => '',
			'database' => 'default',
		);

		$columns    = array();
		$values     = array();
		$bindParams = array();
		$params     = array_merge($defaultParams, $params);

		foreach ($params['data'] as $column => $value) {
			$columns[]    = $column;
			$values[]     = $value;
			$bindParams[] = '?';
		}

		$sql  = 'INSERT INTO ' . $this->toolbox->sanitizeKey($params['table']);
		$sql .= ' (' . implode(', ', array_map(array($this->toolbox, 'sanitizeKey'), $columns)) . ')';
		$sql .= ' VALUES (' . implode(', ', $bindParams) . ')';

		$this->prepare($sql, $params['database']);

		foreach ($values as $valueNumber => $value) {
			$this->bindValue($this->toolbox->sanitizeInt($valueNumber + 1), $value);
		}

		return $this->execute();
	}

	/**
	 * Reads.
	 *
	 * @param  array $params
	 * @return array
	 *
	 * @todo Implement joins...
	 */
	public function read(array $params)
	{
		$defaultParams = array(
			'columns'  => array('*'),
			'table'    => '',
			'where'    => array(
				0 => array(
					'condition' => '',
					'column'    => 'id',
					'operator'  => '=',
					'value'     => '',
				),
			),
			'orderby'  => '',
			'order'    => 'ASC',
			'limit'    => 0,
			'database' => 'default',
		);

		$params = array_merge($defaultParams, $params);

		foreach ($params['where'] as $clauseNumber => $clause) {
			$params['where'][$clauseNumber] = array_merge($defaultParams['where'][$clauseNumber], $params['where'][$clauseNumber]);
		}

		$sql  = 'SELECT ' . implode(', ', array_map(array($this->toolbox, 'sanitizeKey'), $params['columns']));
		$sql .= ' FROM ' . $this->toolbox->sanitizeKey($params['table']);

		if ('' !== $params['where'][0]['value']) {
			$sql .= ' WHERE ';

			foreach ($params['where'] as $clauseNumber => $clause) {
				$sql .= $clause['condition'] ? $this->toolbox->sanitizeCondition($clause['condition']) . ' ' : '';
			   	$sql .= $this->toolbox->sanitizeKey($clause['column']) . ' ' . $this->toolbox->sanitizeOperator($clause['operator']) . ' ?';
			}
		}

		if ($params['orderby']) {
			$sql   .= ' ORDER BY ' . $this->toolbox->sanitizeKey($params['orderby']) . '  ' . $this->toolbox->sanitizeKey($params['order']);
		}

		if ($params['limit']) {
			$sql   .= ' LIMIT ' . $this->toolbox->sanitizeInt($params['limit']);
		}

		$this->prepare($sql, $params['database']);

		if ('' !== $params['where'][0]['value']) {
			foreach ($params['where'] as $clauseNumber => $clause) {
				$this->bindValue($this->toolbox->sanitizeInt($clauseNumber + 1), $clause['value']);
			}
		}

		$this->execute();

		return $this->fetchAll();
	}

	/**
	 * Updates.
	 *
	 * @param  array $params
	 * @return bool
	 */
	public function update(array $params)
	{
		$defaultParams = array(
			// The data array MUST be structured as follow: 'column_name' => $value
			'data'     => array(),
			'table'    => '',
			'database' => 'default',
			'where'    => array(
				0 => array(
					'condition' => '',
					'column'    => 'id',
					'operator'  => '=',
					'value'     => '',
				),
			),
		);

		$bindValues = array();
		$params     = array_merge($defaultParams, $params);

		foreach ($params['where'] as $clauseNumber => $clause) {
			$params['where'][$clauseNumber] = array_merge($defaultParams['where'][$clauseNumber], $params['where'][$clauseNumber]);
		}

		$sql  = 'UPDATE ' . $this->toolbox->sanitizeKey($params['table']);
		$sql .= ' SET ';

		foreach ($params['data'] as $column => $value) {
			$bindValues[] = $value;

			$sql .= $this->toolbox->sanitizeKey($column) . ' = ?';
			$sql .= count($bindValues) === count($params['data']) ? '' : ', ';
		}

		if ('' !== $params['where'][0]['value']) {
			$sql .= ' WHERE ';

			foreach ($params['where'] as $clauseNumber => $clause) {
				$bindValues[] = $clause['value'];

				$sql .= $clause['condition'] ? $this->toolbox->sanitizeCondition($clause['condition']) . ' ' : '';
			   	$sql .= $this->toolbox->sanitizeKey($clause['column']) . ' ' . $this->toolbox->sanitizeOperator($clause['operator']) . ' ?';
			}
		}

		$this->prepare($sql, $params['database']);

		foreach ($bindValues as $valueNumber => $value) {
			$this->bindValue($this->toolbox->sanitizeInt($valueNumber + 1), $value);
		}

		return $this->execute();
	}

	/**
	 * Deletes.
	 *
	 * @param  array $params
	 * @return bool
	 */
	public function delete(array $params)
	{
		$defaultParams = array(
			'table'    => '',
			'database' => 'default',
			'where'    => array(
				0 => array(
					'condition' => '',
					'column'    => 'id',
					'operator'  => '=',
					'value'     => '',
				),
			),
		);

		$params = array_merge($defaultParams, $params);

		foreach ($params['where'] as $clauseNumber => $clause) {
			$params['where'][$clauseNumber] = array_merge($defaultParams['where'][$clauseNumber], $params['where'][$clauseNumber]);
		}

		$sql = 'DELETE FROM ' . $this->toolbox->sanitizeKey($params['table']);

		if ('' !== $params['where'][0]['value']) {
			$sql .= ' WHERE ';

			foreach ($params['where'] as $clauseNumber => $clause) {
				$sql .= $clause['condition'] ? $this->toolbox->sanitizeCondition($clause['condition']) . ' ' : '';
			   	$sql .= $this->toolbox->sanitizeKey($clause['column']) . ' ' . $this->toolbox->sanitizeOperator($clause['operator']) . ' ?';
			}
		}

		$this->prepare($sql, $params['database']);

		if ('' !== $params['where'][0]['value']) {
			foreach ($params['where'] as $clauseNumber => $clause) {
				$this->bindValue($this->toolbox->sanitizeInt($clauseNumber + 1), $clause['value']);
			}
		}

		return $this->execute();
	}
}


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
	 * @var object $_config
	 */
	private $_config;

	/**
	 * @var object $_toolbox
	 */
	private $_toolbox;

	/**
	 * @var array $_connections
	 */
	private $_connections = array();

	/**
	 * @var object $_statement
	 */
	private $_statement;

	/**
	 * Constructor.
	 *
	 * @param object $config
	 * @param object $toolbox
	 */
	public function __construct(Config $config, Toolbox $toolbox)
	{
		$this->_init($config, $toolbox);
	}

	/**
	 * Initializes the adapter.
	 *
	 * @param object $config
	 * @param object $toolbox
	 */
	private function _init(Config $config, Toolbox $toolbox)
	{
		$this->_config  = $config;
		$this->_toolbox = $toolbox;
	}

	/**
	 * Connects to the given database.
	 *
	 * @param string $database Default: 'default'
	 */
	public function connect($database = 'default')
	{
		if (isset($this->_connections[$database])) {
			return;
		}

		try {
			$credentials = $this->_config->getDb($database);

			$pdo = new PDO(
				'mysql:host=' . $credentials['dbHost'] . ';dbname=' . $credentials['dbName'],
				$credentials['dbUser'],
				$credentials['dbPass'],
				$credentials['dbOptions']
			);

			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

			$this->_connections[$database] = $pdo;

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
		if (isset($this->_connections[$database])) {
			$this->_connections[$database] = null;
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
			return $this->_connections[$database]->lastInsertId($name);

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
	private function _prepare($statement, $database = 'default', $driverOptions = array())
	{
		$this->connect($database);

		try {
			$this->_statement = $this->_connections[$database]->prepare($statement, $driverOptions);

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
	private function _bindValue($parameter, $value, $dataType = null)
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

			$this->_statement->bindValue($parameter, $value, $dataType);

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
	private function _execute(array $inputParameters = null)
	{
		try {
			$this->_statement->execute($inputParameters);

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
	private function _fetchAll($fetchStyle = PDO::FETCH_ASSOC, $fetchArgument = 0, array $ctorArgs = array())
	{
		try {
			switch ($fetchStyle) {
				case PDO::FETCH_COLUMN:
					return $this->_statement->fetchAll($fetchStyle, $fetchArgument);
				case PDO::FETCH_FUNC:
					return $this->_statement->fetchAll($fetchStyle, $fetchArgument);
				case PDO::FETCH_CLASS:
					return $this->_statement->fetchAll($fetchStyle, $fetchArgument, $ctorArgs);
				default:
					return $this->_statement->fetchAll($fetchStyle);
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

		$sql  = 'INSERT INTO ' . $this->_toolbox->sanitizeKey($params['table']);
		$sql .= ' (' . implode(', ', array_map(array($this->_toolbox, 'sanitizeKey'), $columns)) . ')';
		$sql .= ' VALUES (' . implode(', ', $bindParams) . ')';

		$this->_prepare($sql, $params['database']);

		foreach ($values as $valueNumber => $value) {
			$this->_bindValue($this->_toolbox->sanitizeInt($valueNumber + 1), $value);
		}

		return $this->_execute();
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

		$sql  = 'SELECT ' . implode(', ', array_map(array($this->_toolbox, 'sanitizeKey'), $params['columns']));
		$sql .= ' FROM ' . $this->_toolbox->sanitizeKey($params['table']);

		if ('' !== $params['where'][0]['value']) {
			$sql .= ' WHERE ';

			foreach ($params['where'] as $clauseNumber => $clause) {
				$sql .= $clause['condition'] ? $this->_toolbox->sanitizeCondition($clause['condition']) . ' ' : '';
			   	$sql .= $this->_toolbox->sanitizeKey($clause['column']) . ' ' . $this->_toolbox->sanitizeOperator($clause['operator']) . ' ?';
			}
		}

		if ($params['orderby']) {
			$sql   .= ' ORDER BY ' . $this->_toolbox->sanitizeKey($params['orderby']) . '  ' . $this->_toolbox->sanitizeKey($params['order']);
		}

		if ($params['limit']) {
			$sql   .= ' LIMIT ' . $this->_toolbox->sanitizeInt($params['limit']);
		}

		$this->_prepare($sql, $params['database']);

		if ('' !== $params['where'][0]['value']) {
			foreach ($params['where'] as $clauseNumber => $clause) {
				$this->_bindValue($this->_toolbox->sanitizeInt($clauseNumber + 1), $clause['value']);
			}
		}

		$this->_execute();

		return $this->_fetchAll();
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

		$sql  = 'UPDATE ' . $this->_toolbox->sanitizeKey($params['table']);
		$sql .= ' SET ';

		foreach ($params['data'] as $column => $value) {
			$bindValues[] = $value;

			$sql .= $this->_toolbox->sanitizeKey($column) . ' = ?';
			$sql .= count($bindValues) === count($params['data']) ? '' : ', ';
		}

		if ('' !== $params['where'][0]['value']) {
			$sql .= ' WHERE ';

			foreach ($params['where'] as $clauseNumber => $clause) {
				$bindValues[] = $clause['value'];

				$sql .= $clause['condition'] ? $this->_toolbox->sanitizeCondition($clause['condition']) . ' ' : '';
			   	$sql .= $this->_toolbox->sanitizeKey($clause['column']) . ' ' . $this->_toolbox->sanitizeOperator($clause['operator']) . ' ?';
			}
		}

		$this->_prepare($sql, $params['database']);

		foreach ($bindValues as $valueNumber => $value) {
			$this->_bindValue($this->_toolbox->sanitizeInt($valueNumber + 1), $value);
		}

		return $this->_execute();
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

		$sql = 'DELETE FROM ' . $this->_toolbox->sanitizeKey($params['table']);

		if ('' !== $params['where'][0]['value']) {
			$sql .= ' WHERE ';

			foreach ($params['where'] as $clauseNumber => $clause) {
				$sql .= $clause['condition'] ? $this->_toolbox->sanitizeCondition($clause['condition']) . ' ' : '';
			   	$sql .= $this->_toolbox->sanitizeKey($clause['column']) . ' ' . $this->_toolbox->sanitizeOperator($clause['operator']) . ' ?';
			}
		}

		$this->_prepare($sql, $params['database']);

		if ('' !== $params['where'][0]['value']) {
			foreach ($params['where'] as $clauseNumber => $clause) {
				$this->_bindValue($this->_toolbox->sanitizeInt($clauseNumber + 1), $clause['value']);
			}
		}

		return $this->_execute();
	}
}


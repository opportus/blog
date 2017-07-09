<?php

namespace Core;

use \PDO;
use \Exception;
use \PDOException;
use \RunTimeException;
use Core\Base\GatewayInterface;

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

	//-----------------------------------------------------------------------------------//
	//---------------------------------| PDO WRAPPERS  |---------------------------------//
	//-----------------------------------------------------------------------------------//

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
	 * Prepares the statement.
	 *
	 * @param  string $statement
	 * @param  string $database  Default: 'default'
	 * @return object $this
	 */
	private function _prepare($statement, $database = 'default')
	{
		$this->connect($database);

		try {
			$this->_statement = $this->_connections[$database]->prepare($statement);

			return $this;

		} catch (PDOException $e) {
			throw new RunTimeException($e->getMessage());
		}
	}

	/**
	 * Binds param to the statement.
	 *
	 * @param  mixed  $parameter
	 * @param  mixed  &$variable
	 * @param  int    $dataType  Default: \PDO::PARAM_STR
	 * @return object $this
	 */
	private function _bindParam($parameter, $variable, $dataType = PDO::PARAM_STR)
	{
		try {
			$this->_statement->bindParam($parameter, $variable, $dataType);

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
	 * Gets the result.
	 *
	 * @param  int   $fetchStyle        Default: \PDO::FETCH_ASSOC
	 * @param  int   $cursorOrientation Default: \PDO::FETCH_ORI_NEXT
	 * @param  int   $cursorOffset      Default: 0
	 * @return array
	 */
	public function get($fetchStyle = PDO::FETCH_ASSOC, $cursorOrientation = PDO::FETCH_ORI_NEXT, $cursorOffset = 0)
	{
		try {
			return $this->_statement->fetch($fetchStyle, $cursorOrientation, $cursorOffset);

		} catch (PDOException $e) {
			throw new RunTimeException($e->getMessage());
		}
	}

	/**
	 * Gets all results.
	 *
	 * @param  int   $fetchStyle    Default: \PDO::FETCH_ASSOC
	 * @param  mixed $fetchArgument Default: 0
	 * @param  array $ctorArgs      Default: array()
	 * @return array
	 */
	public function getAll($fetchStyle = PDO::FETCH_ASSOC, $fetchArgument = 0, array $ctorArgs = array())
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
	 * @todo Implement...
	 */
	public function create(){}

	/**
	 * Reads.
	 *
	 * @param  array  $params
	 * @return object $this
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
					'field'     => 'id',
					'operator'  => '=',
					'data'      => '',
					'dataType'  => 1,
				),
			),
			'orderby'  => '',
			'order'    => 'ASC',
			'limit'    => 0,
			'database' => 'default',
		);

		// Normalizes the params...
		$params = array_merge($defaultParams, $params);
		foreach ($params['where'] as $clauseNumber => $param) {
			$params['where'][$clauseNumber] = array_merge($defaultParams['where'][$clauseNumber], $params['where'][$clauseNumber]);
		}

		// Constructs the query....
		$sql  = 'SELECT ' . implode(', ', array_map(array($this->_toolbox, 'sanitizeKey'), $params['columns']));
		$sql .= ' FROM ' . $this->_toolbox->sanitizeKey($params['table']);
		if ('' !== $params['where'][0]['data']) {
			$sql .= ' WHERE ';
			foreach ($params['where'] as $clauseNumber => $param) {
				$sql .= $this->_toolbox->sanitizeCondition($param['condition']) . ' ' . $this->_toolbox->sanitizeKey($param['field']) . ' ' . $this->_toolbox->sanitizeOperator($param['operator']) . ' ?';
			}
		}
		if ($params['orderby']) {
			$sql   .= ' ORDER BY ' . $this->_toolbox->sanitizeKey($params['orderby']) . '  ' . $this->_toolbox->sanitizeKey($params['order']);
		}
		if ($params['limit']) {
			$sql   .= ' LIMIT ' . $this->_toolbox->sanitizeInt($params['limit']);
		}

		// Prepares the query...
		$this->_prepare($sql, $params['database']);
		if ('' !== $params['where'][0]['data']) {
			foreach ($params['where'] as $clauseNumber => $param) {
				$this->_bindParam($this->_toolbox->sanitizeInt($clauseNumber + 1), $param['data'], $this->_toolbox->sanitizeInt($param['dataType']));
			}
		}

		// Executes the statement...
		$this->_execute();

		return $this;
	}

	/**
	 * Updates.
	 *
	 * @todo Implement...
	 */
	public function update(){}

	/**
	 * Deletes.
	 *
	 * @todo Implement...
	 */
	public function delete(){}
}


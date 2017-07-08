<?php

namespace Core\Base;

use Core\Container;
use Core\Mapper;
use \InvalidArgumentException;

/**
 * The base repository...
 *
 * @version 0.0.1
 * @package Core\Base
 * @author  Clément Cazaud <opportus@gmail.com>
 */
abstract class AbstractRepository implements RepositoryInterface
{
	/**
	 * @var object $container
	 */
	protected $container;

	/**
	 * @var object $mapper
	 */
	protected $mapper;

	/**
	 * @var array $models
	 */
	protected $models = array();

	/**
	 * Constructor.
	 *
	 * @param object $container
	 * @param object $mapper
	 */
	public function __construct(Container $container, AbstractMapper $mapper)
	{
		$this->init($container, $mapper);
	}

	/**
	 * Initializes the repository.
	 *
	 * @param object $container
	 * @param object $mapper
	 */
	protected function init(Container $container, AbstractMapper $mapper)
	{
		$this->container = $container;
		$this->mapper    = $mapper;
	}

	/**
	 * Gets the model.
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
			$id = $params;

			if (isset($this->models[$id])) {
				return $this->model[$id];
			}
		}

		$data   = array();
		$models = array();

		// Filters the request...
		if (is_array($params) && isset($params['where'])) {
			foreach ($params['where'] as $clauseNumber => $param) {

				// The repository handles only requests based on the model/row ID...
				if (isset($param['field']) && 'id' !== $param['field']) {
					unset($params['where'][$clauseNumber]);
					continue;
				}

				if (isset($param['data'])) {
					$id = $param['data'];

					// If the model is already in the repository...
					if (isset($this->models[$id])) {
						$models[$id] = $this->models[$id];
						unset($params['where'][$clauseNumber]);
						continue;
					}
				}
			}
		}

		if ($test = $this->mapper->get($params)) {
			$data = $test;
		}

		if (! empty($data)) {
			$modelClass = str_replace('Repository', 'Model', get_class($this));

			foreach ($data as $datum) {
				$model                         = new $modelClass($this->container->get('Toolbox'), $datum);
				$this->models[$model->getId()] = $model;
				$models[$model->getId()]       = $model;
			}
		}

		$models = count($models) === 1 ? current($models) : $models;

		return $models;
	}

	/**
	 * Adds the model.
	 *
	 * @param object $model
	 */
	public function add(Model $model)
	{
		$this->models[$model->getId()] = $model;

		$this->mapper->add($model->extractData());
	}

	/**
	 * Deletes the model from persistance.
	 *
	 * @param int $id
	 */
	public function delete($id)
	{
		if (isset($this->models[$id])) {
			unset($this->models[$id]);

			$this->mapper->delete($id);
		}
	}
}


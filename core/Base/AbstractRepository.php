<?php

namespace Hedo\Base;

use Hedo\Service\Container;
use \InvalidArgumentException;

/**
 * The base repository...
 *
 * @version 0.0.1
 * @package Base
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
		$models = array();

		if (is_int($params)) {
			$id = $params;

			if (isset($this->models[$id])) {
				return $this->model[$id];
			}

			$params = array(
				'where' => array(
					0 => array(
						'column'   => 'id',
						'operator' => '=',
						'value'    => $id,
					),
				),
			);

		} elseif (is_array($params) && isset($params['where'])) {
			foreach ($params['where'] as $clauseNumber => $clause) {

				// The repository handles only requests based on the model/row ID...
				if (isset($clause['column']) && 'id' !== $clause['column']) {
					unset($params['where'][$clauseNumber]);
					continue;

				} elseif (isset($clause['value'])) {
					$id = $clause['value'];

					// If the model is already in the repository...
					if (isset($this->models[$id])) {
						$models[$id] = $this->models[$id];
						unset($params['where'][$clauseNumber]);
						continue;
					}
				}
			}

			// Reorders where clauses...
			$i = 0;
			foreach ($params['where'] as $clauseNumber => $clause) {
				if ($i = 0 && isset($clause['condition'])) {
					unset($clause['condition']);
				}

				$params['where'][$i] = $clause;

				$i++;
			}
		}

		if (! empty($data = $this->mapper->read($params))) {
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
	 * @param  object $model
	 * @return mixed  $model->id
	 */
	public function add(AbstractModel $model)
	{
		$params = array(
			'data'  => $model->extractData(),
		);

		if (null !== $model->getId()) {
			$this->models[$model->getId()] = $model;

			$params['where'] = array(
				0 => array(
					'column'   => 'id',
					'operator' => '=',
					'value'    => $model->getId(),
				),
			);

			$this->mapper->update($params);

		} elseif (! empty($data = $this->mapper->create($params))) {
			$modelClass                    = str_replace('Repository', 'Model', get_class($this));
			$model                         = new $modelClass($this->container->get('Toolbox'), $data);
			$this->models[$model->getId()] = $model;
		}

		return $model->getId();
	}

	/**
	 * Deletes the model.
	 *
	 * @param  int  $id
	 * @return bool
	 */
	public function delete($id)
	{
		$id = (int) $id;

		if (isset($this->models[$id])) {
			unset($this->models[$id]);
		}

		$params = array(
			'where' => array(
				0 => array(
					'column'   => 'id',
					'operator' => '=',
					'value'    => $id,
				),
			),
		);

		return $this->mapper->delete($params);
	}
}


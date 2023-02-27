<?php

namespace Api\V1_0_0\Repositories\Rest;

use Api\V1_0_0\Repositories\Rest\Contracts\RestInterface;
use Illuminate\Database\Eloquent\Model;


class RestRepository implements RestInterface {


	/**
	 * @var Model
	 * model property on class instances
	 */
	private $model;

	/**
	 * RestRepository constructor.
	 * @param Model $model
	 * Constructor bind to model
	 */
	public function __construct(Model $model)
	{
		$this->model = $model;
	}


	/**
	 * @return mixed
	 * Get all instance of model
	 */
	public function all()
	{
		return $this->model->all();
	}

	/**
	 * @param $limit
	 * @return mixed
	 * Get all instance of model
	 */
	public function paginate($limit)
	{
		return $this->model->paginate($limit);
	}


	/**
	 * @param array $data
	 * @return mixed
	 * Create new record in database
	 */
	public function create(array $data)
	{
		return $this->model->create($data);
	}


	/**
	 * @param array $data
	 * @return mixed
	 * Create many in database
	 */
	public function createMany(array $data)
	{
		return $this->model->createMany($data);
	}


	/**
	 * @param array $data
	 * @param $id
	 * @return mixed
	 * Update record in database
	 */
	public function update(array $data, $id)
	{
		$record = $this->model->find($id);

		return $record->fill($data)->save();
	}

	/**
	 * @param $id
	 * @return mixed
	 * Delete record in database.
	 */
	public function delete($id)
	{
		return $this->model->destroy($id);
	}


	/**
	 * @param $id
	 * @return mixed
	 * Get row in database
	 */
	public function show($id)
	{
		return $this->model->find($id);
	}

	/**
	 * @return Model
	 * Get
	 */
	public function getModel()
	{
		return $this->model;
	}

	/**
	 * @param $model
	 * @return $this
	 * Set Model
	 */
	public function setModel($model)
	{
		$this->model = $model;
		return $this;
	}

	/**
	 * @param $relations
	 * @return mixed
	 * Add relations
	 */
	public function with($relations)
	{
		return $this->model->with($relations);
	}

    public function updateOrCreate(array $identifier, array $data) {
        // TODO: Implement updateOrCreate() method.
        $result = $this->model->updateOrCreate(
            $identifier,
            $data
        );

        return $result;
    }
}

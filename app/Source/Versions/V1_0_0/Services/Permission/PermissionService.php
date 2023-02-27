<?php

namespace Api\V1_0_0\Services\Permission;


use Api\V1_0_0\Models\Permission;
use Api\V1_0_0\Repositories\Rest\RestRepository;

class PermissionService
{

	/**
	 * @var RestRepository
	 */
	private RestRepository $rest;

	public function __construct(Permission $model)
	{

		$this->rest = new RestRepository($model);
	}

	/**
	 * @param array $data
	 * @return array|null
	 */
	public function store(array $data)
	{

		$result = $this->rest->create($data);


		return $result;
	}

	/**
	 * @param int $id
	 * @param array $data
	 * @return array
	 */
	public function update(array $data, int $id)
	{

		if ($response = $this->rest->getModel()->find($id)) {
			$response->fill($data)->save();

			return $this->show($id);
		}
	}

	/**
	 * @param int $id
	 * @return array
	 */
	public function show(int $id)
	{
		return $this->rest->getModel()
			->find($id);
	}


	/**
	 * @param int $id
	 * @return array
	 */
	public function delete(int $id)
	{

		return $this->rest->delete($id);
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function list(array $data)
	{
		$result = $this->rest->getModel();


		if (!empty($data['role'])) {
			$result = $result->whereRole($data['role']);
		}

		if ($data['paginate']) {
			return $result->paginate($data['per_page']);
		}
		return $result->get();
	}

	public function deleteByRole($role){
	    $result = $this->rest->getModel()->whereRole($role);

	    return $result->delete();
    }

	public function permissions(){

	    return config('constants.users.permissions');
    }
}

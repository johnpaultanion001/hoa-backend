<?php

namespace Api\V1_0_0\Services\VisitorLog;

use Api\V1_0_0\Mail\VisitorInformation;
use Api\V1_0_0\Models\VisitorLog;
use Api\V1_0_0\Repositories\Rest\RestRepository;
use Illuminate\Support\Facades\Mail;

class VisitorLogService
{

	/**
	 * @var RestRepository
	 */
	private RestRepository $rest;

	public function __construct(VisitorLog $model)
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

		Mail::send(new VisitorInformation($result));

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
			->with(['fileIdentification', 'status'])
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
		$result = $this->rest->getModel()
			->with(['fileIdentification', 'table', 'status']);

		if (!empty($data['user_uid'])) {
			$result = $result->whereHas('table', function ($query) use ($data) {
				$query->where('uid', $data['user_uid']);
			});
		}

		if (!empty($data['company_id'])) {
			$result = $result->whereCompanyId($data['company_id']);
		}



        if (!empty($data['name'])) {
            $result = $result->where('name','LIKE', '%'.$data['name'].'%');
        }

		if ($data['paginate']) {
			return $result->paginate($data['per_page']);
		}
		return $result->get();
	}
}

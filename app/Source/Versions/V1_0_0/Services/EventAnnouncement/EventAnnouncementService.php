<?php

namespace Api\V1_0_0\Services\EventAnnouncement;


use Api\V1_0_0\Models\EventAnnouncement;
use Api\V1_0_0\Repositories\Rest\RestRepository;

class EventAnnouncementService
{

	/**
	 * @var RestRepository
	 */
	private RestRepository $rest;

	public function __construct(EventAnnouncement $model)
	{

		$this->rest = new RestRepository($model);
	}

	/**
	 * @param array $data
	 * @return array|null
	 */
	public function store(array $data)
	{

		return $this->rest->create($data);
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
		$result = $this->rest->getModel()
			->with(['fileCover'])
			->find($id);
		return $result;
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
			->with(['fileCover']);

		if (!empty($data['company_id'])) {
			$result = $result->whereCompanyId($data['company_id']);
		}

        if (!empty($data['title'])) {
            $result = $result->where('title','LIKE', '%'.$data['title'].'%');
        }
		if ($data['paginate']) {
			return $result->paginate($data['per_page']);
		}
		return $result->get();
	}

	public function clientList(array $data)
	{
		$result = $this->rest->getModel()
			->with(['fileCover']);
		$result = $result->whereVisible(1);

		if (!empty($data['company_id'])) {
			$result = $result->whereCompanyId($data['company_id']);
		}

        if (!empty($data['title'])) {
            $result = $result->where('title','LIKE', '%'.$data['title'].'%');
        }
		if ($data['paginate']) {
			return $result->paginate($data['per_page']);
		}
		return $result->get();
	}

	public function tags()
	{
		$tags = [];
		$result = $this->rest->getModel()
			->pluck('tags');
		foreach ($result as $key => $value) {
			foreach ($value as $k => $v) {
				if (!in_array($v, $tags)) {
					$tags[] = $v;
				}
			}
		}
		return $tags;
	}
}

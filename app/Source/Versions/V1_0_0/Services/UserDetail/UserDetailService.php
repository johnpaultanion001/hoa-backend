<?php

namespace Api\V1_0_0\Services\UserDetail;


use Api\V1_0_0\Models\UserDetail;
use Api\V1_0_0\Repositories\Rest\RestRepository;

class UserDetailService
{

    /**
     * @var RestRepository
     */
    private RestRepository $rest;

    public function __construct(UserDetail $model)
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
        return $this->rest->show($id);
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


        if (!empty($data['user_id'])) {
            $result = $result->where('user_id', $data['user_id']);
        }


        if ($data['paginate']) {
            return $result->paginate($data['per_page']);
        }
        return $result->get();
    }


    public function updateOrCreate(array $identifier, array $data)
    {

        $result = $this->rest->updateOrCreate($identifier, $data);

        return $result;
    }

    public function first($data)
    {
        $result = $this->rest->getModel();

        if (!empty($data['uid'])) {
            $result = $result->whereUid($data['uid']);
        }

        if (!empty($data['user_id'])) {
            $result = $result->where('user_id', $data['user_id']);
        }


        if (!empty($data['company_id'])) {

            $result = $result->whereCompanyId($data['company_id']);
        }

        return $result->first();
    }
}

<?php

namespace Api\V1_0_0\Services\UserSetting;


use Api\V1_0_0\Models\UserSetting;
use Api\V1_0_0\Repositories\Rest\RestRepository;

class UserSettingService
{

    /**
     * @var RestRepository
     */
    private RestRepository $rest;

    public function __construct(UserSetting $model)
    {

        $this->rest = new RestRepository($model);
    }

    /**
     * @param array $data
     * @return array|null
     */
    public function store(array $data)
    {
        $result =  $this->rest->create($data);


        return $result;
    }

    /**
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(array $data,  $id)
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
    public function show($id)
    {
        $result =  $this->rest->show($id);

        return $result;
    }


    /**
     * @param int $id
     * @return array
     */
    public function delete($id)
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

        if (!empty($data['client'])) {
            $result = $result->where('value->client', $data['client']);
        }

        if (!empty($data['admin'])) {
            $result = $result->where('value->admin', $data['admin']);
        }


        if (!empty($data['status'])) {
            $result = $result->where('value->status', boolval($data['status']));
        }

        if (!empty($data['user_id'])) {
            $result = $result->where('user_id', $data['user_id']);
        }

        if (!empty($data['company_id'])) {
            $result = $result->where('user_id', $data['company_id']);
        }


        if (!empty($data['page_name'])) {
            $result = $result->where('value->page', $data['page_name']);
        }

        if (!empty($data['keys'])) {
            $result = $result->whereIn('key', explode("-", $data['keys']));
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
}

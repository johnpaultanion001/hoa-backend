<?php

namespace Api\V1_0_0\Services\User;


use Api\V1_0_0\Models\User;
use Api\V1_0_0\Repositories\Rest\RestRepository;
use Illuminate\Support\Facades\Artisan;

class UserService
{

    /**
     * @var RestRepository
     */
    private RestRepository $rest;

    public function __construct(User $model)
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
        if ($result->role == "company") {
            Artisan::call('setting:create', ['id' =>  $result->id]);
        }

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


        if (!empty($data['roles'])) {
            $result = $result->whereIn('role', explode("-", $data['roles']));
        }


        if (!empty($data['name'])) {
            $result = $result->where('name','LIKE', '%'.$data['name'].'%');
        }


        if (!empty($data['company_id'])) {

            $result = $result->whereHas('userDetail', function ($query) use ($data) {
                $query->where('company_id', $data['company_id']);
            });
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
        return $result->first();
    }
}

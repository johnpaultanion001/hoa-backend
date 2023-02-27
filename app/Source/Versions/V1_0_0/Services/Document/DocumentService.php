<?php

namespace Api\V1_0_0\Services\Document;


use Api\V1_0_0\Models\Document;
use Api\V1_0_0\Models\User;
use Api\V1_0_0\Repositories\Rest\RestRepository;
use DateInterval;
use DatePeriod;
use DateTime;

class DocumentService
{

    /**
     * @var RestRepository
     */
    private RestRepository $rest;

    public function __construct(Document $model)
    {

        $this->rest = new RestRepository($model);
    }

    /**
     * @param array $data
     * @return array|null
     */
    public function store(array $data)
    {
  

        if($data['user_id'] == 0 || !isset($data['user_id'])) {
            
            $users = User::where([
                ['role','client'],
            ])->with(['userDetail'])->get();


            $ids = array();
            
            foreach($users as $user) {
                if($user->userDetail['company_id'] == $data['company_id']) {
                    $doc_param = [
                        'user_id' => $user->id,
                        'title' => $data['title'],
                        'description' => $data['description'],
                        'company_id' => $data['company_id'],
                    ];
                    $document = $this->rest->create($doc_param);
                    array_push($ids, $document->id);
                }
            }
            return [
                'users' => $ids
            ];
        } else {
            return $this->rest->create($data);
        }
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
            ->with(['fileDocument'])
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
            ->with(['fileDocument']);


        if (!empty($data['date'])) {
            $result = $result->whereDate('created_at', $data['date']);
        }

        if (!empty($data['user_id'])) {
            $result = $result->whereUserId($data['user_id']);
        }

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
}

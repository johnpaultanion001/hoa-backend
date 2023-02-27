<?php

namespace Api\V1_0_0\Services\Inquiry;

use Api\V1_0_0\Mail\InquiryReply;
use Api\V1_0_0\Models\Inquiry;
use Api\V1_0_0\Repositories\Rest\RestRepository;
use Illuminate\Support\Facades\Mail;

class InquiryService
{

    /**
     * @var RestRepository
     */
    private RestRepository $rest;

    public function __construct(Inquiry $model)
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
        return $this->rest->getModel()

            ->with(['user'])
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
            ->with(['user']);


        if (!empty($data['user_id'])) {
            $result = $result->whereUserId($data['user_id']);
        }

        if (!empty($data['company_id'])) {

            $result = $result->whereCompanyId($data['company_id']);
        }

        if (!empty($data['subject'])) {
            $result = $result->where('subject','LIKE', '%'.$data['subject'].'%');
        }

        if ($data['paginate']) {
            return $result->paginate($data['per_page']);
        }



        return $result->get();
    }


    public function reply($data, $id)
    {

        Mail::send(new InquiryReply($data));

        $result = $this->update(["status" => 1], $id);
        return $result;
    }
}

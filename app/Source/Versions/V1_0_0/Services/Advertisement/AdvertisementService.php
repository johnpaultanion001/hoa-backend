<?php

namespace Api\V1_0_0\Services\Advertisement;


use Api\V1_0_0\Models\Advertisement;
use Api\V1_0_0\Repositories\Rest\RestRepository;

class AdvertisementService {

	/**
	 * @var RestRepository
	 */
	private RestRepository $rest;

	public function __construct(Advertisement $model) {

		$this->rest = new RestRepository($model);
	}

	/**
	 * @param array $data
	 * @return array|null
	 */
	public function store(array $data) {

		return $this->rest->create($data);
	}

	/**
	 * @param int $id
	 * @param array $data
	 * @return array
	 */
	public function update(array $data, int $id) {

		if ($response = $this->rest->getModel()->find($id)) {
			$response->fill($data)->save();

			return $this->show($id);
		}

	}

	/**
	 * @param int $id
	 * @return array
	 */
	public function show(int $id) {
	    $result =  $this->rest->getModel()
            ->with(['fileCover']);


            if($id){
               $result = $result->find($id);
            }else{
                $result = $result->inRandomOrder()->first();
            }

        return $result;
	}


	/**
	 * @param int $id
	 * @return array
	 */
	public function delete(int $id) {

		return $this->rest->delete($id);
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function list(array $data) {

        $result = $this->rest->getModel()
            ->with(['fileCover']);

        if(!empty($data['type'])){
            $result = $result->whereType($data['type']);
        }
        if (!empty($data['name'])) {
            $result = $result->where('name','LIKE', '%'.$data['name'].'%');
        }

        if($data['paginate']){
            return $result->paginate($data['per_page']);
        }
        return $result->get();
	}
}

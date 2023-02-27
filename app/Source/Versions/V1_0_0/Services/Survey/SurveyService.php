<?php
namespace Api\V1_0_0\Services\Survey;

use Api\V1_0_0\Models\Survey;
use Api\V1_0_0\Repositories\Rest\RestRepository;

class SurveyService 
{
	/**
	 * @var RestRepository
	 */
	private RestRepository $rest;

    public function __construct(Survey $model) {
		$this->rest = new RestRepository($model);
	}

  public function store(array $data) {
		return $this->rest->create($data);
	}

  public function update(array $data, $id)
  {
      if ($response = $this->rest->getModel()->find($id)) {
          $response->fill($data)->save();
          return $this->show($id);
      }
  }

  public function show($id)
  {
      $result = Survey::with(['questions.options'])->where("id", $id)->first();;
      return $result;
  }

  public function display(array $data) {
    $result = $this->rest->getModel()->with(['questions.options'])->whereEnabled(1);
    
    if(!empty($data['company_id'])){ 
      $result = $result->whereCompanyId($data['company_id']);
    }

    return $result->get();
  } 

	public function list(array $data) {
        $result = $this->rest->getModel()->with(['questions.options']);

        if(!empty($data['company_id'])){ 
          $result = $result->whereCompanyId($data['company_id']);
        }

        if($data['paginate']){
            return $result->paginate($data['per_page']);
        }
        return $result->get();
	}
}
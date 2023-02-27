<?php
namespace Api\V1_0_0\Services\Response;

use Api\V1_0_0\Models\Response;
use Api\V1_0_0\Repositories\Rest\RestRepository;

class ResponseService 
{
	/**
	 * @var RestRepository
	 */
	private RestRepository $rest;

    public function __construct(Response $model) {
		$this->rest = new RestRepository($model);
	}

    public function store(array $data) {
		return $this->rest->create($data);
	}

	public function list(array $data) {
		$result = $this->rest->getModel()->with(['user', 'answers', 'survey']);

		if(!empty($data['user_id'])){ 
			$result = $result->whereUserId($data['user_id']);
		}

		if(!empty($data['survey_id'])){ 
			$result = $result->whereSurveyId($data['survey_id']);
		}
		
        return $result->get();
	}
}
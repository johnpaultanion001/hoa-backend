<?php
namespace Api\V1_0_0\Services\Question;

use Api\V1_0_0\Models\Question;
use Api\V1_0_0\Repositories\Rest\RestRepository;

class QuestionService 
{
	/**
	 * @var RestRepository
	 */
	private RestRepository $rest;

    public function __construct(Question $model) {
		$this->rest = new RestRepository($model);
	}

    public function store(array $data) {
		return $this->rest->create($data);
	}

	public function updateSurvey($id) {
		Question::where([
			"survey_id" => $id,
		])->delete();
	}
}
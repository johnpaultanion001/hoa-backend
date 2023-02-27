<?php
namespace Api\V1_0_0\Services\Option;

use Api\V1_0_0\Models\Option;
use Api\V1_0_0\Repositories\Rest\RestRepository;

class OptionService 
{
	/**
	 * @var RestRepository
	 */
	private RestRepository $rest;

    public function __construct(Option $model) {
		$this->rest = new RestRepository($model);
	}

    public function store(array $data) {
		return $this->rest->create($data);
	}

	public function updateSurvey($id) {
		Option::where([
			"survey_id" => $id,
		])->delete();
	}
}
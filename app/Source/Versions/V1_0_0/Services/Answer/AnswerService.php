<?php
namespace Api\V1_0_0\Services\Answer;

use Api\V1_0_0\Models\Answer;
use Api\V1_0_0\Repositories\Rest\RestRepository;

class AnswerService 
{
	/**
	 * @var RestRepository
	 */
	private RestRepository $rest;

    public function __construct(Answer $model) {
		$this->rest = new RestRepository($model);
	}
    
    public function store(array $data) {
		return $this->rest->create($data);
	}
}
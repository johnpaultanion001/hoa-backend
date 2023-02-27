<?php

namespace Api\V1_0_0\Http\Controllers\Admin;

use Api\V1_0_0\Services\Response\ResponseService;
use Api\V1_0_0\Services\Survey\SurveyService;

use Api\V1_0_0\Http\Requests\PaginateRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ResponseController extends Controller
{
    private string $name = "Response";

    private ResponseService $responseService;
    private SurveyService $surveyService;

    public function __construct(ResponseService $responseService, SurveyService $surveyService) {
        $this->responseService = $responseService;
        $this->surveyService = $surveyService;
	}

    public function index(PaginateRequest $request) {
        $data = $request->all();
        $responses = $this->responseService->list($data);
        $survey = $this->surveyService->show($data['survey_id']);

        $result = [
            "responses" => $responses,
            "survey" => $survey,
        ];

		return $this->response(
			$this->name . " Successfully Fetched.",
			$result,
			Response::HTTP_OK
		);
    }
}

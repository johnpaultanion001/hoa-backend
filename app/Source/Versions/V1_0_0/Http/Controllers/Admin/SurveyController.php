<?php

namespace Api\V1_0_0\Http\Controllers\Admin;

use Api\V1_0_0\Http\Requests\PaginateRequest;
use Api\V1_0_0\Services\Survey\SurveyService;
use Api\V1_0_0\Services\Option\OptionService;
use Api\V1_0_0\Services\Question\QuestionService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    private string $name = "Survey";

    private SurveyService $surveyService;
	private OptionService $optionService;
    private QuestionService $questionService;

    public function __construct(SurveyService $surveyService, OptionService $optionService, QuestionService $questionService) {
		$this->surveyService = $surveyService;
		$this->optionService = $optionService;
        $this->questionService = $questionService;
	}

    public function index(PaginateRequest $request) {
		$data = $request->all();
		$response = $this->surveyService->list($data);
		return $this->response(
			$this->name . " Successfully Fetched.",
			$response,
			Response::HTTP_OK
		);
	}
	
	public function show($id) {
        $response = $this->surveyService->show($id);
        return $this->response(
            $this->name . " Successfully Fetched.",
            $response,
            Response::HTTP_OK
        );
    }

	public function store(Request $request) {
		$data = $request->all();

		$survey = $this->surveyService->store($data);
		foreach($data['questions'] as $question) {
			$question_param = [
				'survey_id' => $survey->id,
				'content' => $question['content'],
				'required' => $question['required'],
				'type' => $question['type'],
			];

			$res_question = $this->questionService->store($question_param);
			if(count($question['options']) > 0) {
				foreach($question['options'] as $option) {
					$option_param = [
						'survey_id' => $survey->id,
						'question_id' => $res_question->id,
						'content' => $option['content'],
						'type' => $option['type'],
					];
					$this->optionService->store($option_param);
				}
			}
		}

		$survey = $survey->with(['questions.options'])->get();
		return $this->response(
            $this->name . " Successfully Created.",
            $data,
            Response::HTTP_CREATED
        );
	}

	public function update(Request $request, $id) {
		$data = $request->all();
		$survey = $this->surveyService->update($data, $id);

		$this->questionService->updateSurvey($id);
		$this->optionService->updateSurvey($id);

		foreach($data['questions'] as $question) {
			$question_param = [
				'survey_id' => $survey->id,
				'content' => $question['content'],
				'required' => $question['required'],
				'type' => $question['type'],
			];

			$res_question = $this->questionService->store($question_param);
			if(count($question['options']) > 0) {
				foreach($question['options'] as $option) {
					$option_param = [
						'survey_id' => $survey->id,
						'question_id' => $res_question->id,
						'content' => $option['content'],
						'type' => $option['type'],
					];
					$this->optionService->store($option_param);
				}
			}
		}

        return $this->response(
            $this->name . " Successfully Updated.",
            $data,
            Response::HTTP_OK
        );
	}
}

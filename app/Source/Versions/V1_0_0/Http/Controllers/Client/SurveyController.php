<?php
namespace Api\V1_0_0\Http\Controllers\Client;

use Api\V1_0_0\Services\Survey\SurveyService;
use Api\V1_0_0\Services\Response\ResponseService;

use Api\V1_0_0\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    private string $name = "Survey";

    private SurveyService $surveyService;
	private ResponseService $responseService;

    public function __construct(SurveyService $surveyService, ResponseService $responseService) {
		$this->surveyService = $surveyService;
		$this->responseService = $responseService;
	}

    public function index(Request $request) {
		$data = $request->all();

		$uid = Auth::user()->uid;
        $user = User::where('uid',$uid)->first();

		$surveys = $this->surveyService->display($data);
		$responses =  $this->responseService->list([
			'user_id' => $user->id,
		]);

		$answered_surveys = array();
		$result = array();

		foreach($responses as $response) {
			array_push($answered_surveys, $response->survey_id);
		}

		foreach($surveys as $survey) {
			if(!in_array($survey->id, $answered_surveys)) {
				array_push($result, $survey);
			}
		}

		return $this->response(
			$this->name . " Successfully Fetched.",
			$result,
			Response::HTTP_OK
		);
	}
}

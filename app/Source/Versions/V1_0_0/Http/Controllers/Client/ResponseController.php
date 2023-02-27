<?php
namespace Api\V1_0_0\Http\Controllers\Client;

use Api\V1_0_0\Services\Answer\AnswerService;
use Api\V1_0_0\Services\Response\ResponseService;


use Api\V1_0_0\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Mail;

class ResponseController extends Controller
{
    private string $name = "Response";

    private AnswerService $answerService;
    private ResponseService $responseRequest;

    public function __construct(ResponseService $responseRequest, AnswerService $answerService) {
        $this->responseRequest = $responseRequest;
        $this->answerService = $answerService;
	}

    public function store(Request $request) {
		$data = $request->all();
        $uid = Auth::user()->uid;
        $user = User::where('uid',$uid)->first();

        $response_param = [
            'survey_id' => $data['survey']['id'],
            'user_id' => $user->id,
        ];

        $response = $this->responseRequest->store($response_param);
        for($index = 0; $index < count($data['answers']); $index++) {
            $option_id = 0;
            $answer = "";

            switch($data['survey']['questions'][$index]['type']) {
                case "select":
                case "radio":
                    $option_id = $data['answers'][$index];
                    foreach($data['survey']['questions'][$index]['options'] as $option) {
                        if($option['id'] == $option_id) {
                            $answer = $option['content'];
                        }
                    }
                break;
                case "checkbox":
                    $answer = implode(",", $data['answers'][$index]);
                    $option_id = 0;
                break;
                default:
                    $answer = $data['answers'][$index];
                    $option_id = 0;
            }

            $answer_param = [
                'response_id' => $response->id,
                'survey_id' => $data['survey']['id'],
                'question_id' => $data['survey']['questions'][$index]['id'],
                'option_id' => $option_id,
                'user_id' => $user->id,
                'answer' => $answer,
            ];
            $this->answerService->store($answer_param);
        }

        $response = [
            'response' => $response->with(['answers.question', 'survey'])->get(),
        ];

        Mail::send('v1_0_0.emails.response', $response, function ($m) use ($user) {
            $m->from(config('mail.from.address'), 'Survey Response');
            $m->to($user->email, $user->name)->subject('Survey Response');
        });

		return $this->response(
            $this->name . " Successfully Created.",
            $response,
            Response::HTTP_CREATED
        );
    }
}

<?php

namespace Api\V1_0_0\Http\Controllers;


use Api\V1_0_0\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller {

    /**
     * @var string
     */
    private string $name = "Auth";
    private AuthService $authService;

    public function __construct(AuthService $authService){

        $this->authService = $authService;
    }

    public function authorized(Request $request,$access)
    {
        $data = $request->all();

        $result = $this->authService->authorized($data['allowed']);


        if($result){
            return $this->response(
                $this->name . " Success.",
                ["authorized" => $result],
                Response::HTTP_OK
            );
        }

        return $this->response(
            $this->name . " Failed.",
            ["authorized" => $result],
            Response::HTTP_FORBIDDEN
        );
    }

    public function profile(Request $request){

        $data = $request->all();

        $result = $this->authService->profile();

        return $this->response(
            $this->name . " Successfully Fetched.",
            $result,
            Response::HTTP_OK
        );
    }

}

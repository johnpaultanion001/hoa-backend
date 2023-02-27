<?php

namespace Api\V1_0_0\Http\Controllers\Admin;

use Api\V1_0_0\Http\Requests\Admin\UserRequest;
use Api\V1_0_0\Http\Requests\PaginateRequest;
use Api\V1_0_0\Services\Auth\AuthService;
use Api\V1_0_0\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class UserController extends Controller {

    /**
     * @var string
     */
    private string $name = "User";
    private AuthService $authService;

    /**
     * AccountController constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service, AuthService $authService) {

        $this->service = $service;
        $this->authService = $authService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function index(PaginateRequest $request) {
        $data = $request->all();

        $response = $this->service->list($data);

        return $this->response(
            $this->name . " Successfully Fetched.",
            $response,
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function store(UserRequest $request) {
        $data = $request->all();

        $auth =  $this->authService->updateOrCreate($data);

        $response = $this->service->store(array_merge($data,$auth));

        return $this->response(
            $this->name . " Successfully Created.",
            $response,
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function show($id) {

        $response = $this->service->show($id);

        return $this->response(
            $this->name . " Successfully Fetched.",
            $response,
            Response::HTTP_OK
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function update(UserRequest $request, $id) {
        $data = $request->all();

        $user = (array) $request->user();

        if (!$id) {
            $exist = $this->service->first(["email" => $user['email']]);
            if (!$exist) {
                foreach ($user as $key => $value) {
                    $request->request->set($key, $value);
                }
                return $this->store($request);
            }
            $id = $exist->id;

            $data = array_merge($data, $user);
        }

        $auth =  $this->authService->updateOrCreate($data);

        $response = $this->service->update(array_merge($data,$auth), $id);

        return $this->response(
            $this->name . " Successfully Updated.",
            $response,
            Response::HTTP_OK
        );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function destroy($id) {
        $response = $this->service->first(['id' => $id]);

        $response->delete();

        $this->authService->delete($response->uid);
        return $this->response(
            $this->name . " Successfully Deleted.",
            $response,
            Response::HTTP_OK
        );
    }
}

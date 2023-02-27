<?php

namespace Api\V1_0_0\Http\Controllers\Client;

use Api\V1_0_0\Http\Requests\PaginateRequest;
use Api\V1_0_0\Http\Requests\VisitorLogRequest;
use Api\V1_0_0\Services\User\UserService;
use Api\V1_0_0\Services\VisitorLog\VisitorLogService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class VisitorLogController extends Controller {

	/**
	 * @var string
	 */
	private string $name = "Visitor Log";
    private VisitorLogService $service;
    private UserService $userService;

    /**
     * VisitorLogController constructor.
     * @param VisitorLogService $service
     */
    public function __construct(VisitorLogService $service, UserService $userService) {

		$this->service = $service;

        $this->userService = $userService;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse|Response
	 */
	public function index(PaginateRequest $request) {
		$data = $request->all();
        $data['user_uid'] = $request->user()->uid;
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
	public function store(VisitorLogRequest $request) {
		$data = $request->all();

        $user = $this->userService->first(['uid' => $request->user()->uid]);
        $data['table_id'] = $user['id'];
        $data['table_type'] = "users";

        $response = $this->service->store($data);

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
	public function update(VisitorLogRequest $request, $id) {
		$data = $request->all();

		$response = $this->service->update($data, $id);

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
		$response = $this->service->delete($id);

		return $this->response(
			$this->name . " Successfully Deleted.",
			$response,
			Response::HTTP_OK
		);
	}
}

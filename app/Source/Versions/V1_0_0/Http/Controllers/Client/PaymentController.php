<?php

namespace Api\V1_0_0\Http\Controllers\Client;

use Api\V1_0_0\Http\Requests\PaginateRequest;
use Api\V1_0_0\Services\Service\ServiceService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class PaymentController extends Controller {

	/**
	 * @var string
	 */
	private string $name = "Service";
    private ServiceService $service;

    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse|Response
	 */
	public function test(PaginateRequest $request) {
		$data = $request->all();


        $response = $this->service->list($data);

		return $this->response(
			$this->name . " Successfully Fetched.",
			$response,
			Response::HTTP_OK
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

    public function dateAvailabilities($id,Request $request){
        $response = $this->service->dateAvailabilities($id, $request->all());

        return $this->response(
            $this->name . " Successfully Fetched.",
            $response,
            Response::HTTP_OK
        );
    }


}

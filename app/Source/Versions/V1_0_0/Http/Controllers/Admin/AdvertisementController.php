<?php

namespace Api\V1_0_0\Http\Controllers\Admin;

use Api\V1_0_0\Http\Requests\Admin\AdvertisementRequest;
use Api\V1_0_0\Http\Requests\PaginateRequest;
use Api\V1_0_0\Services\Advertisement\AdvertisementService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class AdvertisementController extends Controller {

	private string $name = "Advertisement";
    /**
     * @var AdvertisementService
     */
    private AdvertisementService $service;

    /**
     * AdvertisementController constructor.
     * @param AdvertisementService $service
     */
    public function __construct(AdvertisementService $service) {

		$this->service = $service;
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
	public function store(AdvertisementRequest $request) {
		$data = $request->all();
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
	public function update(AdvertisementRequest $request, $id) {
		$data = $request->all();

		$response = $this->service->update($data, $id);

		return $this->response(
			$this->name . " Successfully Updated.",
			$response,
			Response::HTTP_OK
		);
	}

    public function destroy($id) {
        $response = $this->service->delete($id);

        return $this->response(
            $this->name . " Successfully Deleted.",
            $response,
            Response::HTTP_OK
        );
    }


}

<?php

namespace Api\V1_0_0\Http\Controllers\Client;

use Api\V1_0_0\Http\Requests\FileRequest;
use Api\V1_0_0\Http\Requests\PaginateRequest;
use Api\V1_0_0\Services\File\FileService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileController extends Controller {

	/**
	 * @var string
	 */
	private string $name = "File";
	/**
	 * @var FileService
	 */
	private FileService $service;

	/**
	 * SampleController constructor.
	 * @param FileService $service
	 */
	public function __construct(FileService $service) {

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
	public function store(FileRequest $request) {
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
	public function update(FileRequest $request, $id) {
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

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function upload(Request $request) {
		$data = $request->all();

		$response = $this->service->upload($data);

		return $this->response(
			$this->name . " Successfully Uploaded.",
			$response,
			Response::HTTP_OK
		);
	}
}

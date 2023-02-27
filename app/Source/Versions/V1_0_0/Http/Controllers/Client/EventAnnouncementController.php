<?php

namespace Api\V1_0_0\Http\Controllers\Client;

use Api\V1_0_0\Http\Requests\PaginateRequest;
use Api\V1_0_0\Services\EventAnnouncement\EventAnnouncementService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class EventAnnouncementController extends Controller {

	/**
	 * @var string
	 */
	private string $name = "Event and Announcement";

    /**
     * EventAnnouncementController constructor.
     * @param EventAnnouncementService $service
     */
    public function __construct(EventAnnouncementService $service) {

		$this->service = $service;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse|Response
	 */
	public function index(PaginateRequest $request) {
		$data = $request->all();

		$response = $this->service->clientList($data);

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



}

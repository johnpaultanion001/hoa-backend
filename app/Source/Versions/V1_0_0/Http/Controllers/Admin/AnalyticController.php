<?php

namespace Api\V1_0_0\Http\Controllers\Admin;

use Api\V1_0_0\Services\Analytic\AnalyticService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnalyticController extends Controller
{
	/**
	 * @var string
	 */
	private string $name = "Analytics";


	public function __construct(AnalyticService $service)
	{
		$this->service = $service;
	}

	public function dashboard(Request $request)
	{
		$data = $request->all();

		$response = $this->service->all($data);
		return $this->response(
			$this->name . " Successfully Fetched.",
			$response,
			Response::HTTP_OK
		);
	}
}

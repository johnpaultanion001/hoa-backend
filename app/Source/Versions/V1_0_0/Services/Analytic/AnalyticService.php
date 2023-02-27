<?php

namespace Api\V1_0_0\Services\Analytic;

use Api\V1_0_0\Models\Booking;
use Api\V1_0_0\Models\Inquiry;
use Api\V1_0_0\Models\VisitorLog;

class AnalyticService
{


	private $booking;
	private $inquiry;
	private $visitorLog;

	public function __construct(Booking $booking, Inquiry $inquiry, VisitorLog $visitorLog)
	{

		$this->booking = $booking;
		$this->inquiry = $inquiry;
		$this->visitorLog = $visitorLog;
	}



	public function all($data)
	{

		$reservation = $this->reservations($data);
		$maintenances = $this->maintenances($data);
		$inquries = $this->inquiries($data);
		$visitors = $this->visitors($data);

		return [
			"reservation" => $reservation,
			"maintenances" => $maintenances,
			"inquiries" => $inquries,
			"visitors" => $visitors
		];
	}
	public function reservations($data)
	{

		$pending = $this->booking
			->whereType(config('constants.booking_types.reservation_booking'))
			->whereStatusId(1);

		$approved = $this->booking
			->whereType(config('constants.booking_types.reservation_booking'))
			->whereStatusId(2);

		$declined = $this->booking
			->whereType(config('constants.booking_types.reservation_booking'))
			->whereStatusId(3);

		if (!empty($data['data_from']) && !empty($data['data_to'])) {

			$pending = $pending->whereHas('bookingDetails', function ($query) use ($data) {
				$query = $query->whereBetween('date', [$data['data_from'], $data['data_to']]);
			});

			$declined = $pending->whereHas('bookingDetails', function ($query) use ($data) {
				$query = $query->whereBetween('date', [$data['data_from'], $data['data_to']]);
			});

			$approved = $this->booking
				= $pending->whereHas('bookingDetails', function ($query) use ($data) {
					$query = $query->whereBetween('date', [$data['data_from'], $data['data_to']]);
				});
		}
        if (!empty($data['company_id'])) {
            $pending = $pending->where('company_id', $data['company_id']);

            $approved = $approved->where('company_id', $data['company_id']);

            $declined = $declined->where('company_id', $data['company_id']);
        }

		$pending = $pending->count();
		$declined = $declined->count();
		$approved = $approved->count();


		return [
			"pending" => $pending,
			"declined" => $declined,
			"approved" => $approved
		];
	}


	public function maintenances($data)
	{

		$pending = $this->booking
			->whereType(config('constants.booking_types.maintenance_service'))
			->whereStatusId(1);

		$approved = $this->booking
			->whereType(config('constants.booking_types.maintenance_service'))
			->whereStatusId(2);

		$declined = $this->booking
			->whereType(config('constants.booking_types.maintenance_service'))
			->whereStatusId(3);

		if (!empty($data['data_from']) && !empty($data['data_to'])) {

			$pending = $pending->whereHas('bookingDetails', function ($query) use ($data) {
				$query = $query->whereBetween('date', [$data['data_from'], $data['data_to']]);
			});

			$declined = $pending->whereHas('bookingDetails', function ($query) use ($data) {
				$query = $query->whereBetween('date', [$data['data_from'], $data['data_to']]);
			});

			$approved = $this->booking
				= $pending->whereHas('bookingDetails', function ($query) use ($data) {
					$query = $query->whereBetween('date', [$data['data_from'], $data['data_to']]);
				});
		}


		if (!empty($data['company_id'])) {
			$approved = $approved->whereCompanyId($data['company_id']);
			$declined = $declined->whereCompanyId($data['company_id']);
			$pending = $pending->whereCompanyId($data['company_id']);
		}

		$pending = $pending->count();
		$declined = $declined->count();
		$approved = $approved->count();


		return [
			"pending" => $pending,
			"declined" => $declined,
			"approved" => $approved
		];
	}


	public function inquiries($data)
	{

		$resolved = $this->inquiry
			->whereStatus(1);


		$pending = $this->inquiry
			->whereStatus(0);

		if (!empty($data['data_from']) && !empty($data['data_to'])) {

			$resolved = $resolved->whereBeetween('created_at', [$data['data_from'], $data['data_to']]);
			$pending = $pending->whereBeetween('created_at', [$data['data_from'], $data['data_to']]);
		}



		if (!empty($data['company_id'])) {
			$resolved = $resolved->whereCompanyId($data['company_id']);
			$pending = $pending->whereCompanyId($data['company_id']);
		}


		$resolved = $resolved->count();
		$pending = $pending->count();


		return [
			"resolved" => $resolved,
			"pending" => $pending,
		];
	}


	public function visitors($data)
	{
		$total = $this->visitorLog;

		if (!empty($data['company_id'])) {
			$total = $total->whereCompanyId($data['company_id']);
		}


		if (!empty($data['data_from']) && !empty($data['data_to'])) {

			$total = $total->whereBeetween('date', [$data['data_from'], $data['data_to']]);
		}



		$total = $total->count();

		return [
			"total" => $total,
		];
	}
}

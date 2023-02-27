<?php

namespace Api\V1_0_0\Services\Booking;


use Api\V1_0_0\Models\Booking;
use Api\V1_0_0\Repositories\Rest\RestRepository;

class BookingService
{

	/**
	 * @var RestRepository
	 */
	private RestRepository $rest;

	public function __construct(Booking $model)
	{

		$this->rest = new RestRepository($model);
	}

	/**
	 * @param array $data
	 * @return array|null
	 */
	public function store(array $data)
	{
		$result = $this->rest->getModel()
			->create($data);

		foreach ($data['booking_details'] as $key => $value) {
			foreach ($value['time'] as $t) {
				$result->bookingDetails()->create(array_merge($value, $t));
			}
		}

		return $result;
	}

	/**
	 * @param int $id
	 * @param array $data
	 * @return array
	 */
	public function update(array $data, int $id)
	{

		if ($response = $this->rest->getModel()->find($id)) {



			$response->fill($data)->save();

			if (!empty($data['update_booking_details'])) {
				$response->bookingDetails()->delete();
				foreach ($data['booking_details'] as $key => $value) {
					foreach ($value['time'] as $t) {
						$response->bookingDetails()->create(array_merge($value, $t));
					}
				}
			}



			return $this->show($id);
		}
	}

	/**
	 * @param int $id
	 * @return array
	 */
	public function show(int $id)
	{
		return $this->rest->getModel()->with(['bookingDetails'])->find($id);
	}


	/**
	 * @param int $id
	 * @return array
	 */
	public function delete(int $id)
	{

		return $this->rest->delete($id);
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function list(array $data)
	{

		$result = $this->rest->getModel()
			->with(['status', 'service', 'user', 'bookingDetails' => function ($query) {
				$query->orderBy('date', 'ASC');
				$query->orderBy('time_to', 'ASC');
			}]);

		if (!empty($data['type'])) {
			$result = $result->whereType($data['type']);
		}

		if (!empty($data['service_id'])) {
			$result = $result->whereServiceId($data['service_id']);
		}

		if (!empty($data['date'])) {
			$result = $result->whereHas('bookingDetails', function ($query) use ($data) {
				$query->where('date', $data['date']);
			});
		}


		if (!empty($data['request'])) {

			$result = $result->whereNotNull('user_id');
		}

		if (!empty($data['manual'])) {

			$result = $result->whereNull('user_id');
		}

		if (!empty($data['company_id'])) {
			$result = $result->whereCompanyId($data['company_id']);
		}

        if (!empty($data['manual_name'])) {
            $result = $result->where('personal_details->first_name','LIKE', '%'.$data['manual_name'].'%')
                ->orWhere('personal_details->last_name','LIKE', '%'.$data['manual_name'].'%');
        }

        if (!empty($data['user_name'])) {
            $result = $result->whereHas('user',function ($query) use ($data){
               $query->where('name','LIKE', '%'.$data['user_name'].'%');
            });
        }

		if ($data['paginate']) {
			return $result->paginate($data['per_page']);
		}
		return $result->get();
	}
}

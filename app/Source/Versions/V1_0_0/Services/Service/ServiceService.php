<?php

namespace Api\V1_0_0\Services\Service;


use Api\V1_0_0\Models\Service;
use Api\V1_0_0\Repositories\Rest\RestRepository;
use DateInterval;
use DatePeriod;
use DateTime;

class ServiceService
{

    /**
     * @var RestRepository
     */
    private RestRepository $rest;

    public function __construct(Service $model)
    {

        $this->rest = new RestRepository($model);
    }

    /**
     * @param array $data
     * @return array|null
     */
    public function store(array $data)
    {


        return $this->rest->create($data);
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

            return $this->show($id);
        }
    }

    /**
     * @param int $id
     * @return array
     */
    public function show(int $id)
    {
        return $this->rest->getModel()
            ->with(['fileCover'])
            ->find($id);
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
            ->with(['fileCover', 'company']);

        if (!empty($data['type'])) {
            $result = $result->whereType($data['type']);
        }


        if (!empty($data['company_id'])) {
            $result = $result->whereCompanyId($data['company_id']);
        }

        if (!empty($data['name'])) {
            $result = $result->where('name','LIKE', '%'.$data['name'].'%');
        }
        if ($data['paginate']) {
            return $result->paginate($data['per_page']);
        }

        return $result->get();
    }

    public function dateAvailabilities($id, $data = [])
    {


        $service = $this->rest->getModel()
            ->with(['bookings', 'bookingDetails'])
            ->whereId($id)
            ->first();




        if ($service->availability == "date") {
            foreach ($this->getDates($service->metadata['date']['startDate'], $service->metadata['date']['endDate']) as $key => $value) {
                $inputs = [
                    "time_slots" => [],
                    "date"       => $value,
                    "name"       => $service->name,
                ];
                foreach ($service->metadata['time_slots'] as $key => $s) {

                    $count =  $service->bookingDetails()
                        ->where('booking_details.time_from', '=', $s['from'])
                        ->where('booking_details.time_to', '=', $s['to'])
                        ->where('booking_details.date', '=', $value)
                        ->count();

                    $s['available'] = $service->metadata['slot'] > $count;

                    $inputs['time_slots'][] = $s;
                }

                $isDateAvailable = collect($inputs['time_slots'])->where('available', true)->count();
                $inputs['available'] =  $isDateAvailable > 0 ? true : false;

                $result[] = $inputs;
            }
        } else if ($service->availability == "days") {

            foreach ($service->metadata['days'] as $key => $value) {

                foreach ($this->getDays($data['year'], $data['month'], config('constants.days.' . $value)) as $v) {
                    $inputs = [
                        "time_slots" => [],
                        "date"       => $v->format("Y-m-d"),
                        "name"       => $service->name,
                    ];

                    foreach ($service->metadata['time_slots'] as $s) {

                        $count =  $service->bookingDetails()
                            ->where('booking_details.time_from', '=', $s['from'])
                            ->where('booking_details.time_to', '=', $s['to'])
                            ->where('booking_details.date', '=', $v->format("Y-m-d"))
                            ->count();

                        $s['available'] = $service->metadata['slot'] > $count;


                        $inputs['time_slots'][] = $s;
                    }

                    $isDateAvailable = collect($inputs['time_slots'])->where('available', "=", true)->count();
                    $inputs['available'] = $isDateAvailable > 0 ? true : false;

                    $result[] = $inputs;
                }
            }
        }

        return $result;
    }

    function getDays($y, $m, $d)
    {
        return new DatePeriod(
            new DateTime("first " . $d . " of $y-$m"),
            DateInterval::createFromDateString('next ' . $d),
            new DateTime("last day of $y-$m")
        );
    }
    function getDates($first, $last, $step = '+1 day', $format = 'Y-m-d')
    {
        $dates = [];
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }
}

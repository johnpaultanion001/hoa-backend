<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('statuses')->truncate();;
        $inputs = [
            ["name" => "Pending", "type" => "reservation_booking"],
            ["name" => "Approved", "type" => "reservation_booking"],
            ["name" => "Declined", "type" => "reservation_booking"],
            ["name" => "Pending", "type" => "maintenance_service"],
            ["name" => "Approved", "type" => "maintenance_service"],
            ["name" => "Declined", "type" => "maintenance_service"],
            ["name" => "Pending", "type" => "visitor_log"],
            ["name" => "Approved", "type" => "visitor_log"],

        ];
        DB::table('statuses')->insert($inputs);;
    }
}

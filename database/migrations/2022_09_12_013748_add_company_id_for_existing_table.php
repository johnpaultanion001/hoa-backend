<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdForExistingTable extends Migration
{

    private $tb = [
        "bookings",
        "documents",
        "event_announcements",
        "services",
        "visitor_logs",
        "user_details"
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        foreach ($this->tb as $value) {

            Schema::table($value, function (Blueprint $table) {
                $table->integer('company_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        foreach ($this->tb as $value) {

            Schema::table($value, function (Blueprint $table) {
                $table->dropColumn('company_id');
            });
        }
    }
}

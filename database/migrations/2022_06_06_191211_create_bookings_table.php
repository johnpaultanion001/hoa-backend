<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('status_id');
            $table->integer('user_id')->nullable();
            $table->integer('service_id')->nullable();
            $table->date('date')->nullable();
            $table->time('time_from')->nbullable();
            $table->time('time_to')->nbullable();
            $table->string('type');
            $table->json('contact_details')->nullable();
            $table->json('address_details')->nullable();
            $table->json('personal_details')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}

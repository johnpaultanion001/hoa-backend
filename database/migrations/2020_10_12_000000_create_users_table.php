<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = "MyISAM";
            $table->id();
            $table->string('name')->nullable();
            $table->string('uid')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('photo_url')->nullable();
            $table->boolean('disabled')->default(0);
            $table->boolean('email_verified')->default(0);
            $table->dateTime('last_login_at')->nullable();
            $table->enum('role', ['client', 'admin', 'super_admin', 'staff']);
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
        Schema::dropIfExists('users');
    }
}

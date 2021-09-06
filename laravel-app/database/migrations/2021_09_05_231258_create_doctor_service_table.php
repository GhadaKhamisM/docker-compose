<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_service', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('doctor_id')->unsigned()->index();
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->bigInteger('service_id')->unsigned()->index();
            $table->foreign('service_id')->references('id')->on('services');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_service');
    }
}

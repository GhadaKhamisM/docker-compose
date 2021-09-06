<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorWeekDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_week_days', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('doctor_id')->unsigned()->index();
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->bigInteger('week_day_id')->unsigned()->index();
            $table->foreign('week_day_id')->references('id')->on('week_days');
            $table->time('start_hour')->nullable();
            $table->time('to_hour')->nullable();
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
        Schema::dropIfExists('doctor_week_days');
    }
}

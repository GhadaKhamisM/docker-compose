<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeSlotToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->time('start_hour')->nullable()->after('visit_date');
            $table->time('to_hour')->nullable()->after('start_hour');
            $table->integer('time_slot')->unsigned()->after('to_hour');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('start_hour');
            $table->dropColumn('to_hour');
            $table->dropColumn('time_slot');
        });
    }
}

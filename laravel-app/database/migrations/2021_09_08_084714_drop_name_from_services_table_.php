<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropNameFromServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropCOlumn('name_arabic');
            $table->dropCOlumn('name_english');
            $table->dropCOlumn('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('name_arabic',150)->after('id');
            $table->string('name_english',150)->after('name_arabic');
            $table->string('description',300)->nullable()->after('name_english');
        });
    }
}

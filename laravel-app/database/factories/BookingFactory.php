<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Booking;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Booking::class, function (Faker $faker) {
    return [
        'status_id' => config('statuses.pending'),
        'visit_date' => Carbon::now()->format('Y-m-d'),
        'patient_id' => null,
        'doctor_id' => null,
        'doctor_week_day_id' => null,
    ];
});

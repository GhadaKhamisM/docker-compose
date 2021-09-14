<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Booking;
use App\Models\Patient;
use App\Models\Doctor;
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
    $doctor = factory(Doctor::class)->state('doctorWeekDays')->create();
    $patient = factory(Patient::class)->create();
    $doctorWeekDay = $doctor->doctorWeekDays()->first();
    
    return [
        'status_id' => config('statuses.pending'),
        'visit_date' => Carbon::now()->format('Y-m-d'),
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'start_hour' => $doctorWeekDay->start_hour,
        'to_hour' => Carbon::now()->addMinutes($doctor->time_slot)->format('H:i'), 
        'time_slot' => $doctor->time_slot,
        'doctor_week_day_id' => $doctorWeekDay->id,
    ];
});

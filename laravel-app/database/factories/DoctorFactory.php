<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Doctor;
use App\Models\DoctorWeekDay;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Doctor::class, function (Faker $faker) {
    return [
        'name_arabic' => $faker->name(),
        'name_english' => $faker->name(),
        'mobile' => $faker->numerify('###########'),
        'password' => 'secret', // password,
        'photo' => $faker->image(),
        'time_slot' => $faker->numberBetween(0, 60),
        'email' => $faker->email(),
    ];
})->state(Doctor::class, 'doctorWeekDays', [])
->afterCreatingState(Doctor::class, 'doctorWeekDays', function ($doctor, $faker) {
    $doctorWeekDays = factory(DoctorWeekDay::class, 2)->make();
    $doctor->doctorWeekDays()->saveMany($doctorWeekDays);
});

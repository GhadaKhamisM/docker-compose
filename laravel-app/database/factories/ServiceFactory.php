<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Service;
use App\Models\ServiceTranslation;
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

$factory->define(Service::class, function (Faker $faker) {
    return array();
})->state(Service::class, 'serviceTranslations', [])
->afterCreatingState(Service::class, 'serviceTranslations', function ($service, $faker) {
    $serviceTranslations = factory(ServiceTranslation::class, 1)->make();
    $service->serviceTranslations()->saveMany($serviceTranslations);
});

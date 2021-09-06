<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use Faker\Factory as Faker;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPatientRegister()
    {
        $faker = Faker::create();
        var_dump($faker->name(), $faker->numerify());
        $response = $this->post(route('auth.patient-register'), [
            'name' => $faker->name(),
            'mobile' => $faker->numerify('###########'),
            'password' => $faker->password()
        ]);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}

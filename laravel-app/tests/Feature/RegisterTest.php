<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use Faker\Factory as Faker;
use App\Models\Patient;
use Hash;

class RegisterTest extends TestCase
{

     /**
     * A patien register faild test without body.
     *
     * @return void
     */
    public function testPatientRegisterWithoutBody()
    {
        $body = array();
        $response = $this->json('POST',route('auth.patient-register'), $body);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A patien register faild test without name.
     *
     * @return void
     */
    public function testPatientRegisterWithoutName()
    {
        $faker = Faker::create();
        $body = array('mobile' => $faker->numerify('###########'),
            'password' => $faker->password());
        $response = $this->json('POST',route('auth.patient-register'), $body);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A patien register faild test without password.
     *
     * @return void
     */
    public function testPatientRegisterWithoutPassword()
    {
        $faker = Faker::create();
        $body = array('name' => $faker->name(),
            'mobile' => $faker->numerify('###########'));
        $response = $this->json('POST',route('auth.patient-register'), $body);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A patien register faild test without mobile.
     *
     * @return void
     */
    public function testPatientRegisterWithoutMobile()
    {
        $faker = Faker::create();
        $body = array('name' => $faker->name(),
            'password' => $faker->password());
        $response = $this->json('POST',route('auth.patient-register'), $body);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A patien register faild test with duplicate mobile and name.
     *
     * @return void
     */
    public function testPatientRegisterWithDuplicateData()
    {
        $patient = factory(Patient::class)->create();
        $body = array('name' => $patient->name,
            'mobile' => $patient->mobile,
            'password' => $patient->password);
        $response = $this->json('POST',route('auth.patient-register'), $body);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $patient->forceDelete();
    }

    /**
     * A patien register success test.
     *
     * @return void
     */
    public function testPatientSuccessRegister()
    {
        $faker = Faker::create();
        $body = array('name' => $faker->name(),
            'mobile' => $faker->numerify('###########'),
            'password' => $faker->password());
        $response = $this->json('POST',route('auth.patient-register'), $body);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        Patient::where('mobile',$body['mobile'])->where('name',$body['name'])->forceDelete();
    }
}

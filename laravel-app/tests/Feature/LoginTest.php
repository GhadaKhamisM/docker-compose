<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use Faker\Factory as Faker;
use App\Models\Patient;
use App\Models\Doctor;

class LoginTest extends TestCase
{
    /**
     * A admin login faild test without body.
     *
     * @return void
     */
    public function testAdminFaildLoginWithoutBody()
    {
        $body = array(); 
        $response = $this->json('POST',route('auth.admin-login'), $body);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A admin login faild test with Invalid data.
     *
     * @return void
     */
    public function testAdminFaildLoginWithInvalidData()
    {
        $faker = Faker::create();
        $body = array('username' => $faker->email(),
            'password' => $faker->password()); 
        $response = $this->json('POST',route('auth.admin-login'), $body);

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * A admin login faild test without password.
     *
     * @return void
     */
    public function testAdminFaildLoginWithoutPassword()
    {
        $body = array('username' => config('admin.SUPPER_ADMIN_USERNAME'),); 
        $response = $this->json('POST',route('auth.admin-login'), $body);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A admin login success test.
     *
     * @return void
     */
    public function testAdminSuccessLogin()
    {
        $body = array('username' => config('admin.SUPPER_ADMIN_USERNAME'),
            'password' => config('admin.SUPPER_ADMIN_PASSWORD')); 
        $response = $this->json('POST',route('auth.admin-login'), $body);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * A patient login faild test without body.
     *
     * @return void
     */
    public function testPatientFaildLoginWithoutBody()
    {
        $body = array(); 
        $response = $this->json('POST',route('auth.patient-login'), $body);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A patient login faild test with Invalid data.
     *
     * @return void
     */
    public function testPatientFaildLoginWithInvalidData()
    {
        $faker = Faker::create();
        $body = array('mobile' => $faker->numerify('###########'),
            'password' => $faker->password()); 
        $response = $this->json('POST',route('auth.patient-login'), $body);

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * A patient login faild test without password.
     *
     * @return void
     */
    public function testPatientFaildLoginWithoutPassword()
    {
        $faker = Faker::create();
        $body = array('mobile' => $faker->numerify('###########'),); 
        $response = $this->json('POST',route('auth.patient-login'), $body);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A patient login success test.
     *
     * @return void
     */
    public function testPatientSuccessLogin()
    {
        $patient = factory(Patient::class)->create();
        $body = array('mobile' => $patient->mobile,
            'password' => 'secret'); 
        $response = $this->json('POST',route('auth.patient-login'), $body);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $patient->forceDelete();
    }

    /**
     * A doctor login faild test without body.
     *
     * @return void
     */
    public function testDoctorFaildLoginWithoutBody()
    {
        $body = array(); 
        $response = $this->json('POST',route('auth.doctor-login'), $body);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A doctor login faild test with Invalid data.
     *
     * @return void
     */
    public function testDoctorFaildLoginWithInvalidData()
    {
        $faker = Faker::create();
        $body = array('mobile' => $faker->numerify('###########'),
            'password' => $faker->password()); 
        $response = $this->json('POST',route('auth.doctor-login'), $body);

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * A doctor login faild test without password.
     *
     * @return void
     */
    public function testDoctorFaildLoginWithoutPassword()
    {
        $faker = Faker::create();
        $body = array('mobile' => $faker->numerify('###########'),); 
        $response = $this->json('POST',route('auth.admin-login'), $body);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A doctor login success test.
     *
     * @return void
     */
    public function testDoctorSuccessLogin()
    {
        $doctor = factory(Doctor::class)->state('doctorWeekDays')->create();
        $body = array('mobile' => $doctor->mobile,
            'password' => 'secret'); 
        $response = $this->json('POST',route('auth.doctor-login'), $body);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}

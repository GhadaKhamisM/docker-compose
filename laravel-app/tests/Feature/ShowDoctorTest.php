<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Doctor;
use App\Models\DoctorWeekDay;
use App\Models\Admin;
use App\Models\DoctorTranslation;
use Faker\Factory as Faker;
use App;

class ShowDoctorTest extends TestCase
{
    /**
     * Show doctor test without authenticate.
     *
     * @return void
     */
    public function testShowDoctorWithoutAuthentication()
    {
        $doctor = factory(Doctor::class)->create();
        $doctorWeekDay = factory(DoctorWeekDay::class)->make();
        $doctor->doctorWeekDays()->save($doctorWeekDay);
        $response = $this->json('GET',route('admin.doctors.show', ['doctor' => $doctor->id]),array(),array('Authorization' => ''));
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $doctor->doctorWeekDays()->forceDelete();
        $doctor->forceDelete();
    }

    /**
     * A Show doctor test example not found.
     *
     * @return void
     */
    public function testShowDoctorNotExist()
    {
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $token = JWTAuth::fromUser($admin);       
        $response = $this->json('GET',route('admin.doctors.show',['doctor' => 0]), array(),array('Authorization' => 'Bearer'. $token));
        
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * A Show doctor test success.
     *
     * @return void
     */
    public function testShowDoctorSuccess()
    {
        $doctor = factory(Doctor::class)->create();
        $doctorWeekDay = factory(DoctorWeekDay::class)->make();
        $doctor->doctorWeekDays()->save($doctorWeekDay);
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $token = JWTAuth::fromUser($admin);       
        $response = $this->json('GET',route('admin.doctors.show',['doctor' => $doctor->id]), array(),array('Authorization' => 'Bearer'. $token));
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $doctor->doctorWeekDays()->forceDelete();
        $doctor->forceDelete();
    }
}

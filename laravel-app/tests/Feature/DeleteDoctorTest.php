<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Doctor;
use App\Models\Admin;
use App\Models\DoctorWeekDay;
use Faker\Factory as Faker;
use App;

class DeleteDoctorTest extends TestCase
{
    /**
     * Delte docotr test without authenticate.
     *
     * @return void
     */
    public function testDeleteDoctorWithoutAuthentication()
    {
        $doctor = factory(Doctor::class)->create();
        $doctorWeekDay = factory(DoctorWeekDay::class)->make();
        $doctor->doctorWeekDays()->save($doctorWeekDay);
        $response = $this->json('DELETE',route('admin.doctors.destroy', ['doctor' => $doctor->id]),array(),array('Authorization' => ''));
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $doctor->doctorWeekDays()->forceDelete();
        $doctor->forceDelete();
    }

    /**
     * A DELETE docotr test example not found.
     *
     * @return void
     */
    public function testDeleteDoctorNotExist()
    {
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $token = JWTAuth::fromUser($admin);       
        $response = $this->json('DELETE',route('admin.doctors.destroy',['doctor' => 0]), array(),array('Authorization' => 'Bearer'. $token));
        
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * A Delete docotr test success.
     *
     * @return void
     */
    public function testDeleteDoctorSuccess()
    {
        $doctor = factory(Doctor::class)->create();
        $doctorWeekDay = factory(DoctorWeekDay::class)->make();
        $doctor->doctorWeekDays()->save($doctorWeekDay);
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $token = JWTAuth::fromUser($admin);       
        $response = $this->json('DELETE',route('admin.doctors.destroy',['doctor' => $doctor->id]), array(),array('Authorization' => 'Bearer'. $token));
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $doctor->doctorWeekDays()->forceDelete();
        $doctor->forceDelete();
    }
}

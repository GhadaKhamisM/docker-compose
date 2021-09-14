<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\Doctor;
use App\Models\Admin;
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
        $doctor = factory(Doctor::class)->state('doctorWeekDays')->create();
        $response = $this->json('GET',route('admin.doctors.show', ['doctor' => $doctor->id]),array());
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * A Show doctor test example not found.
     *
     * @return void
     */
    public function testShowDoctorNotExist()
    {
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('GET',route('admin.doctors.show',['doctor' => 0]), array());
        
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * A Show doctor test success.
     *
     * @return void
     */
    public function testShowDoctorSuccess()
    {
        $doctor = factory(Doctor::class)->state('doctorWeekDays')->create();
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('GET',route('admin.doctors.show',['doctor' => $doctor->id]), array());
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $response->assertJsonStructure(['data' => ['id', 'name_arabic', 'name_english',
            'mobile', 'time_slot', 'photo', 'email', 'rating', 'services', 'week_days']]);
    }
}

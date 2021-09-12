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

class DeleteDoctorTest extends TestCase
{
    /**
     * Delete doctor test without authenticate.
     *
     * @return void
     */
    public function testDeleteDoctorWithoutAuthentication()
    {
        $doctor = factory(Doctor::class)->state('doctorWeekDays')->create();
        $response = $this->json('DELETE',route('admin.doctors.destroy', ['doctor' => $doctor->id]),array());
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * A DELETE doctor test example not found.
     *
     * @return void
     */
    public function testDeleteDoctorNotExist()
    {
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('DELETE',route('admin.doctors.destroy',['doctor' => 0]), array());
        
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * A Delete doctor test success.
     *
     * @return void
     */
    public function testDeleteDoctorSuccess()
    {
        $doctor = factory(Doctor::class)->state('doctorWeekDays')->create();
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('DELETE',route('admin.doctors.destroy',['doctor' => $doctor->id]), array());
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}

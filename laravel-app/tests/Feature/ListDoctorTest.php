<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\Admin;
use Faker\Factory as Faker;
use App;

class ListDoctorTest extends TestCase
{
    /**
     * LIst doctors test without authenticate.
     *
     * @return void
     */
    public function testListDoctorsWithoutAuthentication()
    {
        $response = $this->json('GET',route('admin.doctors.index'),array(),array('Authorization' => ''));
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * A List doctors test success.
     *
     * @return void
     */
    public function testListDoctorsSuccess()
    {
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('GET',route('admin.doctors.index'), array());
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $response->assertJsonStructure(['data' => ['*' => ['id', 'name_arabic', 'name_english',
            'mobile', 'time_slot', 'photo', 'email', 'rating', 'services', 'week_days']]]);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Doctor;
use App\Models\Admin;
use App\Models\DoctorTranslation;
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
        $token = JWTAuth::fromUser($admin);       
        $response = $this->json('GET',route('admin.doctors.index'), array(),array('Authorization' => 'Bearer'. $token));
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Service;
use App\Models\Admin;
use App\Models\ServiceTranslation;
use Faker\Factory as Faker;
use App;

class ListServiceTest extends TestCase
{
    /**
     * LIst services test without authenticate.
     *
     * @return void
     */
    public function testListServicesWithoutAuthentication()
    {
        $response = $this->json('GET',route('admin.services.index'),array(),array('Authorization' => ''));
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * A List services test success.
     *
     * @return void
     */
    public function testListServicesSuccess()
    {
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $token = JWTAuth::fromUser($admin);       
        $response = $this->json('GET',route('admin.services.index'), array(),array('Authorization' => 'Bearer'. $token));
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}

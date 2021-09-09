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

class DeleteServiceTest extends TestCase
{
    /**
     * Delete service test without authenticate.
     *
     * @return void
     */
    public function testDeleteServiceWithoutAuthentication()
    {
        $service = factory(Service::class)->create();
        $serviceTranslation = factory(ServiceTranslation::class)->make();
        $service->serviceTranslations()->save($serviceTranslation);
        $response = $this->json('DELETE',route('admin.services.destroy', ['service' => $service->id]),array(),array('Authorization' => ''));
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $service->serviceTranslations()->forceDelete();
        $service->forceDelete();
    }

    /**
     * A DELETE service test example not found.
     *
     * @return void
     */
    public function testDeleteServiceNotExist()
    {
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $token = JWTAuth::fromUser($admin);       
        $response = $this->json('DELETE',route('admin.services.destroy',['service' => 0]), array(),array('Authorization' => 'Bearer'. $token));
        
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * A Delete service test success.
     *
     * @return void
     */
    public function testDeleteServiceSuccess()
    {
        $service = factory(Service::class)->create();
        $serviceTranslation = factory(ServiceTranslation::class)->make();
        $service->serviceTranslations()->save($serviceTranslation);
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $token = JWTAuth::fromUser($admin);       
        $response = $this->json('DELETE',route('admin.services.destroy',['service' => $service->id]), array(),array('Authorization' => 'Bearer'. $token));
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $service->serviceTranslations()->forceDelete();
        $service->forceDelete();
    }
}

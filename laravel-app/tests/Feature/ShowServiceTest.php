<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\Service;
use App\Models\Admin;
use Faker\Factory as Faker;
use App;

class ShowServiceTest extends TestCase
{
    /**
     * Show service test without authenticate.
     *
     * @return void
     */
    public function testShowServiceWithoutAuthentication()
    {
        $service = factory(Service::class)->state('serviceTranslations')->create();
        $response = $this->json('GET',route('admin.services.show', ['service' => $service->id]),array());
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * A Show service test example not found.
     *
     * @return void
     */
    public function testShowServiceNotExist()
    {
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('GET',route('admin.services.show',['service' => 0]), array());
        
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * A Show service test success.
     *
     * @return void
     */
    public function testShowServiceSuccess()
    {
        $service = factory(Service::class)->state('serviceTranslations')->create();
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('GET',route('admin.services.show',['service' => $service->id]), array());
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}

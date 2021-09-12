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

class DeleteServiceTest extends TestCase
{
    /**
     * Delete service test without authenticate.
     *
     * @return void
     */
    public function testDeleteServiceWithoutAuthentication()
    {
        $service = factory(Service::class)->state('serviceTranslations')->create();
        $response = $this->json('DELETE',route('admin.services.destroy', ['service' => $service->id]),array());
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * A DELETE service test example not found.
     *
     * @return void
     */
    public function testDeleteServiceNotExist()
    {
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('DELETE',route('admin.services.destroy',['service' => 0]), array());
        
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    /**
     * A Delete service test success.
     *
     * @return void
     */
    public function testDeleteServiceSuccess()
    {
        $service = factory(Service::class)->state('serviceTranslations')->create();
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('DELETE',route('admin.services.destroy',['service' => $service->id]), array());
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}

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

class UpdateServiceTest extends TestCase
{
    /**
     * Update service test without authenticate.
     *
     * @return void
     */
    public function testUpdateServiceWithoutAuthentication()
    {
        $service = factory(Service::class)->state('serviceTranslations')->create();
        $body = array('service_translations' => array(array(
            'name' => $service->serviceTranslations()->first()->name,
            'description' => $service->serviceTranslations()->first()->description,
            'locale' => $service->serviceTranslations()->first()->locale
        )));
        $response = $this->put(route('admin.services.update', ['service' => $service->id]), $body);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * A update service test example without body.
     *
     * @return void
     */
    public function testUpdateServiceWithoutBody()
    {
        $body = array();
        $service = factory(Service::class)->state('serviceTranslations')->create();
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('PUT',route('admin.services.update',['service' => $service->id]), $body);
        
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A update service test success.
     *
     * @return void
     */
    public function testUpdateServiceSuccess()
    {
        $faker = Faker::create();
        $service = factory(Service::class)->state('serviceTranslations')->create();
        $body = array('service_translations' => array(array(
            'name' => $faker->name(),
            'description' => $faker->text(),
            'locale' => App::getlocale()
        )));
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('PUT',route('admin.services.update',['service' => $service->id]), $body);
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}

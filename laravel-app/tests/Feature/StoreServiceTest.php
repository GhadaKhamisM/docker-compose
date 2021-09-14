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

class StoreServiceTest extends TestCase
{
    /**
     * Create service test without authenticate.
     *
     * @return void
     */
    public function testStoreServiceWithoutAuthentication()
    {
        $faker = Faker::create();
        $body = array('service_translations' => array(array(
            'name' => $faker->name(),
            'description' => $faker->text(),
            'locale' => App::getlocale()
        )));
        $response = $this->json('POST',route('admin.services.store'), $body);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * A create service test example without body.
     *
     * @return void
     */
    public function testStoreServiceWithoutBody()
    {
        $body = array(); 
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('POST',route('admin.services.store'), $body);
        
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A create service test duplicate name.
     *
     * @return void
     */
    public function testStoreServiceWithDuplicateName()
    {
        $service = factory(Service::class)->state('serviceTranslations')->create();
        $body = array('service_translations' => array(array(
            'name' => $service->serviceTranslations()->first()->name,
            'description' => $service->serviceTranslations()->first()->description,
            'locale' => $service->serviceTranslations()->first()->locale
        )));
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();

        $response = $this->actingAs($admin,'admin')->json('POST',route('admin.services.store'), $body);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A create service test success.
     *
     * @return void
     */
    public function testSuccessStoreService()
    {
        $faker = Faker::create();
        $body = array('service_translations' => array(array(
            'name' => $faker->name(),
            'description' => $faker->text(),
            'locale' => App::getlocale()
        )));
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('POST',route('admin.services.store'), $body);
        
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertDatabaseHas('service_translations', ['name' => $body['service_translations'][0]['name']]);
    }
}

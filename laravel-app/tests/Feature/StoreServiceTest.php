<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Service;
use App\Models\Admin;
use Faker\Factory as Faker;

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
        $body = array('name_arabic' => $faker->name(),
            'name_english' => $faker->name(),
            'description' => $faker->text()); 
        $response = $this->json('POST',route('admin.services.store'), $body,array('Authorization' => ''));
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
        $token = JWTAuth::fromUser($admin);       
        $response = $this->json('POST',route('admin.services.store'), $body,array('Authorization' => 'Bearer'. $token));
        
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A create service test duplicate name.
     *
     * @return void
     */
    public function testStoreServiceWithDuplicateName()
    {
        $service = factory(Service::class)->create();
        $body = array('name_arabic' => $service->name_arabic,
            'name_english' => $service->name_english,
            'description' => $service->description);
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $token = JWTAuth::fromUser($admin);     

        $response = $this->json('POST',route('admin.services.store'), $body,array('Authorization' => 'Bearer'. $token));
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
        $body = array('name_arabic' => $faker->name(),
            'name_english' => $faker->name(),
            'description' => $faker->text()); 
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $token = JWTAuth::fromUser($admin);       
        $response = $this->json('POST',route('admin.services.store'), $body,array('Authorization' => 'Bearer'. $token));
        
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\Doctor;
use App\Models\Admin;
use App\Models\DoctorWeekDay;
use App\Models\Service;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App;

class StoreDoctorTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('avatars');
    }

    /**
     * Create doctor test without authenticate.
     *
     * @return void
     */
    public function testStoreDoctorWithoutAuthentication()
    {
        $faker = Faker::create();
        $service = factory(Service::class)->state('serviceTranslations')->create();
        $body = array(
            'name_arabic' => $faker->name(),
            'name_english' => $faker->name(),
            'mobile' => $faker->numerify('###########'),
            'password' => 'secret', // password,
            'photo' => UploadedFile::fake()->image('avatar.jpg'),
            'time_slot' => $faker->numberBetween(0, 60),
            'email' => $faker->email(), 
            'doctor_week_days' => array(array(
                'week_day_id' => $faker->numberBetween(1, 7),
                'start_hour' => $faker->time('H:i'),
                'to_hour' => $faker->time('H:i'),
            )),
            'services' => array(array(
                'service_id' => $service->id
            ))
        );
        $response = $this->json('POST',route('admin.doctors.store'), $body);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * A create doctor test example without body.
     *
     * @return void
     */
    public function testStoreDoctorWithoutBody()
    {
        $body = array(); 
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('POST',route('admin.doctors.store'), $body);
        
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A create doctor test success.
     *
     * @return void
     */
    public function testSuccessStoreDoctor()
    {
        $faker = Faker::create();
        $service = factory(Service::class)->state('serviceTranslations')->create();
        $body = array(
            'name_arabic' => $faker->name(),
            'name_english' => $faker->name(),
            'mobile' => $faker->numerify('###########'),
            'password' => 'secret', // password,
            'photo' => UploadedFile::fake()->image('avatar.jpg'),
            'time_slot' => $faker->numberBetween(0, 60),
            'email' => $faker->email(), 
            'doctor_week_days' => array(array(
                'week_day_id' => $faker->numberBetween(1, 7),
                'start_hour' => Carbon::now()->format('H:i'),
                'to_hour' => Carbon::now()->addHour()->format('H:i'),
            )),
            'services' => array(array(
                'service_id' => $service->id
            ))
        );
        $admin = Admin::where('username', config('admin.SUPPER_ADMIN_USERNAME'))->first();
        $response = $this->actingAs($admin,'admin')->json('POST',route('admin.doctors.store'), $body);
        
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertDatabaseHas('doctors', ['mobile' => $body['mobile']]);
    }
}

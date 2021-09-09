<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\DoctorWeekDay;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App;

class ShowBookingTest extends TestCase
{
    /**
     * Store booking test without authenticate.
     *
     * @return void
     */
    public function testStoreBookingWithoutAuthentication()
    {
        $faker = Faker::create();
        $doctor = Doctor::first();
        $body = array(
            'doctor_id' => $doctor->id,
            'doctor_week_day_id' => $doctor->doctorWeekDays()->first()->id,
            'visit_date' => $faker->date('Y-m-d')
        );
        $response = $this->json('POST',route('patient.bookings.store'),$body,array('Authorization' => '','Accept-Language' => App::getLocale()));
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * A create booking test example without body.
     *
     * @return void
     */
    public function testStoreBookingWithoutBody()
    {
        $body = array(); 
        config()->set('auth.defaults.guard', 'patient' );
        config()->set('auth.defaults.passwords','patients');
        $patient = Patient::first();
        $token = JWTAuth::fromUser($patient);       
        $response = $this->json('POST',route('patient.bookings.store'), $body,array('Authorization' => 'Bearer'. $token,'Accept-Language' => App::getLocale()));
        
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * A create booking test success.
     *
     * @return void
     */
    public function testSuccessStoreBooking()
    {
        $faker = Faker::create();
        config()->set('auth.defaults.guard', 'patient' );
        config()->set('auth.defaults.passwords','patients');
        $doctor = Doctor::first();
        $patient = Patient::first();
        $body = array(
            'doctor_id' => $doctor->id,
            'doctor_week_day_id' => $doctor->doctorWeekDays()->first()->id,
            'visit_date' => Carbon::now()->format('Y-m-d')
        );
        $token = JWTAuth::fromUser($patient);       
        $response = $this->json('POST',route('patient.bookings.store'), $body,array('Authorization' => 'Bearer'. $token, 'Accept-Language' => App::getLocale()));
        
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $booking = Booking::where('doctor_id',$doctor->id)
            ->where('patient_id',$patient->id)
            ->forceDelete();
    }
}

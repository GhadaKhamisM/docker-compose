<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\Doctor;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App;

class ShowBookingTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        config()->set('auth.defaults.guard', 'patient' );
        config()->set('auth.defaults.passwords','patients');
    }

    /**
     * Store booking test without authenticate.
     *
     * @return void
     */
    public function testStoreBookingWithoutAuthentication()
    {
        $faker = Faker::create();
        $doctor = factory(Doctor::class)->state('doctorWeekDays')->create();
        $body = array(
            'doctor_id' => $doctor->id,
            'doctor_week_day_id' => $doctor->doctorWeekDays()->first()->id,
            'visit_date' => $faker->date('Y-m-d')
        );
        $response = $this->json('POST',route('patient.bookings.store'),$body,array('Accept-Language' => App::getLocale()));
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
        $patient = factory(Patient::class)->create();
        $response = $this->actingAs($patient,'patient')->json('POST',route('patient.bookings.store'), $body,array('Accept-Language' => App::getLocale()));
        
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
        $doctor = factory(Doctor::class)->state('doctorWeekDays')->create();
        $doctorWeekDay = $doctor->doctorWeekDays()->first();
        $patient = factory(Patient::class)->create();
        $visitDate = $this->getVisitDate(Carbon::now(),$doctorWeekDay->weekDay->day_index);
        $startTime = Carbon::parse($visitDate. ' '.$doctorWeekDay->start_hour);
        $body = array(
            'doctor_id' => $doctor->id,
            'doctor_week_day_id' => $doctorWeekDay->id,
            'visit_date' => $visitDate,
            'start_hour' =>  $startTime->format('H:i'),
            'to_hour' => $startTime->addMinutes($doctor->time_slot)->format('H:i')
        );
        $response = $this->actingAs($patient,'patient')->json('POST',route('patient.bookings.store'), $body,array('Accept-Language' => App::getLocale()));
        
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertDatabaseHas('bookings', ['doctor_id' => $body['doctor_id'],'visit_date' => $body['visit_date'],'patient_id' => $patient->id]);
    }

    private function getVisitDate($date,$dayIndex){
        if($date->dayOfWeek == $dayIndex){
            return $date->format('Y-m-d');
        }
        return $this->getVisitDate($date->addDay(),$dayIndex);
    }
}

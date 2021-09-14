<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\Doctor;
use App\Models\Booking;
use Faker\Factory as Faker;
use App;

class CancelBookingTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        config()->set('auth.defaults.guard', 'doctor' );
        config()->set('auth.defaults.passwords','doctors');
    }
    /**
     * Delete doctor test without authenticate.
     *
     * @return void
     */
    public function testCancelBookingWithoutAuthentication()
    {
        $booking = factory(Booking::class)->create();
        $response = $this->json('POST',route('doctor.bookings.cancel', ['booking' => $booking->id]),array(),array('Accept-Language' => App::getLocale()));
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * Cancel booking example not assin to doctor.
     *
     * @return void
     */
    public function testCancelBookingNotAssinToDoctor()
    {
        $booking = factory(Booking::class)->create();

        $doctor = factory(Doctor::class)->state('doctorWeekDays')->create();
        $response = $this->actingAs($doctor,'doctor')->json('POST',route('doctor.bookings.cancel',['booking' => $booking->id]), array(),array('Accept-Language' => App::getLocale()));

        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    /**
     * Cancel booking test success.
     *
     * @return void
     */
    public function testCnacelBookingSuccess()
    {
        $booking = factory(Booking::class)->create();
        $response = $this->actingAs($booking->doctor,'doctor')->json('POST',route('doctor.bookings.cancel',['booking' => $booking->id]), array(),array('Accept-Language' => App::getLocale()));
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertDatabaseHas('bookings', ['id' => $booking->id,'status_id' => config('statuses.canceled')]);
    }
}

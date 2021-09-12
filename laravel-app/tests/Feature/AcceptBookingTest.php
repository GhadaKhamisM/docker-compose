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

class AcceptBookingTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        config()->set('auth.defaults.guard', 'doctor' );
        config()->set('auth.defaults.passwords','doctors');
    }

    /**
     * Accept booking test without authenticate.
     *
     * @return void
     */
    public function testAcceptBookingWithoutAuthentication()
    {
        $booking = factory(Booking::class)->create();
        $response = $this->json('POST',route('doctor.bookings.accept', ['booking' => $booking->id]),array(),array('Accept-Language' => App::getLocale()));
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * Accept booking example not assin to doctor.
     *
     * @return void
     */
    public function testAcceptBookingNotAssinToDoctor()
    {
        $booking = factory(Booking::class)->create();

        $doctor = factory(Doctor::class)->state('doctorWeekDays')->create();
        $response = $this->actingAs($doctor,'doctor')->json('POST',route('doctor.bookings.accept',['booking' => $booking->id]), array(),array('Accept-Language' => App::getLocale()));
        
        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    /**
     * Accept booking test success.
     *
     * @return void
     */
    public function testAcceptBookingSuccess()
    {
        $booking = factory(Booking::class)->create();
        $response = $this->actingAs($booking->doctor,'doctor')->json('POST',route('doctor.bookings.accept',['booking' => $booking->id]), array(),array('Accept-Language' => App::getLocale()));
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}

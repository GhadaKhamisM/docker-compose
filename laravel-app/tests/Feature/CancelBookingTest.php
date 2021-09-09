<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Booking;
use App\Models\DoctorWeekDay;
use Faker\Factory as Faker;
use App;

class CancelBookingTest extends TestCase
{
    /**
     * Delete doctor test without authenticate.
     *
     * @return void
     */
    public function testCancelBookingWithoutAuthentication()
    {
        $patient = factory(Patient::class)->create();
        $doctor = factory(Doctor::class)->create();
        $doctorWeekDay = factory(DoctorWeekDay::class)->make();
        $doctor->doctorWeekDays()->save($doctorWeekDay);
        $booking = factory(Booking::class)->create(['patient_id' => $patient->id,
            'doctor_id' => $doctor->id,'doctor_week_day_id' => $doctorWeekDay->id]);
        $response = $this->json('POST',route('doctor.bookings.cancel', ['booking' => $booking->id]),array(),array('Authorization' => '', 'Accept-Language' => App::getLocale()));
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $booking->forceDelete();
        $patient->forceDelete();
        $doctor->doctorWeekDays()->forceDelete();
        $doctor->forceDelete();

    }

    /**
     * Cancel booking example not assin to doctor.
     *
     * @return void
     */
    public function testCancelBookingNotAssinToDoctor()
    {
        config()->set('auth.defaults.guard', 'doctor' );
        config()->set('auth.defaults.passwords','doctors');
        $patient = factory(Patient::class)->create();
        $doctorBooking = factory(Doctor::class)->create();
        $doctorBookingWeekDay = factory(DoctorWeekDay::class)->make();
        $doctorBooking->doctorWeekDays()->save($doctorBookingWeekDay);
        $doctor = factory(Doctor::class)->create();
        $doctorWeekDay = factory(DoctorWeekDay::class)->make();
        $doctor->doctorWeekDays()->save($doctorWeekDay);
        $booking = factory(Booking::class)->create(['patient_id' => $patient->id,
            'doctor_id' => $doctorBooking->id,'doctor_week_day_id' => $doctorBookingWeekDay->id]);

        $token = JWTAuth::fromUser($doctor);       
        $response = $this->json('POST',route('doctor.bookings.cancel',['booking' => $booking->id]), array(),array('Authorization' => 'Bearer'. $token, 'Accept-Language' => App::getLocale()));
        
        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $booking->forceDelete();
        $patient->forceDelete();
        $doctorBooking->doctorWeekDays()->forceDelete();
        $doctorBooking->forceDelete();
        $doctor->doctorWeekDays()->forceDelete();
        $doctor->forceDelete();
    }

    /**
     * Cancel booking test success.
     *
     * @return void
     */
    public function testCnacelBookingSuccess()
    {
        config()->set('auth.defaults.guard', 'doctor' );
        config()->set('auth.defaults.passwords','doctors');
        $patient = factory(Patient::class)->create();
        $doctor = factory(Doctor::class)->create();
        $doctorWeekDay = factory(DoctorWeekDay::class)->make();
        $doctor->doctorWeekDays()->save($doctorWeekDay);
        $booking = factory(Booking::class)->create(['patient_id' => $patient->id,
            'doctor_id' => $doctor->id,'doctor_week_day_id' => $doctorWeekDay->id]);

        $token = JWTAuth::fromUser($doctor);       
        $response = $this->json('POST',route('doctor.bookings.cancel',['booking' => $booking->id]), array(),array('Authorization' => 'Bearer'. $token, 'Accept-Language' => App::getLocale()));
        
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $booking->forceDelete();
        $patient->forceDelete();
        $doctor->doctorWeekDays()->forceDelete();
        $doctor->forceDelete();
    }
}

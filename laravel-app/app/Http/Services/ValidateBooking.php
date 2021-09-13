<?php

namespace App\Http\Services;

use Carbon\Carbon;

trait ValidateBooking
{
    public function canBooking($doctor,$doctorWeekDay,$visitDate)
    {
        $bookingTimeExited = $this->checkBookingTimeAvailable($doctor,$doctorWeekDay,$visitDate);
        if($bookingTimeExited){
            return false;
        }

        $durationOfDoctorDay = $this->getWorkingDayDuration($doctorWeekDay,$visitDate);
        $bookingsDuration = $doctorWeekDay->bookings()->sum('time_slot');
        return $this->canAddBooking($durationOfDoctorDay,$bookingsDuration, $doctor->time_slot);
    }

    private function checkBookingTimeAvailable($doctor,$doctorWeekDay,$visitDate){
        $endTime = Carbon::parse($visitDate. ' '.$doctorWeekDay->to_hour);
        $currentTime = Carbon::now();
        $currentTimeWithTimeSlot = $currentTime->addMinutes($doctor->time_slot);
        return $currentTimeWithTimeSlot->gt($endTime);
    }

    private function getWorkingDayDuration($doctorWorkingDay,$visitDate){
        $startHour = Carbon::parse($visitDate .' '. $doctorWorkingDay->start_hour);
        $endHour = Carbon::parse($visitDate .' '. $doctorWorkingDay->to_hour);
        return $endHour->diffInMinutes($startHour);
    }

    private function canAddBooking(int $durationOfDoctorDay,int $bookingsDuration,int $newBookingDuration){
        return $durationOfDoctorDay >= $bookingsDuration + $newBookingDuration;
    }
}

<?php

namespace App\Http\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

trait DayInterval
{
    public function getAvailableTimesInInterval($doctor,$doctorWeekDay,$visitDate)
    {
        $intervaltClosed = $this->checkIntervaltClosed($doctor,$doctorWeekDay,$visitDate);
        if($intervaltClosed){
            return array();
        }

        $dayIntervals = $this->getDayIntervals($doctor,$doctorWeekDay,$visitDate);        
        return collect($dayIntervals);
    }

    public function checkIntervaltClosed($doctor,$doctorWeekDay,$visitDate){
        $intervalEndTime = Carbon::parse($visitDate. ' '.$doctorWeekDay->to_hour);
        $currentTime = Carbon::now();
        $currentTimeWithTimeSlot = $currentTime->addMinutes($doctor->time_slot);
        return $currentTimeWithTimeSlot->gt($intervalEndTime);
    }

    private function getDayIntervals($doctor,$doctorWeekDay,$visitDate){
        $data = array();
        $intervals = CarbonPeriod::since($doctorWeekDay->start_hour)->minutes($doctor->time_slot)->until($doctorWeekDay->to_hour)->toArray();
        foreach ($intervals as $interval) {
            $to = next($intervals);
            if ($to !== false) {
                $startHour = $interval->format('H:i');
                $toHour = $to->format('H:i');
                $overlapingBookings = $this->bookingRepository->getOverlappingBooking($doctor->id,$visitDate,$startHour,$toHour);
                $data[] = (object) array('start_hour' => $startHour, 'to_hour' => $toHour, 'is_available' => $overlapingBookings->count() == 0);
            }
        }
        return $data;
    }

    public function getTimeIntervals($doctor,$doctorWeekDay,$visitDate){
        $data = array();
        $intervals = CarbonPeriod::since($doctorWeekDay->start_hour)->minutes($doctor->time_slot)->until($doctorWeekDay->to_hour)->toArray();
        foreach ($intervals as $interval) {
            $to = next($intervals);
            if ($to !== false) {
                $startHour = $interval->format('H:i');
                $toHour = $to->format('H:i');
                $data[] = (object) array('start_hour' => $startHour, 'to_hour' => $toHour);
            }
        }
        return $data;
    }
}

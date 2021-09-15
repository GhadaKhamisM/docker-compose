<?php

namespace App\Http\Services;

use Illuminate\Http\Response;
use App\Repositories\DoctorRepository;
use App\Repositories\WeekDayRepository;
use App\Repositories\BookingRepository;
use App\Repositories\DoctorWeekDayRepository;
use App\Http\Filters\DoctorFilter;
use App\Models\Doctor;
use App\Http\Services\UploadFile;
use Carbon\Carbon;
use Lang;

class DoctorService
{
    use UploadFile;
    use DayInterval;

    private $doctorRepository, $uploadService, $weekDayRepository,
        $bookingRepository, $doctorWeekDayRepository;

    public function __construct(DoctorRepository $doctorRepository, WeekDayRepository $weekDayRepository,
        BookingRepository $bookingRepository, DoctorWeekDayRepository $doctorWeekDayRepository)
    {
        $this->doctorRepository = $doctorRepository;
        $this->weekDayRepository = $weekDayRepository;
        $this->bookingRepository = $bookingRepository;
        $this->doctorWeekDayRepository = $doctorWeekDayRepository;
    }

    public function create(array $data){
        $this->validateDoctorWeekDays($data['doctor_week_days']);
        $data['photo'] = $this->uploadFile($data['photo'],'/doctors');
        return $this->doctorRepository->create($data);
    }

    public function getAll(DoctorFilter $filter){
        return $this->doctorRepository->filterAll($filter);
    }

    public function update(Doctor $doctor,array $data){
        $this->validateDoctorWeekDays($data['doctor_week_days']);
        $data['photo'] = $this->uploadFile($data['photo'],'/doctors');
        $this->doctorRepository->update($doctor,$data);
    }

    public function delete(Doctor $doctor){
        $doctor->delete();
    }

    public function getDoctorAvailableTimes(Doctor $doctor, array $data)
    {
        $visitDate = Carbon::parse($data['visit_date']);
        $doctorWeekDays = $this->doctorWeekDayRepository->getDoctorWeekDays($doctor->id,$visitDate->dayOfWeek)->load('weekDay');

        if(!$doctorWeekDays->count()){
            abort(Response::HTTP_NOT_FOUND, Lang::get('messages.doctors.errors.date'));
        }

        $availableTimes = $this->getAvailableTimes($doctorWeekDays, $doctor, $data['visit_date']);

        if(empty($availableTimes)) {
            abort(Response::HTTP_BAD_REQUEST, Lang::get('messages.doctors.errors.booking'));
        }
        return $availableTimes;
    }

    public function getAvailableTimes($doctorWeekDays, Doctor $doctor, string $visitDate){
        $availableTimes = array();
        foreach ($doctorWeekDays as $key => $doctorWeekDay) {
            $doctorWeekDay['intervals'] = $this->getAvailableTimesInInterval($doctor,$doctorWeekDay,$visitDate); 
            $availableTimes[] = $doctorWeekDay;
        }
        return $availableTimes;
    }

    private function validateDoctorWeekDays($doctorWeekDays){
        $duplicatedWeekDays = $this->getDuplicatedWeekDays($doctorWeekDays);    
        if(empty($duplicatedWeekDays)){
            return ;
        }
        $doctorWeekDays = collect($doctorWeekDays)->whereIn('week_day_id',array_keys($duplicatedWeekDays))->sortBy('start_hour');
        return $this->checkTimeOverlapping(array_values($doctorWeekDays->toArray()));
    }

    private function getDuplicatedWeekDays($doctorWeekDays){
        $weekDaysIds = array_column($doctorWeekDays,'week_day_id');
        $countOfrepeatedWeekDays = array_count_values($weekDaysIds);
        return array_filter($countOfrepeatedWeekDays, function ($count) { return $count > 1; });
    }

    private function checkTimeOverlapping($doctorWeekDays){
        foreach ($doctorWeekDays as $key => $doctorWeekDay) {
            $weekDayId = $doctorWeekDay['week_day_id'];
            $duplicatedDoctorWeekDays = array_filter($doctorWeekDays, function ($doctorWeekDay) use ($weekDayId) { return $doctorWeekDay['week_day_id'] == $weekDayId; });
            $doctorWeekDayIndex = array_search($doctorWeekDay,$duplicatedDoctorWeekDays);
            if($doctorWeekDayIndex > 0){
                $previousEndTime = $duplicatedDoctorWeekDays[$doctorWeekDayIndex -1]['to_hour'];
                if($doctorWeekDay['start_hour'] < $previousEndTime){
                    abort(Response::HTTP_UNPROCESSABLE_ENTITY,Lang::get('messages.doctors.errors.week_days'));
                }
            }
        }
    }
}

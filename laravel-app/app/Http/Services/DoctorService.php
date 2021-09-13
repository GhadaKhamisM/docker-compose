<?php

namespace App\Http\Services;

use Illuminate\Http\Response;
use App\Repositories\DoctorRepository;
use App\Repositories\WeekDayRepository;
use App\Http\Filters\DoctorFilter;
use App\Models\Doctor;
use App\Http\Services\UploadFile;
use Carbon\Carbon;
use Lang;

class DoctorService
{
    use UploadFile;
    use ValidateBooking;

    private $doctorRepository, $uploadService, $weekDayRepository;

    public function __construct(DoctorRepository $doctorRepository, WeekDayRepository $weekDayRepository)
    {
        $this->doctorRepository = $doctorRepository;
        $this->weekDayRepository = $weekDayRepository;
    }

    public function create(array $data){
        $data['photo'] = $this->uploadFile($data['photo'],'/doctors');
        return $this->doctorRepository->create($data);
    }

    public function getAll(DoctorFilter $filter){
        return $this->doctorRepository->getAll($filter);
    }

    public function update(Doctor $doctor,array $data){
        $data['photo'] = $this->uploadFile($data['photo'],'/doctors');
        $this->doctorRepository->update($doctor,$data);
    }

    public function delete(Doctor $doctor){
        $this->doctorRepository->delete($doctor->id);
    }

    public function getDoctorAvailableTimes(Doctor $doctor, array $data)
    {
        $visitDate = Carbon::parse($data['visit_date']);
        $doctorWeekDays = $this->getDoctorWeekDays($doctor,$visitDate,$data);

        if(!$doctorWeekDays->count()){
            abort(Response::HTTP_NOT_FOUND, Lang::get('messages.doctors.errors.date'));
        }

        $availableTimes = $this->getAvailableTimes($doctorWeekDays, $doctor, $data['visit_date']);

        if(empty($availableTimes)) {
            abort(Response::HTTP_BAD_REQUEST, Lang::get('messages.doctors.errors.booking'));
        }
        return $availableTimes;
    }

    public function getDoctorWeekDays(Doctor $doctor,$visitDate,Array $data){
        return $doctor->doctorWeekDays()
            ->whereHas('weekDay', function($query) use ($visitDate){
                $query->where('day_index', $visitDate->dayOfWeek);
            })->with(['bookings' => function ($query) use ($data){
                $query->whereDate('visit_date',$data['visit_date']);
            }])->get();
    }

    public function getAvailableTimes($doctorWeekDays, Doctor $doctor, string $visitDate){
        $availableTimes = array();
        foreach ($doctorWeekDays as $key => $doctorWeekDay) {
            $canBooking = $this->canBooking($doctor,$doctorWeekDay,$visitDate);
            if($canBooking){
                $availableTimes[] = $doctorWeekDay;
            }
        }
        return $availableTimes;
    }
}

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
        return $this->doctorRepository->findBy('id',$doctor->id);
    }

    public function delete(Doctor $doctor){
        $this->doctorRepository->delete($doctor->id);
        return response()->json(['messages' => Lang::get('messages.doctors.success.delete')] , Response::HTTP_OK);
    }

    public function getDoctorAvailableDates(Doctor $doctor, array $data)
    {
        if(isset($data['week_day_id'])){
            $today =  Carbon::now();
            $weekDay = $this->weekDayRepository->findBy('id',$data['week_day_id']);
            $result['visit_date'] = $this->getNearestAvailableDate($today, $weekDay->day_index);
            return $result;
        } 

        $result['visit_date'] = Carbon::now()->format('Y-m-d');
        return $result;
    }

    private function getNearestAvailableDate($date, int $dayIndex){
        if($date->dayOfWeek == $dayIndex) {
            return  $date->format('Y-m-d');
        }
        return $this->getNearestAvailableDate($date->addDay(),$dayIndex);
    }
}

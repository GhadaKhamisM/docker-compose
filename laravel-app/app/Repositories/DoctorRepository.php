<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Http\Filters\DoctorFilter;

class DoctorRepository
{

    public function __construct()
    {
    }

    public function create(Array $data){
        $doctor = Doctor::create($data);
        $this->attachDoctorData($doctor,$data);
        return $doctor;
    }

    public function getAll(DoctorFilter $filter){
        return Doctor::filter($filter)->get();
    }

    public function update(Doctor $doctor,Array $data){
        $doctorData = $data;
        unset($doctorData['services']);
        unset($doctorData['doctor_week_days']);
        Doctor::where('id',$doctor->id)->update($doctorData);
        $this->detachDoctorData($doctor);
        $this->attachDoctorData($doctor,$data);
    }

    public function getDoctor(string $filter, string $value)
    {
        return Doctor::where($filter,$value)->first();
    }

    public function delete(int $id){
        Doctor::where('id',$id)->first()->delete();
    }

    public function attachDoctorData(Doctor $doctor,Array $data){
        $doctor->services()->attach($data['services']);
        $doctor->weekDays()->attach($data['doctor_week_days']);
    }

    public function detachDoctorData(Doctor $doctor){
        $doctor->services()->detach();
        $doctor->weekDays()->detach();
    }
}

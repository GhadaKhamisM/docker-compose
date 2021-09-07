<?php

namespace App\Repositories;

use App\Models\Doctor;

class DoctorRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(Doctor::class);
    }

    public function create(Array $data){
        $doctor = $this->model->create($data);
        $this->attachDoctorData($doctor,$data);
        return $doctor;
    }

    public function update(Doctor $doctor,Array $data){
        $doctorData = $data;
        unset($doctorData['services']);
        unset($doctorData['doctor_week_days']);
        $this->findBy('id',$doctor->id)->update($doctorData);
        $this->updateDoctorRelations($doctor,$data);
    }

    public function delete(int $id){
        $this->findBy('id',$id)->first()->delete();
    }

    public function attachDoctorData(Doctor $doctor,Array $data){
        $doctor->services()->attach($data['services']);
        $doctor->doctorWeekDays()->createMany($data['doctor_week_days']);
    }

    public function updateDoctorRelations(Doctor $doctor,Array $data){
        $doctor->services()->sync($data['services']);
        $doctor->doctorWeekDays()->delete();
        $doctor->doctorWeekDays()->createMany($data['doctor_week_days']);
    }
}

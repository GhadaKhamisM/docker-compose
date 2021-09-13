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
        $doctor->services()->sync($data['services']);
        $this->updateDoctorWeekDays($doctor,$data['doctor_week_days']);
    }

    public function delete(int $id){
        $this->findBy('id',$id)->delete();
    }

    public function attachDoctorData(Doctor $doctor,Array $data){
        $doctor->services()->attach($data['services']);
        $doctor->doctorWeekDays()->createMany($data['doctor_week_days']);
    }

    public function updateDoctorWeekDays(Doctor $doctor,Array $data){
        $OldDoctorWeekDaysIds = array_column($doctor->doctorWeekDays->toArray(),'id');
        $updateWeekDaysIds = array_column($data,'id');

        // delete
        $deleteWeekDaysIds = array_diff($OldDoctorWeekDaysIds,$updateWeekDaysIds);
        $doctor->doctorWeekDays()->whereIn('id',$deleteWeekDaysIds)->delete();

        // update
        $updateDoctorWeekDays = array_filter($data, function ($doctorWeekDay) { return isset($doctorWeekDay['id']); });
        if(!empty($updateDoctorWeekDays)){
            foreach ($updateDoctorWeekDays as $key => $doctorWeekDay) {
                $doctor->doctorWeekDays()->where('id',$doctorWeekDay['id'])->update($doctorWeekDay);
            }
        }

        // create
        $createdData = array_filter($data, function ($doctorWeekDay) {return !isset($doctorWeekDay['id']);});
        if(!empty($createdData)){
            $doctor->doctorWeekDays()->createMany($createdData);
        }
    }
}

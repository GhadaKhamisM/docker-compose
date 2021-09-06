<?php

namespace App\Http\Services;

use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Response;
use App\Repositories\DoctorRepository;
use App\Http\Filters\DoctorFilter;
use App\Models\Doctor;
use App\Http\Services\UploadFile;

class DoctorService
{
    use UploadFile;
    private $database, $doctorRepository, $uploadService;

    public function __construct(DatabaseManager $database, DoctorRepository $doctorRepository)
    {
        $this->database = $database;
        $this->doctorRepository = $doctorRepository;
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
        return $this->doctorRepository->getDoctor('id',$doctor->id);
    }

    public function delete(Doctor $doctor){
        $this->doctorRepository->delete($doctor->id);
    }
}

<?php

namespace App\Repositories;

use App\Models\Patient;

class PatientRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(Patient::class);
    }

    public function create(Array $patientData){
        return $this->model->create($patientData);
    }
}

<?php

namespace App\Repositories;

use App\Models\Patient;

class PatientRepository
{

    public function __construct()
    {
    }

    public function getPatient(string $filter, string $value)
    {
        return Patient::where($filter,$value)->first();
    }

    public function create(Array $patientData){
        return Patient::create($patientData);
    }
}

<?php

namespace App\Repositories;

use App\Models\ServiceTranslation;
use App\Http\Filters\ServiceFilter;

class ServiceTranslationRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(ServiceTranslation::class);
    }

    public function update(int $serviceId, string $locale, Array $data){
        $this->model->where('locale',$locale)->where('service_id',$serviceId)->update($data);
    }
}

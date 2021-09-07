<?php

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(Service::class);
    }

    public function create(Array $data){
        return $this->model->create($data);
    }

    public function update(int $id,Array $data){
        $this->findBy('id',$id)->update($data);
    }

    public function delete(int $id){
        $this->findBy('id',$id)->delete();
    }
}

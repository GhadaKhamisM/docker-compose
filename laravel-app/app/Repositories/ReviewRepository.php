<?php

namespace App\Repositories;

use App\Models\Review;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Filters\ReviewFilter;
use Carbon\Carbon;

class ReviewRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(Review::class);
    }

    public function create(Array $data){
        $data['patient_id'] = JWTAuth::parseToken()->authenticate()->id;
        $data['date'] = Carbon::now();
        $review = $this->model->create($data);
        return $review;
    }
}

<?php

namespace App\Http\Services;

use Illuminate\Http\Response;
use App\Repositories\ReviewRepository;
use App\Http\Filters\ReviewFilter;
use App\Models\Review;

class ReviewService
{
    private $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function create(array $data){
        return $this->reviewRepository->create($data);
    }

    public function getAll(ReviewFilter $filter){
        return $this->reviewRepository->filterAll($filter);
    }
}

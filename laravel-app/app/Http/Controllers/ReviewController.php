<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Services\ReviewService;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use App\Models\Doctor;
use App\Http\Resources\ReviewResource;
use App\Http\Filters\ReviewFilter;
use Illuminate\Http\Response;
use Lang;

class ReviewController extends Controller
{
    private $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function index(Request $request,Doctor $doctor){
        $request->request->add(['doctor_id' => $doctor->id]);
        $reviews = $this->reviewService->getAll(new ReviewFilter($request));
        return ReviewResource::collection($reviews);
    }

    public function store(StoreReviewRequest $request,Doctor $doctor){
        $reviewData = $request->validated();
        $reviewData['doctor_id'] = $doctor->id;
        $review = $this->reviewService->create($reviewData);
        return response()->json(['message' => Lang::get('messages.reviews.success.created')] , Response::HTTP_CREATED);
    }
}
